@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100 py-12">
    <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête avec animation -->
        <div class="text-center mb-12">
            <h1 class="text-2xl md:text-xl font-extrabold text-gray-900 mb-4">
                <span class="inline-block bg-clip-text text-transparent bg-gradient-to-r from-purple-600 to-indigo-600 animate-pulse">
                    Produits en vedette
                </span>
            </h1>
            <p class="max-w-2xl mx-auto text-lg text-gray-600">Découvrez notre collection exclusive de produits cosmétiques sélectionnés pour leur qualité exceptionnelle.</p>
        </div>

        @if($products->count())
            <!-- Grille de produits avec effets d'animation -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach ($products as $product)
                    <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
                        @if($product->image)
                            <div class="relative h-64 overflow-hidden">
                                <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" 
                                    class="w-full h-full object-cover object-center group-hover:scale-110 transition-all duration-500">
                                @if($product->discount > 0)
                                    <div class="absolute top-4 right-4 bg-red-500 text-white text-sm font-bold px-3 py-1 rounded-full shadow-md">
                                        -{{ $product->discount }}%
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="h-64 bg-gradient-to-br from-purple-100 to-indigo-100 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-2">
                                <h2 class="text-xl font-bold text-gray-800 group-hover:text-indigo-600 transition-colors">{{ $product->name }}</h2>
                                <div class="flex items-center">
                                    <span class="text-yellow-400">★★★★</span>
                                    <span class="text-yellow-200">★</span>
                                </div>
                            </div>
                            
                            <p class="text-gray-600 mb-4 line-clamp-2">{{ $product->description }}</p>
                            
                            <div class="flex justify-between items-center">
                                <div>
                                    @if($product->old_price > $product->price)
                                        <span class="text-sm text-gray-500 line-through">{{ number_format($product->old_price, 0) }} FCFA</span><br>
                                    @endif
                                    <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">
                                        {{ number_format($product->price, 0) }} FCFA
                                    </span>
                                </div>
                                
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex items-center justify-center p-3 rounded-full bg-indigo-600 text-white hover:bg-indigo-700 transition-colors shadow-md hover:shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                            <div class="flex items-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    En stock
                                </span>
                            </div>
                            <a href="{{ route('products.show', $product->id) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                Voir le détail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- État vide stylisé -->
            <div class="bg-white rounded-2xl shadow-xl p-8 text-center max-w-2xl mx-auto">
                <div class="flex justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-700 mb-2">Aucun produit en vedette</h2>
                <p class="text-gray-600 mb-6">Nos produits en vedette seront bientôt disponibles. Revenez nous voir plus tard !</p>
                <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700">
                    Voir tous les produits
                </a>
            </div>
        @endif
        
        <!-- Bannière de promotion -->
        <div class="mt-16 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-xl overflow-hidden">
            <div class="md:flex">
                <div class="px-6 py-12 md:p-12 md:w-1/2">
                    <h2 class="text-xl font-extrabold text-white mb-4">Recevez 20% de réduction sur votre première commande !</h2>
                    <p class="text-indigo-100 mb-6">Inscrivez-vous à notre newsletter pour profiter de cette offre exceptionnelle et recevoir nos promotions exclusives.</p>
                    <form class="flex flex-col sm:flex-row gap-3">
                        <input type="email" placeholder="Votre email" class="flex-grow px-4 py-3 rounded-lg focus:ring-2 focus:ring-indigo-300 focus:outline-none">
                        <button type="submit" class="px-6 py-3 bg-white text-indigo-600 font-medium rounded-lg hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-white">S'inscrire</button>
                    </form>
                </div>
                <div class="hidden md:block md:w-1/2 bg-indigo-800 relative">
                    <div class="absolute inset-0 flex items-center justify-center opacity-20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-64 w-64 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection