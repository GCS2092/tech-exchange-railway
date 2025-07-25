@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-8 max-w-md">
    <h1 class="text-2xl font-bold text-indigo-700 mb-6">Ajouter un produit</h1>
    <form method="POST" action="{{ route('vendeur.products.store') }}" class="bg-white rounded-xl shadow p-6" enctype="multipart/form-data">
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
            <label class="block text-gray-700 font-semibold mb-2">Prix</label>
            <input type="number" step="0.01" name="price" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Devise</label>
            <select name="currency" class="w-full border rounded p-2" required>
                <option value="XOF">Franc CFA (XOF)</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Stock</label>
            <input type="number" name="quantity" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Catégorie</label>
            <select name="category_id" class="w-full border rounded p-2" required>
                <option value="">Sélectionner</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Type d'image</label>
            <div class="flex items-center space-x-4">
                <label><input type="radio" name="image_type" value="upload" checked onchange="toggleImageField()"> Télécharger</label>
                <label><input type="radio" name="image_type" value="url" onchange="toggleImageField()"> Lien URL</label>
            </div>
        </div>
        <div class="mb-4" id="uploadField">
            <label class="block text-gray-700 font-semibold mb-2">Image (fichier)</label>
            <input type="file" name="image" accept="image/*" class="w-full border rounded">
        </div>
        <div class="mb-4 hidden" id="urlField">
            <label class="block text-gray-700 font-semibold mb-2">Image (URL)</label>
            <input type="url" name="image_url" class="w-full border rounded">
        </div>
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded font-semibold">Ajouter</button>
        <a href="{{ route('vendeur.products.index') }}" class="ml-4 text-gray-600 hover:underline">Annuler</a>
    </form>
    <script>
        function toggleImageField() {
            const uploadField = document.getElementById('uploadField');
            const urlField = document.getElementById('urlField');
            const type = document.querySelector('input[name="image_type"]:checked').value;
            if (type === 'upload') {
                uploadField.classList.remove('hidden');
                urlField.classList.add('hidden');
            } else {
                uploadField.classList.add('hidden');
                urlField.classList.remove('hidden');
            }
        }
    </script>
</div>
@endsection 