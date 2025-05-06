<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientesSeeder extends Seeder
{
    /**
     * Executa o seeder.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clientes')->insert([
            [
                'NOME' => 'João Silva',
                'CPF_CNPJ' => '123.456.789-00',
                'ENDERECO' => 'Rua A, 123, Cidade X',
                'EMAIL' => 'joao.silva@example.com',
                'TELEFONE' => '(11) 99999-9999',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'NOME' => 'Maria Oliveira',
                'CPF_CNPJ' => '987.654.321-00',
                'ENDERECO' => 'Av. B, 456, Cidade Y',
                'EMAIL' => 'maria.oliveira@example.com',
                'TELEFONE' => '(21) 88888-8888',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Adicione mais clientes conforme necessário
        ]);
    }
}
