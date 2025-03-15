<?php

namespace App\Exceptions;

use App\Enums\ExceptionType;

class ModelNotFoundException extends ApiException
{
    protected $code = 404;
    public function getCustomMessage(): ?string
    {
        return 'Record not found';
    }

    public function getExceptionType(): ExceptionType
    {
        return ExceptionType::NotFoundHttpException;
    }
}
