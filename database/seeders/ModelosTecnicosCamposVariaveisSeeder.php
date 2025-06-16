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

            [
                'modelo_tecnico_id' => 1,
                'nome' => 'cpf',
                'obrigatorio' => true,
                'ordem' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
