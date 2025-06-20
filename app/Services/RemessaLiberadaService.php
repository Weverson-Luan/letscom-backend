<?php

namespace App\Services;

use App\Repositories\RemessaLiberadaRepository;
use Illuminate\Support\Facades\Auth;

class RemessaLiberadaService
{
    protected $repository;

    public function __construct(RemessaLiberadaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function liberarRemessa(array $data)
    {
        $data['user_id_executor'] = Auth::id();
        return $this->repository->create($data);
    }

    public function listarLiberacoes()
    {
        return $this->repository->all();
    }

    public function buscarPorRemessa($remessaId)
    {
        return $this->repository->findByRemessa($remessaId);
    }
}
