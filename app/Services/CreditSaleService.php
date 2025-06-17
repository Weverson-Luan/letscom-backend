<?php

namespace App\Services;

use App\Repositories\CreditSaleRepository;
use App\Models\CreditSale;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Serviço para gerenciamento de Vendas de Créditos
 *
 * @package App\Services
 * @version 1.0.0
 */
class CreditSaleService
{
    /** @var CreditSaleRepository */
    protected $repository;

    /**
     * Construtor do serviço
     *
     * @param CreditSaleRepository $repository Repositório de vendas
     */
    public function __construct(CreditSaleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Lista vendas com paginação
     *
     * @param array $params Parâmetros de filtro e paginação
     * @return array
     * @throws \Exception
     */
    public function list(array $params): array
    {
        try {
            $sales = $this->repository->paginate($params);

            return [
                'data' => $sales->items(),
                'pagination' => [
                    'current_page' => $sales->currentPage(),
                    'last_page' => $sales->lastPage(),
                    'per_page' => $sales->perPage(),
                    'total' => $sales->total()
                ]
            ];
        } catch (\Exception $e) {
            Log::error('Erro ao listar vendas: ' . $e->getMessage());
            throw $e;
        }
    }

    public function listarTransacoes(array $params): LengthAwarePaginator
    {

        return $this->repository->buscarTransacoesPorCliente($params);
    }

    public function create(array $data): CreditSale
    {
        try {
            DB::beginTransaction();


            $user = \Illuminate\Support\Facades\Auth::user();

            $role = strtolower($user->roles->first()?->nome ?? '');

            if (in_array($role, ['admin', 'producao'])) {
                $data['status'] = 'confirmado';
            }

            $data['data_venda'] = now();
            $data['valor'] = 0; // valor da unidade do crédito
            $data['valor_total'] = 0; // valor da total dos crédito

            // ✅ Atualiza estoque do produto se fornecido produto_id
            if (!empty($data['produto_id']) && isset($data['quantidade_creditos'])) {
                $produto = \App\Models\Product::findOrFail($data['produto_id']);

                $estoqueAtual = $produto->estoque_atual;
                $quantidadeVendida = $data['quantidade_creditos'];

                if ($quantidadeVendida > $estoqueAtual) {
                    throw new \Exception("Estoque insuficiente para o produto: {$produto->nome}");
                }

                $produto->update([
                    'estoque_atual' => $estoqueAtual - $quantidadeVendida
                ]);
            }

            // Cria a venda
            $sale = $this->repository->create($data);

            DB::commit();
            return $sale;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao criar venda: ' . $e->getMessage());
            throw $e;
        }
    }


    /**
     * Atualiza uma venda existente
     *
     * @param CreditSale $creditSale Venda a ser atualizada
     * @param array $data Novos dados
     * @return bool
     * @throws \Exception
     */
    public function update(CreditSale $creditSale, array $data): bool
    {
        try {
            if ($creditSale->status === 'confirmado' || $creditSale->status === 'cancelado') {
                throw new \Exception('Não é possível alterar uma venda já confirmada');
            }

            DB::beginTransaction();

            $success = $this->repository->update($creditSale, $data);

            DB::commit();

            return $success;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao atualizar venda: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Remove uma venda
     *
     * @param CreditSale $creditSale Venda a ser removida
     * @return bool
     * @throws \Exception
     */
    public function delete(CreditSale $creditSale): bool
    {
        try {
            if ($creditSale->status === 'confirmado') {
                throw new \Exception('Não é possível excluir uma venda já confirmada');
            }

            DB::beginTransaction();

            $success = $this->repository->delete($creditSale);

            DB::commit();

            return $success;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao excluir venda: ' . $e->getMessage());
            throw $e;
        }
    }

    public function cancel(CreditSale $creditSale): bool
    {
        try {
            if ($creditSale->status !== 'confirmado') {
                throw new \Exception('Apenas vendas confirmadas podem ser canceladas');
            }

            DB::beginTransaction();

            $creditSale->update([
                'status' => 'cancelado',
                'quantidade_creditos' => 0
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao cancelar venda: ' . $e->getMessage());
            throw $e;
        }
    }
}
