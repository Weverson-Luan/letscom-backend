<?php

namespace App\Services;

use App\Repositories\EnderecoRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class EnderecoService
{
    protected $repository;

    public function __construct(EnderecoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(array $params): array
    {
        $users = $this->repository->buscarTodosEnderecos($params);
        return [
            'data' => $users->items(),
            'pagination' => [
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'per_page' => $users->perPage(),
                'total' => $users->total()
            ]
        ];
    }

    public function getById($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Retorna os endereços do usuário separados por tipo (residencial e entrega).
     *
     * @param int $userId
     * @param array $params
     * @return array
     */
    public function buscarEnderecosSeparadosPorTipo(int $userId, array $params): array
    {
        return $this->repository->buscarEnderecosPorUsuarioESepararPorTipo($userId, $params);
    }


    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}
