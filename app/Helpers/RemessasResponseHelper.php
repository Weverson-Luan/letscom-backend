<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class RemessasResponseHelper
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

    public static function jsonCriacaoSuccess($message, $data = [], $pagination = null, $code = 200): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'status' => 'success',
            'message' => $message,
            'data' => $data[0],
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

    public static function mapRemessas(array $remessas): array
    {
        return array_map(function ($remessa) {
                  $dataRemessa = Carbon::parse($remessa->data_remessa);
                  $diasCorridos = $dataRemessa->diffInDays(Carbon::now());

            return [
                'id' => $remessa->id,
                'total_solicitacoes' => $remessa->total_solicitacoes,
                'situacao' => $remessa->situacao,
                'data_remessa' => $remessa->data_remessa,
                'data_inicio_producao' => $remessa->data_inicio_producao,
                'posicao' => $remessa->posicao,
                'observacao'=> $remessa->observacao,
                'tecnologia' => $remessa->tecnologia,
                'prazo' => (int) $dataRemessa->diffInDays(Carbon::now()), // dias corridos aprtir da data criacao
                'cliente' => \App\Models\User::find($remessa->user_id),
                'solicitante' => \App\Models\User::find($remessa->user_id_solicitante_remessa),
                'consultor' => \App\Models\UserCliente::where("cliente_id", $remessa->user_id)->first(),
                'designer' => \App\Models\User::find($remessa->user_id_executor),
                'modelo_tecnico' => \App\Models\ModeloTecnico::find($remessa->modelo_tecnico_id),
                'created_at' => $remessa->created_at,
                'updated_at' => $remessa->updated_at,
                'deleted_at' => $remessa->deleted_at,
            ];
        }, $remessas);
    }
}

