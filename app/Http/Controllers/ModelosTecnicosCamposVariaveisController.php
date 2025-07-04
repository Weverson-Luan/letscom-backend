<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\ModelosTecnicosCamposVariaveisService;
use App\Helpers\ModelosTecnicosCamposResponseHelper;

class ModelosTecnicosCamposVariaveisController extends Controller
{
    protected $service;

    public function __construct(ModelosTecnicosCamposVariaveisService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $response = $this->service->list($request->all());

            return ModelosTecnicosCamposResponseHelper::jsonSuccess(
                $response['message'],
                $response['data'],
                $response['pagination']
            );
        } catch (\Throwable $e) {
            Log::error('Erro ao listar campos variáveis: ' . $e->getMessage());
            return ModelosTecnicosCamposResponseHelper::jsonError('Erro ao carregar campos variáveis.');
        }
    }

    public function store(Request $request)
    {
        try {
            $result = $this->service->create($request->all());

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Campos variáveis criados com sucesso!',
                'data' => $result
            ]);
        } catch (\Throwable $e) {
            Log::error('Erro ao criar campos variáveis: ' . $e->getMessage());
            // Tratamento de erro de chave estrangeira
            if ($e->getCode() === '23000') {
                return response()->json([
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'O modelo técnico informado não existe. Verifique o ID e tente novamente.',
                    'data' => [],
                ], 400);
            }

            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => [],
                'pagination' => null
            ], 500);
        }
    }


    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $success = $this->service->update($id, $request->all());
            return ModelosTecnicosCamposResponseHelper::jsonSuccess('Campo atualizado com sucesso.', $success);
        } catch (\Throwable $e) {
            Log::error('Erro ao atualizar campo variável: ' . $e->getMessage());
            return ModelosTecnicosCamposResponseHelper::jsonError('Erro ao atualizar campo variável.');
        }
    }


    public function destroy(int $id): JsonResponse
    {
        try {
            $success = $this->service->delete($id);
            return ModelosTecnicosCamposResponseHelper::jsonSuccess('Campo removido com sucesso.', []);
        } catch (\Throwable $e) {
            Log::error('Erro ao excluir campo variável: ' . $e->getMessage());
            return ModelosTecnicosCamposResponseHelper::jsonError($e->getMessage());
        }
    }
}
