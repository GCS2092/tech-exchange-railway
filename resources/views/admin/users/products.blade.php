@extends('layouts.admin')
@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Produits du vendeur : {{ $user->name }}</h1>
    <div class="bg-white rounded-lg shadow p-4">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Prix</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($products as $product)
                <tr>
                    <td class="px-4 py-2">{{ $product->name }}</td>
                    <td class="px-4 py-2">{{ number_format($product->price, 0, ',', ' ') }} FCFA</td>
                    <td class="px-4 py-2">{{ $product->quantity }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 rounded-full text-xs {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->is_active ? 'Actif' : 'Inactif' }}
                        </span>
                    </td>
                    <td class="px-4 py-2">
                        <a href="{{ route('products.edit', $product->id) }}" class="text-blue-600 hover:underline">Éditer</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-4 text-center text-gray-500">Aucun produit trouvé pour ce vendeur.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $products->links() }}</div>
    </div>
    <div class="mt-6">
        <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:underline">&larr; Retour à la liste des utilisateurs</a>
    </div>
</div>
@endsection 