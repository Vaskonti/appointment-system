<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->hasHeader('Accept') || $request->header('Accept') !== 'application/json'){
            return response()->json(['error' => 'Invalid request headers'], 400);
        }

        return $next($request);
    }
}
