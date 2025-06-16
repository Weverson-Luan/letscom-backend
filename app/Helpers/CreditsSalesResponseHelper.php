<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class CreditsSalesResponseHelper
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

    public static function mapVendasCredito(array $vendasCreditos): array
    {
        return array_map(function ($vendasCreditos) {
              $vendasCreditos['produto'] = \App\Models\Product::where('id', $vendasCreditos['produto_id'])->first();

              $vendasCreditos['designer'] = \App\Models\User::where('id', $vendasCreditos['user_id_executor'])->first();

            return [
                'id' => $vendasCreditos['id'],
                'user_id' => $vendasCreditos['user_id'],
                'status' => $vendasCreditos['status'],
                'valor' => $vendasCreditos['valor'],
                'quantidade_creditos' => self::formatarValor($vendasCreditos["quantidade_creditos"]),
                'data_venda'=> $vendasCreditos["data_venda"],
                'tipo_transacao'=> $vendasCreditos["tipo_transacao"],
                'produto'=> $vendasCreditos["produto"],
                'designer' => $vendasCreditos['designer'],
                'observacao'=> $vendasCreditos["observacao"],
                'created_at' => $vendasCreditos['created_at'],
                'updated_at' => $vendasCreditos['updated_at'],
                'deleted_at' => $vendasCreditos['deleted_at'],
            ];
        }, $vendasCreditos);
    }

   public static function formatarValor($valor)
    {
        return fmod($valor, 1) == 0.0 ? (int) $valor : number_format($valor, 2, '.', '');
    }
}
