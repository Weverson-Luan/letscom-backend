<?php

namespace App\Services;

use App\Repositories\TecnologiasRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class TecnologiasService
{
    protected $repository;

    public function __construct(TecnologiasRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list(array $params): LengthAwarePaginator
    {

        try {
            return $this->repository->paginate($params);
        } catch (\Throwable $e) {
            Log::error('Erro ao listar remessas: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getById($id)
    {
        return $this->repository->find($id);
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
