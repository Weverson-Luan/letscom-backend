<?php

namespace App\Repositories;

use App\Models\TipoEntregaUser;

class TipoEntregaUserRepository
{
   public function attachTipoEntregaToUser(int $userId, int $tipoEntregaId): bool
{
    $data = [
            'cliente_id' => $userId,
            'tipo_entrega_id' => $tipoEntregaId,
            'created_at' => now(),
            'updated_at' => now(),
        ];

    return \App\Models\TipoEntregaUser::insert($data);
}

    public function getTiposEntregaPorUsuario(int $userId)
    {
        return TipoEntregaUser::where('cliente_id', $userId)->with('tipoEntrega')->get();
    }
}
