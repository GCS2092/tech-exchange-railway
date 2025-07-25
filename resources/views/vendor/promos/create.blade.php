@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-8 max-w-md">
    <h1 class="text-2xl font-bold text-indigo-700 mb-6">Nouveau code promo</h1>
    <form method="POST" action="{{ route('vendeur.promos.store') }}" class="bg-white rounded-xl shadow p-6">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Code</label>
            <input type="text" name="code" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Réduction (%)</label>
            <input type="number" name="discount" class="w-full border rounded p-2" min="1" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Date d'expiration</label>
            <input type="date" name="expires_at" class="w-full border rounded">
        </div>
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded font-semibold">Créer</button>
        <a href="{{ route('vendeur.promos.index') }}" class="ml-4 text-gray-600 hover:underline">Annuler</a>
    </form>
</div>
@endsection 