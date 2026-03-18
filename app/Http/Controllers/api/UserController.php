<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\SetPasswordRequest;
use App\Http\Requests\UpdateMyProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Traits\ResponseTrait;
use App\Models\User;
use App\Services\RegisterService;


class UserController extends Controller
{
    use ResponseTrait;

    protected RegisterService $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        if(Auth::attempt($validated)){
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return $this->sendResponse([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }else{
            return $this->sendError('Hibás email vagy jelszó', [], 401);
        }
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        return $this->registerService->create($validated);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->sendResponse([], 'Sikeres kijelentkezés');
    }

    public function getProfile(Request $request)
    {
        $user = $request->user();
        Gate::authorize('viewProfile', $user);

        return $this->registerService->getProfile($user);
    }

    public function updateProfile(UpdateMyProfileRequest $request)
    {
        $user = $request->user();
        Gate::authorize('updateProfile', $user);

        $validated = $request->validated();
        return $this->registerService->updateProfile($user, $validated);
    }

    public function setPassword(SetPasswordRequest $request)
    {
        $user = $request->user();
        Gate::authorize('setPassword', $user);

        $validated = $request->validated();
        return $this->registerService->setPassword($user, $validated['password']);
    }

    public function getProfiles()
    {
        Gate::authorize('viewProfiles', User::class);
        return $this->registerService->getProfiles();
    }

    public function makeAdmin(User $user)
    {
        Gate::authorize('updateRole', $user);
        return $this->registerService->makeAdmin($user);
    }

    public function removeAdmin(User $user)
    {
        Gate::authorize('updateRole', $user);
        return $this->registerService->removeAdmin($user);
    }

    public function deleteUser(User $user)
    {
        Gate::authorize('delete', $user);
        return $this->registerService->deleteUser($user);
    }

    public function setPasswordByAdmin(SetPasswordRequest $request, User $user)
    {
        Gate::authorize('setPasswordByAdmin', $user);

        $validated = $request->validated();
        return $this->registerService->setPasswordByAdmin($user, $validated['password']);
    }

    public function updateProfileByAdmin(UpdateMyProfileRequest $request, User $user)
    {
        Gate::authorize('updateProfileByAdmin', $user);

        $validated = $request->validated();
        return $this->registerService->updateProfileByAdmin($user, $validated);
    }
}
