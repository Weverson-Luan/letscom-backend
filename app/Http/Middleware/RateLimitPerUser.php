<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class RateLimitPerUser
{
    public function handle(Request $request, Closure $next): Response
    {
        // $user = $request->user();
        // $key = 'rate_limit_' . ($user ? $user->CPF : $request->ip());

        // if ($request->is('api/login')) {
        //     $key = 'rate_limit_login_' . $request->ip();
        // }

        // if (RateLimiter::tooManyAttempts($key, 50)) {
        //     return response()->json(['error' => 'Limite de requisições excedido. Tente novamente mais tarde.'], 429);
        // }

        // RateLimiter::hit($key, 60);

        return $next($request);
    }
}
