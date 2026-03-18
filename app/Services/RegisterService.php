<?php

namespace App\Services;

use App\Mail\WelcomeMail;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RegisterService
{
    use ResponseTrait;

    public function create(array $data): JsonResponse
    {
        $plainPassword = $data['password'];

        $user = DB::transaction(function () use ($data, $plainPassword) {
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->role = 'user';
            $user->password = Hash::make($plainPassword);
            $user->save();

            $user->profile()->create([
                'full_name' => $data['full_name'],
                'city' => $data['city'] ?? null,
                'address' => $data['address'] ?? null,
                'phone_number' => $data['phone_number'] ?? null,
                'birth_date' => $data['birth_date'] ?? null,
            ]);

            return $user->fresh('profile');
        });

        Mail::to($user->email)->send(new WelcomeMail($user, $plainPassword));

        event(new Registered($user));

        return $this->sendResponse($user, 'Sikeres regisztráció.');
    }

    public function getProfile(User $user): JsonResponse
    {
        return $this->sendResponse($user->load('profile'), 'Profil lekérve.');
    }

    public function getProfiles(): JsonResponse
    {
        $users = User::with('profile')->get();
        return $this->sendResponse($users, 'Felhasználók lekérve.');
    }

    public function makeAdmin(User $targetUser): JsonResponse
    {
        if ($targetUser->role === 'super_admin') {
            return $this->sendError('A szuper admin szerepkör nem módosítható.', [], 422);
        }

        Log::channel('user')->info('make_admin', [
            'actor_user_id' => request()->user()?->id,
            'actor_role' => request()->user()?->role,
            'target_user_id' => $targetUser->id,
        ]);

        $targetUser->role = 'admin';
        $targetUser->save();

        return $this->sendResponse($targetUser, 'Felhasználó admin jogosultságot kapott.');
    }

    public function removeAdmin(User $targetUser): JsonResponse
    {
        if ($targetUser->role === 'super_admin') {
            return $this->sendError('A szuper admin szerepkör nem módosítható.', [], 422);
        }

        Log::channel('user')->info('remove_admin', [
            'actor_user_id' => request()->user()?->id,
            'actor_role' => request()->user()?->role,
            'target_user_id' => $targetUser->id,
        ]);

        $targetUser->role = 'user';
        $targetUser->save();

        return $this->sendResponse($targetUser, 'Admin jogosultság elvéve.');
    }

    public function deleteUser(User $targetUser): JsonResponse
    {
        if ($targetUser->role === 'super_admin') {
            return $this->sendError('A szuper admin felhasználó nem törölhető.', [], 422);
        }

        Log::channel('user')->info('delete_user', [
            'actor_user_id' => request()->user()?->id,
            'actor_role' => request()->user()?->role,
            'target_user_id' => $targetUser->id,
        ]);

        $deleted = $targetUser->delete();
        return $this->sendResponse($deleted, 'Felhasználó törölve.');
    }

    public function setPassword(User $user, string $password): JsonResponse
    {
        Log::channel('user')->info('self_set_password', [
            'user_id' => $user->id,
            'role' => $user->role,
        ]);

        $user->password = Hash::make($password);
        $user->save();

        return $this->sendResponse(true, 'Jelszó sikeresen módosítva.');
    }

    public function updateProfile(User $user, array $data): JsonResponse
    {
        Log::channel('user')->info('self_update_profile', [
            'user_id' => $user->id,
            'role' => $user->role,
        ]);

        $profileData = $this->onlyProfileFields($data);

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );

        return $this->sendResponse($user->fresh('profile'), 'Profil sikeresen frissítve.');
    }

    public function setPasswordByAdmin(User $targetUser, string $password): JsonResponse
    {
        if ($targetUser->role === 'super_admin') {
            return $this->sendError('A szuper admin jelszava itt nem módosítható.', [], 422);
        }

        Log::channel('user')->info('admin_set_password', [
            'actor_user_id' => request()->user()?->id,
            'actor_role' => request()->user()?->role,
            'target_user_id' => $targetUser->id,
        ]);

        $targetUser->password = Hash::make($password);
        $targetUser->save();

        return $this->sendResponse(true, 'Jelszó sikeresen módosítva (admin).');
    }

    public function updateProfileByAdmin(User $targetUser, array $data): JsonResponse
    {
        Log::channel('user')->info('admin_update_profile', [
            'actor_user_id' => request()->user()?->id,
            'actor_role' => request()->user()?->role,
            'target_user_id' => $targetUser->id,
        ]);

        $profileData = $this->onlyProfileFields($data);

        $targetUser->profile()->updateOrCreate(
            ['user_id' => $targetUser->id],
            $profileData
        );

        return $this->sendResponse($targetUser->fresh('profile'), 'Profil sikeresen frissítve (admin).');
    }

    private function onlyProfileFields(array $data): array
    {
        return array_filter(
            [
                'full_name' => $data['full_name'] ?? null,
                'city' => $data['city'] ?? null,
                'address' => $data['address'] ?? null,
                'phone_number' => $data['phone_number'] ?? null,
                'birth_date' => $data['birth_date'] ?? null,
            ],
            static fn ($value) => $value !== null
        );
    }
}
