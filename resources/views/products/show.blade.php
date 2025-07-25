@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb amélioré -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-pink-600 inline-flex items-center transition-colors duration-300">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    Produits
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-gray-500 ml-1 md:ml-2 text-sm font-medium">{{ $product->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Product Details avec design amélioré -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Product Image Gallery avec effets -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform hover:shadow-2xl transition-all duration-300">
            <div class="relative h-96 group flex items-center justify-center">
                <img src="{{ $product->image }}" alt="{{ $product->name }}" 
                    class="max-w-full h-auto object-contain transition-transform duration-500 group-hover:scale-105 mx-auto">
                
                <!-- Product Badges avec animations -->
                <div class="absolute top-4 left-4 space-y-2">
                    @if($product->is_featured)
                        <span class="bg-pink-500 text-white text-xs font-semibold px-3 py-1 rounded-full transform hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-star mr-1"></i> Produit vedette
                        </span>
                    @endif
                    @if($product->discount > 0)
                        <span class="bg-red-500 text-white text-xs font-semibold px-3 py-1 rounded-full transform hover:scale-110 transition-transform duration-300">
                            -{{ $product->discount }}%
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Info avec design amélioré -->
        <div class="bg-white rounded-2xl shadow-lg p-6 transform hover:shadow-2xl transition-all duration-300">
            <!-- Category Badge -->
            <div class="mb-4">
                <span class="inline-block px-3 py-1 text-xs font-medium bg-gradient-to-r from-purple-100 to-pink-100 text-purple-700 rounded-full shadow-sm">
                    {{ $product->category->name ?? 'Non catégorisé' }}
                </span>
            </div>

            <!-- Product Title -->
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4">{{ $product->name }}</h1>

            <!-- Rating avec animations -->
            <div class="flex items-center mb-4">
                <div class="flex items-center">
                    <span class="text-yellow-400 hover:text-yellow-500 transition-colors duration-300">★★★★★</span>
                    <span class="text-gray-500 text-sm ml-2">(4.8)</span>
                </div>
                <span class="text-gray-500 text-sm ml-4">128 avis</span>
            </div>

            <!-- Price avec effets -->
            <div class="mb-6">
                @php $currentCurrency = session('currency', 'XOF'); @endphp
                @if($product->old_price > $product->price)
                    <span class="text-gray-400 line-through text-lg mr-2">{{ \App\Helpers\CurrencyHelper::format($product->old_price, $currentCurrency) }}</span>
                @endif
                <span class="text-3xl font-bold text-pink-600 hover:text-pink-700 transition-colors duration-300">
                    {{ \App\Helpers\CurrencyHelper::format($product->price, $currentCurrency) }}
                </span>
            </div>

            <!-- Description avec animation -->
            <div class="mb-6">
                <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-2">Description</h2>
                <p class="text-gray-600 text-sm sm:text-base">{{ $product->description }}</p>
            </div>

            <!-- Stock Status avec badges animés -->
            <div class="mb-6">
                @if($product->is_active)
                    <span class="inline-flex items-center text-green-600 hover:text-green-700 transition-colors duration-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        En stock
                    </span>
                @else
                    <span class="inline-flex items-center text-red-600 hover:text-red-700 transition-colors duration-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Rupture de stock
                    </span>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                @if($product->is_active)
                    @auth
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full bg-gradient-to-r from-pink-600 to-purple-600 text-white py-3 px-6 rounded-xl font-bold tracking-wide 
                                hover:from-pink-700 hover:to-purple-700 transform hover:-translate-y-1 hover:shadow-lg 
                                transition-all duration-300 ease-in-out focus:outline-none">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Ajouter au panier
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="w-full bg-gradient-to-r from-pink-600 to-purple-600 text-white py-3 px-6 rounded-xl font-bold tracking-wide 
                            hover:from-pink-700 hover:to-purple-700 transform hover:-translate-y-1 hover:shadow-lg 
                            transition-all duration-300 ease-in-out focus:outline-none flex items-center justify-center">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Ajouter au panier
                        </a>
                        <div class="text-xs text-gray-400 mt-1">Connectez-vous ou créez un compte pour acheter</div>
                    @endauth
                @endif

                @auth
                    @php
                        $isFavorite = Auth::user()->favorites()->where('product_id', $product->id)->exists();
                    @endphp
                    
                    @if($isFavorite)
                        <form action="{{ route('favorites.remove', $product) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-500 text-white py-3 px-6 rounded-xl font-bold tracking-wide 
                                hover:bg-red-600 transform hover:-translate-y-1 hover:shadow-lg 
                                transition-all duration-300 ease-in-out focus:outline-none">
                                <i class="fas fa-heart mr-2"></i>
                                Retirer des favoris
                            </button>
                        </form>
                    @else
                        <form action="{{ route('favorites.add', $product) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full bg-gray-200 text-gray-700 py-3 px-6 rounded-xl font-bold tracking-wide 
                                hover:bg-gray-300 transform hover:-translate-y-1 hover:shadow-lg 
                                transition-all duration-300 ease-in-out focus:outline-none">
                                <i class="far fa-heart mr-2"></i>
                                Ajouter aux favoris
                            </button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <!-- Related Products avec design amélioré -->
    <div class="mt-16">
        <h2 class="text-2xl font-bold text-gray-800 mb-8">Produits similaires</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($relatedProducts as $relatedProduct)
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
                    <div class="relative h-64 overflow-hidden">
                        <img src="{{ $relatedProduct->image }}" alt="{{ $relatedProduct->name }}" 
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-pink-600 transition-colors">{{ $relatedProduct->name }}</h3>
                        <p class="text-pink-600 font-bold mt-2">{{ \App\Helpers\CurrencyHelper::format($relatedProduct->price, $currentCurrency) }}</p>
                        <a href="{{ route('products.show', $relatedProduct->id) }}" class="mt-4 inline-block text-pink-600 hover:text-pink-700 font-medium transition-colors duration-300">
                            Voir le produit
                            <svg class="w-4 h-4 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<x-onboarding-button tourId="product-show" position="fixed" />

@push('styles')
<style>
    /* Animations pour les éléments */
    .fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Effets de survol améliorés */
    .hover-scale {
        transition: transform 0.3s ease;
    }

    .hover-scale:hover {
        transform: scale(1.05);
    }

    /* Transitions fluides */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }
</style>
@endpush

@push('scripts')
<script>
    // Animation au chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
        const elements = document.querySelectorAll('.fade-in');
        elements.forEach((element, index) => {
            setTimeout(() => {
                element.classList.add('fade-in');
            }, index * 100);
        });
    });

    window.tourSteps_ = [
        {
            id: 'step-1',
            title: 'Fiche produit détaillée',
            text: 'Retrouvez ici toutes les <b>informations essentielles</b> sur ce produit.',
            attachTo: { element: 'h1, .product-title', on: 'bottom' },
            buttons: [ { text: 'Suivant', action: function() { tour.next(); } } ]
        },
        {
            id: 'step-2',
            title: 'Ajout au panier',
            text: 'Cliquez ici pour <b>ajouter ce produit à votre panier</b> et poursuivre votre shopping.',
            attachTo: { element: 'button.add-to-cart, .btn-primary', on: 'bottom' },
            buttons: [ { text: 'Terminer', action: function() { tour.complete(); } } ]
        }
    ];
    window.showOnboardingTour = function(tourId, steps) {
        const tour = window.createCustomTour(steps);
        window.tour = tour;
        tour.start();
    };
</script>
@endpush
@endsection
