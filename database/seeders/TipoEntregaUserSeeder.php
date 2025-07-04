<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\TipoEntregaUser;

class TipoEntregaUserSeeder extends Seeder
{
    public function run(): void
    {
        TipoEntregaUser::create([
            'cliente_id' => 1,
            'tipo_entrega_id' => 1,
            'user_executor_id' => 1,
            'observacao' => "Pedido para retirada balcão",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        TipoEntregaUser::create([
            'cliente_id' => 2,
            'tipo_entrega_id' => 2,
            'user_executor_id' => 1,
            'observacao' => "Pedido para enviar pelo correio",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
