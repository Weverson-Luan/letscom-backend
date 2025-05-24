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
                'user_id' => 2,
                'user_id_solicitante_remessa' => 5, // ID do solicitante
                'user_id_executor' => null,         // Pode ser null
                'modelo_tecnico_id' => 1,
                'tecnologia_id' => 1,
                'total_solicitacoes' => 10,
                'situacao' => 'pendente', // ou 'envios_dados' se já estiver padronizando
                "status"=> "pendente",
                "observacao"=> null,
                'data_remessa' => Carbon::now(),
                'data_inicio_producao' => Carbon::now(),
                'posicao' => 'H',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
             [
                'user_id' => 2,
                'user_id_solicitante_remessa' => 5, // ID do solicitante
                'user_id_executor' => null,         // Pode ser null
                'modelo_tecnico_id' => 1,
                'tecnologia_id' => 1,
                'total_solicitacoes' => 5,
                'situacao' => 'pendente', // ou 'envios_dados' se já estiver padronizando
                "status"=> "pendente",
                "observacao"=> null,
                'data_remessa' => Carbon::now(),
                'data_inicio_producao' => Carbon::now(),
                'posicao' => 'H',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
