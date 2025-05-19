<?php

namespace App\Services;

use App\Repositories\EntregaClienteRepository;

class EntregaClienteService
{
    protected $repository;

    public function __construct(EntregaClienteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function registrarEntrega(array $data)
    {
        return $this->repository->create($data);
    }
}
