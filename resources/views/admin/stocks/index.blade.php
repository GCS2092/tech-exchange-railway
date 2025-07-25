@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">📦 Gestion des Stocks</h1>
    <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 text-white px-3 py-2 rounded-lg hover:bg-gray-600 transition duration-300 flex items-center shadow-md text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
        </svg>
        Retour
    </a>
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-indigo-100 text-indigo-700">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Image</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Produit</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Quantité</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Statut</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach ($products as $product)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4">
                            @if($product->image)
                                <img src="{{ $product->image }}" alt="Image du produit" class="h-12 w-12 object-cover rounded">
                            @else
                                <span class="text-sm text-gray-400 italic">Aucune image</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-semibold">{{ $product->name }}</td>
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.products.updateStock', $product->id) }}" method="POST" class="flex items-center space-x-2">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $product->quantity }}" min="0" class="w-20 px-2 py-1 border rounded text-sm">
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-3 py-1 rounded">
                                    Mettre à jour
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4">
                            @if($product->quantity > 10)
                                <span class="text-green-600 font-medium">En stock</span>
                            @elseif($product->quantity > 0)
                                <span class="text-yellow-600 font-medium">Stock faible</span>
                            @else
                                <span class="text-red-600 font-medium">Rupture</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('products.edit', $product->id) }}" class="text-blue-600 hover:underline text-sm">Modifier</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
