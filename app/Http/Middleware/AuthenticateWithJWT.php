<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Database\Factories\JWTDecoderFactory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Services\JWTService;

class AuthenticateWithJWT
{
    protected $jwtService;

    public function __construct(JWTService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    /**
     * Manipula uma requisição recebida.
     *
     * Este método verifica se o token JWT fornecido é válido e está armazenado no cache.
     * Se o token for válido e estiver no cache, a requisição é permitida.
     * Caso contrário, uma resposta de erro é retornada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {   
        try {
            // Log do header de autorização
            $authHeader = $request->header('Authorization');
            Log::info('Header de autorização recebido:', ['Authorization' => $authHeader]);

            // Extrai o token
            $token = str_replace('Bearer ', '', $authHeader);
            Log::info('Token extraído:', ['token' => $token]);
            
            // Tenta validar o token
            try {
                $payload = $this->jwtService->validateToken($token);
                Log::info('Payload do token:', ['payload' => $payload]);
            } catch (\Exception $e) {
                Log::error('Erro na validação do token:', [
                    'error' => $e->getMessage(),
                    'token' => $token
                ]);
                throw $e;
            }
            
            // Busca o usuário
            $user = User::find($payload['sub']); // Alterado para acessar como array
            Log::info('Usuário encontrado:', ['user' => $user ? $user->toArray() : null]);
            
            if (!$user) {
                Log::warning('Usuário não encontrado para o CPF:', ['cpf' => $payload['sub']]);
                return response()->json(['error' => 'Usuário não encontrado'], 401);
            }
            
            // Define o usuário autenticado
            auth()->setUser($user);
            
            // Adiciona o payload do token à requisição
            $request->auth = $payload;
            
            return $next($request);
        } catch (\Exception $e) {
            Log::error('Erro na autenticação JWT:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Token JWT inválido ou expirado'], 401);
        }
    }
}
