<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ProductsResponseHelper
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

    public static function mapProdutos(array $products): array
    {
        return array_map(function ($product) {
            return [
                'id'=> $product->id,
                'nome' => $product->nome,
                'valor'=> $product->valor,
                'valor_creditos' => $product->valor_creditos,
                'tecnologia'=>  $product->tecnologia,
                'estoque_maximo'=>  $product->estoque_maximo,
                'estoque_minimo'=>  $product->estoque_minimo,
                'estoque_atual'=>  $product->estoque_minimo,
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
                'deleted_at' => $product->deleted_at,
            ];
        }, $products);
    }
}

