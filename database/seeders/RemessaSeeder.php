<?php

namespace Database\Seeders;

use App\Models\Remessa;
use Illuminate\Database\Seeder;

class RemessaSeeder extends Seeder
{
    public function run(): void
    {
        // Remessa confirmada para João Silva
        Remessa::create([
            'client_id' => 1,
            'total_creditos' => 15.00,
            'status' => 'confirmado',
            'data_remessa' => now()
        ]);

        // Remessa pendente para Empresa XYZ
        Remessa::create([
            'client_id' => 2,
            'total_creditos' => 450.00,
            'status' => 'pendente',
            'data_remessa' => now()->subDays(1)
        ]);

        // Remessa cancelada para Maria Oliveira
        Remessa::create([
            'client_id' => 3,
            'total_creditos' => 25.00,
            'status' => 'cancelado',
            'data_remessa' => now()->subDays(2)
        ]);

        // Remessa antiga confirmada para Empresa XYZ
        Remessa::create([
            'client_id' => 2,
            'total_creditos' => 225.00,
            'status' => 'confirmado',
            'data_remessa' => now()->subDays(5)
        ]);
    }
} 