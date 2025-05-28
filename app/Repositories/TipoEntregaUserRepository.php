<?php

namespace App\Repositories;

use App\Models\TipoEntregaUser;
use App\Models\TipoEntrega;

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

    /**
     * Atualiza o tipo de entrega relacionado ao usuário
     *
     * @param int $userId
     * @param int $tipoEntregaId
     * @return array
     */
    public function atualizarTipoEntregaParaUsuario(int $userId, int $tipoEntregaId): array
    {
        //  // verifica se o tipo de entrega existe
        // $tipoEntrega = TipoEntregaUser::findOrFail($tipoEntregaId);
        // ✅ Corrigir para verificar na tabela correta
        $tipoEntrega = TipoEntrega::findOrFail($tipoEntregaId);

        // remove qualquer vínculo anterior com o mesmo usuário
        TipoEntregaUser::where('cliente_id', $userId)->delete();

        // cria novo vínculo
        $tiposEntregaCriada = TipoEntregaUser::create([
                'cliente_id' => $userId,
                'tipo_entrega_id' => $tipoEntrega->id,
            ]);

        return [
        "code" => 201,
        'status' => 'success',
        'message' => 'Tipo de entrega atualizado com sucesso!',
        "data" => $tiposEntregaCriada
    ];

    }

    public function getTiposEntregaPorUsuario(int $userId)
    {
        return TipoEntregaUser::where('cliente_id', $userId)->with('tipoEntrega')->get();
    }
}
