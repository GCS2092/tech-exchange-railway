<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AssignVendorRolesSeeder extends Seeder
{
    public function run(): void
    {
        // S'assurer que le rôle vendeur existe
        $vendeurRole = Role::firstOrCreate(['name' => 'vendeur', 'guard_name' => 'web']);
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $clientRole = Role::firstOrCreate(['name' => 'client', 'guard_name' => 'web']);

        // Assigner le rôle vendeur aux utilisateurs existants qui ont des produits
        $usersWithProducts = User::whereHas('products')->get();
        
        foreach ($usersWithProducts as $user) {
            if (!$user->hasRole('vendeur')) {
                $user->assignRole('vendeur');
                $this->command->info("Rôle vendeur assigné à {$user->name} ({$user->email})");
            }
        }

        // Assigner le rôle admin aux utilisateurs admin existants
        $adminUsers = User::role('admin')->orWhere('email', 'like', '%admin%')->get();
        
        foreach ($adminUsers as $user) {
            if (!$user->hasRole('admin')) {
                $user->assignRole('admin');
                $this->command->info("Rôle admin assigné à {$user->name} ({$user->email})");
            }
        }

        // Assigner le rôle client aux autres utilisateurs
        $usersWithoutRoles = User::whereDoesntHave('roles')->get();
        
        foreach ($usersWithoutRoles as $user) {
            if (!$user->hasRole('client')) {
                $user->assignRole('client');
                $this->command->info("Rôle client assigné à {$user->name} ({$user->email})");
            }
        }

        $this->command->info('Rôles assignés avec succès !');
    }
} 