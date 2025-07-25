@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-8">
        <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 text-white px-3 py-2 rounded-lg hover:bg-gray-600 transition duration-300 flex items-center shadow-md text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Retour
        </a>
        <h1 class="text-3xl font-bold text-blue">Inventaire des produits</h1>
        <a href="{{ route('products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-300 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Ajouter un produit
        </a>
    </div>

    <div class="bg-gray-900 bg-opacity-80 rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Nom du produit</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Catégorie</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Quantité</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Prix</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700 bg-gray-900 bg-opacity-60">
                    @forelse ($products as $product)
                        <tr class="hover:bg-gray-800 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                <div class="flex items-center">
                                    @if($product->image)
                                        @if(Str::startsWith($product->image, ['http://', 'https://']))
                                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="h-10 w-10 rounded-md object-cover mr-3">
                                        @else
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-10 w-10 rounded-md object-cover mr-3">
                                        @endif
                                    @else
                                        <div class="h-10 w-10 rounded-md bg-gray-700 flex items-center justify-center mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                    {{ $product->name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                @if ($product->category)
                                    <span class="px-2 py-1 text-xs rounded-full bg-indigo-900 text-indigo-200">
                                        {{ $product->category->name ?? 'Catégorie inconnue' }}

                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-700 text-gray-300">
                                        Non catégorisé
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                @if($product->quantity == 0)
                                    <span class="text-red-500 font-medium">{{ $product->quantity }}</span>
                                @elseif($product->quantity < 5)
                                    <span class="text-yellow-500 font-medium">{{ $product->quantity }}</span>
                                @else
                                    <span class="text-green-500 font-medium">{{ $product->quantity }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                <span class="font-medium">{{ number_format($product->price, 2) }}</span>
                                <span class="text-gray-400">{{ $product->currency }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-3">
                                    <a href="{{ route('products.edit', $product->id) }}" class="text-blue-500 hover:text-blue-400 transition duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-400 transition duration-150" 
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p>Aucun produit n'a été trouvé.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection