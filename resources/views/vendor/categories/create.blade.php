@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-8 max-w-md">
    <h1 class="text-2xl font-bold text-indigo-700 mb-6">Ajouter une catégorie</h1>
    <form method="POST" action="{{ route('vendeur.categories.store') }}" class="bg-white rounded-xl shadow p-6" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Nom</label>
            <input type="text" name="name" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Description</label>
            <textarea name="description" class="w-full border rounded p-2" rows="3"></textarea>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Image (fichier)</label>
            <input type="file" name="image_path" accept="image/*" class="w-full border rounded">
        </div>
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded font-semibold">Ajouter</button>
        <a href="{{ route('vendeur.categories.index') }}" class="ml-4 text-gray-600 hover:underline">Annuler</a>
    </form>
</div>
@endsection 