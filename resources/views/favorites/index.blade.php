@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white">
    <div class="container-nike py-12">
        
        <!-- Header - Style Nike -->
        <div class="text-center mb-16">
            <h1 class="nike-title mb-4">MES FAVORIS</h1>
            <p class="nike-text text-gray-600">Retrouvez tous vos produits préférés en un seul endroit</p>
        </div>

        @if($favorites->count() > 0)
            <!-- Grille des produits favoris -->
            <div class="grid-nike grid-nike-3 gap-nike-lg mb-16">
                @foreach($favorites as $favorite)
                    <div class="product-card-nike group">
                        <!-- Image du produit -->
                        <div class="relative overflow-hidden">
                            @if($favorite->product->images && count($favorite->product->images) > 0)
                                <img src="{{ asset('storage/' . $favorite->product->images->first()->path) }}" 
                                     alt="{{ $favorite->product->name }}" 
                                     class="product-image-nike group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="product-image-nike bg-gray-100 flex items-center justify-center">
                                    <i class="fas fa-image text-2xl text-gray-400"></i>
                                </div>
                            @endif
                            
                            <!-- Badge de promotion -->
                            @if($favorite->product->promo_price)
                                <div class="absolute top-4 left-4 bg-black text-white px-3 py-1 text-sm font-semibold">
                                    PROMO
                                </div>
                            @endif
                            
                            <!-- Bouton supprimer des favoris -->
                            <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <form action="{{ route('favorites.remove', $favorite->product) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-red-500 hover:bg-red-50 transition-colors shadow-lg">
                                        <i class="fas fa-heart-broken"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Informations du produit -->
                        <div class="product-info-nike">
                            <h3 class="product-title-nike group-hover:text-gray-600 transition-colors">
                                <a href="{{ route('products.show', $favorite->product) }}">{{ $favorite->product->name }}</a>
                            </h3>
                            
                            <p class="text-gray-600 text-sm mb-4">{{ $favorite->product->category->name ?? 'Sans catégorie' }}</p>
                            
                            <!-- Prix -->
                            <div class="flex items-center justify-between mb-4">
                                @if($favorite->product->promo_price)
                                    <div class="flex items-center space-x-2">
                                        <span class="product-price-old-nike">{{ number_format($favorite->product->price) }} FCFA</span>
                                        <span class="product-price-nike">{{ number_format($favorite->product->promo_price) }} FCFA</span>
                                    </div>
                                @else
                                    <span class="product-price-nike">{{ number_format($favorite->product->price) }} FCFA</span>
                            @endif
                            </div>
                            
                            <!-- Boutons d'action -->
                            <div class="grid grid-cols-1 gap-2">
                                <a href="{{ route('products.show', $favorite->product) }}" class="btn-nike text-center">
                                    Voir détails
                                </a>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $favorite->product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn-nike-outline w-full">
                                        <i class="fas fa-shopping-cart mr-2"></i>
                                        Ajouter au panier
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Actions en masse -->
            <div class="card-nike">
                <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0">
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">
                            {{ $favorites->count() }} produit(s) dans vos favoris
                        </span>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('products.index') }}" class="btn-nike-outline">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Continuer les achats
                        </a>
                        
                        <form action="{{ route('favorites.clear') }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 transition-colors font-medium" 
                                    onclick="return confirm('Êtes-vous sûr de vouloir vider tous vos favoris ?')">
                                <i class="fas fa-trash mr-2"></i>
                                Vider les favoris
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
        @else
            <!-- Aucun favori - Style Nike -->
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-heart text-gray-400 text-2xl"></i>
    </div>
                <h3 class="nike-heading mb-4">Aucun produit favori</h3>
                <p class="nike-text text-gray-600 mb-8">
                    Vous n'avez pas encore ajouté de produits à vos favoris. 
                    Découvrez notre sélection et ajoutez vos produits préférés !
                </p>
                <a href="{{ route('products.index') }}" class="btn-nike">
                    EXPLORER LES PRODUITS
                </a>
</div>
        @endif
        
        <!-- Produits recommandés -->
        @if(isset($recommendedProducts) && $recommendedProducts->count() > 0)
            <div class="mt-20 border-t border-gray-200 pt-16">
                <h2 class="nike-heading text-center mb-12">PRODUITS RECOMMANDÉS</h2>
                <div class="grid-nike grid-nike-3 gap-nike-lg">
                    @foreach($recommendedProducts as $product)
                        <div class="product-card-nike group">
                            <!-- Image du produit -->
                            <div class="relative overflow-hidden">
                                @if($product->images && count($product->images) > 0)
                                    <img src="{{ asset('storage/' . $product->images->first()->path) }}" 
                                         alt="{{ $product->name }}" 
                                         class="product-image-nike group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="product-image-nike bg-gray-100 flex items-center justify-center">
                                        <i class="fas fa-image text-2xl text-gray-400"></i>
                                    </div>
                                @endif
                                
                                <!-- Badge de promotion -->
                                @if($product->promo_price)
                                    <div class="absolute top-4 left-4 bg-black text-white px-3 py-1 text-sm font-semibold">
                                        PROMO
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Informations du produit -->
                            <div class="product-info-nike">
                                <h3 class="product-title-nike group-hover:text-gray-600 transition-colors">
                                    <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                                </h3>
                                
                                <!-- Prix -->
                                <div class="flex items-center justify-between mb-4">
                                    @if($product->promo_price)
                                        <div class="flex items-center space-x-2">
                                            <span class="product-price-old-nike">{{ number_format($product->price) }} FCFA</span>
                                            <span class="product-price-nike">{{ number_format($product->promo_price) }} FCFA</span>
                                        </div>
                                    @else
                                        <span class="product-price-nike">{{ number_format($product->price) }} FCFA</span>
                                    @endif
                                </div>
                                
                                <!-- Boutons d'action -->
                                <div class="grid grid-cols-1 gap-2">
                                    <a href="{{ route('products.show', $product) }}" class="btn-nike text-center">
                                        Voir détails
                                    </a>
                                    <div class="grid grid-cols-2 gap-2">
                                        <form action="{{ route('cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn-nike-outline w-full text-sm">
                                                <i class="fas fa-shopping-cart mr-1"></i>
                                                Panier
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('favorites.add', $product) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-nike-outline w-full text-sm">
                                                <i class="fas fa-heart mr-1"></i>
                                                Favoris
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        
        <!-- Informations sur les favoris -->
        <div class="mt-20 border-t border-gray-200 pt-16">
            <div class="grid-nike grid-nike-3 gap-nike-lg">
                <div class="text-center">
                    <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-heart text-white text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-black mb-2">Sauvegardez vos préférés</h3>
                    <p class="text-gray-600">Gardez une trace de tous les produits qui vous intéressent</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bell text-white text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-black mb-2">Notifications de prix</h3>
                    <p class="text-gray-600">Soyez informé des baisses de prix sur vos produits favoris</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-sync text-white text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-black mb-2">Accès rapide</h3>
                    <p class="text-gray-600">Retrouvez facilement vos produits préférés à tout moment</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection