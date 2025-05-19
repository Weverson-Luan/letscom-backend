<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
// use App\Http\Middleware\CheckPermission;
use App\Http\Middleware\AuthenticateWithJWT;
// use App\Http\Middleware\CheckCpfToken;
use App\Http\Middleware\RateLimitPerUser;
use App\Http\Middleware\IcronoeventosLogger;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth.jwt' => AuthenticateWithJWT::class,
            'rate.limit.user' => RateLimitPerUser::class,
            'role' => \App\Http\Middleware\CheckRole::class, // 👈 Adicione esta linha
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->booting(function (Application $app) {
        RateLimiter::for('api', function (Request $request) {
            $user = $request->user();
            return Limit::perMinute(50)->by($user ? $user->CPF : $request->ip());
        });
    })
    ->create();
