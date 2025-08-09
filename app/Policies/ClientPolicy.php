<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;

class ClientPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'manager';
    }

    public function view(User $user, Client $client): bool
    {
        return $user->role === 'manager' && $user->clinic_id === $client->clinic_id;
    }

    public function create(User $user): bool
    {
        return $user->role === 'manager';
    }

    public function update(User $user, Client $client): bool
    {
        return $user->role === 'manager' && $user->clinic_id === $client->clinic_id;
    }

    public function delete(User $user, Client $client): bool
    {
        return $user->role === 'manager' && $user->clinic_id === $client->clinic_id;
    }
}