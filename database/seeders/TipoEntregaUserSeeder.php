<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

use App\Models\TipoEntregaUser;

class TipoEntregaUserSeeder extends Seeder
{
    public function run(): void
    {
        TipoEntregaUser::create([
            'cliente_id' => 1,
            'tipo_entrega_id' => 1,
        ]);

        TipoEntregaUser::create([
            'cliente_id' => 2,
            'tipo_entrega_id' => 2,
        ]);
    }
}
