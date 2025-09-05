@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white">
    <div class="container-nike py-12">
        
        <!-- Breadcrumb - Style Nike -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li><a href="{{ route('dashboard') }}" class="hover:text-black transition-colors">Accueil</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('products.index') }}" class="hover:text-black transition-colors">Produits</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-black font-medium">{{ $product->name }}</li>
        </ol>
    </nav>

        <!-- Détail du produit - Style Nike -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 mb-16">
            
            <!-- Images du produit -->
            <div class="space-y-4">
                @if($product->image)
                    <!-- Image principale -->
                    <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
                        @if(filter_var($product->image, FILTER_VALIDATE_URL))
                            <!-- Image externe (URL) -->
                            <img src="{{ $product->image }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover"
                                 onerror="this.src='{{ asset('images/default-device.svg') }}'">
                        @else
                            <!-- Image locale -->
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover"
                                 onerror="this.src='{{ asset('images/default-device.svg') }}'">
                        @endif
                    </div>
                @else
                    <!-- Placeholder si pas d'image -->
                    <div class="aspect-square bg-gray-100 rounded-lg flex items-center justify-center">
                        <img src="{{ asset('images/default-device.svg') }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover">
                    </div>
                @endif
            </div>

            <!-- Informations du produit -->
            <div class="space-y-8">
                <!-- Titre et catégorie -->
                <div>
                    <h1 class="nike-heading mb-4">{{ $product->name }}</h1>
                    <p class="text-gray-600">{{ $product->category->name ?? 'Sans catégorie' }}</p>
            </div>

                <!-- Prix -->
                <div class="space-y-2">
                    @if($product->promo_price)
                        <div class="flex items-center space-x-4">
                            <span class="text-xl font-bold text-black" id="unit-price" data-price="{{ $product->promo_price }}">{{ number_format($product->promo_price) }} FCFA</span>
                            <span class="text-xl text-gray-500 line-through">{{ number_format($product->price) }} FCFA</span>
                            <span class="bg-black text-white px-3 py-1 text-sm font-semibold">
                                PROMO
                            </span>
                        </div>
                        <div class="text-2xl font-bold text-black" id="total-price">
                            Total : {{ number_format($product->promo_price) }} FCFA
                        </div>
                    @else
                        <span class="text-xl font-bold text-black" id="unit-price" data-price="{{ $product->price }}">{{ number_format($product->price) }} FCFA</span>
                        <div class="text-2xl font-bold text-black" id="total-price">
                            Total : {{ number_format($product->price) }} FCFA
                        </div>
                    @endif
                </div>

                <!-- Description -->
                <div>
                    <h3 class="text-lg font-semibold text-black mb-3">Description</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                </div>
                
                <!-- Caractéristiques -->
                @if($product->specifications)
                    <div>
                        <h3 class="text-lg font-semibold text-black mb-3">Caractéristiques</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach(json_decode($product->specifications, true) ?? [] as $key => $value)
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="font-medium text-gray-700">{{ $key }}</span>
                                    <span class="text-gray-600">{{ $value }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Actions -->
                <div class="space-y-4">
                    @if($product->isInStock())
                        <!-- Quantité -->
                        <div>
                            <label class="label-nike mb-2">Quantité</label>
                            <div class="flex items-center space-x-4">
                                <button type="button" class="w-10 h-10 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors" onclick="decreaseQuantity()">
                                    <i class="fas fa-minus text-gray-600"></i>
                                </button>
                                <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->quantity }}" class="w-20 text-center border border-gray-300 rounded-lg py-2">
                                <button type="button" class="w-10 h-10 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors" onclick="increaseQuantity()">
                                    <i class="fas fa-plus text-gray-600"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Boutons d'action -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" id="quantity-input" value="1">
                                <button type="submit" class="btn-nike w-full">
                                    <i class="fas fa-shopping-cart mr-2"></i>
                                    AJOUTER AU PANIER
                                </button>
                            </form>
                            
                            <a href="{{ route('favorites.toggle', $product->id) }}" 
                               class="btn-nike-outline w-full text-center">
                                <i class="fas fa-heart mr-2 {{ $product->isFavoritedBy(auth()->id()) ? 'text-red-500' : '' }}"></i>
                                {{ $product->isFavoritedBy(auth()->id()) ? 'Retirer des favoris' : 'Ajouter aux favoris' }}
                            </a>
                        </div>
                        
                        <!-- Stock disponible -->
                        <div class="text-center">
                            <p class="text-sm text-gray-600">
                                Stock disponible : <span class="font-semibold text-black">{{ $product->quantity }}</span> unité(s)
                            </p>
                        </div>
                    @else
                        <!-- Produit en rupture de stock -->
                        <div class="text-center space-y-4">
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                <div class="flex items-center justify-center mb-2">
                                    <i class="fas fa-exclamation-triangle text-red-500 text-xl mr-2"></i>
                                    <span class="text-red-700 font-semibold">Rupture de stock</span>
                                </div>
                                <p class="text-red-600 text-sm">
                                    Ce produit n'est temporairement plus disponible. 
                                    Contactez-nous pour être informé de sa disponibilité.
                                </p>
                            </div>
                            
                            <!-- Bouton de contact -->
                            <a href="tel:+221776543210" class="btn-nike-outline w-full text-center">
                                <i class="fas fa-phone mr-2"></i>
                                NOUS CONTACTER
                            </a>
                            
                            <!-- Bouton favoris toujours disponible -->
                            <a href="{{ route('favorites.toggle', $product->id) }}" 
                               class="btn-nike-outline w-full text-center">
                                <i class="fas fa-heart mr-2 {{ $product->isFavoritedBy(auth()->id()) ? 'text-red-500' : '' }}"></i>
                                {{ $product->isFavoritedBy(auth()->id()) ? 'Retirer des favoris' : 'Ajouter aux favoris' }}
                            </a>
                        </div>
                    @endif
            </div>
        </div>
    </div>

        <!-- Produits similaires - Style Nike -->
        @if($relatedProducts->count() > 0)
            <div class="border-t border-gray-200 pt-16">
                <h2 class="nike-heading text-center mb-12">PRODUITS SIMILAIRES</h2>
                <div class="grid-nike grid-nike-3 gap-nike-lg">
            @foreach($relatedProducts as $relatedProduct)
                        <div class="product-card-nike group">
                            <!-- Image du produit -->
                            <div class="relative overflow-hidden">
                                @if($relatedProduct->image)
                                    @if(filter_var($relatedProduct->image, FILTER_VALIDATE_URL))
                                        <!-- Image externe (URL) -->
                                        <img src="{{ $relatedProduct->image }}" 
                                             alt="{{ $relatedProduct->name }}" 
                                             class="product-image-nike group-hover:scale-105 transition-transform duration-300"
                                             onerror="this.src='{{ asset('images/default-device.svg') }}'">
                                    @else
                                        <!-- Image locale -->
                                        <img src="{{ asset('storage/' . $relatedProduct->image) }}" 
                                             alt="{{ $relatedProduct->name }}" 
                                             class="product-image-nike group-hover:scale-105 transition-transform duration-300"
                                             onerror="this.src='{{ asset('images/default-device.svg') }}'">
                                    @endif
                                @else
                                    <div class="product-image-nike bg-gray-100 flex items-center justify-center">
                                        <img src="{{ asset('images/default-device.svg') }}" 
                                             alt="{{ $relatedProduct->name }}" 
                                             class="w-full h-full object-cover">
                                    </div>
                                @endif
                                
                                <!-- Badge de promotion -->
                                @if($relatedProduct->promo_price)
                                    <div class="absolute top-4 left-4 bg-black text-white px-3 py-1 text-sm font-semibold">
                                        PROMO
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Informations du produit -->
                            <div class="product-info-nike">
                                <h3 class="product-title-nike group-hover:text-gray-600 transition-colors">
                                    <a href="{{ route('products.show', $relatedProduct) }}">{{ $relatedProduct->name }}</a>
                                </h3>
                                
                                <!-- Prix -->
                                <div class="flex items-center justify-between mb-4">
                                    @if($relatedProduct->promo_price)
                                        <div class="flex items-center space-x-2">
                                            <span class="product-price-old-nike">{{ number_format($relatedProduct->price) }} FCFA</span>
                                            <span class="product-price-nike">{{ number_format($relatedProduct->promo_price) }} FCFA</span>
                                        </div>
                                    @else
                                        <span class="product-price-nike">{{ number_format($relatedProduct->price) }} FCFA</span>
                                    @endif
                    </div>
                                
                                <!-- Bouton d'action -->
                                <a href="{{ route('products.show', $relatedProduct) }}" class="btn-nike w-full text-center">
                                    Voir détails
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
            </div>
        @endif
    </div>
</div>

<script>
function updateTotalPrice() {
    const quantity = parseInt(document.getElementById('quantity').value);
    const unitPrice = parseFloat(document.getElementById('unit-price').getAttribute('data-price'));
    const totalPrice = quantity * unitPrice;
    
    document.getElementById('total-price').textContent = 'Total : ' + new Intl.NumberFormat('fr-FR').format(totalPrice) + ' FCFA';
}

function decreaseQuantity() {
    const input = document.getElementById('quantity');
    const quantityInput = document.getElementById('quantity-input');
    if (input.value > 1) {
        input.value = parseInt(input.value) - 1;
        quantityInput.value = input.value;
        updateTotalPrice();
    }
}

function increaseQuantity() {
    const input = document.getElementById('quantity');
    const quantityInput = document.getElementById('quantity-input');
    const max = parseInt(input.getAttribute('max'));
    if (input.value < max) {
        input.value = parseInt(input.value) + 1;
        quantityInput.value = input.value;
        updateTotalPrice();
    }
}

// Synchroniser les inputs de quantité et mettre à jour le prix
document.getElementById('quantity').addEventListener('change', function() {
    document.getElementById('quantity-input').value = this.value;
    updateTotalPrice();
});

// Initialiser le prix total au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    updateTotalPrice();
});
</script>
@endsection
