<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AcceptsJsonMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->hasHeader('Accept') || $request->header('Accept') !== 'application/json' || $request->header('Content-Type') !== 'application/json') {
            return response()->json(['error' => 'Invalid request headers'], 400);
        }

        return $next($request);
    }
}
