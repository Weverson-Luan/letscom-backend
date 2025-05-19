<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposEntregaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tipos_entrega')->insert([
            [
                'user_id' => 1,
                'cliente_id' => 2,
                'endereco_entrega_id' => 1,
                'tipo' => 'balcao',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'cliente_id' => 3,
                'endereco_entrega_id' => 2,
                'tipo' => 'correios',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'cliente_id' => 4,
                'endereco_entrega_id' => 3,
                'tipo' => 'motoboy_letscom',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'cliente_id' => 6,
                'endereco_entrega_id' => null, // entrega sem endereço associado
                'tipo' => 'outros',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
