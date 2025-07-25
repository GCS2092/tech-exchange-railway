<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpController extends Controller
{
    /**
     * Afficher la page d'aide selon le rôle de l'utilisateur
     */
    public function index()
    {
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        if ($user->hasRole('admin')) {
            return view('help.admin');
        } elseif ($user->hasRole('livreur')) {
            return view('help.livreur');
        } else {
            return view('help.client');
        }
    }
    
    /**
     * Afficher l'aide pour les clients
     */
    public function client()
    {
        return view('help.client');
    }
    
    /**
     * Afficher l'aide pour les administrateurs
     */
    public function admin()
    {
        return view('help.admin');
    }
    
    /**
     * Afficher l'aide pour les livreurs
     */
    public function livreur()
    {
        return view('help.livreur');
    }
} 