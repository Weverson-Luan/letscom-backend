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
            $remessasPaginadas = $this->repository->paginate($params);

            $data = [];

            foreach ($remessasPaginadas->items() as $remessa) {
                $cliente = \App\Models\Client::find($remessa->cliente_id);
                $modelo = \App\Models\ModeloTecnico::find($remessa->modelo_tecnico_id);

                $data[] = [
                    'id' => $remessa->id,
                    'total_solicitacoes' => $remessa->total_solicitacoes,
                    'status' => $remessa->status,
                    'data_remessa' => $remessa->data_remessa,
                    'data_inicio_producao' => $remessa->data_inicio_producao,
                    'tecnologia' => $remessa->tecnologia,
                    'posicao' => $remessa->posicao,
                    'cliente' => $cliente ?? [],
                    'modelo_tecnico' => $modelo ?? [],
                    'created_at' => $remessa->created_at,
                    'updated_at' => $remessa->updated_at,
                    'deleted_at' => $remessa->deleted_at,
                ];
            }

            return [
                'code' => 200,
                'status' => 'success',
                'message' => 'Remessas carregadas com sucesso!',
                'data' => $data,
                'pagination' => [
                    'current_page' => $remessasPaginadas->currentPage(),
                    'last_page' => $remessasPaginadas->lastPage(),
                    'per_page' => $remessasPaginadas->perPage(),
                    'total' => $remessasPaginadas->total()
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
