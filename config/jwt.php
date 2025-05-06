<?php

return [
    'secret' => env('JWT_SECRET', 'sua_chave_secreta_aqui'),
    'ttl' => env('JWT_TTL', 60), // tempo em minutos
    'algo' => env('JWT_ALGO', 'HS256')
]; 