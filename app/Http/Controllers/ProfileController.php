<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    // Méthode pour afficher le profil
    public function edit()
    {
        $user = Auth::user();
        
        // Redirection basée sur le rôle pour utiliser les bons layouts
        if ($user->hasRole('livreur')) {
            return view('livreurs.profile', compact('user'));
        } elseif ($user->hasRole('admin')) {
            return view('admin.profile', compact('user'));
        } elseif ($user->hasRole('vendeur')) {
            return view('vendor.profile', compact('user'));
        } else {
            return view('user.profile', compact('user'));
        }
    }

    // Méthode pour mettre à jour le profil
    public function update(Request $request)
    {
        $user = Auth::user();
        
        try {
            // Validation mise à jour pour accepter les différents champs
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'phone' => 'nullable|string|max:20',
                'phone_number' => 'nullable|string|max:20',
                'password' => 'nullable|string|min:8|confirmed',
                'current_password' => 'nullable|required_with:password',
                'vehicle_type' => 'nullable|string|max:100',
                'address' => 'nullable|string|max:500',
            ]);

            // Mise à jour des informations de base
            $user->name = $validated['name'];
            
            // Gestion de l'email avec vérification
            if ($request->email !== $user->email) {
                $user->email = $validated['email'];
                $user->email_verified_at = null;
            }

            // Gestion du téléphone (support des deux noms de champs)
            if (isset($validated['phone'])) {
                $user->phone = $validated['phone'];
            } elseif (isset($validated['phone_number'])) {
                $user->phone = $validated['phone_number'];
            }

            // Gestion des champs spécifiques aux livreurs
            if (isset($validated['vehicle_type'])) {
                $user->vehicle_type = $validated['vehicle_type'];
            }

            // Gestion de l'adresse
            if (isset($validated['address'])) {
                $user->address = $validated['address'];
            }

            // Gestion du mot de passe
            if ($request->filled('password')) {
                // Vérification du mot de passe actuel si fourni
                if ($request->filled('current_password')) {
                    if (!Hash::check($request->current_password, $user->password)) {
                        return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
                    }
                }
                $user->password = Hash::make($validated['password']);
            }

            $user->save();

            // Log de la mise à jour
            Log::info('Profil mis à jour', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'updated_fields' => array_keys($validated)
            ]);

            $successMessage = 'Profil mis à jour avec succès.';
            
            // Redirection basée sur le rôle
            if ($user->hasRole('livreur')) {
                return redirect()->route('livreur.profile')->with('success', $successMessage);
            } elseif ($user->hasRole('admin')) {
                return redirect()->route('admin.profile')->with('success', $successMessage);
            } elseif ($user->hasRole('vendeur')) {
                return redirect()->route('vendeur.profile')->with('success', $successMessage);
            } else {
                return redirect()->route('profile.edit')->with('success', $successMessage);
            }

        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour du profil', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'request_data' => $request->except(['password', 'password_confirmation', 'current_password'])
            ]);

            return back()->withErrors(['general' => 'Une erreur est survenue lors de la mise à jour du profil. Veuillez réessayer.']);
        }
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
            return redirect()->route('admin.users.index')->with('success', 'Compte administrateur supprimé.');
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
