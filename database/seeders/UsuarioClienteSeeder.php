<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserCliente;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
class UsuarioClienteSeeder extends Seeder
{
    public function run(): void
    {
        UserCliente::create([
            'cliente_id' => 2, // qual cliente pertece
            'nome' => 'Marlon da Silva',
            'email' => 'marlon.atendimento@example.com',
            'senha' =>  Hash::make('cliente123'),
            "documento"=> "148766598634",
            'ativo' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        UserCliente::create([
            'cliente_id' => 1, // qual cliente pertece
            'nome' => 'Maria Souza',
            'email' => 'maria.atendimento@example.com',
            'senha' =>  Hash::make('cliente123'),
            'documento' => '12097387489',
            'ativo' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
