@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-purple-50 to-pink-50 py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <!-- En-tête avec animation -->
        <div class="text-center mb-12 transform transition duration-700 hover:scale-105">
            <h1 class="text-4xl md:text-5xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-purple-600 to-pink-600 mb-4">
                Mes Produits Favoris
            </h1>
            <div class="h-1 w-24 bg-gradient-to-r from-purple-500 to-pink-500 mx-auto rounded-full"></div>
        </div>

        @if(count($favorites) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($favorites as $fav)
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform transition duration-300 hover:-translate-y-1 hover:shadow-2xl">
                        <div class="relative">
                            @if($fav->product->image)
                                <img src="{{ asset($fav->product->image) }}" alt="{{ $fav->product->name }}" 
                                    class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute top-2 right-2">
                                <form method="POST" action="{{ route('favorites.remove', $fav->product) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-white rounded-full shadow-lg hover:bg-red-100 transition-colors duration-200">
                                        <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $fav->product->name }}</h3>
                            
                            @if($fav->product->price)
                                <p class="text-2xl font-bold text-purple-600 mb-4">
                                    {{ number_format($fav->product->price, 2, ',', ' ') }} €
                                </p>
                            @endif
                            
                            <a href="{{ route('products.show', $fav->product) }}" 
                                class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Voir le produit
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="max-w-md mx-auto">
                    <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <h2 class="mt-6 text-2xl font-semibold text-gray-900">Aucun produit favori</h2>
                    <p class="mt-2 text-gray-600">Vous n'avez pas encore ajouté de produits à vos favoris.</p>
                    <div class="mt-6">
                        <a href="{{ route('products.index') }}" 
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-purple-600 hover:bg-purple-700 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Parcourir les produits
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

<style>
    .favorites-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        font-family: 'Arial', sans-serif;
    }
    
    .favorites-title {
        color: #333;
        margin-bottom: 30px;
        font-size: 32px;
        border-bottom: 2px solid #eaeaea;
        padding-bottom: 15px;
    }
    
    .favorites-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 25px;
    }
    
    .favorite-item {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        background-color: white;
        display: flex;
        flex-direction: column;
    }
    
    .favorite-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .favorite-content {
        padding: 15px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    .product-name {
        margin-top: 0;
        font-size: 18px;
        color: #333;
    }
    
    .product-price {
        font-weight: bold;
        color: #e63946;
        margin: 10px 0;
    }
    
    .product-image {
        width: 100%;
        height: 180px;
        object-fit: cover;
        margin-top: auto;
    }
    
    .remove-form {
        margin-top: auto;
    }
    
    .remove-button {
        width: 100%;
        padding: 12px;
        background-color: #f8f9fa;
        color: #555;
        border: none;
        border-top: 1px solid #e0e0e0;
        cursor: pointer;
        transition: background-color 0.2s;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .remove-button:hover {
        background-color: #f1f1f1;
        color: #e63946;
    }
    
    .remove-button i {
        margin-right: 8px;
    }
    
    .empty-favorites {
        text-align: center;
        padding: 40px 0;
    }
    
    .empty-favorites p {
        color: #666;
        margin-bottom: 20px;
        font-size: 16px;
    }
    
    .browse-button {
        display: inline-block;
        padding: 12px 24px;
        background-color: #4a6fa5;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        transition: background-color 0.3s;
    }
    
    .browse-button:hover {
        background-color: #3a5a80;
    }
    
    @media (max-width: 768px) {
        .favorites-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }
    }
</style>