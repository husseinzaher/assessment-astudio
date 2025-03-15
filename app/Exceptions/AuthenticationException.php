<?php

namespace App\Exceptions;

use App\Enums\ExceptionType;

class AuthenticationException extends ApiException
{
    protected $code = 401;
    public function getCustomMessage(): ?string
    {
        return $this->getPrevious()->getMessage();
    }

    public function getExceptionType(): ExceptionType
    {
        return ExceptionType::AuthenticationException;
    }
}
