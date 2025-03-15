<?php

use App\Exceptions\ApiException;
use Illuminate\Foundation\Configuration\Exceptions;

return function (Exceptions $exceptions) {

    $exceptions->dontReport([
        ApiException::class,
    ]);

    if (request()->wantsJson()) {
        $exceptions->map(\Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException::class, \App\Exceptions\MethodNotAllowed::class);
        $exceptions->map(\Illuminate\Auth\AuthenticationException::class, \App\Exceptions\AuthenticationException::class);
        $exceptions->map(\Illuminate\Database\Eloquent\ModelNotFoundException::class, \App\Exceptions\ModelNotFoundException::class);
        $exceptions->map(\Illuminate\Validation\ValidationException::class, \App\Exceptions\ValidationException::class);
        $exceptions->map(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class, \App\Exceptions\NotFoundHttpException::class);
    }

    $exceptions->render(function (Throwable $exception) {
        if (method_exists($exception, 'toResponse')) {
            return $exception->toResponse();
        }
    });

    $exceptions->reportable(static function (Throwable $exception) use ($exceptions) {
        $exceptions->dontReportDuplicates();
    });

};
