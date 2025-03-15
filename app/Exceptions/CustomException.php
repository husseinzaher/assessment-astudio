<?php

namespace App\Exceptions;

use App\Enums\ExceptionType;

class CustomException extends ApiException
{
    public function getCustomMessage(): ?string
    {
        return $this->message;
    }

    public function getExceptionType(): ExceptionType
    {
        return ExceptionType::AccessDenied;
    }
}
