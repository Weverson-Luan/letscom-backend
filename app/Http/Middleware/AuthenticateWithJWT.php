<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateWithJWT
{
    public function handle(Request $request, Closure $next): Response
    {
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return response()->json([
                'code' => 401,
                'error' => 'Token de autenticação não fornecido.',
            ], 401);
        }

        $token = str_replace('Bearer ', '', $authHeader);

        try {
            $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));

            $user = User::find($decoded->sub);

            if (!$user) {
                return response()->json([
                    'code' => 401,
                    'error' => 'Usuário associado ao token não foi encontrado.',
                ], 401);
            }

            auth()->setUser($user);

            return $next($request);
        } catch (\Firebase\JWT\ExpiredException $e) {
            return response()->json([
                'code' => 401,
                'error' => 'Token expirado.',
            ], 401);
        } catch (\Firebase\JWT\SignatureInvalidException $e) {
            return response()->json([
                'error' => 'Assinatura do token inválida.',
                'code' => 'invalid_signature'
            ], 401);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Token JWT inválido.',
                'code' => 'invalid_token',
                'message' => $e->getMessage()
            ], 401);
        }
    }
}
