<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpresasSeeder extends Seeder
{
    /**
     * Executa o seeder.
     *
     * @return void
     */
    public function run()
    {
        DB::table('empresas')->insert([
            [
                'CODEMPRESA' => 1,
                'NOME_EMPRESA' => 'Empresa A',
                'CNPJ' => '12.345.678/0001-99',
                'ENDERECO' => 'Rua Empresarial, 100, São Paulo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'CODEMPRESA' => 2,
                'NOME_EMPRESA' => 'Empresa B',
                'CNPJ' => '98.765.432/0001-11',
                'ENDERECO' => 'Avenida Comercial, 200, Rio de Janeiro',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Adicione mais empresas conforme necessário
        ]);
    }
} 