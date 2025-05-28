<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class TiposEntregaResponseHelper
{
    public static function jsonSuccess($message, $data = [], $pagination = null, $code = 200): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'status' => 'success',
            'message' => $message,
            'data' => $data,
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

    public static function mapTiposEntrega(array|object $data): array
{
    return array_map(function ($item) {
        // Garante que é um objeto (pode vir como array se for ->toArray())
        $item = (object) $item;

        return [
            'id' => $item->id,
            'tipo' => $item->tipo,
            // 'cliente_id' => $item->cliente_id,
            'endereco_entrega_id' => $item->endereco_entrega_id,
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at,
            // 'deleted_at' => $item->deleted_at ?? null,
        ];
    }, is_array($data) ? $data : $data->toArray());
}

}
