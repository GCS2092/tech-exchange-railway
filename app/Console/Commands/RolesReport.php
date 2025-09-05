<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesReport extends Command
{
    protected $signature = 'roles:report';
    protected $description = 'Affiche les rôles, permissions et manquants recommandés pour le site e-commerce';

    public function handle()
    {
        $this->info('--- RÔLES EXISTANTS ---');
        $roles = Role::with('permissions')->get();
        foreach ($roles as $role) {
            $this->line("- {$role->name} (" . $role->permissions->count() . ' permissions)');
        }

        $this->info("\n--- PERMISSIONS EXISTANTES ---");
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            $this->line("- {$permission->name}");
        }

        $this->info("\n--- PERMISSIONS ORPHELINES (non attribuées à un rôle) ---");
        $orphans = $permissions->filter(function($perm) {
            return $perm->roles->count() === 0;
        });
        foreach ($orphans as $permission) {
            $this->line("- {$permission->name}");
        }
        if ($orphans->isEmpty()) {
            $this->line('Aucune permission orpheline.');
        }

        $this->info("\n--- RÔLES RECOMMANDÉS MANQUANTS ---");
        $recommended = ['super_admin','admin','manager','supervisor','vendeur','livreur','support','client'];
        $existing = $roles->pluck('name')->toArray();
        $missing = array_diff($recommended, $existing);
        foreach ($missing as $role) {
            $this->line("- $role");
        }
        if (empty($missing)) {
            $this->line('Aucun rôle recommandé manquant.');
        }

        $this->info("\n--- FIN DU RAPPORT ---");
        return 0;
    }
} 