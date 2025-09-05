@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white flex items-center justify-center py-8 sm:py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-6 sm:space-y-8">
        
        <!-- Header - Style Nike -->
        <div class="text-center">
            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-black rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6">
                <i class="fas fa-user text-white text-lg sm:text-xl"></i>
            </div>
            <h2 class="text-2xl sm:text-3xl font-black mb-3 sm:mb-4 text-black">CONNEXION</h2>
            <p class="text-sm sm:text-base text-gray-600">Accédez à votre espace personnel</p>
                        </div>

        <!-- Formulaire de connexion -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 sm:p-8">
                    <form method="POST" action="{{ route('login') }}" class="space-y-4 sm:space-y-6">
                        @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Adresse email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full px-3 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black text-base @error('email') border-red-500 @enderror"
                           placeholder="votre@email.com">
                            @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                <!-- Mot de passe -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                    <input id="password" type="password" name="password" required
                           class="w-full px-3 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black text-base @error('password') border-red-500 @enderror"
                           placeholder="Votre mot de passe">
                            @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                <!-- Options -->
                        <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" 
                               class="w-4 h-4 text-black border-gray-300 rounded focus:ring-black">
                        <label for="remember_me" class="ml-2 text-sm text-gray-700">
                            Se souvenir de moi
                            </label>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-gray-600 hover:text-black transition-colors">
                                    Mot de passe oublié ?
                                </a>
                            @endif
                        </div>

                <!-- Bouton de connexion -->
                <div>
                    <button type="submit" class="w-full bg-black text-white py-3 sm:py-4 px-4 font-semibold rounded-lg hover:bg-gray-800 transition-all duration-300 text-base">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        SE CONNECTER
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

                <!-- Connexion avec Google -->
                <div>
                    <a href="{{ route('google.login') }}" class="w-full flex items-center justify-center px-4 py-3 sm:py-4 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors text-base">
                        <i class="fab fa-google mr-3 text-red-500"></i>
                        Continuer avec Google
                    </a>
                </div>
                
                <!-- Lien d'inscription -->
                <div class="text-center">
                    <p class="text-sm text-gray-600">
                            Pas encore de compte ?
                        <a href="{{ route('register') }}" class="font-medium text-black hover:text-gray-700 transition-colors">
                            Créer un compte
                            </a>
                        </p>
                </div>
            </form>
            </div>
        
        <!-- Informations supplémentaires -->
        <div class="text-center">
            <p class="text-xs text-gray-500">
                En vous connectant, vous acceptez nos 
                <a href="#" class="text-black hover:text-gray-700 transition-colors">conditions d'utilisation</a>
                et notre 
                <a href="#" class="text-black hover:text-gray-700 transition-colors">politique de confidentialité</a>
            </p>
        </div>
    </div>
</div>
@endsection