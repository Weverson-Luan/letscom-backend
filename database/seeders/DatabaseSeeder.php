<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Executa todos os seeders na ordem correta.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,        // Primeiro usuários (para autenticação)
            ClientSeeder::class,      // Depois clientes (necessário para vendas)
            ProductSeeder::class,     // Produtos (necessário para remessas)
            CreditSaleSeeder::class,  // Vendas de créditos
            RemessaSeeder::class,     // Remessas
            RemessaItemSeeder::class  // Itens das remessas
        ]);
    }
}
