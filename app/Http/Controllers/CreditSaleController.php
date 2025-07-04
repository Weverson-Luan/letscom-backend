<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CreditSaleService;
use App\Models\CreditSale;
use App\Http\Requests\CreditSaleRequest;
use Illuminate\Http\JsonResponse;
use App\Helpers\CreditsSalesResponseHelper;

/**
 * Controller para gerenciamento de Vendas de Créditos
 *
 * @package App\Http\Controllers
 * @version 1.0.0
 */
class CreditSaleController extends Controller
{
    /** @var CreditSaleService */
    protected $service;

    /**
     * Construtor do controller
     *
     * @param CreditSaleService $service Serviço de vendas
     */
    public function __construct(CreditSaleService $service)
    {
        $this->service = $service;
    }

    /**
     * Lista vendas com paginação
     *
     * @param Request $request Requisição HTTP buscarTransacoesPorCliente
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {

            $response = $this->service->list($request->all());

            $vendasCredito = CreditsSalesResponseHelper::mapVendasCredito($response['data']);

            return CreditsSalesResponseHelper::jsonSuccess(
                'Histórico de transações carregadas com sucesso!',
                $vendasCredito,
                $response['pagination']
            );
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function buscarTransacoesPorCliente(Request $request, $userId): JsonResponse
    {
        try {

            $params = $request->all();
            $params['user_id'] = $userId;

            $transacoes = $this->service->listarTransacoes($params);

            $vendasCredito = CreditsSalesResponseHelper::mapVendasCredito($transacoes->items());

            return CreditsSalesResponseHelper::jsonSuccess(
                'Histórico de transações carregadas com sucessos!',
                $vendasCredito,
                $transacoes['pagination']
            );
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    /**
     * Cria uma nova venda
     *
     * @param Request $request Requisição validada
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $sale = $this->service->create($request->all());
            return response()->json($sale, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Exibe uma venda específica
     *
     * @param CreditSale $creditSale Venda a ser exibida
     * @return JsonResponse
     */
    public function show(CreditSale $creditSale): JsonResponse
    {
        return response()->json($creditSale->load('client'));
    }

    /**
     * Atualiza uma venda
     *
     * @param CreditSaleRequest $request Requisição validada
     * @param CreditSale $creditSale Venda a ser atualizada
     * @return JsonResponse
     */
    public function update(CreditSaleRequest $request, CreditSale $creditSale): JsonResponse
    {
        try {

            $bodyVendaCredito = $request->all();

            $success = $this->service->update($creditSale, $bodyVendaCredito);
            return response()->json(['success' => $success]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function cancelVendaCreditos($id)
    {
        try {
            $creditSale = CreditSale::findOrFail($id);

            $this->service->cancel($creditSale);

            return CreditsSalesResponseHelper::jsonSuccess('Venda cancelada com sucesso');
        } catch (\Exception $e) {
            return CreditsSalesResponseHelper::jsonError($e->getMessage());
        }
    }

    /**
     * Remove uma venda
     *
     * @param CreditSale $creditSale Venda a ser removida
     * @return JsonResponse
     */
    public function destroy(CreditSale $creditSale): JsonResponse
    {
        try {
            $success = $this->service->delete($creditSale);
            return response()->json(['success' => $success]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
