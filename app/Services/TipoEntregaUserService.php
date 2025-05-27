<?php

namespace App\Services;

use App\Repositories\TipoEntregaUserRepository;

class TipoEntregaUserService
{
    protected $repository;

    public function __construct(TipoEntregaUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function vincularTiposEntrega(int $userId, int $tipoEntregaId)
    {
        return $this->repository->attachTipoEntregaToUser($userId, $tipoEntregaId);
    }

    public function listarPorUsuario(int $userId)
    {
        return $this->repository->getTiposEntregaPorUsuario($userId);
    }
}
