@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white flex items-center justify-center py-12">
    <div class="max-w-md w-full space-y-8">
        
        <!-- Header - Style Nike -->
        <div class="text-center">
            <div class="w-20 h-20 bg-black rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-user-plus text-white text-xl"></i>
            </div>
            <h2 class="nike-heading mb-4">CRÉER UN COMPTE</h2>
            <p class="nike-text text-gray-600">Rejoignez notre communauté</p>
            </div>
            
        <!-- Formulaire d'inscription -->
        <div class="card-nike">
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Prénom -->
                <div>
                    <label for="first_name" class="label-nike mb-2">Prénom</label>
                    <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" required autofocus
                           class="input-nike @error('first_name') border-red-500 @enderror"
                           placeholder="Votre prénom">
                    @error('first_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Nom -->
                <div>
                    <label for="last_name" class="label-nike mb-2">Nom</label>
                    <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" required
                           class="input-nike @error('last_name') border-red-500 @enderror"
                           placeholder="Votre nom">
                    @error('last_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Email -->
                <div>
                    <label for="email" class="label-nike mb-2">Adresse email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                           class="input-nike @error('email') border-red-500 @enderror"
                           placeholder="votre@email.com">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Téléphone -->
                <div>
                    <label for="phone" class="label-nike mb-2">Téléphone</label>
                    <input id="phone" type="tel" name="phone" value="{{ old('phone') }}"
                           class="input-nike @error('phone') border-red-500 @enderror"
                           placeholder="Votre numéro de téléphone">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Mot de passe -->
                <div>
                    <label for="password" class="label-nike mb-2">Mot de passe</label>
                    <input id="password" type="password" name="password" required
                           class="input-nike @error('password') border-red-500 @enderror"
                           placeholder="Votre mot de passe">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Confirmation du mot de passe -->
                <div>
                    <label for="password_confirmation" class="label-nike mb-2">Confirmer le mot de passe</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                           class="input-nike"
                           placeholder="Confirmez votre mot de passe">
                </div>
                
                <!-- Conditions d'utilisation -->
                <div class="flex items-start">
                    <input id="terms" name="terms" type="checkbox" required
                           class="w-4 h-4 text-black border-gray-300 rounded focus:ring-black mt-1">
                    <label for="terms" class="ml-2 text-sm text-gray-700">
                        J'accepte les 
                        <a href="#" class="text-black hover:text-gray-700 transition-colors">conditions d'utilisation</a>
                        et la 
                        <a href="#" class="text-black hover:text-gray-700 transition-colors">politique de confidentialité</a>
                    </label>
                </div>
                
                <!-- Newsletter -->
                <div class="flex items-center">
                    <input id="newsletter" name="newsletter" type="checkbox"
                           class="w-4 h-4 text-black border-gray-300 rounded focus:ring-black">
                    <label for="newsletter" class="ml-2 text-sm text-gray-700">
                        Recevoir la newsletter et les offres spéciales
                    </label>
                </div>
                
                <!-- Bouton d'inscription -->
                <div>
                    <button type="submit" class="btn-nike w-full">
                        <i class="fas fa-user-plus mr-2"></i>
                        CRÉER MON COMPTE
                    </button>
                </div>

                <!-- Séparateur -->
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Ou</span>
                    </div>
                </div>

                <!-- Inscription avec Google -->
                <div>
                    <a href="{{ route('google.login') }}" class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fab fa-google mr-3 text-red-500"></i>
                        Continuer avec Google
                    </a>
                </div>
                
                <!-- Lien de connexion -->
                    <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Déjà un compte ? 
                        <a href="{{ route('login') }}" class="font-medium text-black hover:text-gray-700 transition-colors">
                            Se connecter
                        </a>
                    </p>
                </div>
            </form>
        </div>
        
        <!-- Avantages de l'inscription -->
        <div class="text-center">
            <h3 class="text-lg font-semibold text-black mb-4">Pourquoi s'inscrire ?</h3>
            <div class="grid grid-cols-1 gap-3 text-sm text-gray-600">
                <div class="flex items-center justify-center">
                    <i class="fas fa-check text-green-500 mr-2"></i>
                    Accès à des offres exclusives
                </div>
                <div class="flex items-center justify-center">
                    <i class="fas fa-check text-green-500 mr-2"></i>
                    Suivi de vos commandes
                </div>
                <div class="flex items-center justify-center">
                    <i class="fas fa-check text-green-500 mr-2"></i>
                    Programme de fidélité
                </div>
                <div class="flex items-center justify-center">
                    <i class="fas fa-check text-green-500 mr-2"></i>
                    Support client prioritaire
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
