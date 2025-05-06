<?php

namespace App\Repositories;

use App\Models\Client;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Repositório para gerenciamento de Clientes
 *
 * @package App\Repositories
 * @version 1.0.0
 */
class ClientRepository
{
    /** @var Client */
    protected $model;

    public function __construct(Client $model)
    {
        $this->model = $model;
    }

    public function paginate(array $params): LengthAwarePaginator
    {
        $query = $this->model->query();

        if (!empty($params['search'])) {
            $query->where(function($q) use ($params) {
                $q->where('nome', 'like', "%{$params['search']}%")
                  ->orWhere('email', 'like', "%{$params['search']}%")
                  ->orWhere('cpf_cnpj', 'like', "%{$params['search']}%");
            });
        }

        return $query->orderBy(
            $params['sort_by'] ?? 'created_at',
            $params['order'] ?? 'desc'
        )->paginate($params['per_page'] ?? 10);
    }

    /**
     * Repositorio para a dados do usuário cliente
     */
    public function create(array $data): Client
    {
        return $this->model->create($data);
    }

    /**
     * Repositorio para atualizar dados do usuário cliente
     */
    public function update(Client $client, array $data): Client
    {
        $client->update($data);
        return $client;
    }

    public function find($id): ?Client
    {
        return $this->model->find($id);
    }
}
