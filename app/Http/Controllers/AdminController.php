<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session; // 👈 à ajouter
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function getNotifications()
    {
        return auth()->user()->unreadNotifications;
    }

    // ✅ Affiche tous les utilisateurs
    public function showUsers()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // ✅ Supprimer un utilisateur après vérification du mot de passe admin
    public function destroyUser(User $user, Request $request)
    {
        if (Hash::check($request->password, auth()->user()->password)) {
            $user->orders()->delete(); // Supprime ses commandes
            $user->delete();

            return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé avec succès.');
        }

        return redirect()->route('admin.users.index')->with('error', 'Mot de passe incorrect.');
    }

    // ✅ Affiche les commandes d'un utilisateur
    public function showUserOrders(User $user)
    {
        $orders = $user->orders;
        return view('admin.users.orders', compact('orders', 'user'));
    }

    // ✅ Crée un utilisateur depuis l’étape 3 du formulaire multistep
    public function storeUser(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::create([
            'name' => $request->name ?? Session::get('register_name'),
            'email' => $request->email ?? Session::get('register_email'),
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        // ✅ Gestion de la photo de profil
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo = $path;
            $user->save();
        }

        return redirect()->route('login')->with('success', "Compte créé avec succès !");
    }

    // ✅ Affiche la liste des utilisateurs paginée
    public function listUsers()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }
}
