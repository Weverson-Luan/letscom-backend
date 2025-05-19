<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class TecnologiasResponseHelper
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

    public static function mapTecnologias(array $data): array
    {
        return array_map(function ($data) {
            return [
                'id'=> $data->id,
                'nome' => $data->nome,
                'descricao'=> $data->descricao,
                'ativo'=> $data->ativo,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
                'deleted_at' => $data->deleted_at,
            ];
        }, $data);
    }
}

