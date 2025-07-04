<?php

namespace App\Repositories;

use App\Models\RemessaLiberada;

class RemessaLiberadaRepository
{
    public function create(array $data): RemessaLiberada
    {
        return RemessaLiberada::create($data);
    }

    public function findByRemessa($remessaId)
    {
        return RemessaLiberada::where('remessa_id', $remessaId)->first();
    }

    public function all()
    {
        return RemessaLiberada::with(['remessa', 'executor', 'tipoEntrega'])->get();
    }
}
