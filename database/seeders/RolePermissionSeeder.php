<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Delete all existing permissions and roles
        Permission::query()->delete();
        Role::query()->delete();

        // Create permissions
        $permissions = [
            'view dashboard',
            'manage users',
            'manage products',
            'manage orders',
            'manage categories',
            'manage delivery',
            'view orders',
            'create orders',
            'update orders',
            'delete orders',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo($permissions);

        $livreurRole = Role::create(['name' => 'livreur']);
        $livreurRole->givePermissionTo([
            'view orders',
            'update orders',
        ]);

        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo([
            'view orders',
            'create orders',
        ]);
    }
} 