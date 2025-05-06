<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Administrador com todas as permissões
        $admin = User::create([
            'nome' => 'Administrador',
            'email' => 'admin@example.com',
            'senha' => Hash::make('admin123'),
            'cpf' => '12345678900',
            'permissoes' => [
                'users' => 'CRUD',
                'clients' => 'CRUD',
                'products' => 'CRUD',
                'credit_sales' => 'CRUD',
                'remessas' => 'CRUD'
            ]
        ]);

        // Gerente com permissões de leitura e escrita
        User::create([
            'nome' => 'Gerente Comercial',
            'email' => 'gerente@example.com',
            'senha' => Hash::make('gerente123'),
            'cpf' => '98765432100',
            'permissoes' => [
                'clients' => 'CRUD',
                'products' => 'RU',
                'credit_sales' => 'CRUD',
                'remessas' => 'CRUD'
            ]
        ]);

        // Operador com permissões limitadas
        User::create([
            'nome' => 'Operador',
            'email' => 'operador@example.com',
            'senha' => Hash::make('operador123'),
            'cpf' => '45678912300',
            'permissoes' => [
                'clients' => 'R',
                'products' => 'R',
                'credit_sales' => 'CR',
                'remessas' => 'CR'
            ]
        ]);

        // Vendedor com permissões específicas
        User::create([
            'nome' => 'Vendedor',
            'email' => 'vendedor@example.com',
            'senha' => Hash::make('vendedor123'),
            'cpf' => '78912345600',
            'permissoes' => [
                'clients' => 'CRU',
                'products' => 'R',
                'credit_sales' => 'CR',
                'remessas' => 'CR'
            ]
        ]);
    }
} 