@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-8 max-w-md">
    <h1 class="text-2xl font-bold text-indigo-700 mb-6">Modifier le produit</h1>
    <form method="POST" action="{{ route('vendeur.products.update', $product) }}" class="bg-white rounded-xl shadow p-6">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Nom</label>
            <input type="text" name="name" class="w-full border rounded p-2" value="{{ old('name', $product->name) }}" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Prix</label>
            <input type="number" name="price" class="w-full border rounded p-2" value="{{ old('price', $product->price) }}" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Stock</label>
            <input type="number" name="quantity" class="w-full border rounded p-2" value="{{ old('quantity', $product->quantity) }}" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Catégorie</label>
            <select name="category_id" class="w-full border rounded p-2" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @if($product->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-semibold">Enregistrer</button>
        <a href="{{ route('vendeur.products.index') }}" class="ml-4 text-gray-600 hover:underline">Annuler</a>
    </form>
</div>
@endsection 