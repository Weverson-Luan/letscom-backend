<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Lista de usuários e papéis
        $usuarios = [
            [
                'nome' => 'Administrador',
                'email' => 'admin@example.com',
                'senha' => 'admin123',
                'role' => 'Admin',
                'descricao_role' => 'Responsável por gerenciar todo o sistema, incluindo usuários, permissões, configurações globais e dados operacionais. Possui acesso irrestrito a todos os recursos da plataforma.',
                'telefone' => '31999999999',
            ],
            [
                'nome' => 'WLTECH',
                'email' => 'luansousa@gmail.com',
                'senha' => 'cliente123',
                'role' => 'Cliente',
                'descricao_role' => 'Usuário externo com acesso às suas remessas e informações de produção.',
                'telefone' => '31999999998',
            ],
            [
                'nome' => 'Guilherme',
                'email' => 'guilherme@letscom.com',
                'senha' => 'producao123',
                'role' => 'Producao',
                'descricao_role' => 'Responsável por executar tarefas de produção e acompanhar remessas em andamento.',
                'telefone' => '31999999997',
            ],
            [
                'nome' => 'Alice',
                'email' => 'alice@letscom.com',
                'senha' => 'producao123',
                'role' => 'Producao',
                'descricao_role' => 'Responsável por executar tarefas de produção e acompanhar remessas em andamento.',
                'telefone' => '31999999992',
            ],
            [
                'nome' => 'Xirlene',
                'email' => 'xirlene@example.com',
                'senha' => 'recepcao123',
                'role' => 'Recepcao',
                'descricao_role' => 'Responsável por cadastrar remessas e encaminhá-las para produção.',
                'telefone' => '31999999996',
            ],
            [
                'nome' => 'Solicitante Remessa',
                'email' => 'solicitante@example.com',
                'senha' => 'recepcao123',
                'role' => 'Solicitante',
                'descricao_role' => 'Responsável por solicitar remessas.',
                'telefone' => '31999999934',
            ],
        ];

        foreach ($usuarios as $dados) {
            // Cria ou atualiza a role
            $role = Role::firstOrCreate(
                ['nome' => $dados['role']],
                ['descricao' => $dados['descricao_role']]
            );

            // Cria o usuário
            $user = User::firstOrCreate(
                ['email' => $dados['email']],
                [
                    'nome' => $dados['nome'],
                    'senha' => Hash::make($dados['senha']),
                    'documento' => Str::random(14),
                    'ativo' => true,
                    'tipo_pessoa' => 'F',
                    'telefone' => $dados['telefone'],
                ]
            );

            // Vincula o papel ao usuário
            $user->roles()->syncWithoutDetaching([$role->id]);
        }
    }
}
