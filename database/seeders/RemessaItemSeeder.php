<?php

namespace Database\Seeders;

use App\Models\RemessaItem;
use Illuminate\Database\Seeder;

class RemessaItemSeeder extends Seeder
{
    public function run(): void
    {
        // Itens da primeira remessa (João Silva)
        RemessaItem::create([
            'remessa_id' => 1,
            'product_id' => 1, // Cartão RFID 13.56MHz
            'quantidade' => 10,
            'valor_creditos_unitario' => 1.50,
            'valor_creditos_total' => 15.00
        ]);

        // Itens da segunda remessa (Empresa XYZ)
        RemessaItem::create([
            'remessa_id' => 2,
            'product_id' => 3, // Cartão Dual Frequency
            'quantidade' => 100,
            'valor_creditos_unitario' => 4.50,
            'valor_creditos_total' => 450.00
        ]);

        // Itens da terceira remessa (Maria Oliveira)
        RemessaItem::create([
            'remessa_id' => 3,
            'product_id' => 2, // Tag NFC Adesiva
            'quantidade' => 10,
            'valor_creditos_unitario' => 2.50,
            'valor_creditos_total' => 25.00
        ]);

        // Itens da quarta remessa (Empresa XYZ)
        RemessaItem::create([
            'remessa_id' => 4,
            'product_id' => 3, // Cartão Dual Frequency
            'quantidade' => 50,
            'valor_creditos_unitario' => 4.50,
            'valor_creditos_total' => 225.00
        ]);
    }
} 