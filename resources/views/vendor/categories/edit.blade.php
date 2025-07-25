@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-8 max-w-md">
    <h1 class="text-2xl font-bold text-indigo-700 mb-6">Modifier la catégorie</h1>
    <form method="POST" action="{{ route('vendeur.categories.update', $category) }}" class="bg-white rounded-xl shadow p-6" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Nom</label>
            <input type="text" name="name" class="w-full border rounded p-2" value="{{ old('name', $category->name) }}" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Description</label>
            <textarea name="description" class="w-full border rounded p-2" rows="3">{{ old('description', $category->description) }}</textarea>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Image actuelle</label>
            @if($category->image_path)
                <img src="/{{ $category->image_path }}" alt="Image catégorie" class="w-32 h-32 object-cover rounded mb-2">
            @else
                <span class="text-gray-500">Aucune image</span>
            @endif
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Nouvelle image (remplace l'ancienne)</label>
            <input type="file" name="image_path" accept="image/*" class="w-full border rounded">
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-semibold">Enregistrer</button>
        <a href="{{ route('vendeur.categories.index') }}" class="ml-4 text-gray-600 hover:underline">Annuler</a>
    </form>
    <form action="{{ route('vendeur.categories.destroy', $category) }}" method="POST" class="mt-4" onsubmit="return confirm('Supprimer cette catégorie ?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded font-semibold">Supprimer</button>
    </form>
</div>
@endsection 