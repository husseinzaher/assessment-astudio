<?php

namespace App\Exceptions;

use App\Enums\ExceptionType;
use Exception;
use Illuminate\Http\JsonResponse;

abstract class ApiException extends Exception
{
    protected $code = 400;

    protected array $customBody = [];

    abstract public function getCustomMessage(): ?string;

    abstract public function getExceptionType(): ExceptionType;

    public function getErrors(): ?array
    {
        return [];
    }

    public function toResponse(): JsonResponse
    {

        return response()->json([
            'status' => false,
            'exception_type' => $this->getExceptionType()->value,
            'message' => $this->getCustomMessage(),
            'errors' => $this->getErrors(),
        ], $this->code);

    }
}
