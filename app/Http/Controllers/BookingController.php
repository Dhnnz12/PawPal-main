<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Booking;
use App\Models\Pet;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function search(Request $request)
    {
        $type = $request->query('type', 'groomer'); // groomer, veterinarian, pet_sitter
        
        $providers = User::with(['services', 'reviewsAsProvider'])
            ->where('role', 'service_provider')
            ->where('provider_type', $type)
            ->where('is_verified', true)
            ->get();

        return view('owner.search_providers', compact('providers', 'type'));
    }

    public function showCreate(User $provider)
    {
        if (!$provider->isServiceProvider()) {
            abort(404);
        }

        $user = Auth::user();
        $pets = $user->pets;
        $addresses = $user->addresses;
        
        // Load clinic-wide services based on the provider's type dynamically
        $services = Service::whereNull('provider_id')
            ->where('provider_type', $provider->provider_type)
            ->get();

        // Get schedules to show operating times
        $schedules = $provider->schedules()->where('is_available', true)->get();

        // Get already booked slots for this provider
        $bookedSlots = Booking::where('provider_id', $provider->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->get(['booking_date', 'start_time'])
            ->map(function($b) {
                return $b->booking_date . '_' . \Carbon\Carbon::parse($b->start_time)->format('H:i');
            })
            ->toArray();

        return view('owner.create_booking', compact('provider', 'pets', 'addresses', 'services', 'schedules', 'bookedSlots'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'provider_id' => 'required|exists:users,id',
            'pet_id' => 'required|exists:pets,id',
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'address_id' => 'nullable|exists:addresses,id',
            'notes' => 'nullable|string',
        ]);

        $provider = User::find($request->provider_id);
        $service = Service::find($request->service_id);

        // Check operational hours (strictly one of the 8 slots)
        $timeStr = $request->start_time;
        $validStartTimes = ['07:00', '08:00', '09:00', '10:00', '13:00', '14:00', '15:00', '16:00'];
        if (!in_array($timeStr, $validStartTimes)) {
            return back()->withErrors(['start_time' => 'Booking hanya dapat dilakukan pada jam operasional 8-jam yang telah ditentukan.'])->withInput();
        }

        // Check if provider works on this day of week
        $dayOfWeek = date('w', strtotime($request->booking_date));
        $schedule = $provider->schedules()
            ->where('day_of_week', $dayOfWeek)
            ->where('is_available', true)
            ->first();

        if (!$schedule) {
            return back()->withErrors(['booking_date' => 'Tenaga klinik tidak aktif di hari tersebut.'])->withInput();
        }

        // Check if time is within schedule hours
        if ($timeStr < date('H:i', strtotime($schedule->start_time)) || $timeStr > date('H:i', strtotime($schedule->end_time))) {
            return back()->withErrors(['start_time' => 'Jam pilihan di luar jam kerja tenaga klinik.'])->withInput();
        }

        // Check for double booking
        $conflict = Booking::where('provider_id', $provider->id)
            ->where('booking_date', $request->booking_date)
            ->where('start_time', $request->start_time)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($conflict) {
            return back()->withErrors(['start_time' => 'Jam ini sudah di-booking oleh pelanggan lain.'])->withInput();
        }

        Booking::create([
            'pet_owner_id' => Auth::id(),
            'provider_id' => $provider->id,
            'pet_id' => $request->pet_id,
            'service_id' => $service->id,
            'booking_date' => $request->booking_date,
            'start_time' => $request->start_time,
            'total_price' => $service->price,
            'address_id' => $request->address_id,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect()->route('owner.dashboard')->with('success', 'Pemesanan berhasil diajukan! Menunggu konfirmasi admin.');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|string|in:confirmed,completed,cancelled',
        ]);

        $user = Auth::user();

        // Security check: Only Admin and the Booking Owner (cancellation only) can update status.
        if ($user->isAdmin()) {
            if ($request->status === 'completed') {
                abort(403, 'Gunakan form penyelesaian untuk menyelesaikan booking.');
            }
        } elseif ($user->isPetOwner()) {
            if ($booking->pet_owner_id !== $user->id) {
                abort(403);
            }
            // Pet owner can only cancel their booking
            if ($request->status !== 'cancelled') {
                abort(403);
            }
        } else {
            // Service providers (clinical staff) are not allowed to accept/decline bookings directly
            abort(403);
        }

        $booking->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan berhasil diupdate menjadi: ' . __($request->status));
    }

    public function showCompleteForm(Booking $booking)
    {
        abort_unless(Auth::user()->isAdmin(), 403);
        
        if ($booking->status !== 'confirmed') {
            return redirect()->route('admin.dashboard')->with('error', 'Hanya booking dengan status Diterima yang dapat diselesaikan.');
        }

        return view('admin.bookings.complete', compact('booking'));
    }

    public function submitComplete(Request $request, Booking $booking)
    {
        abort_unless(Auth::user()->isAdmin(), 403);

        if ($booking->status !== 'confirmed') {
            return redirect()->route('admin.dashboard')->with('error', 'Hanya booking dengan status Diterima yang dapat diselesaikan.');
        }

        $serviceType = $booking->service->provider_type ?? '';

        if ($serviceType === 'veterinarian') {
            $request->validate([
                'diagnosis' => 'required|string',
                'treatment' => 'required|string',
                'recommendation' => 'required|string',
                'notes' => 'nullable|string',
            ]);

            \App\Models\MedicalRecord::create([
                'pet_id' => $booking->pet_id,
                'vet_id' => $booking->provider_id,
                'booking_id' => $booking->id,
                'visit_date' => now()->toDateString(),
                'diagnosis' => $request->diagnosis,
                'treatment' => $request->treatment,
                'recommendation' => $request->recommendation,
                'notes' => $request->notes,
            ]);
        } else {
            // Groomer / other services
            $request->validate([
                'notes' => 'nullable|string',
            ]);

            $booking->update([
                'completion_notes' => $request->notes ?: '-',
            ]);
        }

        $booking->update(['status' => 'completed']);

        return redirect()->route('admin.dashboard')->with('success', 'Booking telah berhasil diselesaikan!');
    }
}
