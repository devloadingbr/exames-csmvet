<?php

namespace App\Policies;

use App\Models\ExamType;
use App\Models\User;

class ExamTypePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'manager';
    }

    public function view(User $user, ExamType $examType): bool
    {
        return $user->role === 'manager' && $user->clinic_id === $examType->clinic_id;
    }

    public function create(User $user): bool
    {
        return $user->role === 'manager';
    }

    public function update(User $user, ExamType $examType): bool
    {
        return $user->role === 'manager' && $user->clinic_id === $examType->clinic_id;
    }

    public function delete(User $user, ExamType $examType): bool
    {
        return $user->role === 'manager' && $user->clinic_id === $examType->clinic_id;
    }
}