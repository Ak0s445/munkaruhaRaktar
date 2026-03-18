<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isSuperAdmin();
    }

    public function view(User $user, Category $category): bool
    {
        return $user->isAdmin() || $user->isSuperAdmin();
    }

    public function create(User $user): Response
    {
        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return Response::allow();
        }

        return Response::deny('Nincs jogosultságod kategória létrehozásához.');
    }

    public function update(User $user, Category $category): Response
    {
        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return Response::allow();
        }

        return Response::deny('Nincs jogosultságod kategória szerkesztéséhez.');
    }

    public function delete(User $user, Category $category): Response
    {
        if ($user->isSuperAdmin()) {
            return Response::allow();
        }

        return Response::deny('Nincs jogosultságod kategória törléséhez.');
    }
}
