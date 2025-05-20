<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UsersResponseHelper
{
 public static function jsonSuccess($message, $users = [], $pagination = null, $code = 200): JsonResponse
{
    $mappedUsers = array_map(function ($user) {
        $creditSales = \App\Models\CreditSale::where('user_id', $user['id'])
        ->where('status', 'confirmado')
        ->get();

        $entradas = $creditSales->where('tipo_transacao', 'entrada')->sum('quantidade_creditos');
        $saidas = $creditSales->where('tipo_transacao', 'saida')->sum('quantidade_creditos');

        $user['consultor'] = \App\Models\UserCliente::where('user_id', $user['id'])->first();
        $user['designer'] = isset($user['user_id_executor'])
            ? \App\Models\User::find($user['user_id_executor'])
            : null;

        $userModel = \App\Models\User::find($user['id']);
        $user['produto'] = $userModel?->produtosVinculados()?->first()?->makeHidden('pivot');

        $user['creditos'] = [
            'saldo' => $entradas - $saidas,
            'entradas' => $entradas,
            'saidas' => $saidas,
        ];




        return $user;
    }, $users);

    return response()->json([
        'code' => $code,
        'status' => 'success',
        'message' => $message,
        'data' => $mappedUsers,
        'pagination' => $pagination ?? [
            'current_page' => 1,
            'last_page' => 1,
            'per_page' => 10,
            'total' => count($mappedUsers),
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
}
