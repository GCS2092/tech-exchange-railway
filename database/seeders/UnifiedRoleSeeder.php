<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class UnifiedRoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Supprimer tous les rôles et permissions existants
        Role::query()->delete();
        Permission::query()->delete();

        // Créer toutes les permissions
        $permissions = [
            // Dashboard
            'view dashboard',
            
            // Gestion des utilisateurs
            'view users',
            'create users',
            'edit users',
            'delete users',
            'manage users',
            'block users',
            'unblock users',
            
            // Gestion des produits
            'view products',
            'create products',
            'edit products',
            'delete products',
            'manage products',
            'manage inventory',
            'view inventory',
            
            // Gestion des commandes
            'view orders',
            'create orders',
            'edit orders',
            'delete orders',
            'manage orders',
            'export orders',
            'update order status',
            'assign livreur',
            
            // Gestion des transactions
            'view transactions',
            'create transactions',
            'edit transactions',
            'delete transactions',
            'manage transactions',
            'export transactions',
            
            // Gestion des catégories
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            'manage categories',
            
            // Gestion des promotions
            'view promotions',
            'create promotions',
            'edit promotions',
            'delete promotions',
            'manage promotions',
            
            // Gestion des livraisons
            'view deliveries',
            'manage deliveries',
            'view delivery routes',
            'update delivery status',
            'assign deliveries',
            
            // Rapports et analytics
            'view reports',
            'export reports',
            'view analytics',
            
            // Gestion des avis
            'view reviews',
            'moderate reviews',
            'delete reviews',
            
            // Support client
            'view support tickets',
            'manage support tickets',
            'respond to tickets',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Créer les rôles avec leurs permissions
        $this->createRoles();
        
        // Migrer les utilisateurs existants vers le nouveau système
        $this->migrateExistingUsers();
    }

    private function createRoles()
    {
        // Super Admin - Tous les droits
        $superAdmin = Role::create(['name' => 'super_admin', 'guard_name' => 'web']);
        $superAdmin->givePermissionTo(Permission::all());

        // Admin - Droits administratifs complets
        $admin = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $admin->givePermissionTo([
            'view dashboard',
            'view users', 'create users', 'edit users', 'delete users', 'manage users', 'block users', 'unblock users',
            'view products', 'create products', 'edit products', 'delete products', 'manage products', 'manage inventory', 'view inventory',
            'view orders', 'create orders', 'edit orders', 'delete orders', 'manage orders', 'export orders', 'update order status', 'assign livreur',
            'view transactions', 'create transactions', 'edit transactions', 'delete transactions', 'manage transactions', 'export transactions',
            'view categories', 'create categories', 'edit categories', 'delete categories', 'manage categories',
            'view promotions', 'create promotions', 'edit promotions', 'delete promotions', 'manage promotions',
            'view deliveries', 'manage deliveries', 'view delivery routes', 'update delivery status', 'assign deliveries',
            'view reports', 'export reports', 'view analytics',
            'view reviews', 'moderate reviews', 'delete reviews',
            'view support tickets', 'manage support tickets', 'respond to tickets',
        ]);

        // Manager - Gestion d'équipe et stratégie
        $manager = Role::create(['name' => 'manager', 'guard_name' => 'web']);
        $manager->givePermissionTo([
            'view dashboard',
            'view users', 'edit users', 'manage users',
            'view products', 'edit products', 'manage products', 'view inventory',
            'view orders', 'edit orders', 'manage orders', 'export orders', 'update order status',
            'view transactions', 'manage transactions', 'export transactions',
            'view categories', 'edit categories', 'manage categories',
            'view promotions', 'edit promotions', 'manage promotions',
            'view deliveries', 'manage deliveries',
            'view reports', 'export reports', 'view analytics',
            'view reviews', 'moderate reviews',
            'view support tickets', 'manage support tickets',
        ]);

        // Supervisor - Supervision opérationnelle
        $supervisor = Role::create(['name' => 'supervisor', 'guard_name' => 'web']);
        $supervisor->givePermissionTo([
            'view dashboard',
            'view users',
            'view products', 'edit products', 'view inventory',
            'view orders', 'edit orders', 'update order status', 'assign livreur',
            'view transactions',
            'view categories',
            'view promotions',
            'view deliveries', 'update delivery status',
            'view reports',
            'view reviews', 'moderate reviews',
            'view support tickets', 'respond to tickets',
        ]);

        // Vendeur - Gestion des ventes
        $vendeur = Role::create(['name' => 'vendeur', 'guard_name' => 'web']);
        $vendeur->givePermissionTo([
            'view dashboard',
            'view products', 'create products', 'edit products', 'delete products', 'manage products',
            'manage inventory', 'view inventory',
            'view orders', 'create orders', 'edit orders', 'delete orders',
            'view transactions',
            'view categories',
            'view promotions',
            'view reports',
            // Permissions spécifiques vendeur
            'view users', // Pour voir ses clients/abonnés
        ]);

        // Livreur - Gestion des livraisons
        $livreur = Role::create(['name' => 'livreur', 'guard_name' => 'web']);
        $livreur->givePermissionTo([
            'view dashboard',
            'view orders',
            'update delivery status',
            'view delivery routes',
        ]);

        // Support Client - Service client
        $support = Role::create(['name' => 'support', 'guard_name' => 'web']);
        $support->givePermissionTo([
            'view dashboard',
            'view users',
            'view orders',
            'view transactions',
            'view support tickets', 'manage support tickets', 'respond to tickets',
            'view reviews', 'moderate reviews',
        ]);

        // Client - Utilisateur final
        $client = Role::create(['name' => 'client', 'guard_name' => 'web']);
        $client->givePermissionTo([
            'view products',
            'create orders',
            'view orders',
        ]);
    }

    private function migrateExistingUsers()
    {
        // Migrer les utilisateurs existants vers le nouveau système
        $users = User::all();

        foreach ($users as $user) {
            // Si l'utilisateur a un rôle legacy, le migrer
            if (isset($user->role)) {
                $legacyRole = $user->role;
                
                // Mapping des rôles legacy vers les nouveaux rôles
                $roleMapping = [
                    'admin' => 'admin',
                    'user' => 'client',
                    'livreur' => 'livreur',
                    'delivery' => 'livreur',
                    'client' => 'client',
                    'vendeur' => 'vendeur',
                ];

                $newRole = $roleMapping[$legacyRole] ?? 'client';
                
                // Assigner le nouveau rôle
                $user->assignRole($newRole);
                
                // Supprimer l'ancien champ role (optionnel)
                // $user->update(['role' => null]);
            } else {
                // Si pas de rôle, assigner le rôle client par défaut
                $user->assignRole('client');
            }
        }
    }
}
