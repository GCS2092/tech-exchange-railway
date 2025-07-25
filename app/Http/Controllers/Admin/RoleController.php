<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin|super-admin']);
    }

    /**
     * Afficher la liste des rôles
     */
    public function index()
    {
        $roles = Role::withCount(['users', 'permissions'])->get();
        $permissions = Permission::all();
        $activeUsers = User::where('is_blocked', false)->count();
        $usedRoles = Role::whereHas('users')->count();

        return view('admin.roles.index', compact('roles', 'permissions', 'activeUsers', 'usedRoles'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $permissions = Permission::all()->groupBy(function($permission) {
            return explode('-', $permission->name)[0] ?? 'general';
        });

        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Enregistrer un nouveau rôle
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'description' => 'nullable|string|max:500',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role = Role::create([
            'name' => strtolower($request->name),
            'description' => $request->description,
            'guard_name' => 'web'
        ]);

        if ($request->has('permissions')) {
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permissions);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rôle créé avec succès.');
    }

    /**
     * Afficher un rôle spécifique
     */
    public function show(Role $role)
    {
        $role->load(['users', 'permissions']);
        $permissions = Permission::all()->groupBy(function($permission) {
            return explode('-', $permission->name)[0] ?? 'general';
        });

        return view('admin.roles.show', compact('role', 'permissions'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all()->groupBy(function($permission) {
            return explode('-', $permission->name)[0] ?? 'general';
        });

        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Mettre à jour un rôle
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'description' => 'nullable|string|max:500',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        // Empêcher la modification des rôles système
        if (in_array($role->name, ['admin', 'super-admin'])) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Impossible de modifier les rôles système.');
        }

        $role->update([
            'name' => strtolower($request->name),
            'description' => $request->description
        ]);

        if ($request->has('permissions')) {
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permissions);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rôle mis à jour avec succès.');
    }

    /**
     * Supprimer un rôle
     */
    public function destroy(Role $role)
    {
        // Empêcher la suppression des rôles système
        if (in_array($role->name, ['admin', 'super-admin'])) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Impossible de supprimer les rôles système.');
        }

        // Vérifier si le rôle est utilisé
        if ($role->users()->count() > 0) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Impossible de supprimer un rôle utilisé par des utilisateurs.');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rôle supprimé avec succès.');
    }

    /**
     * Attribuer un rôle à un utilisateur
     */
    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name'
        ]);

        $user->syncRoles([$request->role]);

        return redirect()->back()
            ->with('success', 'Rôle attribué avec succès.');
    }

    /**
     * Retirer un rôle d'un utilisateur
     */
    public function removeRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name'
        ]);

        $user->removeRole($request->role);

        return redirect()->back()
            ->with('success', 'Rôle retiré avec succès.');
    }

    /**
     * Afficher les permissions
     */
    public function permissions()
    {
        $permissions = Permission::withCount('roles')->get()->groupBy(function($permission) {
            return explode('-', $permission->name)[0] ?? 'general';
        });

        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Créer une nouvelle permission
     */
    public function createPermission(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'description' => 'nullable|string|max:500'
        ]);

        Permission::create([
            'name' => strtolower($request->name),
            'description' => $request->description,
            'guard_name' => 'web'
        ]);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission créée avec succès.');
    }

    /**
     * Supprimer une permission
     */
    public function destroyPermission(Permission $permission)
    {
        // Vérifier si la permission est utilisée
        if ($permission->roles()->count() > 0) {
            return redirect()->route('admin.permissions.index')
                ->with('error', 'Impossible de supprimer une permission utilisée par des rôles.');
        }

        $permission->delete();

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission supprimée avec succès.');
    }
} 