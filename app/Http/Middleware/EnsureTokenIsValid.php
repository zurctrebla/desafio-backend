<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $expectedToken = config('config.api_token_frontend');

        $token = $request->header('Authorization');

        if (empty($expectedToken)) {
            return response()->json(['error' => 'API token not set'], 500);
        }

        if ($token !== $expectedToken) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}
