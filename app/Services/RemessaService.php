<?php

namespace App\Services;

use App\Repositories\RemessaRepository;
use App\Models\Remessa;
use App\Models\Product;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Serviço para gerenciamento de Remessas
 * 
 * @package App\Services
 * @version 1.0.0
 */
class RemessaService
{
    /** @var RemessaRepository */
    protected $repository;

    /**
     * Construtor do serviço
     * 
     * @param RemessaRepository $repository Repositório de remessas
     */
    public function __construct(RemessaRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Lista remessas com paginação
     * 
     * @param array $params Parâmetros de filtro e paginação
     * @return array
     * @throws \Exception
     */
    public function list(array $params): array
    {
        try {
            $remessas = $this->repository->paginate($params);
            
            return [
                'data' => $remessas->items(),
                'pagination' => [
                    'current_page' => $remessas->currentPage(),
                    'last_page' => $remessas->lastPage(),
                    'per_page' => $remessas->perPage(),
                    'total' => $remessas->total()
                ]
            ];
        } catch (\Exception $e) {
            Log::error('Erro ao listar remessas: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Cria uma nova remessa
     * 
     * @param array $data Dados da remessa
     * @return Remessa
     * @throws \Exception
     */
    public function create(array $data): Remessa
    {
        try {
            DB::beginTransaction();

            $client = Client::findOrFail($data['client_id']);
            $totalCreditos = 0;

            // Calcula total de créditos e verifica estoque
            foreach ($data['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                
                if ($product->estoque_atual < $item['quantidade']) {
                    throw new \Exception("Produto {$product->nome} sem estoque suficiente");
                }

                $totalCreditos += $product->valor_creditos * $item['quantidade'];
            }

            // Verifica saldo de créditos do cliente
            if ($client->saldo_creditos < $totalCreditos) {
                throw new \Exception("Cliente não possui créditos suficientes");
            }

            // Cria a remessa
            $remessa = $this->repository->create([
                'client_id' => $data['client_id'],
                'total_creditos' => $totalCreditos,
                'status' => 'confirmado',
                'data_remessa' => now()
            ]);

            // Cria os itens da remessa e atualiza estoque
            foreach ($data['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                
                $remessa->items()->create([
                    'product_id' => $item['product_id'],
                    'quantidade' => $item['quantidade'],
                    'valor_creditos_unitario' => $product->valor_creditos,
                    'valor_creditos_total' => $product->valor_creditos * $item['quantidade']
                ]);

                $product->estoque_atual -= $item['quantidade'];
                $product->save();
            }

            // Atualiza saldo do cliente
            $client->saldo_creditos -= $totalCreditos;
            $client->save();

            DB::commit();
            
            return $remessa->load('items.product');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao criar remessa: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Atualiza uma remessa existente
     * 
     * @param Remessa $remessa Remessa a ser atualizada
     * @param array $data Novos dados
     * @return bool
     * @throws \Exception
     */
    public function update(Remessa $remessa, array $data): bool
    {
        try {
            if ($remessa->status === 'confirmado') {
                throw new \Exception('Não é possível alterar uma remessa já confirmada');
            }

            DB::beginTransaction();

            if (isset($data['status']) && $data['status'] === 'confirmado') {
                $this->processarConfirmacaoRemessa($remessa);
            }

            $success = $this->repository->update($remessa, $data);

            DB::commit();
            
            return $success;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao atualizar remessa: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Remove uma remessa
     * 
     * @param Remessa $remessa Remessa a ser removida
     * @return bool
     * @throws \Exception
     */
    public function delete(Remessa $remessa): bool
    {
        try {
            if ($remessa->status === 'confirmado') {
                throw new \Exception('Não é possível excluir uma remessa já confirmada');
            }

            DB::beginTransaction();

            if ($remessa->status === 'confirmado') {
                $this->estornarRemessa($remessa);
            }

            $remessa->items()->delete();
            $success = $this->repository->delete($remessa);

            DB::commit();
            
            return $success;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao excluir remessa: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Processa a confirmação de uma remessa
     * 
     * @param Remessa $remessa Remessa a ser confirmada
     * @throws \Exception
     */
    private function processarConfirmacaoRemessa(Remessa $remessa): void
    {
        $client = Client::findOrFail($remessa->client_id);
        
        foreach ($remessa->items as $item) {
            $product = Product::findOrFail($item->product_id);
            if ($product->estoque_atual < $item->quantidade) {
                throw new \Exception("Produto {$product->nome} sem estoque suficiente");
            }
        }

        if ($client->saldo_creditos < $remessa->total_creditos) {
            throw new \Exception("Cliente não possui créditos suficientes");
        }

        foreach ($remessa->items as $item) {
            $product = Product::findOrFail($item->product_id);
            $product->estoque_atual -= $item->quantidade;
            $product->save();
        }

        $client->saldo_creditos -= $remessa->total_creditos;
        $client->save();
    }

    /**
     * Estorna uma remessa
     * 
     * @param Remessa $remessa Remessa a ser estornada
     */
    private function estornarRemessa(Remessa $remessa): void
    {
        $client = Client::findOrFail($remessa->client_id);
        
        foreach ($remessa->items as $item) {
            $product = Product::findOrFail($item->product_id);
            $product->estoque_atual += $item->quantidade;
            $product->save();
        }

        $client->saldo_creditos += $remessa->total_creditos;
        $client->save();
    }
} 