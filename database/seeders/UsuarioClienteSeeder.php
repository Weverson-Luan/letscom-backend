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
            'nome' => 'Marlon da Silva',
            'email' => 'marlon.atendimento@example.com',
            "documento"=> "148766598634",
            'ativo' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        UserCliente::create([
            'user_id' => 1,
            'nome' => 'Maria Souza',
            'email' => 'maria.atendimento@example.com',
            'documento' => '12097387489',
            'ativo' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
