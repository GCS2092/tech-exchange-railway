@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <h1 class="text-2xl font-bold text-indigo-700 mb-6">Gestion rapide</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Ajouter un produit</h2>
            <a href="{{ route('vendeur.products.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded font-semibold">Nouveau produit</a>
        </div>
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Ajouter une catégorie</h2>
            <a href="{{ route('vendeur.categories.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded font-semibold">Nouvelle catégorie</a>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow p-6 mt-8">
        <h2 class="text-lg font-semibold mb-4">Associer/Dissocier un produit à une catégorie</h2>
        <form method="POST" action="#">
            @csrf
            <div class="flex flex-wrap gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Produit</label>
                    <select name="product_id" class="border rounded p-2">
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Catégorie</label>
                    <select name="category_id" class="border rounded p-2">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded font-semibold mr-2">Associer</button>
            <button type="submit" formaction="#" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded font-semibold">Dissocier</button>
        </form>
    </div>
</div>
@endsection 