<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\Log;
use App\Models\Remessa;
use App\Services\RemessaService;
use App\Helpers\RemessasResponseHelper;
use Illuminate\Support\Facades\Auth;

class RemessaController extends Controller
{
    protected RemessaService $service;

    public function __construct(RemessaService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        try {

            $remessasPaginadas = $this->service->list($request->all());

            $data = RemessasResponseHelper::mapRemessas($remessasPaginadas->items());

            return RemessasResponseHelper::jsonSuccess(
                'Remessas carregadas com sucesso!',
                $data,
                [
                    'current_page' => $remessasPaginadas->currentPage(),
                    'last_page' => $remessasPaginadas->lastPage(),
                    'per_page' => $remessasPaginadas->perPage(),
                    'total' => $remessasPaginadas->total(),
                ]
            );
        } catch (\Throwable $e) {
            Log::error('Erro ao listar remessas: ' . $e->getMessage());
            return RemessasResponseHelper::jsonError('Erro ao carregar remessas.');
        }
    }

    public function tarefasDisponiveis(Request $request): JsonResponse
    {
        try {
            $remessasPaginadas = $this->service->listarDisponiveisParaProducao($request->all());
            $data = RemessasResponseHelper::mapRemessas($remessasPaginadas->items());

            return RemessasResponseHelper::jsonSuccess(
                'Remessas disponíveis carregadas com sucesso!',
                $data,
                [
                    'current_page' => $remessasPaginadas->currentPage(),
                    'last_page' => $remessasPaginadas->lastPage(),
                    'per_page' => $remessasPaginadas->perPage(),
                    'total' => $remessasPaginadas->total(),
                ]
            );
        } catch (\Throwable $e) {
            Log::error('Erro ao listar remessas disponíveis: ' . $e->getMessage());
            return RemessasResponseHelper::jsonError($e->getMessage());
        }
    }

    public function minhasTarefas(Request $request): JsonResponse
    {
        try {
            $remessasPaginadas = $this->service->listarMinhasTarefas($request->all());

            $data = RemessasResponseHelper::mapRemessas($remessasPaginadas->items());

            return RemessasResponseHelper::jsonSuccess(
                'Minhas remessas carregadas com sucesso!',
                $data,
                [
                    'current_page' => $remessasPaginadas->currentPage(),
                    'last_page' => $remessasPaginadas->lastPage(),
                    'per_page' => $remessasPaginadas->perPage(),
                    'total' => $remessasPaginadas->total(),
                ]
            );
        } catch (\Throwable $e) {
            Log::error('Erro ao listar minhas remessas: ' . $e->getMessage());
            return RemessasResponseHelper::jsonError($e->getMessage());
        }
    }

    public function tarefasEmExpedicao(Request $request): JsonResponse
    {
        try {
            $remessasPaginadas = $this->service->listarTarefasEmExpedicao($request->all());

            $data = RemessasResponseHelper::mapRemessas($remessasPaginadas->items());

            return RemessasResponseHelper::jsonSuccess(
                'Minhas expedições carregadas com sucesso!',
                $data,
                [
                    'current_page' => $remessasPaginadas->currentPage(),
                    'last_page' => $remessasPaginadas->lastPage(),
                    'per_page' => $remessasPaginadas->perPage(),
                    'total' => $remessasPaginadas->total(),
                ]
            );
        } catch (\Throwable $e) {
            Log::error('Erro ao listar minhas remessas em expedições: ' . $e->getMessage());
            return RemessasResponseHelper::jsonError("Erro ao listar minhas remessas em expedições!");
        }
    }

    public function tarefasBalcao(Request $request): JsonResponse
    {
        try {
            $remessasPaginadas = $this->service->listarTarefasBalcao($request->all());

            $data = RemessasResponseHelper::mapRemessas($remessasPaginadas->items());

            return RemessasResponseHelper::jsonSuccess(
                'Remessas balcão carregadas com sucesso!',
                $data,
                [
                    'current_page' => $remessasPaginadas->currentPage(),
                    'last_page' => $remessasPaginadas->lastPage(),
                    'per_page' => $remessasPaginadas->perPage(),
                    'total' => $remessasPaginadas->total(),
                ]
            );
        } catch (\Throwable $e) {
            Log::error('Erro ao listar minhas remessas balcão: ' . $e->getMessage());
            return RemessasResponseHelper::jsonError("Erro ao listar minhas remessas balcão!");
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $remessa = $this->service->create($request->all());
            return response()->json($remessa, 201);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(Remessa $remessa): JsonResponse
    {
        return response()->json($remessa);
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {

            $userIdExecutouTarefa = Auth::user()->id;

            $remessa = Remessa::findOrFail($id);

            $data = $request->all();

            //    // Apenas define o executor se ainda não foi atribuído
            //     if (is_null($remessa->user_id_executor)) {
            //         $data['user_id_executor'] = $userIdExecutouTarefa;
            //     } else {
            //         $data['user_id_executor'] = $remessa->user_id_executor; // mantém o valor original
            //     }

            $this->service->update($remessa, $data);

            return RemessasResponseHelper::jsonCriacaoSuccess(
                'Remessa atualizada com sucesso!',
                [$remessa]
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return RemessasResponseHelper::jsonError('Remessa não encontrada.', 422);
        } catch (\Exception $e) {
            if ($e->getMessage() === 'Não é possível alterar uma remessa já confirmada') {
                return RemessasResponseHelper::jsonError($e->getMessage(), 422);
            }

            Log::error('Erro ao atualizar remessa: ' . $e->getMessage());
            return RemessasResponseHelper::jsonError('Erro inesperado ao atualizar remessa.', 500);
        }
    }


    public function destroy(Remessa $remessa): JsonResponse
    {
        try {
            $success = $this->service->delete($remessa);
            return response()->json(['success' => $success]);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
