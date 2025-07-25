@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-8 max-w-5xl">
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded shadow">{{ session('success') }}</div>
    @endif
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-indigo-700">Mes produits</h1>
        <a href="{{ route('vendeur.products.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-semibold">Ajouter un produit</a>
    </div>
    <div class="bg-white rounded-xl shadow p-6">
        @if($products->count() > 0)
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Image</th>
                        <th class="px-4 py-2 text-left">Nom</th>
                        <th class="px-4 py-2 text-left">Description</th>
                        <th class="px-4 py-2 text-left">Catégorie</th>
                        <th class="px-4 py-2 text-left">Prix</th>
                        <th class="px-4 py-2 text-left">Stock</th>
                        <th class="px-4 py-2 text-left">Statut</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($products as $product)
                    <tr>
                        <td class="px-4 py-2">
                            @if($product->image)
                                <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded">
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 font-semibold">{{ $product->name }}</td>
                        <td class="px-4 py-2">{{ Str::limit($product->description, 40) }}</td>
                        <td class="px-4 py-2">{{ optional($product->category)->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ number_format($product->price, 0, ',', ' ') }} FCFA</td>
                        <td class="px-4 py-2">{{ $product->quantity }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded-full text-xs {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td class="px-4 py-2 flex gap-2">
                            <a href="{{ route('vendeur.products.edit', $product->id) }}" class="text-blue-600 hover:underline">Éditer</a>
                            <form action="{{ route('vendeur.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Supprimer ce produit ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                            </form>
                            <form action="{{ route('vendeur.products.toggle', $product->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-xs px-2 py-1 rounded {{ $product->is_active ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $product->is_active ? 'Désactiver' : 'Activer' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">{{ $products->links() }}</div>
        @else
            <p class="text-gray-500">Aucun produit pour l'instant.</p>
        @endif
    </div>
</div>
@endsection 