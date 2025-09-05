<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
        $permissions = [
            // User management
            'view users',
            'edit users',
            'delete users',
            'manage roles',
            // Product management
            'view products',
            'create products',
            'edit products',
            'delete products',
            'manage inventory',
            // Order management
            'view orders',
            'manage orders',
            'export orders',
            // Delivery management
            'manage deliveries',
            'view delivery routes',
            'update delivery status',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web']
            );
        }

        // Create roles if not exists
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $vendeur = Role::firstOrCreate(['name' => 'vendeur', 'guard_name' => 'web']);
        $livreur = Role::firstOrCreate(['name' => 'livreur', 'guard_name' => 'web']);
        $client = Role::firstOrCreate(['name' => 'client', 'guard_name' => 'web']);
        
        // Anciens rôles pour compatibilité
        $user = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
        $delivery = Role::firstOrCreate(['name' => 'delivery', 'guard_name' => 'web']);

        // Assign permissions to admin (all permissions)
        $admin->givePermissionTo(Permission::all());

        // Assign permissions to vendeur
        $vendeur->givePermissionTo([
            'view products',
            'create products',
            'edit products',
            'delete products',
            'manage inventory',
            'view orders',
        ]);

        // Assign permissions to livreur
        $livreur->givePermissionTo([
            'view orders',
            'manage deliveries',
            'view delivery routes',
            'update delivery status',
        ]);

        // Assign permissions to client
        $client->givePermissionTo([
            'view products',
            'view orders',
        ]);

        // Assign permissions to legacy roles
        $user->givePermissionTo([
            'view products',
            'view orders',
        ]);

        $delivery->givePermissionTo([
            'view orders',
            'manage deliveries',
            'view delivery routes',
            'update delivery status',
        ]);
    }
}
