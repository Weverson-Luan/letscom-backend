<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user || !$user->roles()->whereIn('nome', $roles)->exists()) {
            return response()->json(
                [
                    'status'=> 403,
                    'message' => 'Acesso não autorizado para usuário.',
                    'data'=> null
                ]
                , 403);
        }

        return $next($request);
    }
}
