<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

class ModeloTecnicosResponseHelper
{
    public static function jsonSuccess($message, $data = [], $pagination = null, $code = 200): JsonResponse
    {
            if (is_object($data) && method_exists($data, 'toArray')) {
                $data = $data->toArray();
            }

            return response()->json([
                'code' => $code,
                'status' => 'success',
                'message' => $message,
                'data' => $data,
                'pagination' => $pagination ?? [
                    'current_page' => 1,
                    'last_page' => 1,
                    'per_page' => 10,
                    'total' => is_array($data) ? count($data) : 1,
                ]
            ], $code);
    }

    public static function jsonError($message, $code = 500): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'status' => 'error',
            'message' => $message,
            'data' => [],
            'pagination' => null
        ], $code);
    }

public static function mapModelos(array $modelos): array
{
    return array_map(function ($modelo) {
        return self::mapModelo($modelo->toArray());
    }, $modelos);
}
public static function mapModelo($modelo): array
{
    if (is_object($modelo) && method_exists($modelo, 'toArray')) {
        $modelo = $modelo->toArray(); // ← converte aqui
    }

    return [
        ...$modelo,
        'foto_frente_url' => filled(Arr::get($modelo, 'foto_frente_path'))
            ? asset(Storage::url($modelo['foto_frente_path']))
            : null,

        'foto_verso_url' => filled(Arr::get($modelo, 'foto_verso_path'))
            ? asset(Storage::url($modelo['foto_verso_path']))
            : null,
    ];
}

}
