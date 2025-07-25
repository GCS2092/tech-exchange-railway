<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Mail\WelcomeSellerMail;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
            'role' => ['required', 'string', 'exists:roles,name'],
        ]);
        $user = \App\Models\User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);
        $user->assignRole($request->role);
        // Mail de bienvenue vendeur
        if ($request->role === 'vendeur') {
            \Mail::to($user->email)->send(new \App\Mail\WelcomeSellerMail($user));
        }
        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur créé avec succès');
    }

    public function edit(User $user)
    {
        // Limiter aux rôles ayant des vues et logique : admin, vendeur, delivery, user
        $availableRoles = \Spatie\Permission\Models\Role::whereIn('name', ['admin', 'vendeur', 'livreur', 'user'])->get();
        $permissions = \Spatie\Permission\Models\Permission::all();
        
        return view('admin.users.edit', compact('user', 'availableRoles', 'permissions'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['nullable', 'string', 'exists:roles,name'],
            'permissions' => ['array'],
            'permissions.*' => ['exists:permissions,id'],
            'is_blocked' => ['boolean'],
        ]);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'is_blocked' => $request->boolean('is_blocked'),
        ]);
        if ($request->filled('role')) {
            $user->syncRoles([$request->role]);
        }
        if ($request->has('permissions')) {
            $permissions = \Spatie\Permission\Models\Permission::whereIn('id', $request->permissions)->get();
            $user->syncDirectPermissions($permissions);
        }
        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur mis à jour avec succès');
    }

    public function destroy(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        // Vérifier si l'utilisateur connecté est un admin
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Vous n\'avez pas les permissions nécessaires pour effectuer cette action.');
        }

        // Vérifier le mot de passe de l'admin
        if (!Hash::check($request->password, auth()->user()->password)) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Mot de passe incorrect.');
        }

        // Empêcher l'auto-suppression
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        // Suppression en cascade des cart_items
        $user->cartItems()->delete();
        // (Optionnel) Ajoute ici d'autres suppressions liées si besoin (ex: commandes, avis...)

        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur supprimé avec succès');
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => ['required', 'string', 'exists:roles,name'],
        ]);
        $user->syncRoles([$request->role]);
        return redirect()->route('admin.users.index')
            ->with('success', 'Rôle de l\'utilisateur mis à jour avec succès');
    }

    public function block(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);
        if (!auth()->user()->hasRole('admin')) {
            return back()->with('error', 'Vous n\'avez pas les permissions nécessaires.');
        }
        if (!Hash::check($request->password, auth()->user()->password)) {
            return back()->with('error', 'Mot de passe admin incorrect.');
        }
        if ($user->is_blocked) {
            return back()->with('error', 'Ce compte est déjà bloqué.');
        }
        $user->is_blocked = true;
        $user->save();
        // Envoi d'un email à l'utilisateur avec lien de contact admin
        \Mail::to($user->email)->send(new \App\Mail\UserBlockedMail($user, auth()->user()));
        return back()->with('success', 'Utilisateur bloqué et notifié par email.');
    }

    public function unblock(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);
        if (!auth()->user()->hasRole('admin')) {
            return back()->with('error', 'Vous n\'avez pas les permissions nécessaires.');
        }
        if (!Hash::check($request->password, auth()->user()->password)) {
            return back()->with('error', 'Mot de passe admin incorrect.');
        }
        if (!$user->is_blocked) {
            return back()->with('error', 'Ce compte n\'est pas bloqué.');
        }
        $user->is_blocked = false;
        $user->save();
        // Envoi d'un email à l'utilisateur pour l'informer du déblocage
        \Mail::to($user->email)->send(new \App\Mail\UserUnblockedMail($user, auth()->user()));
        return back()->with('success', 'Utilisateur débloqué et notifié par email.');
    }

    // Afficher les produits d'un vendeur
    public function products(User $user)
    {
        if (!$user->hasRole('vendeur')) {
            abort(403, 'Cet utilisateur n\'est pas un vendeur.');
        }
        $products = $user->products()->paginate(20);
        return view('admin.users.products', compact('user', 'products'));
    }
} 