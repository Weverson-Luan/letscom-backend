<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RemessaFoto;

class RemessaFotosSeeder extends Seeder
{
    public function run(): void
    {
        // Simula fotos associadas à remessa_id = 1, cliente_id = 1
        RemessaFoto::create([
            'remessa_id' => 9,
            'cliente_id' => 1,
            'file_path' => 'remessas/fotos/1/foto1.jpg',
        ]);

    }
}
