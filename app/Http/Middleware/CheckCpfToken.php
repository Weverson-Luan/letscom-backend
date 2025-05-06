<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Cache;

class CheckCpfToken
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['error' => 'Usuário não autenticado'], 401);
        }

        $cpfToken = $request->header('X-CPF-Token');

        if (!$cpfToken || !Cache::has("cpf_token:{$cpfToken}")) {
            $newToken = $this->userService->generateCpfToken($user->CPF);
            $request->headers->set('X-CPF-Token', $newToken);
        }

        return $next($request);
    }
}
