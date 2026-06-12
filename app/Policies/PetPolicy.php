<?php

namespace App\Policies;

use App\Models\Pet;
use App\Models\User;

class PetPolicy
{
    public function view(User $user, Pet $pet): bool
    {
        // Owner can view their own pet
        return $user->id === $pet->user_id;
    }

    public function update(User $user, Pet $pet): bool
    {
        // Only owner can update their pet
        return $user->id === $pet->user_id;
    }

    public function delete(User $user, Pet $pet): bool
    {
        // Only owner can delete their pet
        return $user->id === $pet->user_id;
    }
}
