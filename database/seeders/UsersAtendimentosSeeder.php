<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersAtendimentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users_atendimentos')->insert([
            [
                'cliente_id' => 1, // Altere conforme o ID do cliente existente
                'nome' => 'Guilherme',
                'email' => 'guilherme@letscom.com',
                'telefone' => '31999990000',
                'documento' => '12345678901',
                'ativo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cliente_id' => 2,
                'nome' => 'Alice',
                'email' => 'alice@letscom.com',
                'documento' => '98765432100',
                'telefone' => '31999990001',
                'ativo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
