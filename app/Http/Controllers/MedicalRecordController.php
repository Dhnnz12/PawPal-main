<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\MedicalRecord;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController extends Controller
{
    public function index()
    {
        // Get all pets belonging to the authenticated user (pet owner)
        $pets = Auth::user()->pets;
        
        // Group medical records by pet name
        $petsMedicalRecords = [];
        foreach ($pets as $pet) {
            $medicalRecords = MedicalRecord::where('pet_id', $pet->id)
                ->with('vet')
                ->orderBy('visit_date', 'desc')
                ->get();
            
            if ($medicalRecords->count() > 0) {
                $petsMedicalRecords[$pet->name] = $medicalRecords;
            }
        }
        
        return view('medical-records.index', [
            'petsMedicalRecords' => $petsMedicalRecords
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'nullable|exists:bookings,id',
            'pet_id' => 'required|exists:pets,id',
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'notes' => 'nullable|string',
            'pdf_attachment' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        // Authorization check: either assigned vet or admin
        $user = Auth::user();
        if (!$user->isVet() && !$user->isAdmin()) {
            abort(403, 'Hanya dokter hewan atau administrator yang dapat menulis rekam medis.');
        }

        $booking = null;
        if ($request->booking_id) {
            $booking = Booking::find($request->booking_id);
            if ($booking && !$user->isAdmin() && $booking->provider_id !== $user->id) {
                abort(403, 'Hanya dokter hewan yang bertugas pada booking ini yang dapat mencatat.');
            }
        }

        $pdfPath = null;
        if ($request->hasFile('pdf_attachment')) {
            $pdfPath = $request->file('pdf_attachment')->store('medical_records', 'public');
        }

        $vetId = $user->isVet() ? $user->id : ($booking ? ($booking->provider_id ?? $user->id) : $user->id);

        MedicalRecord::create([
            'pet_id' => $request->pet_id,
            'vet_id' => $vetId,
            'booking_id' => $request->booking_id,
            'visit_date' => now()->toDateString(),
            'diagnosis' => $request->diagnosis,
            'treatment' => $request->treatment,
            'notes' => $request->notes,
            'pdf_path' => $pdfPath,
        ]);

        if ($user->isAdmin()) {
            return redirect()->route('admin.medical-records.index')->with('success', 'Rekam medis hewan berhasil dicatat!');
        }

        return back()->with('success', 'Rekam medis hewan berhasil dicatat!');
    }
}
