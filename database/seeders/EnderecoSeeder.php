<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Endereco;

class EnderecoSeeder extends Seeder
{
    public function run(): void
    {
        Endereco::create([
            'user_id' => 1, // certifique-se de que esse usuário exista
            'logradouro' => 'Rua Exemplo',
            'numero' => '123',
            'complemento' => 'Sala 5',
            'bairro' => 'Centro',
            'cidade' => 'Belo Horizonte',
            'estado' => 'MG',
            'cep' => '30130-000',
            'tipo_endereco' => "residencial",
            'nome_responsavel' => "Pedro Lucas Silva",
            'email' => 'pedrolucas@gmail.com',
            'setor' => 'Juridico',
            'telefone' => '3197582241',
        ]);

        Endereco::create([
            'user_id' => 2, // certifique-se de que esse usuário exista
            'logradouro' => 'Av. Brasil',
            'numero' => '198',
            'complemento' => null,
            'bairro' => 'Serra',
            'cidade' => 'Belo Horizonte',
            'estado' => 'MG',
            'cep' => '30140-100',
            'tipo_endereco' => "residencial",
            'nome_responsavel' => "Maria Das Dores",
            'email' => 'mariadores2025@gmail.com',
            'setor' => 'Administrativo',
            'telefone' => '31965357842',
        ]);

        Endereco::create([
            'user_id' => 3, // certifique-se de que esse usuário exista
            'logradouro' => 'Av. Portugal',
            'numero' => '159',
            'complemento' => null,
            'bairro' => 'Gameleira',
            'cidade' => 'Belo Horizonte',
            'estado' => 'MG',
            'cep' => '30140-240',
            'tipo_endereco' => "residencial",
            'nome_responsavel' => "Elton Souza",
            'email' => 'eltonsouza@gmail.com',
            'setor' => 'Financeiro',
            'telefone' => '31985637659',
        ]);

        Endereco::create([
            'user_id' => 4, // certifique-se de que esse usuário exista
            'logradouro' => 'Av. Dom pedro I',
            'numero' => '100',
            'complemento' => null,
            'bairro' => 'Santa Terezinha',
            'cidade' => 'Belo Horizonte',
            'estado' => 'MG',
            'cep' => '31170-811',
            'tipo_endereco' => "residencial",
            'nome_responsavel' => "Mateus Carlos Almeida",
            'email' => 'mateuscarlos@gmail.com',
            'setor' => 'Administrativo',
            'telefone' => '31965357842',
        ]);

        Endereco::create([
            'user_id' => 5, // certifique-se de que esse usuário exista
            'logradouro' => 'Rua Silva Lobo',
            'numero' => '100',
            'complemento' => null,
            'bairro' => 'Jaqueline',
            'cidade' => 'Belo Horizonte',
            'estado' => 'MG',
            'cep' => '32471-438',
            'tipo_endereco' => "residencial",
            'nome_responsavel' => "José Pedro Alemida",
            'email' => 'pedro@gmail.com',
            'setor' => 'Administrativo',
            'telefone' => '31965357842',
        ]);
    }
}
