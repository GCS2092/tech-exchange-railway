@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white">
    
    <!-- Header Section - Style Nike -->
    <div class="bg-white border-b border-gray-200">
        <div class="container-nike py-16">
            <div class="text-center">
                <h1 class="nike-title mb-4">
                    <span class="text-black">TECH</span>
                    <span class="text-gray-600">WORLD</span>
                </h1>
                <p class="nike-subtitle mb-6">
                        Appareils électroniques premium
                </p>
                <p class="nike-text max-w-2xl mx-auto text-gray-600">
                    Découvrez notre sélection d'appareils high-tech, smartphones, ordinateurs et accessoires de dernière génération
                </p>
            </div>
        </div>
    </div>

    <div class="container-nike py-12">
        
        <!-- Filtres et Recherche - Style Nike -->
        <div class="mb-16">
            <form method="GET" action="{{ route('products.index') }}" class="bg-gray-50 border border-gray-200 p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <!-- Recherche -->
                    <div>
                        <label class="label-nike mb-3">
                            <i class="fas fa-search mr-2 text-black"></i>
                            Rechercher
                        </label>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="iPhone, MacBook, Samsung..." 
                               class="input-nike">
                    </div>
                    
                    <!-- Catégorie -->
                    <div>
                        <label class="label-nike mb-3">
                            <i class="fas fa-layer-group mr-2 text-black"></i>
                            Catégorie
                        </label>
                        <select name="category_id" class="input-nike">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Prix -->
                    <div>
                        <label class="label-nike mb-3">
                            <i class="fas fa-coins mr-2 text-black"></i>
                            Gamme de prix
                        </label>
                        <select name="price_range" class="input-nike">
                            <option value="">Tous les prix</option>
                            <option value="0-20000" {{ request('price_range') == '0-20000' ? 'selected' : '' }}>
                                Moins de 20 000 FCFA
                            </option>
                            <option value="20000-50000" {{ request('price_range') == '20000-50000' ? 'selected' : '' }}>
                                20 000 - 50 000 FCFA
                            </option>
                            <option value="50000-100000" {{ request('price_range') == '50000-100000' ? 'selected' : '' }}>
                                50 000 - 100 000 FCFA
                            </option>
                            <option value="100000+" {{ request('price_range') == '100000+' ? 'selected' : '' }}>
                                Plus de 100 000 FCFA
                            </option>
                        </select>
                    </div>

                    <!-- Trier -->
                    <div>
                        <label class="label-nike mb-3">
                            <i class="fas fa-sort mr-2 text-black"></i>
                            Trier par
                        </label>
                        <select name="sort" class="input-nike">
                            <option value="">Plus récents</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                Prix croissant
                            </option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                Prix décroissant
                            </option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>
                                Nom A-Z
                            </option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>
                                Nom Z-A
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Bouton de recherche -->
                <div class="mt-6 text-center">
                    <button type="submit" class="btn-nike">
                            <i class="fas fa-search mr-2"></i>
                            Rechercher
                        </button>
                </div>
            </form>
        </div>

        <!-- Résultats de recherche -->
        @if(request('search') || request('category_id') || request('price_range') || request('sort'))
            <div class="mb-8 text-center">
                <h2 class="nike-heading mb-4">Résultats de recherche</h2>
                <p class="nike-text text-gray-600">
                    {{ $products->total() }} produit(s) trouvé(s)
                </p>
                            </div>
                        @endif
                        
        <!-- Grille des produits - Style Nike -->
        @if($products->count() > 0)
            <div class="grid-nike grid-nike-3 gap-nike-lg">
                @foreach($products as $product)
                    <div class="product-card-nike group">
                        <!-- Image du produit -->
                        <div class="relative overflow-hidden">
                            @if($product->image)
                                @if(filter_var($product->image, FILTER_VALIDATE_URL))
                                    <!-- Image externe (URL) -->
                                    <img src="{{ $product->image }}" 
                                         alt="{{ $product->name }}" 
                                         class="product-image-nike group-hover:scale-105 transition-transform duration-300"
                                         onerror="this.src='{{ asset('images/default-device.svg') }}'">
                                @else
                                    <!-- Image locale -->
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="product-image-nike group-hover:scale-105 transition-transform duration-300"
                                         onerror="this.src='{{ asset('images/default-device.svg') }}'">
                                @endif
                            @else
                                <div class="product-image-nike bg-gray-100 flex items-center justify-center">
                                    <img src="{{ asset('images/default-device.svg') }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover">
                                </div>
                            @endif

                            <!-- Badge de promotion -->
                            @if($product->promo_price)
                                <div class="absolute top-4 left-4 bg-black text-white px-3 py-1 text-sm font-semibold">
                                    PROMO
                                </div>
                            @endif
                            
                            <!-- Actions rapides -->
                            <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <a href="{{ route('favorites.toggle', $product->id) }}" 
                                   class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-black hover:bg-gray-100 transition-colors">
                                    <i class="fas fa-heart {{ $product->isFavoritedBy(auth()->id()) ? 'text-red-500' : '' }}"></i>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Informations du produit -->
                        <div class="product-info-nike">
                            <h3 class="product-title-nike group-hover:text-gray-600 transition-colors">
                                <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                            </h3>
                            
                            <p class="text-gray-600 mb-4 line-clamp-2">{{ $product->description }}</p>

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
                                
                                <span class="text-sm text-gray-500">{{ $product->category->name ?? 'Sans catégorie' }}</span>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex space-x-2">
                                <a href="{{ route('products.show', $product) }}" class="btn-nike flex-1 text-center">
                                Voir détails
                            </a>
                                <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn-nike w-full">
                                        <i class="fas fa-shopping-cart mr-2"></i>
                                        Ajouter
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination - Style Nike -->
            @if($products->hasPages())
                <div class="mt-16 flex justify-center">
                    <div class="flex space-x-2">
                        @if($products->onFirstPage())
                            <span class="px-4 py-2 text-gray-400 border border-gray-200">Précédent</span>
                        @else
                            <a href="{{ $products->previousPageUrl() }}" class="px-4 py-2 border border-gray-200 text-black hover:bg-gray-50 transition-colors">
                                Précédent
                            </a>
                            @endif
                            
                        @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                            @if($page == $products->currentPage())
                                <span class="px-4 py-2 bg-black text-white border border-black">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-4 py-2 border border-gray-200 text-black hover:bg-gray-50 transition-colors">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                        
                        @if($products->hasMorePages())
                            <a href="{{ $products->nextPageUrl() }}" class="px-4 py-2 border border-gray-200 text-black hover:bg-gray-50 transition-colors">
                                Suivant
                            </a>
                        @else
                            <span class="px-4 py-2 text-gray-400 border border-gray-200">Suivant</span>
                        @endif
                    </div>
                </div>
            @endif
            
        @else
            <!-- Aucun produit trouvé - Style Nike -->
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-search text-2xl text-gray-400"></i>
                </div>
                <h3 class="nike-heading mb-4">Aucun produit trouvé</h3>
                <p class="nike-text text-gray-600 mb-8">
                    Essayez de modifier vos critères de recherche ou parcourez tous nos produits
                </p>
                <a href="{{ route('products.index') }}" class="btn-nike">
                            Voir tous les produits
                        </a>
                    </div>
        @endif
        
        <!-- Section des catégories populaires -->
        <div class="mt-20">
            <h2 class="nike-heading text-center mb-12">Catégories populaires</h2>
            <div class="grid-nike grid-nike-4 gap-nike">
                @foreach($categories->take(8) as $category)
                    <a href="{{ route('products.index', ['category_id' => $category->id]) }}" 
                       class="card-nike text-center group">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-gray-200 transition-colors">
                            <i class="fas fa-mobile-alt text-2xl text-gray-600"></i>
                </div>
                        <h3 class="font-semibold text-black group-hover:text-gray-600 transition-colors">
                            {{ $category->name }}
                        </h3>
                        <p class="text-sm text-gray-500 mt-2">{{ $category->products_count ?? 0 }} produits</p>
                    </a>
                @endforeach
    </div>
</div>
                </div>
            </div>
@endsection
