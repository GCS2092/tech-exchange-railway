<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Méthode pour afficher le profil
    public function edit()
    {
        return view('user.profile', ['user' => Auth::user()]);
    }

    // Méthode pour mettre à jour le profil
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validation mise à jour selon les spécifications demandées
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone_number' => 'nullable|regex:/^\+?\d{8,15}$/',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Vérification si l'email a changé
        if ($request->email !== $user->email) {
            $user->email = $validated['email'];
            $user->email_verified_at = null;
        }

        $user->name = $validated['name'];
        $user->phone_number = $validated['phone_number'] ?? $user->phone_number;

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil mis à jour avec succès.');
    }

    // Méthode pour supprimer le compte
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Rediriger vers la liste des utilisateurs si l'utilisateur supprimé était un admin
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.users.list')->with('success', 'Compte administrateur supprimé.');
        }

        // Sinon, redirection générique
        return redirect('/')->with('success', 'Votre compte a été supprimé avec succès.');
    }

    // Méthode pour afficher l'historique des commandes
    public function orders()
    {
        $orders = Auth::user()->orders()->latest()->get();
        return view('user.orders', compact('orders'));
    }

    // Méthode pour afficher les détails d'une commande
    public function orderDetails($id)
    {
        $order = Auth::user()->orders()->findOrFail($id);
        return view('user.order-details', compact('order'));
    }


    public function showFidelityCalendar()
{
    $user = auth()->user();
    $orders = $user->eligibleOrdersForReward()->get();
    $orderCount = $orders->count();
    $neededForReward = max(0, 5 - $orderCount); // 5 commandes requises

    return view('profile.fidelity-calendar', compact('orders', 'orderCount', 'neededForReward'));
}

}
