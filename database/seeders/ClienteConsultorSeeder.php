<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClienteConsultorSeeder extends Seeder
{
    public function run(): void
    {
        // Simulação: cliente_id e consultor_id já existem
        $vinculos = [
            ['cliente_id' => 1, 'consultor_id' => 3],
            ['cliente_id' => 5, 'consultor_id' => 3],
            ['cliente_id' => 2, 'consultor_id' => 4],
        ];

        foreach ($vinculos as $vinculo) {
            DB::table('cliente_consultor')->updateOrInsert(
                [
                    'cliente_id' => $vinculo['cliente_id'],
                    'consultor_id' => $vinculo['consultor_id'],
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
