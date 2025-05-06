<?php

namespace App\Services;

use App\Repositories\ClientRepository;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Serviço para gerenciamento de Clientes
 *
 * @package App\Services
 * @version 1.0.0
 */
class ClientService
{
    /** @var ClientRepository */
    protected $repository;

    public function __construct(ClientRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list(array $params): array
    {
        try {
            $clients = $this->repository->paginate($params);

            return [
                'data' => $clients->items(),
                'pagination' => [
                    'current_page' => $clients->currentPage(),
                    'last_page' => $clients->lastPage(),
                    'per_page' => $clients->perPage(),
                    'total' => $clients->total()
                ]
            ];
        } catch (\Exception $e) {
            Log::error('Erro ao listar clientes: ' . $e->getMessage());
            throw $e;
        }
    }

    public function create(array $data): Client
    {
        try {
            DB::beginTransaction();
            $client = $this->repository->create($data);
            DB::commit();

            return $client;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao criar cliente: ' . $e->getMessage());
            throw $e;
        }
    }


    /**
     * Atualiza os dados de um cliente
     */
    public function update(Client $client, array $data): Client
    {
        try {
            $this->repository->update($client, $data);

            Log::debug('Service: atualizando cliente', [
                'id' => $client->id,
                'data' => $data,
            ]);

            return $client;
        } catch (\Throwable $e) {
            Log::error('Erro ao atualizar cliente: ' . $e->getMessage());
            throw $e;
        }
    }
}
