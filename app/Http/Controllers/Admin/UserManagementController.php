<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Notifications\NewUserCreatedNotification;
use App\Constants\ValidationRules;
class UserManagementController extends Controller
{
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);
        $user->syncRoles([$request->role]);
        return redirect()->route('admin.users.index')->with('success', 'Rôle mis à jour avec succès.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (!$user) {
            return redirect()->route('admin.users.index')->with('error', 'Utilisateur non trouvé.');
        }
        $request->validate([
            'name' => 'required',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,name',
        ]);
        $user->update($request->only('name', 'email'));
        $user->syncRoles([$request->role]);
        // Notifier les admins après avoir mis à jour l'utilisateur
        \App\Models\User::role('admin')->get()->each(function ($admin) use ($user) {
            $admin->notify(new \App\Notifications\NewUserCreatedNotification($user));
        });
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }


    public function details()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Accès refusé');
        }

        $users = User::orderBy('name')->paginate(10);
        return view('admin.users.details', compact('users'));
    }

    public function userOrders(User $user)
    {
        $orders = $user->orders;
        return view('admin.users.orders', compact('user', 'orders'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function orders(User $user)
    {
        $orders = $user->orders()->latest()->get();
        return view('admin.users.orders', compact('user', 'orders'));
    }

    public function show(User $user)
    {
        return view('admin.users.details', compact('user'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Compte administrateur supprimé.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
        ]);
        $user = \App\Models\User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);
        $user->assignRole($request->role);
        // Notifier les admins
        \App\Models\User::role('admin')->get()->each(function ($admin) use ($user) {
            $admin->notify(new \App\Notifications\NewUserCreatedNotification($user));
        });
        return redirect()->route('admin.users.index')->with('success', 'Nouvel utilisateur ajouté et notification envoyée.');
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Mot de passe mis à jour avec succès.');
    }
    
}
