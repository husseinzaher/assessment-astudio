<?php

namespace App\Traits;

/**
 * @version 1.0
 */
trait ApiResponse
{
    protected int $code = 200;

    protected array|object $body = [];

    protected ?string $message = null;

    protected function apiResponse(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => $this->code === 200,
            'message' => $this->message,
            'body' => (object) $this->body,
        ], $this->code);
    }

    protected function apiBody(array|object $body = []): static
    {
        if (! is_object($body)) {
            $this->body = $body;
        }

        if (! is_array($body)) {
            foreach ($body as $key => $value) {
                $this->body[$key] = $value;
            }
        }

        return $this;
    }

    protected function apiMessage(string $message = ''): static
    {
        $this->message = $message;

        return $this;
    }

    protected function apiCode(int $code): static
    {
        $this->code = $code;

        return $this;
    }
}
