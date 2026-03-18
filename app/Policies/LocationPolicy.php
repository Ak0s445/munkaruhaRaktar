<?php

namespace App\Policies;

use App\Models\Location;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LocationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isSuperAdmin();
    }

    public function view(User $user, Location $location): bool
    {
        return $user->isAdmin() || $user->isSuperAdmin();
    }

    public function create(User $user): Response
    {
        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return Response::allow();
        }

        return Response::deny('Nincs jogosultságod hely létrehozásához.');
    }

    public function update(User $user, Location $location): Response
    {
        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return Response::allow();
        }

        return Response::deny('Nincs jogosultságod hely szerkesztéséhez.');
    }

    public function delete(User $user, Location $location): Response
    {
        if ($user->isSuperAdmin()) {
            return Response::allow();
        }

        return Response::deny('Nincs jogosultságod hely törléséhez.');
    }
}
