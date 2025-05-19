<?php

namespace App\Repositories;

use App\Models\EntregaCliente;

class EntregaClienteRepository
{
    public function create(array $data): EntregaCliente
    {
        return EntregaCliente::create($data);
    }

    public function findByRemessaId(int $remessaId): ?EntregaCliente
    {
        return EntregaCliente::where('remessa_id', $remessaId)->first();
    }
}
