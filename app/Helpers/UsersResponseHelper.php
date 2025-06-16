<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UsersResponseHelper
{
    public static function jsonSuccess($message, $users = [], $pagination = null, $code = 200): JsonResponse
    {
        $mappedUsers = array_map(function ($user) {

            // buscando dados de créditos de cada cliente
            $creditSales = \App\Models\CreditSale::where('cliente_id', $user['id'])
                ->where('status', 'confirmado')
                ->get();

            // buscando apenas as transações do tipo de entrada
            $entradas = $creditSales->where('tipo_transacao', 'entrada')->sum('quantidade_creditos');

            // buscando apenas as transações do tipo de saida
            $saidas = $creditSales->where('tipo_transacao', 'saida')->sum('quantidade_creditos');

            // buscando por consultor que vai atender o cliente ex: [Luan -> Fiat]
            $user['consultor'] = $user->consultores()->first();

            // buscando os usuários do cliente ex: [Fiat -> clint1, client2, WLTECH -> client]
            $user["contato"] = \App\Models\UserCliente::where('cliente_id', $user['id'])->first();

            // buscando o responsável por executar tarefas
            $user['designer'] = isset($user['user_id_executor'])
                ? \App\Models\User::find($user['user_id_executor'])
                : null;

            // buscando dados do produto vinculado ao usuários
            $userModel = \App\Models\User::find($user['id']);
            $user['produto'] = $userModel?->produtosVinculados()?->first()?->makeHidden('pivot');

            // buscando endereços relacionado com usuários
            $enderecoModel = \App\Models\Endereco::where('user_id', $user->id)->first();
            $user['enderecos'] = $enderecoModel;

            // buscando créditos relacionados com usuários
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

    public static function jsonSingleUser($message, $user, $code = 200): JsonResponse
    {
        // Esconde o campo "pivot" de cada item de tiposEntrega
        if ($user->relationLoaded('tiposEntrega')) {
            $user->tiposEntrega->makeHidden(['pivot']);
        }

        return response()->json([
            'code' => $code,
            'status' => 'success',
            'message' => $message,
            'data' => $user,
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

    public static function jsonErrorNotFoud($message, $code = 404): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'status' => 'error',
            'message' => $message,
        ], $code);
    }
}
