<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Log;

class JWTService
{
    public function createToken(array $payload): string
    {
        $payload['iat'] = time();
        $payload['exp'] = time() + (24 * 60 * 60); // 24 horas

        return JWT::encode(
            $payload,
            config('jwt.secret'),
            config('jwt.algo')
        );
    }

    public function validateToken(string $token): array
    {
        Log::info('Configurações JWT:', [
            'algo' => config('jwt.algo'),
            'ttl' => config('jwt.ttl'),
            'secret_length' => strlen(config('jwt.secret'))
        ]);

        return (array) JWT::decode(
            $token,
            new Key(config('jwt.secret'), config('jwt.algo'))
        );
    }
}
