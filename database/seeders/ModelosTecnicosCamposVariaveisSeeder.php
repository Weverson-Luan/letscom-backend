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
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // [
            //     'modelo_tecnico_id' => 2,
            //     'nome' => 'nome_completo',
            //     'obrigatorio' => false,
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],
            // [
            //     'modelo_tecnico_id' => 2,
            //     'nome' => 'cargo',
            //     'obrigatorio' => false,
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],
            // [
            //     'modelo_tecnico_id' => 2,
            //     'nome' => 'admissao',
            //     'obrigatorio' => false,
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],
            // [
            //     'modelo_tecnico_id' => 2,
            //     'nome' => 'qr_code',
            //     'obrigatorio' => false,
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],
            // [
            //     'modelo_tecnico_id' => 2,
            //     'nome' => 'ige_a_abelha',
            //     'obrigatorio' => false,
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],
        ]);
    }
}
