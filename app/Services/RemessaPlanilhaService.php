<?php

namespace App\Services;

use App\Repositories\RemessaPlanilhaRepository;
use Illuminate\Support\Facades\Storage;

class RemessaPlanilhaService
{
    protected $repository;

    public function __construct(RemessaPlanilhaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function upload($file, $remessaId, $userId, $tipo = null)
    {
        $path = $file->store("remessas/planilhas/{$remessaId}");

        return $this->repository->create([
            'remessa_id' => $remessaId,
            'user_id' => $userId,
            'file_path' => $path,
            'tipo' => $tipo,
        ]);
    }

    public function listByRemessa($remessaId)
    {
        return $this->repository->findByRemessa($remessaId);
    }
}
