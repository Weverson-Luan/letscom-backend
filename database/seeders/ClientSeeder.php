<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        Client::create([
            'nome' => 'João Silva',
            'email' => 'joao.silva@example.com',
            'telefone' => '11999999999',
            'cpf_cnpj' => '12345678901',
            'tipo_pessoa' => 'F',
            'endereco' => 'Rua das Flores',
            'numero' => '123',
            'complemento' => 'Apto 42',
            'bairro' => 'Jardim América',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'cep' => '01234567',
            'saldo_creditos' => 1000.00
        ]);

        Client::create([
            'nome' => 'Empresa XYZ Ltda',
            'email' => 'contato@empresaxyz.com.br',
            'telefone' => '1133333333',
            'cpf_cnpj' => '12345678000199',
            'tipo_pessoa' => 'J',
            'endereco' => 'Avenida Paulista',
            'numero' => '1000',
            'complemento' => 'Sala 1010',
            'bairro' => 'Bela Vista',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'cep' => '01310100',
            'saldo_creditos' => 5000.00
        ]);

        // Cliente PF sem complemento
        Client::create([
            'nome' => 'Maria Oliveira',
            'email' => 'maria.oliveira@example.com',
            'telefone' => '11988888888',
            'cpf_cnpj' => '98765432100',
            'tipo_pessoa' => 'F',
            'endereco' => 'Rua dos Pinheiros',
            'numero' => '456',
            'complemento' => null,
            'bairro' => 'Pinheiros',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'cep' => '05422000',
            'saldo_creditos' => 500.00
        ]);
    }
} 