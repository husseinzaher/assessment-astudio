<?php

namespace App\Exceptions;

use App\Enums\ExceptionType;

class MethodNotAllowed extends ApiException
{
    public function getCustomMessage(): ?string
    {
        return $this->getPrevious()->getMessage();
    }

    public function getExceptionType(): ExceptionType
    {
        return ExceptionType::MethodNotAllowed;
    }
}
