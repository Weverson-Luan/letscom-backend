<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        Permission::create([
            'user_id' => 1, // admin user
            'module' => 'all',
            'permissions' => 'all'
        ]);
    }
} 