<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-bold text-gray-800">{{ __('Créer un compte') }}</h2>
                <p class="text-sm text-gray-600 mt-1">{{ __('Renseignez votre nom et votre email pour commencer') }}</p>
            </div>
            <div class="mb-4">
                <label for="profile_photo" class="block text-sm font-medium text-gray-700">Photo de profil (optionnel)</label>
                <input type="file" name="profile_photo" accept="image/*" class="mt-1 block w-full">
            </div>
            
            <form method="POST" action="{{ route('register.code') }}">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <x-input-label for="name" :value="__('Nom')" class="text-gray-700 font-medium" />
                    <x-text-input id="name" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Votre nom complet" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mb-6">
                    <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-medium" />
                    <x-text-input id="email" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="votre-email@exemple.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex flex-col space-y-4">
                    <x-primary-button class="w-full justify-center py-3 bg-indigo-600 hover:bg-indigo-700 transition">
                        {{ __("Continuer") }}
                    </x-primary-button>

                    <div class="text-center">
                        <span class="text-sm text-gray-600">{{ __('Déjà inscrit?') }}</span>
                        <a class="text-sm text-indigo-600 hover:text-indigo-900 font-medium" href="{{ route('login') }}">
                            {{ __('Se connecter') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
