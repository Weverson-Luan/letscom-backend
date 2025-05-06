<?php

namespace Database\Factories;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTDecoderFactory
{
    /**
     * Cria uma instância do decodificador JWT.
     *
     * @return object
     */
    public static function create(): object
    {
        return new class {
            /**
             * Decodifica um token JWT.
             *
             * @param string $token
             * @return object
             */
            public function decode(string $token): object
            {
                $key = new Key(env('JWT_SECRET'), 'HS256');
                return JWT::decode($token, $key);
            }
        };
    }
}

