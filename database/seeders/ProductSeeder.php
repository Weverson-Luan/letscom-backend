<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Produto básico com estoque médio
        Product::create([
            'nome' => 'Cartão PVC',
            'tecnologia' => 'RFID',
            'valor' => 15.00,
            'valor_creditos' => 1.50,
            'estoque_minimo' => 100,
            'estoque_maximo' => 1000,
            'estoque_atual' => 500
        ]);

        // Produto premium com estoque baixo
        Product::create([
            'nome' => 'Cartão Fosco',
            'tecnologia' => 'NFC',
            'valor' => 25.00,
            'valor_creditos' => 2.50,
            'estoque_minimo' => 50,
            'estoque_maximo' => 500,
            'estoque_atual' => 75
        ]);

        // Produto empresarial com estoque alto
        Product::create([
            'nome' => 'Cartão PVC adesivado',
            'tecnologia' => 'RFID/NFC',
            'valor' => 45.00,
            'valor_creditos' => 4.50,
            'estoque_minimo' => 200,
            'estoque_maximo' => 2000,
            'estoque_atual' => 1500
        ]);

        // Produto econômico com estoque crítico
        Product::create([
            'nome' => 'Tarja RFID 125KHz',
            'tecnologia' => 'RFID',
            'valor' => 10.00,
            'valor_creditos' => 1.00,
            'estoque_minimo' => 100,
            'estoque_maximo' => 800,
            'estoque_atual' => 120
        ]);

          // Produto econômico com estoque crítico
        Product::create([
            'nome' => 'Chip MIFARE',
            'tecnologia' => 'Mifare 13,56kHz',
            'valor' => 10.00,
            'valor_creditos' => 1.00,
            'estoque_minimo' => 100,
            'estoque_maximo' => 800,
            'estoque_atual' => 120
        ]);
    }
}
