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
            UserSeeder::class,  // Usuários (para autenticação)
            EnderecoSeeder::class, // Criar endereços para usuários
            TiposEntregaSeeder::class, // Criar endereços para usuários
            ProductSeeder::class,     // Produtos (necessário para remessas)
            TecnologiasSeeder::class, // Tecnologias [Mirafe, RFID]
            ModelosTecnicosSeeder::class, // Modelo do cliente (crachás)
            ModelosTecnicosCamposVariaveisSeeder::class, // Campos variáveis que vão ter no modelo
            UsuarioClienteSeeder::class, // Usuário do cliente (vedendor da letscom)
            RemessaSeeder::class,     // Remessas
            RemessaItemSeeder::class,  // Itens das remessas
            CreditSaleSeeder::class,  // Vendas de créditos
        ]);
    }
}
