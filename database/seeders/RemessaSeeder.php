<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RemessaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('remessas')->insert([
            [
                'cliente_id' => 1,
                'user_id' => 1,
                'modelo_tecnico_id' => 6,
                'total_solicitacoes' => 10,
                'status' => 'concluida',
                'data_remessa' => Carbon::now(),
                'data_inicio_producao' => Carbon::now(),
                'tecnologia' => 'RFID',
                'posicao' => 'H',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ]);
    }
}
