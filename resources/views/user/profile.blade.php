@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-2xl md:text-xl font-bold text-white mb-4 drop-shadow-lg">
                Mon Profil
            </h1>
            <p class="text-slate-300 text-lg max-w-2xl mx-auto">
                Gérez vos informations personnelles et vos paramètres de sécurité
            </p>
        </div>

        <!-- Profile Card -->
        <div class="bg-white/10 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20 p-6 md:p-8">
            <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf
                @method('PATCH')

                <!-- Messages de succès/erreur -->
                @if (session('success'))
                    <div class="bg-green-500/20 border border-green-500/50 text-green-300 px-4 py-3 rounded-xl backdrop-blur-sm">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-500/20 border border-red-500/50 text-red-300 px-4 py-3 rounded-xl backdrop-blur-sm">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-semibold">Erreurs de validation :</span>
                        </div>
                        <ul class="list-disc list-inside space-y-1 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Informations personnelles -->
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Nom complet -->
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-semibold text-slate-200">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Nom complet
                            </div>
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 backdrop-blur-sm transition-all duration-300" 
                            value="{{ old('name', $user->name) }}" 
                            required
                            placeholder="Votre nom complet"
                        >
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-semibold text-slate-200">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Adresse email
                            </div>
                        </label>
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500/50 backdrop-blur-sm transition-all duration-300" 
                            value="{{ old('email', $user->email) }}" 
                            required
                            placeholder="votre@email.com"
                        >
                    </div>
                </div>

                <!-- Numéro de téléphone -->
                <div class="space-y-2">
                    <label for="phone" class="block text-sm font-semibold text-slate-200">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            Numéro de téléphone
                        </div>
                    </label>
                    <input 
                        type="tel" 
                        name="phone" 
                        id="phone" 
                        class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500/50 backdrop-blur-sm transition-all duration-300" 
                        value="{{ old('phone', $user->phone) }}"
                        placeholder="+33 6 12 34 56 78"
                    >
                    <p class="text-slate-400 text-sm flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Format international recommandé (ex: +33612345678)
                    </p>
                </div>

                <!-- Sécurité -->
                <div class="border-t border-white/10 pt-6">
                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Sécurité du compte
                    </h3>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Nouveau mot de passe -->
                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-semibold text-slate-200">
                                Nouveau mot de passe
                            </label>
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-yellow-500/50 focus:border-yellow-500/50 backdrop-blur-sm transition-all duration-300" 
                                placeholder="••••••••"
                            >
                            <p class="text-slate-400 text-sm">Laissez vide pour conserver votre mot de passe actuel</p>
                        </div>

                        <!-- Confirmation du mot de passe -->
                        <div class="space-y-2">
                            <label for="password_confirmation" class="block text-sm font-semibold text-slate-200">
                                Confirmer le mot de passe
                            </label>
                            <input 
                                type="password" 
                                name="password_confirmation" 
                                id="password_confirmation" 
                                class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-yellow-500/50 focus:border-yellow-500/50 backdrop-blur-sm transition-all duration-300" 
                                placeholder="••••••••"
                            >
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-white/10">
                    <button 
                        type="submit" 
                        class="flex-1 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 transition-all duration-300 border border-blue-400/30 hover:scale-105 flex items-center justify-center"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Mettre à jour le profil
                    </button>
                    
                    <a 
                        href="{{ route('dashboard') }}" 
                        class="flex-1 bg-white/10 hover:bg-white/20 text-white font-semibold py-3 px-6 rounded-xl border border-white/20 hover:border-white/30 transition-all duration-300 backdrop-blur-sm flex items-center justify-center"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Retour au tableau de bord
                    </a>
                </div>
            </form>
        </div>

        <!-- Informations supplémentaires -->
        <div class="mt-8 grid md:grid-cols-3 gap-6">
            <!-- Statut du compte -->
            <div class="bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 p-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-green-500/20 rounded-xl flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-white font-semibold">Statut du compte</h3>
                </div>
                <p class="text-green-400 font-semibold">Actif</p>
                <p class="text-slate-400 text-sm mt-1">Votre compte est en bon état</p>
            </div>

            <!-- Rôle utilisateur -->
            <div class="bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 p-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-blue-500/20 rounded-xl flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-white font-semibold">Rôle</h3>
                </div>
                <p class="text-blue-400 font-semibold">{{ Auth::user()->roles->first()->name ?? 'Utilisateur' }}</p>
                <p class="text-slate-400 text-sm mt-1">Vos permissions actuelles</p>
            </div>

            <!-- Membre depuis -->
            <div class="bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 p-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-purple-500/20 rounded-xl flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-white font-semibold">Membre depuis</h3>
                </div>
                <p class="text-purple-400 font-semibold">{{ Auth::user()->created_at->format('d/m/Y') }}</p>
                <p class="text-slate-400 text-sm mt-1">Il y a {{ Auth::user()->created_at->diffForHumans() }}</p>
            </div>
        </div>
    </div>
</div>

<style>
    /* Animations personnalisées */
    .bg-gradient-to-br {
        background-size: 400% 400%;
        animation: gradientShift 15s ease infinite;
    }
    
    @keyframes gradientShift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }
    
    /* Effet de glow sur les inputs focus */
    input:focus {
        box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
    }
    
    /* Animation des cartes */
    .bg-white\/5 {
        transition: all 0.3s ease;
    }
    
    .bg-white\/5:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }
    
    /* Effet de ripple sur les boutons */
    button {
        position: relative;
        overflow: hidden;
    }
    
    button::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }
    
    button:active::after {
        width: 300px;
        height: 300px;
    }
</style>
@endsection