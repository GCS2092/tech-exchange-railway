@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white">
    <div class="container-nike py-12">
        
        <!-- Header - Style Nike -->
        <div class="text-center mb-16">
            <h1 class="nike-title mb-4">TABLEAU DE BORD</h1>
            <p class="nike-text text-gray-600">Bienvenue {{ auth()->user()->name }}, voici un aperçu de votre activité</p>
        </div>

        <!-- Statistiques principales -->
        <div class="grid-nike grid-nike-4 gap-nike-lg mb-16">
            <div class="card-nike text-center">
                <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shopping-cart text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-black mb-2">{{ $stats['total_orders'] ?? 0 }}</h3>
                <p class="text-gray-600">Commandes totales</p>
            </div>
            
            <div class="card-nike text-center">
                <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-heart text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-black mb-2">{{ $stats['total_favorites'] ?? 0 }}</h3>
                <p class="text-gray-600">Favoris</p>
            </div>
            
            <div class="card-nike text-center">
                <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-star text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-black mb-2">{{ $stats['total_reviews'] ?? 0 }}</h3>
                <p class="text-gray-600">Avis laissés</p>
            </div>
            
            <div class="card-nike text-center">
                <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-coins text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-black mb-2">{{ number_format($stats['total_spent'] ?? 0) }} FCFA</h3>
                <p class="text-gray-600">Total dépensé</p>
            </div>
        </div>

        <!-- Commandes récentes -->
        <div class="card-nike mb-16">
            <div class="flex items-center justify-between mb-8">
                <h2 class="nike-heading">Commandes récentes</h2>
                <a href="{{ route('orders.index') }}" class="btn-nike-outline">
                    Voir toutes les commandes
                </a>
            </div>
            
            @if(isset($recentOrders) && $recentOrders->count() > 0)
                <div class="space-y-4">
                    @foreach($recentOrders as $order)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-black rounded-full flex items-center justify-center">
                                    <i class="fas fa-shopping-bag text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-black">Commande #{{ $order->order_number }}</h4>
                                    <p class="text-sm text-gray-600">{{ $order->created_at->format('d/m/Y à H:i') }}</p>
                                </div>
                            </div>
                            
                            <div class="text-right">
                                <div class="font-semibold text-black">{{ number_format($order->total) }} FCFA</div>
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'processing' => 'bg-blue-100 text-blue-800',
                                        'shipped' => 'bg-purple-100 text-purple-800',
                                        'delivered' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800'
                                    ];
                                    
                                    $statusLabels = [
                                        'pending' => 'En attente',
                                        'processing' => 'En cours',
                                        'shipped' => 'Expédiée',
                                        'delivered' => 'Livrée',
                                        'cancelled' => 'Annulée'
                                    ];
                                    
                                    $statusColor = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                                    $statusLabel = $statusLabels[$order->status] ?? 'Inconnu';
                                @endphp
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                                    {{ $statusLabel }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shopping-cart text-gray-400 text-xl"></i>
                    </div>
                    <p class="text-gray-600">Aucune commande récente</p>
                </div>
            @endif
        </div>

        <!-- Produits favoris -->
        <div class="card-nike mb-16">
            <div class="flex items-center justify-between mb-8">
                <h2 class="nike-heading">Produits favoris</h2>
                <a href="{{ route('favorites.index') }}" class="btn-nike-outline">
                    Voir tous les favoris
                </a>
            </div>
            
            @if(isset($favoriteProducts) && $favoriteProducts->count() > 0)
                <div class="grid-nike grid-nike-3 gap-nike">
                    @foreach($favoriteProducts as $product)
                        <div class="product-card-nike group">
                            <!-- Image du produit -->
                            <div class="relative overflow-hidden">
                                @if($product->images && count($product->images) > 0)
                                    <img src="{{ asset('storage/' . $product->images->first()->path) }}" 
                                         alt="{{ $product->name }}" 
                                         class="product-image-nike group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="product-image-nike bg-gray-100 flex items-center justify-center">
                                        <i class="fas fa-image text-4xl text-gray-400"></i>
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
                                
                                <!-- Bouton d'action -->
                                <div class="grid grid-cols-1 gap-2">
                                    <a href="{{ route('products.show', $product) }}" class="btn-nike text-center">
                                        Voir détails
                                    </a>
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
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
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-heart text-gray-400 text-xl"></i>
                    </div>
                    <p class="text-gray-600 mb-4">Aucun produit favori</p>
                    <a href="{{ route('products.index') }}" class="btn-nike">
                        Découvrir des produits
                    </a>
                </div>
            @endif
        </div>

        <!-- Actions rapides -->
        <div class="card-nike">
            <h2 class="nike-heading mb-8">Actions rapides</h2>
            <div class="grid-nike grid-nike-2 gap-nike">
                <a href="{{ route('products.index') }}" class="p-6 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors text-center group">
                    <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-search text-white text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-black mb-2">Explorer les produits</h3>
                    <p class="text-gray-600">Découvrez notre sélection d'appareils électroniques</p>
                </a>
                
                <a href="{{ route('trades.search') }}" class="p-6 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors text-center group">
                    <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-exchange-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-black mb-2">Système de troc</h3>
                    <p class="text-gray-600">Échangez vos anciens appareils contre de nouveaux</p>
                </a>
                
                <a href="{{ route('promos.index') }}" class="p-6 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors text-center group">
                    <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-tag text-white text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-black mb-2">Codes promo</h3>
                    <p class="text-gray-600">Profitez de nos offres et réductions exclusives</p>
                </a>
                
                <a href="{{ route('help.index') }}" class="p-6 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors text-center group">
                    <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-question-circle text-white text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-black mb-2">Centre d'aide</h3>
                    <p class="text-gray-600">Trouvez des réponses à vos questions</p>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
