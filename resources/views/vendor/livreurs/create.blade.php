@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-8 max-w-md">
    <h1 class="text-2xl font-bold text-indigo-700 mb-6">Ajouter un livreur</h1>
    <form method="POST" action="{{ route('vendeur.livreurs.store') }}" class="bg-white rounded-xl shadow p-6">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Nom</label>
            <input type="text" name="name" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Email</label>
            <input type="email" name="email" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Mot de passe</label>
            <input type="password" name="password" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" class="w-full border rounded p-2" required>
        </div>
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded font-semibold">Ajouter</button>
        <a href="{{ route('vendeur.livreurs.index') }}" class="ml-4 text-gray-600 hover:underline">Annuler</a>
    </form>
</div>
@endsection 