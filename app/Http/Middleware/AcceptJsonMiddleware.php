<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AcceptJsonMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $request->headers->set('Accept', 'application/json');

        return $next($request);
    }
}
