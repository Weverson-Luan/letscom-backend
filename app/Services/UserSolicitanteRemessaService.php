<?php

namespace App\Services;

use App\Repositories\UserSolicitanteRemessaRepository;

class UserSolicitanteRemessaService
{
    protected $repository;

    public function __construct(UserSolicitanteRemessaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function listAll()
    {
        return $this->repository->all();
    }
}
