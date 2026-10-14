<?php

namespace App\Policies;

use App\Models\MedicalCase;
use App\Models\User;

class MedicalCasePolicy
{
    /**
     * Determine whether the user can view any medical cases.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['Admin', 'Viewer'], true);
    }

    /**
     * Determine whether the user can view the specific medical case.
     */
    public function view(User $user, MedicalCase $medicalCase): bool
    {
        return in_array($user->role, ['Admin', 'Viewer'], true);
    }

    /**
     * Determine whether the user can create medical cases.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the medical case.
     */
    public function update(User $user, MedicalCase $medicalCase): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the medical case.
     */
    public function delete(User $user, MedicalCase $medicalCase): bool
    {
        return $user->isAdmin();
    }
}
