<?php

namespace Modules\User\Exceptions;

use App\Enums\ExceptionType;
use App\Exceptions\ApiException;

class InvalidLoginCredentials extends ApiException
{
    public function getCustomMessage(): ?string
    {
        return 'Invalid login credentials';
    }

    public function getExceptionType(): ExceptionType
    {
        return ExceptionType::InvalidLoginCredentials;
    }
}
