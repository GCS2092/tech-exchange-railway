@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white">
    <div class="container-nike py-12">
        
        <!-- Header - Style Nike -->
        <div class="text-center mb-16">
            <h1 class="nike-title mb-4">PANIER</h1>
            <p class="nike-text text-gray-600">Vérifiez vos articles et finalisez votre commande</p>
        </div>

        @if($cartItems->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                
                <!-- Liste des articles - Style Nike -->
                <div class="lg:col-span-2">
                    <div class="space-y-6">
                        @foreach($cartItems as $item)
                            <div class="product-card-nike">
                                <div class="flex items-center space-x-6">
                                    <!-- Image du produit -->
                                    <div class="flex-shrink-0">
                                        @if($item->product->images && count($item->product->images) > 0)
                                            <img src="{{ asset('storage/' . $item->product->images->first()->path) }}" 
                                                 alt="{{ $item->product->name }}" 
                                                 class="w-24 h-24 object-cover rounded-lg">
                                        @else
                                            <div class="w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-image text-lg text-gray-400"></i>
            </div>
            @endif
                            </div>
                            
                            <!-- Informations du produit -->
                            <div class="flex-1 min-w-0">
                                        <h3 class="product-title-nike mb-2">
                                            <a href="{{ route('products.show', $item->product) }}" class="hover:text-gray-600 transition-colors">
                                                {{ $item->product->name }}
                                            </a>
                                        </h3>
                                        <p class="text-gray-600 text-sm mb-2">{{ $item->product->category->name ?? 'Sans catégorie' }}</p>
                                        
                                        <!-- Prix -->
                                        <div class="flex items-center space-x-4 mb-4">
                                            @if($item->product->promo_price)
                                                <span class="product-price-old-nike">{{ number_format($item->product->price) }} FCFA</span>
                                                <span class="product-price-nike">{{ number_format($item->product->promo_price) }} FCFA</span>
                                            @else
                                                <span class="product-price-nike">{{ number_format($item->product->price) }} FCFA</span>
                                            @endif
                            </div>
                            
                                        <!-- Quantité et actions -->
                                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                                    @method('PUT')
                                                    <button type="button" class="w-8 h-8 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors" onclick="decreaseQuantity({{ $item->id }})">
                                                        <i class="fas fa-minus text-gray-600 text-sm"></i>
                                                    </button>
                                                    <input type="number" name="quantity" id="quantity-{{ $item->id }}" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock ?? 99 }}" class="w-16 text-center border border-gray-300 rounded-lg py-1 text-sm">
                                                    <button type="button" class="w-8 h-8 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors" onclick="increaseQuantity({{ $item->id }})">
                                                        <i class="fas fa-plus text-gray-600 text-sm"></i>
                                    </button>
                                                    <button type="submit" class="ml-2 text-sm text-gray-600 hover:text-black transition-colors">
                                                        <i class="fas fa-save"></i>
                                    </button>
                                </form>
                            </div>
                            
                            <!-- Supprimer -->
                                            <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="flex-shrink-0">
                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 transition-colors">
                                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                                        </div>
                                    </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                    <!-- Actions du panier -->
                    <div class="mt-8 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                        <a href="{{ route('products.index') }}" class="btn-nike-outline">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Continuer les achats
                        </a>
                        
                        <form action="{{ route('cart.clear') }}" method="POST" class="flex-shrink-0">
                            @csrf
                            <button type="submit" class="text-red-500 hover:text-red-700 transition-colors font-medium">
                                <i class="fas fa-trash mr-2"></i>
                                Vider le panier
                            </button>
                        </form>
                        </div>
                    </div>
                    
                <!-- Résumé de la commande - Style Nike -->
                <div class="lg:col-span-1">
                    <div class="card-nike sticky top-8">
                        <h2 class="nike-heading mb-6">RÉSUMÉ DE LA COMMANDE</h2>
                        
                        <!-- Détails des prix -->
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Sous-total</span>
                                <span class="font-semibold">{{ number_format($subtotal) }} FCFA</span>
                            </div>
                            
                            @if($discount > 0)
                                <div class="flex justify-between text-green-600">
                                    <span>Réduction</span>
                                    <span>-{{ number_format($discount) }} FCFA</span>
                    </div>
                    @endif
                    
                            <div class="flex justify-between">
                                <span class="text-gray-600">Livraison</span>
                                <span class="font-semibold">{{ $shipping > 0 ? number_format($shipping) . ' FCFA' : 'Gratuite' }}</span>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-between">
                                    <span class="text-lg font-semibold text-black">Total</span>
                                    <span class="text-2xl font-bold text-black">{{ number_format($total) }} FCFA</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Bouton de finalisation -->
                        <a href="{{ route('checkout.index') }}" class="btn-nike w-full text-center">
                            FINALISER LA COMMANDE
                        </a>
                        
                        <!-- Informations supplémentaires -->
                        <div class="mt-6 text-center">
                            <p class="text-sm text-gray-500">
                                <i class="fas fa-shield-alt mr-2"></i>
                                Paiement sécurisé
                            </p>
                            <p class="text-sm text-gray-500 mt-2">
                                <i class="fas fa-truck mr-2"></i>
                                Livraison gratuite dès 50 000 FCFA
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
                            @else
            <!-- Panier vide - Style Nike -->
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-shopping-cart text-xl text-gray-400"></i>
                </div>
                <h3 class="nike-heading mb-4">Votre panier est vide</h3>
                <p class="nike-text text-gray-600 mb-8">
                    Découvrez nos produits et commencez votre shopping
                </p>
                <a href="{{ route('products.index') }}" class="btn-nike">
                    EXPLORER LES PRODUITS
                </a>
            </div>
                            @endif
        
        <!-- Produits recommandés -->
        @if($recommendedProducts && $recommendedProducts->count() > 0)
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
                                        <i class="fas fa-image text-lg text-gray-400"></i>
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
            </div>
        @endif
    </div>
</div>

<script>
function decreaseQuantity(itemId) {
    const input = document.getElementById('quantity-' + itemId);
    if (input.value > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

function increaseQuantity(itemId) {
    const input = document.getElementById('quantity-' + itemId);
    const max = parseInt(input.getAttribute('max'));
    if (input.value < max) {
        input.value = parseInt(input.value) + 1;
    }
}
</script>
@endsection