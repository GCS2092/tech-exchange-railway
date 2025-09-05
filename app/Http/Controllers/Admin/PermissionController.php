<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin|super-admin']);
    }

    /**
     * Afficher la liste des permissions
     */
    public function index()
    {
        $permissions = Permission::withCount('roles')->get()->groupBy(function($permission) {
            return explode('-', $permission->name)[0] ?? 'general';
        });

        $totalPermissions = Permission::count();
        $usedPermissions = Permission::whereHas('roles')->count();
        $unusedPermissions = $totalPermissions - $usedPermissions;

        return view('admin.permissions.index', compact('permissions', 'totalPermissions', 'usedPermissions', 'unusedPermissions'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $roles = Role::all();
        $permissionGroups = [
            'user' => 'Gestion des utilisateurs',
            'product' => 'Gestion des produits',
            'order' => 'Gestion des commandes',
            'transaction' => 'Gestion des transactions',
            'role' => 'Gestion des rôles',
            'permission' => 'Gestion des permissions',
            'report' => 'Rapports et statistiques',
            'delivery' => 'Gestion des livraisons',
            'notification' => 'Gestion des notifications',
            'system' => 'Configuration système'
        ];

        return view('admin.permissions.create', compact('roles', 'permissionGroups'));
    }

    /**
     * Enregistrer une nouvelle permission
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'description' => 'nullable|string|max:500',
            'group' => 'nullable|string|max:100',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id'
        ]);

        $permission = Permission::create([
            'name' => strtolower($request->name),
            'description' => $request->description,
            'guard_name' => 'web'
        ]);

        // Attribuer la permission aux rôles sélectionnés
        if ($request->has('roles')) {
            $roles = Role::whereIn('id', $request->roles)->get();
            foreach ($roles as $role) {
                $role->givePermissionTo($permission);
            }
        }

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission créée avec succès.');
    }

    /**
     * Afficher une permission spécifique
     */
    public function show(Permission $permission)
    {
        $permission->load(['roles']);
        $allRoles = Role::all();
        
        return view('admin.permissions.show', compact('permission', 'allRoles'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Permission $permission)
    {
        $roles = Role::all();
        $permissionGroups = [
            'user' => 'Gestion des utilisateurs',
            'product' => 'Gestion des produits',
            'order' => 'Gestion des commandes',
            'transaction' => 'Gestion des transactions',
            'role' => 'Gestion des rôles',
            'permission' => 'Gestion des permissions',
            'report' => 'Rapports et statistiques',
            'delivery' => 'Gestion des livraisons',
            'notification' => 'Gestion des notifications',
            'system' => 'Configuration système'
        ];

        return view('admin.permissions.edit', compact('permission', 'roles', 'permissionGroups'));
    }

    /**
     * Mettre à jour une permission
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
            'description' => 'nullable|string|max:500',
            'group' => 'nullable|string|max:100',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id'
        ]);

        // Empêcher la modification des permissions système
        if (in_array($permission->name, ['manage users', 'manage roles', 'manage permissions'])) {
            return redirect()->route('admin.permissions.index')
                ->with('error', 'Impossible de modifier les permissions système.');
        }

        $permission->update([
            'name' => strtolower($request->name),
            'description' => $request->description
        ]);

        // Synchroniser les rôles
        if ($request->has('roles')) {
            $roles = Role::whereIn('id', $request->roles)->get();
            $permission->syncRoles($roles);
        } else {
            $permission->syncRoles([]);
        }

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission mise à jour avec succès.');
    }

    /**
     * Supprimer une permission
     */
    public function destroy(Permission $permission)
    {
        // Empêcher la suppression des permissions système
        if (in_array($permission->name, ['manage users', 'manage roles', 'manage permissions'])) {
            return redirect()->route('admin.permissions.index')
                ->with('error', 'Impossible de supprimer les permissions système.');
        }

        // Vérifier si la permission est utilisée
        if ($permission->roles()->count() > 0) {
            return redirect()->route('admin.permissions.index')
                ->with('error', 'Impossible de supprimer une permission utilisée par des rôles.');
        }

        $permission->delete();

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission supprimée avec succès.');
    }

    /**
     * Attribuer une permission à un rôle
     */
    public function assignToRole(Request $request, Permission $permission)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id'
        ]);

        $role = Role::find($request->role_id);
        $role->givePermissionTo($permission);

        return redirect()->back()
            ->with('success', 'Permission attribuée au rôle avec succès.');
    }

    /**
     * Retirer une permission d'un rôle
     */
    public function removeFromRole(Request $request, Permission $permission)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id'
        ]);

        $role = Role::find($request->role_id);
        $role->revokePermissionTo($permission);

        return redirect()->back()
            ->with('success', 'Permission retirée du rôle avec succès.');
    }

    /**
     * Générer des permissions par défaut
     */
    public function generateDefaultPermissions()
    {
        $defaultPermissions = [
            // Gestion des utilisateurs
            'user-view' => 'Voir les utilisateurs',
            'user-create' => 'Créer des utilisateurs',
            'user-edit' => 'Modifier les utilisateurs',
            'user-delete' => 'Supprimer les utilisateurs',
            'user-block' => 'Bloquer/débloquer les utilisateurs',

            // Gestion des produits
            'product-view' => 'Voir les produits',
            'product-create' => 'Créer des produits',
            'product-edit' => 'Modifier les produits',
            'product-delete' => 'Supprimer les produits',
            'product-manage-stock' => 'Gérer le stock des produits',

            // Gestion des commandes
            'order-view' => 'Voir les commandes',
            'order-create' => 'Créer des commandes',
            'order-edit' => 'Modifier les commandes',
            'order-delete' => 'Supprimer les commandes',
            'order-update-status' => 'Mettre à jour le statut des commandes',

            // Gestion des transactions
            'transaction-view' => 'Voir les transactions',
            'transaction-create' => 'Créer des transactions',
            'transaction-edit' => 'Modifier les transactions',
            'transaction-delete' => 'Supprimer les transactions',

            // Gestion des rôles
            'role-view' => 'Voir les rôles',
            'role-create' => 'Créer des rôles',
            'role-edit' => 'Modifier les rôles',
            'role-delete' => 'Supprimer les rôles',

            // Gestion des permissions
            'permission-view' => 'Voir les permissions',
            'permission-create' => 'Créer des permissions',
            'permission-edit' => 'Modifier les permissions',
            'permission-delete' => 'Supprimer les permissions',

            // Rapports et statistiques
            'report-view' => 'Voir les rapports',
            'report-export' => 'Exporter les rapports',
            'report-generate' => 'Générer des rapports',

            // Gestion des livraisons
            'delivery-view' => 'Voir les livraisons',
            'delivery-assign' => 'Assigner des livraisons',
            'delivery-update-status' => 'Mettre à jour le statut des livraisons',

            // Notifications
            'notification-send' => 'Envoyer des notifications',
            'notification-manage' => 'Gérer les notifications',

            // Configuration système
            'system-settings' => 'Gérer les paramètres système',
            'system-backup' => 'Effectuer des sauvegardes',
            'system-logs' => 'Voir les logs système'
        ];

        $createdCount = 0;
        foreach ($defaultPermissions as $name => $description) {
            if (!Permission::where('name', $name)->exists()) {
                Permission::create([
                    'name' => $name,
                    'description' => $description,
                    'guard_name' => 'web'
                ]);
                $createdCount++;
            }
        }

        return redirect()->route('admin.permissions.index')
            ->with('success', "{$createdCount} permissions par défaut ont été créées.");
    }

    /**
     * Afficher les statistiques des permissions
     */
    public function stats()
    {
        $stats = [
            'total_permissions' => Permission::count(),
            'used_permissions' => Permission::whereHas('roles')->count(),
            'unused_permissions' => Permission::whereDoesntHave('roles')->count(),
            'total_roles' => Role::count(),
            'permissions_by_group' => Permission::all()->groupBy(function($permission) {
                return explode('-', $permission->name)[0] ?? 'general';
            })->map->count()
        ];

        return view('admin.permissions.stats', compact('stats'));
    }
} 