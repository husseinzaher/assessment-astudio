<?php

namespace Modules\User\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Modules\User\Exceptions\InvalidLoginCredentials;
use Modules\User\Http\Requests\LoginUser;
use Modules\User\Http\Requests\RegisterUser;
use Modules\User\Http\Resources\UserResource;
use Modules\User\Services\AuthService;

class AuthController extends ApiController
{
    public function __construct(private readonly AuthService $authService) {}

    /**
     * Store a newly created resource in storage.
     */
    public function register(RegisterUser $request)
    {
        $user = $this->authService->register($request->validated());

        return self::apiBody([
            'user' => UserResource::make($user),
            'accessToken' => $this->authService->generateAccessToken($user),
        ])->apiResponse();
    }

    /**
     * Display a listing of the resource.
     *
     * @throws InvalidLoginCredentials
     */
    public function login(LoginUser $loginUser)
    {
        $user = $this->authService->login($loginUser->validated());

        return self::apiMessage('Success Login')->apiBody([
            'user' => UserResource::make($user),
            'accessToken' => $this->authService->generateAccessToken($user),
        ])->apiResponse();
    }

    /**
     * Show the specified resource.
     */
    public function logout()
    {
        $this->authService->logout(auth()->user());

        return self::apiMessage('Logged out successfully')->apiResponse();
    }
}
