<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function viewProfiles(User $user): Response
    {
        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return Response::allow();
        }

        return Response::deny('Nincs adminisztrátori jogosultságod.');
    }

    public function viewProfile(User $user, User $targetUser): Response
    {
        if ($user->id === $targetUser->id) {
            return Response::allow();
        }

        return Response::deny('Nincs jogosultságod más profiljának megtekintéséhez.');
    }

    public function delete(User $user, User $targetUser): Response
    {
        if ($user->isSuperAdmin()) {
            return Response::allow();
        }

        return Response::deny('Csak a szuper adminisztrátor törölhet felhasználókat.');
    }

    public function updateRole(User $user, User $targetUser): Response
    {
        if ($user->isSuperAdmin()) {
            return Response::allow();
        }

        return Response::deny('Csak a szuper adminisztrátor adhat vagy vehet el adminisztrátor jogosultságot.');
    }

    public function updateProfile(User $user, User $targetUser): Response
    {
        if ($user->id === $targetUser->id) {
            return Response::allow();
        }

        return Response::deny('Nincs jogosultságod más profiljának módosításához.');
    }

    public function setPassword(User $user, User $targetUser): Response
    {
        if ($user->id === $targetUser->id) {
            return Response::allow();
        }

        return Response::deny('Nincs jogosultságod más jelszavának módosításához.');
    }

    public function setPasswordByAdmin(User $user, User $targetUser): Response
    {
        if ($user->isSuperAdmin()) {
            return Response::allow();
        }

        return Response::deny('Csak a szuper adminisztrátor módosíthat más jelszót.');
    }

    public function updateProfileByAdmin(User $user, User $targetUser): Response
    {
        if ($user->isSuperAdmin()) {
            return Response::allow();
        }

        return Response::deny('Csak a szuper adminisztrátor módosíthat más profilt.');
    }
}
