<?php

namespace App\Exceptions;

use App\Enums\ExceptionType;

class ValidationException extends ApiException
{
    protected $code = 422;

    public function getCustomMessage(): ?string
    {
        return $this->getPrevious()->getMessage();
    }

    public function getExceptionType(): ExceptionType
    {
        return ExceptionType::Validation;
    }

    public function getErrors(): array
    {
        return $this->getPrevious()->errors();
    }
}
