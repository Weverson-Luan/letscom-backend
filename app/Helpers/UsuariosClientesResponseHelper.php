<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class UsuariosClientesResponseHelper
{
    public static function jsonSuccess($message, $data = [], $pagination = null, $code = 200): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'status' => 'success',
            'message' => $message,
            'data' => $data, // ✅ Corrigido aqui
            'pagination' => $pagination ?? [
                'current_page' => 1,
                'last_page' => 1,
                'per_page' => 10,
                'total' => count($data),
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

    public static function mapModelo(array $usuarios): array
    {
        return array_map(function ($usuario) {
            return [
                'id' => $usuario['id'],
                'user_id' => $usuario['user_id'],
                'email' => $usuario['email'],
                'nome' => $usuario['nome'],
                "ativo" => $usuario["ativo"],
                'created_at' => $usuario['created_at'],
                'updated_at' => $usuario['updated_at'],
            ];
        }, $usuarios);
    }
}
