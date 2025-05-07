<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ModelosTecnicosCamposVariaveisSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('modelos_tecnicos_campos_variaveis')->insert([
            // Modelo Técnico ID 1 (RFID)
            [
                'modelo_tecnico_id' => 6,
                'nome' => 'CPF',
                'obrigatorio' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // [
            //     'modelo_tecnico_id' => 2,
            //     'nome' => 'Matrícula',
            //     'obrigatorio' => false,
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],
        ]);
    }
}
