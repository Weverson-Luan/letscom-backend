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
                'tipo' => 'balcao',
                'ativo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo' => 'correios',
                'ativo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo' => 'motoboy_letscom',
                'ativo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo' => 'entregue_pela_letscom',
                'ativo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo' => 'outros',
                'ativo' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
