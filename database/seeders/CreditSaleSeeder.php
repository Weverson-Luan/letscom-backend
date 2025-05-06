<?php

namespace Database\Seeders;

use App\Models\CreditSale;
use Illuminate\Database\Seeder;

class CreditSaleSeeder extends Seeder
{
    public function run(): void
    {
        // Venda confirmada para João Silva
        CreditSale::create([
            'client_id' => 1,
            'valor' => 1000.00,
            'quantidade_creditos' => 100.00,
            'status' => 'confirmado',
            'data_venda' => now(),
            'observacao' => 'Venda inicial de créditos'
        ]);

        // Venda pendente para Empresa XYZ
        CreditSale::create([
            'client_id' => 2,
            'valor' => 5000.00,
            'quantidade_creditos' => 500.00,
            'status' => 'pendente',
            'data_venda' => now()->subDays(1),
            'observacao' => 'Aguardando confirmação de pagamento'
        ]);

        // Venda cancelada para Maria Oliveira
        CreditSale::create([
            'client_id' => 3,
            'valor' => 200.00,
            'quantidade_creditos' => 20.00,
            'status' => 'cancelado',
            'data_venda' => now()->subDays(2),
            'observacao' => 'Cancelado a pedido do cliente'
        ]);

        // Outra venda confirmada para Empresa XYZ
        CreditSale::create([
            'client_id' => 2,
            'valor' => 10000.00,
            'quantidade_creditos' => 1000.00,
            'status' => 'confirmado',
            'data_venda' => now()->subDays(5),
            'observacao' => 'Pacote empresarial'
        ]);
    }
} 