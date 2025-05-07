<?php

namespace Database\Seeders;

use App\Models\ModeloTecnico;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ModelosTecnicosSeeder extends Seeder
{
    public function run(): void
    {

        DB::table('modelos_tecnicos')->insert([
            [
                'cliente_id' => 1,
                'produto_id' => 1,
                'user_id' => 1,
                'nome_modelo' => 'Modelo RFID',
                'tipo_entrega' => 'Normal',
                'posicionamento' => 'horizontal',
                'tem_furo' => false,
                'tem_carga_foto' => false,
                'tem_dados_variaveis' => false,
                'campo_chave' => 'cpf',
                'foto_frente_path' => null,
                'foto_verso_path' => null,
                'observacoes' => 'Modelo técnico de teste',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);


    }
}
