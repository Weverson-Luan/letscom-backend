<?php

namespace App\Services;

use App\Repositories\CreditSaleRepository;
use App\Models\CreditSale;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    /**
     * Cria uma nova venda de créditos
     * 
     * @param array $data Dados da venda
     * @return CreditSale
     * @throws \Exception
     */
    public function create(array $data): CreditSale
    {
        try {
            DB::beginTransaction();

            $data['status'] = 'confirmado';
            $data['data_venda'] = now();

            $sale = $this->repository->create($data);

            $client = Client::findOrFail($data['client_id']);
            $client->saldo_creditos = ($client->saldo_creditos ?? 0) + $data['quantidade_creditos'];
            $client->save();

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
            if ($creditSale->status === 'confirmado') {
                throw new \Exception('Não é possível alterar uma venda já confirmada');
            }

            DB::beginTransaction();

            if (isset($data['quantidade_creditos']) && 
                $data['quantidade_creditos'] != $creditSale->quantidade_creditos) {
                $client = Client::findOrFail($creditSale->client_id);
                $client->saldo_creditos = ($client->saldo_creditos - $creditSale->quantidade_creditos) + $data['quantidade_creditos'];
                $client->save();
            }

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

            if ($creditSale->status === 'confirmado') {
                $client = Client::findOrFail($creditSale->client_id);
                $client->saldo_creditos -= $creditSale->quantidade_creditos;
                $client->save();
            }

            $success = $this->repository->delete($creditSale);

            DB::commit();
            
            return $success;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao excluir venda: ' . $e->getMessage());
            throw $e;
        }
    }
} 