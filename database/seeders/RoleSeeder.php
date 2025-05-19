<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Cria a role de admin
        $role = Role::create([
            "nome"=> "Admin",
            "descricao"=> "Dono do sistema",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Associa ao usuário de ID 1
        $user = User::find(1);

        if ($user && $role) {
            $user->roles()->attach($role->user_id);
        }
    }
}
