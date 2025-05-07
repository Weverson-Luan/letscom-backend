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
            ModelosTecnicosSeeder::class, // modelo do cliente
            ProductSeeder::class,     // Produtos (necessário para remessas)
            RemessaSeeder::class,     // Remessas
            RemessaItemSeeder::class,  // Itens das remessas
            CreditSaleSeeder::class,  // Vendas de créditos
            ModelosTecnicosCamposVariaveisSeeder::class
        ]);
    }
}
