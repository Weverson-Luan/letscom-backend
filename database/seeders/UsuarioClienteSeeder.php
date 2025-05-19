<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserCliente;
use Illuminate\Support\Carbon;

class UsuarioClienteSeeder extends Seeder
{
    public function run(): void
    {
        UserCliente::create([
            'user_id' => 2,
            'email' => 'tiago2025@gmail.com',
            'nome' => 'Tiago Gurgel',
            'ativo' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // UsuarioCliente::create([
        //     'user_id' => 1,
        //     'cliente_nome' => 'Leandro Sousa',
        //     'consultor_nome' => 'Consultor 2',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);
    }
}
