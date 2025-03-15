<?php

namespace App\Enums;

enum Guard: string
{
    case User = 'user';
    case UserSession = 'user_session';

    public function middleware(): string
    {
        return 'auth:'.$this->value;
    }

    public function authUser(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        return auth($this->value)->user();
    }
}
