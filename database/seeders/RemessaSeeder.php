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
                'cliente_id' => 2, // cliente que solicitou remessa
                'user_id_solicitante_remessa' => 9, // ID do solicitante
                'user_id_executor' => null,         // Pode ser null
                'modelo_tecnico_id' => 1,
                'tecnologia_id' => 1,
                'total_solicitacoes' => 10,
                'situacao' => 'solicitado', // ou 'envios_dados' se já estiver padronizando
                "status"=> "solicitado",
                "observacao"=> null,
                'data_fim_producao' => null,
                'data_inicio_producao' => null,
                'posicao' => 'H',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
             [
                'cliente_id' => 1, // cliente que solicitou remessa
                'user_id_solicitante_remessa' => 9, // ID do solicitante
                'user_id_executor' => null,         // Pode ser null
                'modelo_tecnico_id' => 1,
                'tecnologia_id' => 1,
                'total_solicitacoes' => 5,
                'situacao' => 'solicitado', // ou 'envios_dados' se já estiver padronizando
                "status"=> "solicitado",
                "observacao"=> null,
                'data_fim_producao' => null,
                'data_inicio_producao' => null,
                'posicao' => 'H',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
