<?php

namespace App\Policies;

use App\Models\Pet;
use App\Models\User;

class PetPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'manager';
    }

    public function view(User $user, Pet $pet): bool
    {
        return $user->role === 'manager' && $user->clinic_id === $pet->clinic_id;
    }

    public function create(User $user): bool
    {
        return $user->role === 'manager';
    }

    public function update(User $user, Pet $pet): bool
    {
        return $user->role === 'manager' && $user->clinic_id === $pet->clinic_id;
    }

    public function delete(User $user, Pet $pet): bool
    {
        return $user->role === 'manager' && $user->clinic_id === $pet->clinic_id;
    }
}