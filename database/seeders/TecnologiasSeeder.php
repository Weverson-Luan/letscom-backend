<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TecnologiasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tecnologias')->insert([
            [
                'nome' => 'Mifare 13,56kHz',
                'descricao' => 'Tecnologia de rádio frequência para leitura segura.',
                'ativo' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nome' => 'RFID 125kHz',
                'descricao' => 'Leitura de cartões de baixa frequência.',
                'ativo' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nome' => 'Tarja Magnética de Alta Densidade',
                'descricao' => 'Para cartões com alta resistência à leitura.',
                'ativo' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nome' => 'Adesivo',
                'descricao' => 'Tecnologia adesiva para cartões ou etiquetas.',
                'ativo' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nome' => 'Laminação Fosca',
                'descricao' => 'Acabamento fosco resistente e sofisticado.',
                'ativo' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nome' => 'Código de barras 2 de 5 intercalado',
                'descricao' => 'Padrão comum de código de barras em cartões.',
                'ativo' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nome' => 'Nenhuma Tecnologia',
                'descricao' => 'Nenhum tipo de tecnologia para o cartão.',
                'ativo' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
