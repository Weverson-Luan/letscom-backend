<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserSolicitanteRemessa;
use Illuminate\Support\Carbon;

class UserSolicitanteRemessaSeeder extends Seeder
{
    public function run(): void
    {
        UserSolicitanteRemessa::create([
            'remessa_id' => 1,
            'user_id' => 1,
            'nome' => 'Fulano de Tal',
            'documento' => '36589526520',
            'telefone' => '31982132413',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
