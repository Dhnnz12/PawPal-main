<?php

namespace App\Policies;

use App\Models\MedicalRecord;
use App\Models\User;

class MedicalRecordPolicy
{
    public function view(User $user, MedicalRecord $record): bool
    {
        // Vet who created it or pet owner can view
        return $user->id === $record->vet_id || $user->id === $record->pet->user_id;
    }

    public function update(User $user, MedicalRecord $record): bool
    {
        // Only the vet who created it can update
        return $user->id === $record->vet_id;
    }

    public function delete(User $user, MedicalRecord $record): bool
    {
        // Only the vet who created it can delete
        return $user->id === $record->vet_id;
    }
}
