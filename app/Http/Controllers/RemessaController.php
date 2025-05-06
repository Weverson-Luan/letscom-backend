<?php

namespace App\Http\Controllers;

use App\Services\RemessaService;
use App\Models\Remessa;
use Illuminate\Http\Request;
use App\Http\Requests\RemessaRequest;
use Illuminate\Http\JsonResponse;

/**
 * Controller para gerenciamento de Remessas
 *
 * @package App\Http\Controllers
 * @version 1.0.0
 */
class RemessaController extends Controller
{
    /** @var RemessaService */
    protected $service;

    /**
     * Construtor do controller
     *
     * @param RemessaService $service Serviço de remessas
     */
    public function __construct(RemessaService $service)
    {
        $this->service = $service;
    }

    /**
     * Lista remessas com paginação
     *
     * @param Request $request Requisição HTTP
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $result = $this->service->list($request->all());

            return response()->json([
                "code" => 200,
                "status" => "success",
                "message" => "Remessas carregadas com sucesso!",
                "data" => $result['data'],
                "pagination" => $result['pagination']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "code" => 500,
                "status" => "error",
                "message" => "Erro ao carregar remessas.",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cria uma nova remessa
     *
     * @param RemessaRequest $request Requisição validada
     * @return JsonResponse
     */
    public function store(RemessaRequest $request): JsonResponse
    {
        try {
            $remessa = $this->service->create($request->validated());
            return response()->json($remessa, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Exibe uma remessa específica
     *
     * @param Remessa $remessa Remessa a ser exibida
     * @return JsonResponse
     */
    public function show(Remessa $remessa): JsonResponse
    {
        return response()->json($remessa->load(['client', 'items.product']));
    }

    /**
     * Atualiza uma remessa
     *
     * @param RemessaRequest $request Requisição validada
     * @param Remessa $remessa Remessa a ser atualizada
     * @return JsonResponse
     */
    public function update(RemessaRequest $request, Remessa $remessa): JsonResponse
    {
        try {
            $success = $this->service->update($remessa, $request->validated());
            return response()->json(['success' => $success]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove uma remessa
     *
     * @param Remessa $remessa Remessa a ser removida
     * @return JsonResponse
     */
    public function destroy(Remessa $remessa): JsonResponse
    {
        try {
            $success = $this->service->delete($remessa);
            return response()->json(['success' => $success]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
