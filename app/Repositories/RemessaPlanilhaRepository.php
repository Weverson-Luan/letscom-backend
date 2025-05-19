<?php

namespace App\Repositories;

use App\Models\RemessaPlanilha;

class RemessaPlanilhaRepository
{
    public function create(array $data)
    {
        return RemessaPlanilha::create($data);
    }

    public function findByRemessa($remessaId)
    {
        return RemessaPlanilha::where('remessa_id', $remessaId)->get();
    }
}
