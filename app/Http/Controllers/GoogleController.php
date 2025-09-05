<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Exception;

class GoogleController extends Controller
{
    /**
     * Redirige vers Google pour l'authentification
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Gère le callback de Google après authentification
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Vérifier si l'utilisateur existe déjà
            $user = User::where('email', $googleUser->getEmail())->first();
            
            if ($user) {
                // L'utilisateur existe, le connecter
                Auth::login($user);
                
                // CORRECTION: S'assurer que l'utilisateur existant a un rôle
                if (!$user->hasAnyRole(['admin', 'livreur', 'vendeur', 'client', 'manager', 'supervisor', 'support'])) {
                    $user->assignRole('client');
                }
                
                // Mettre à jour les informations Google si nécessaire
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar(),
                    ]);
                }
                
                return redirect()->intended('/dashboard');
            } else {
                // Créer un nouvel utilisateur
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'email_verified_at' => now(), // Email vérifié par Google
                    'password' => Hash::make(Str::random(16)), // Mot de passe aléatoire
                ]);
                
                // CORRECTION: Assigner automatiquement le rôle "client" aux nouveaux utilisateurs Google
                $user->assignRole('client');
                
                // Connecter l'utilisateur
                Auth::login($user);
                
                return redirect()->intended('/dashboard');
            }
            
        } catch (Exception $e) {
            return redirect('/login')->with('error', 'Erreur lors de la connexion avec Google. Veuillez réessayer.');
        }
    }
}
