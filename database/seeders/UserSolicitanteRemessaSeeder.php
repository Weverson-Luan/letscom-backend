<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserSolicitanteRemessa;

class UserSolicitanteRemessaSeeder extends Seeder
{
    public function run(): void
    {
        UserSolicitanteRemessa::create([
            'remessa_id' => 1,
            'user_id' => 1,
            'nome' => 'Fulano de Tal',
            'cpf' => '12345678900',
            'telefone' => '31982132423',
        ]);
    }
}
