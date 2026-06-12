<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    public function view(User $user, Booking $booking): bool
    {
        // Pet owner or provider can view the booking
        return $user->id === $booking->pet_owner_id || $user->id === $booking->provider_id;
    }

    public function updateStatus(User $user, Booking $booking): bool
    {
        // Provider can update booking status
        return $user->id === $booking->provider_id;
    }

    public function cancel(User $user, Booking $booking): bool
    {
        // Pet owner can cancel their booking
        return $user->id === $booking->pet_owner_id && $booking->status !== 'completed';
    }
}
