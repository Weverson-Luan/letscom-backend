<?php

namespace App\Repositories;

use App\Models\UserCliente;
use Illuminate\Pagination\LengthAwarePaginator;

class UserClienteRepository
{
    protected $model;

    public function __construct(UserCliente $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function paginate(array $params): LengthAwarePaginator
    {
        $query = $this->model->query();

        if (!empty($params['search'])) {
            $query->where(function ($q) use ($params) {
                $q->where('cliente_nome', 'like', "%{$params['search']}%")
                  ->orWhere('email', 'like', "%{$params['search']}%");
            });
        }

        return $query->orderBy(
            $params['sort_by'] ?? 'created_at',
            $params['order'] ?? 'desc'
        )->paginate($params['per_page'] ?? 10);
    }

    /**
     * Resposável por listar os usuário de um cliente.
     */
    public function buscarUsuariosPorCliente(array $params): LengthAwarePaginator
    {
        $query = $this->model->query();

        if (!empty($params['user_id'])) {
            $query->where('user_id', $params['user_id']);
        }

        if (!empty($params['search'])) {
            $query->where(function ($q) use ($params) {
                $q->where('email', 'like', "%{$params['search']}%")
                ->orWhere('nome', 'like', "%{$params['search']}%")
                ->orWhere('ativo', 'like', "%{$params['search']}%");
            });
        }

        return $query->orderBy(
            $params['sort_by'] ?? 'created_at',
            $params['order'] ?? 'desc'
        )->paginate($params['per_page'] ?? 10);
    }

    public function create(array $data): UserCliente
    {
        return $this->model->create($data);
    }

    public function update(UserCliente $cliente, array $data): bool
    {
        return $cliente->update($data);
    }

    public function delete(UserCliente $cliente): bool
    {
        return $cliente->delete();
    }

    public function find($id): ?UserCliente
    {
        return $this->model->find($id);
    }

    public function findByEmail(string $email): ?UserCliente
    {
        return $this->model->where('email', $email)->first();
    }
}
