<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AssignRolesSeeder extends Seeder
{
    public function run(): void
    {
        // Assign admin role to admin user
        $adminUser = User::where('email', 'Slovengama@gmail.com')->first();
        if ($adminUser) {
            $adminUser->assignRole('admin');
        }

        // Assign livreur role to livreur user
        $livreurUser = User::where('email', 'Stemk2151@gmail.com')->first();
        if ($livreurUser) {
            $livreurUser->assignRole('livreur');
        }
    }
} 