@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-center text-gray-800 mb-8">Mon Profil</h1>

    <div class="max-w-lg mx-auto bg-white shadow-lg rounded-lg p-6">
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <!-- Affichage des messages de succès/erreur -->
            @if (session('success'))
                <div class="mb-4 text-green-500">{{ session('success') }}</div>
            @endif

            <!-- Nom -->
            <div class="mb-4">
                <label for="name" class="block text-lg font-semibold text-gray-700">Nom complet</label>
                <input type="text" name="name" id="name" class="w-full mt-2 p-3 border border-gray-300 rounded-lg" value="{{ old('name', $user->name) }}" required>
                @error('name') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-lg font-semibold text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="w-full mt-2 p-3 border border-gray-300 rounded-lg" value="{{ old('email', $user->email) }}" required>
                @error('email') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>

            <!-- Numéro de téléphone -->
            <div class="mb-4">
                <label for="phone" class="block text-lg font-semibold text-gray-700">Numéro de téléphone</label>
                <input type="text" name="phone" id="phone" class="w-full mt-2 p-3 border border-gray-300 rounded-lg" value="{{ old('phone', $user->phone) }}">
                <p class="text-gray-500 text-sm mt-1">Format international recommandé (ex: +33612345678)</p>
                @error('phone') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>

            <!-- Mot de passe -->
            <div class="mb-4">
                <label for="password" class="block text-lg font-semibold text-gray-700">Nouveau mot de passe</label>
                <input type="password" name="password" id="password" class="w-full mt-2 p-3 border border-gray-300 rounded-lg">
                <p class="text-gray-500 text-sm mt-1">Laissez vide pour conserver votre mot de passe actuel</p>
                @error('password') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>

            <!-- Confirmation du mot de passe -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-lg font-semibold text-gray-700">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full mt-2 p-3 border border-gray-300 rounded-lg">
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-3 rounded-lg hover:bg-blue-600 transition duration-300">Mettre à jour</button>
        </form>
    </div>
</div>
@endsection