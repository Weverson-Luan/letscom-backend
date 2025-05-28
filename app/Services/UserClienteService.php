<?php

namespace App\Services;

use App\Repositories\UserClienteRepository;

use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserClienteService
{
    protected $repository;

    public function __construct(UserClienteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function listAll()
    {
        return $this->repository->all();
    }

    public function getById($id)
    {
        return $this->repository->find($id);
    }

    public function listUsarioPorCliente(array $params): LengthAwarePaginator
    {
        return $this->repository->buscarUsuariosPorCliente($params);
    }


    public function create(array $data)
    {
        $data['senha'] = Hash::make($data['senha']); // aplica o bcrypt

        return $this->repository->create($data);
    }

    public function update($id, array $data)
    {
        $cliente = $this->repository->find($id);

        if (!empty($data['senha'])) {
            $data['senha'] = Hash::make($data['senha']);
        }

        return $this->repository->update($cliente, $data);
    }

    public function delete($id)
    {
        $cliente = $this->repository->find($id);
        return $this->repository->delete($cliente);
    }
}
