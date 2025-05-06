<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;

class CheckPermission
{
    protected $userService;

    /**
     * Construtor do middleware CheckPermission.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Manipula uma requisição recebida.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $resource = null, string $action = null)
    {
        $user = $request->user();

        if (!$user) {
            Log::warning('Usuário não autenticado na verificação de permissão');
            return response()->json(['error' => 'Usuário não autenticado'], 401);
        }

        $cpf = $user->cpf;

        if (!$cpf) {
            Log::warning('CPF do usuário não encontrado', ['user' => $user]);
            return response()->json(['error' => 'CPF do usuário não encontrado'], 401);
        }

        if (!$this->userService->hasPermission($cpf, $resource, $action)) {
            Log::warning('Usuário sem permissão', [
                'cpf' => $cpf,
                'resource' => $resource,
                'action' => $action
            ]);
            return response()->json(['error' => 'Acesso não autorizado'], 403);
        }

        return $next($request);
    }
}
