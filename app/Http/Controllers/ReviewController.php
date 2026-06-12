<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string',
        ]);

        $booking = Booking::find($request->booking_id);

        // Security check: only pet owner of the booking can write this
        if ($booking->pet_owner_id !== Auth::id()) {
            abort(403);
        }

        // Check if already reviewed
        $exists = Review::where('booking_id', $booking->id)->exists();
        if ($exists) {
            return back()->withErrors(['booking_id' => 'Pesanan ini sudah pernah diulas.']);
        }

        Review::create([
            'booking_id' => $booking->id,
            'pet_owner_id' => Auth::id(),
            'provider_id' => $booking->provider_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('bookings.index')->with('success', 'Ulasan berhasil dikirim!');
    }
}
