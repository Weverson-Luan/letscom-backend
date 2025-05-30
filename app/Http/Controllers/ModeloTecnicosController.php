<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\ModeloTecnicosService;
use App\Models\ModeloTecnico;
use App\Helpers\ModeloTecnicosResponseHelper;

class ModeloTecnicosController extends Controller
{
    protected ModeloTecnicosService $service;

    public function __construct(ModeloTecnicosService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $response = $this->service->list($request->all());

            // Mapeia os caminhos das imagens
            $modelos = ModeloTecnicosResponseHelper::mapModelos($response['data']);

            return ModeloTecnicosResponseHelper::jsonSuccess(
                $response['message'],
                $modelos,
                $response['pagination']
            );
        } catch (\Throwable $e) {
            Log::error('Erro ao listar modelos técnicos: ' . $e->getMessage());
            return ModeloTecnicosResponseHelper::jsonError($e->getMessage());
        }
    }

    public function buscarPorUsuarios(Request $request, int $id): JsonResponse
    {
        try {
            $params = $request->all();
            $params['cliente_id'] = $id;

            $response = $this->service->listPorUsuario($params);

            // obtém os modelos da paginação
            $modelos = $response->items();

            // mapeia os dados para o formato customizado
            $modelosFormatados = ModeloTecnicosResponseHelper::mapModelos($modelos);

        //  retorna o JSON com paginação
        return ModeloTecnicosResponseHelper::jsonSuccess(
            'Modelos carregados com sucesso!',
            $modelosFormatados,
            [
                'current_page' => $response->currentPage(),
                'last_page' => $response->lastPage(),
                'per_page' => $response->perPage(),
                'total' => $response->total(),
            ]
        );
        } catch (\Throwable $e) {
            Log::error('Erro ao listar modelos técnicos: ' . $e->getMessage());
            return ModeloTecnicosResponseHelper::jsonError($e->getMessage());
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $data = $request->all();

            if ($request->hasFile('foto_frente')) {
                $data['foto_frente_path'] = $request->file('foto_frente')->store('modelos/frente', 'public');
            }

            if ($request->hasFile('foto_verso')) {
                $data['foto_verso_path'] = $request->file('foto_verso')->store('modelos/verso', 'public');
            }

            $modelo = $this->service->create($data);

            return ModeloTecnicosResponseHelper::jsonSuccess(
                'Modelo criado com sucesso!',
                $modelo,
                [],
                201
            );
        } catch (\Throwable $e) {
            Log::error('Erro ao criar modelo técnico: ' . $e->getMessage());
            return ModeloTecnicosResponseHelper::jsonError($e->getMessage());
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $modelo = $this->service->find($id);

            return ModeloTecnicosResponseHelper::jsonSuccess(
                'Modelo encontrado com sucesso.',
                $modelo
            );
        } catch (\Throwable $e) {
            Log::error('Erro ao exibir modelo técnico: ' . $e->getMessage());
            return ModeloTecnicosResponseHelper::jsonError('Erro ao exibir modelo técnico.');
        }
    }


public function atualizarModelo(Request $request, int $id): JsonResponse
{
    try {


        $data = $request->all();

        // Salva imagens se forem enviadas
        if ($request->hasFile('foto_frente')) {
            $data['foto_frente_path'] = $request->file('foto_frente')->store('modelos/frente', 'public');
        }

        if ($request->hasFile('foto_verso')) {
            $data['foto_verso_path'] = $request->file('foto_verso')->store('modelos/verso', 'public');
        }

        $modelo = $this->service->atualizarModelo($id, $data);

        return ModeloTecnicosResponseHelper::jsonSuccess(
            'Modelo atualizado com sucesso.',
            $modelo
        );
    } catch (\Throwable $e) {
        Log::error('Erro ao atualizar modelo técnico: ' . $e->getMessage());
        return ModeloTecnicosResponseHelper::jsonError($e->getMessage());
    }
}


    public function destroy(int $id): JsonResponse
    {
        try {
            $this->service->delete($id);

            return ModeloTecnicosResponseHelper::jsonSuccess(
                'Modelo excluído com sucesso.',
                null
            );
        } catch (\Throwable $e) {
            Log::error('Erro ao excluir modelo técnico: ' . $e->getMessage());
            return ModeloTecnicosResponseHelper::jsonError('Erro ao excluir modelo técnico.');
        }
    }
}
