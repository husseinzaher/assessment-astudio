<?php

namespace Modules\User\Services;

use App\Enums\Guard;
use Modules\User\Exceptions\InvalidLoginCredentials;
use Modules\User\Models\User;

class AuthService
{
    public function register(array $data): User
    {
        return User::create($data);
    }

    /**
     * @throws InvalidLoginCredentials
     */
    public function login(array $credentials): User
    {
        $guard = Guard::UserSession->value;

        if (! auth($guard)->attempt($credentials)) {
            throw new InvalidLoginCredentials;
        }

        return auth($guard)->user();
    }

    public function generateAccessToken(User $user): string
    {
        return $user->createToken('user')->accessToken;
    }

    public function logout(User $user): void
    {
        $this->deleteAuthTokens($user);
    }

    private function deleteAuthTokens(User $user): void
    {
        $user->tokens()->delete();
    }
}
