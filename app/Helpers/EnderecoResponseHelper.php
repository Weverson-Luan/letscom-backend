<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class EnderecoResponseHelper
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

    public static function mapEnderecos(array $enderecos): array
    {
        return array_map(function ($endereco) {
            return [
            'id' => $endereco['id'],
            'user_id' => $endereco['user_id'],
            'logradouro' => $endereco['logradouro'],
            'numero' => $endereco['numero'],
            'complemento' => $endereco['complemento'],
            'bairro' => $endereco['bairro'],
            'cidade' => $endereco['cidade'],
            'estado' => $endereco['estado'],
            'cep' => $endereco['cep'],
            'ativo' => $endereco['ativo'],
            'tipo_endereco' => $endereco['tipo_endereco'],
            'nome_responsavel' => $endereco['nome_responsavel'],
            'email' => $endereco['email'],
            'setor' => $endereco['setor'],
            'telefone' => $endereco['telefone'],
            'user' => $endereco['user'],
            'created_at' => $endereco['created_at'],
            'updated_at' => $endereco['updated_at'],
            'deleted_at' => $endereco['deleted_at'],
            ];
        }, $enderecos);
    }
}

