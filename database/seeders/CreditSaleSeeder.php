<?php

namespace Database\Seeders;

use App\Models\CreditSale;
use Illuminate\Database\Seeder;

class CreditSaleSeeder extends Seeder
{
    public function run(): void
    {
        // Venda confirmada
        CreditSale::create([
            'cliente_id' => 1,
            'produto_id' => 1,
            'user_id_executor' => 2,
            "tipo_transacao" => "entrada",
            'valor' => 2.25,
            'quantidade_creditos' => 15,
            'valor_total' => 27,
            'status' => 'confirmado',
            'data_venda' => now(),
            'observacao' => 'Venda inicial de créditos'
        ]);

        // Venda pendente
        CreditSale::create([
            'cliente_id' => 2,
            'produto_id' => 1,
            'user_id_executor' => 2,
            "tipo_transacao" => "saida",
            'valor' => 1.89,
            'quantidade_creditos' => 10,
            'valor_total' => 18.9,
            'status' => 'pendente',
            'data_venda' => now()->subDays(1),
            'observacao' => 'Aguardando confirmação de pagamento'
        ]);
    }
}
