<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Product $product): bool
    {
        return true;
    }

    public function create(User $user): Response
    {
        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return Response::allow();
        }

        return Response::deny('Nincs jogosultságod termék létrehozásához.');
    }

    public function update(User $user, Product $product): Response
    {
        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return Response::allow();
        }

        return Response::deny('Nincs jogosultságod termék szerkesztéséhez.');
    }

    public function delete(User $user, Product $product): Response
    {
        if ($user->isSuperAdmin()) {
            return Response::allow();
        }

        return Response::deny('Nincs jogosultságod termék törléséhez.');
    }
}
