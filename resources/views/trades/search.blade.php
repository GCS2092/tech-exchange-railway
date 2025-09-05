@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-blue-900/20 to-cyan-900/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- En-tête -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center px-4 py-2 bg-gray-800/50 border border-cyan-500/30 rounded-full text-cyan-400 text-sm font-medium mb-6 backdrop-blur-sm">
                <div class="w-2 h-2 bg-cyan-400 rounded-full mr-2 animate-pulse"></div>
                Système d'échange TechHub
            </div>
            
            <h1 class="text-2xl md:text-2xl font-black mb-6 leading-tight">
                <span class="bg-gradient-to-r from-cyan-400 via-blue-500 to-indigo-600 bg-clip-text text-transparent">
                    ÉCHANGEZ
                </span>
                <span class="text-white">VOS APPAREILS</span>
            </h1>
            
            <p class="text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed">
                Découvrez notre sélection d'appareils électroniques disponibles à l'échange. 
                Proposez vos appareils et trouvez votre prochain coup de cœur technologique.
            </p>
        </div>

        <!-- Filtres -->
        <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-2xl p-6 mb-8">
            <form method="GET" action="{{ route('trades.search') }}" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Recherche -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-300 mb-2">Recherche</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 text-white placeholder-gray-400"
                               placeholder="Nom, marque, modèle...">
                    </div>

                    <!-- Type d'appareil -->
                    <div>
                        <label for="device_type" class="block text-sm font-medium text-gray-300 mb-2">Type d'appareil</label>
                        <select name="device_type" id="device_type"
                                class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 text-white">
                            <option value="">Tous les types</option>
                            @foreach($deviceTypes as $type)
                                <option value="{{ $type }}" {{ request('device_type') == $type ? 'selected' : '' }}>
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Marque -->
                    <div>
                        <label for="brand" class="block text-sm font-medium text-gray-300 mb-2">Marque</label>
                        <select name="brand" id="brand" 
                                class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 text-white">
                            <option value="">Toutes les marques</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>
                                    {{ $brand }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- État -->
                    <div>
                        <label for="condition" class="block text-sm font-medium text-gray-300 mb-2">État</label>
                        <select name="condition" id="condition"
                                class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 text-white">
                            <option value="">Tous les états</option>
                            @foreach($conditions as $condition)
                                <option value="{{ $condition }}" {{ request('condition') == $condition ? 'selected' : '' }}>
                                    {{ ucfirst($condition) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <button type="submit"
                            class="bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-semibold py-3 px-8 rounded-xl hover:from-cyan-600 hover:to-blue-700 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Rechercher
                    </button>

                    @if(request()->hasAny(['search', 'device_type', 'brand', 'condition']))
                        <a href="{{ route('trades.search') }}"
                           class="text-gray-400 hover:text-cyan-400 font-medium transition-colors">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Effacer les filtres
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Résultats -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-white">
                    {{ $products->total() }} appareil(s) trouvé(s)
                </h2>
                
                @guest
                    <div class="bg-gradient-to-r from-yellow-500/20 to-orange-500/20 border border-yellow-500/30 rounded-xl px-4 py-2">
                        <p class="text-yellow-400 text-sm">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            Connectez-vous pour proposer un échange
                        </p>
                    </div>
                @endguest
            </div>

            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="group bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl overflow-hidden hover:border-cyan-500/50 transition-all duration-300 transform hover:-translate-y-2">
                            <!-- Image du produit -->
                            <div class="relative overflow-hidden">
                                <div class="w-full h-48 bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-16 h-16 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a1 1 0 001-1V4a1 1 0 00-1-1H8a1 1 0 00-1 1v16a1 1 0 001 1z"></path>
                                        </svg>
                                    @endif
                                </div>
                                
                                <!-- Badge échange -->
                                <div class="absolute top-4 left-4">
                                    <span class="bg-gradient-to-r from-green-500 to-emerald-600 text-white text-xs px-2 py-1 rounded-full font-medium">
                                        Échange disponible
                                    </span>
                                </div>
                                
                                <!-- Badge état -->
                                <div class="absolute top-4 right-4">
                                    <span class="bg-gray-800/80 text-gray-300 text-xs px-2 py-1 rounded-full backdrop-blur-sm">
                                        {{ ucfirst($product->condition) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Informations du produit -->
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-white mb-2">{{ $product->name }}</h3>
                                <p class="text-gray-400 text-sm mb-4">{{ $product->brand }} {{ $product->model }}</p>
                                
                                <!-- Spécifications -->
                                <div class="space-y-2 mb-4 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Type:</span>
                                        <span class="text-gray-300 font-medium">{{ ucfirst($product->device_type) }}</span>
                                    </div>
                                    @if($product->ram)
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">RAM:</span>
                                            <span class="text-gray-300 font-medium">{{ $product->ram }}</span>
                                        </div>
                                    @endif
                                    @if($product->storage)
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">Stockage:</span>
                                            <span class="text-gray-300 font-medium">{{ $product->storage }}</span>
                                        </div>
                                    @endif
                                    @if($product->screen_size)
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">Écran:</span>
                                            <span class="text-gray-300 font-medium">{{ $product->screen_size }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Prix et action -->
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-2xl font-bold text-cyan-400">{{ \App\Helpers\CurrencyHelper::formatXOF($product->price) }}</span>
                                        <p class="text-gray-500 text-xs">Prix de référence</p>
                                    </div>
                                    
                                    @auth
                                        <a href="{{ route('trades.show.page', $product) }}" 
                                           class="bg-gradient-to-r from-cyan-500 to-blue-600 text-white px-4 py-2 rounded-lg hover:from-cyan-600 hover:to-blue-700 transition-all duration-200 transform hover:scale-105">
                                            Proposer un échange
                                        </a>
                                    @else
                                        <div class="text-center">
                                            <a href="{{ route('login') }}" 
                                               class="bg-gradient-to-r from-yellow-500 to-orange-600 text-white px-4 py-2 rounded-lg hover:from-yellow-600 hover:to-orange-700 transition-all duration-200 transform hover:scale-105">
                                                Se connecter
                                            </a>
                                            <p class="text-gray-500 text-xs mt-1">Pour échanger</p>
                                        </div>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                    <div class="mt-8 flex justify-center">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <!-- Aucun résultat -->
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium text-gray-300 mb-2">Aucun appareil trouvé</h3>
                    <p class="text-gray-500 mb-6">Aucun appareil ne correspond à vos critères de recherche.</p>
                    <a href="{{ route('trades.search') }}"
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-medium rounded-xl hover:from-cyan-600 hover:to-blue-700 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Effacer les filtres
                    </a>
                </div>
            @endif
        </div>

        <!-- Section d'information pour les utilisateurs non connectés -->
        @guest
            <div class="bg-gradient-to-r from-cyan-600/20 via-blue-600/20 to-indigo-600/20 border border-cyan-500/30 rounded-2xl p-8 mt-12">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    
                    <h3 class="text-2xl font-bold text-white mb-4">Prêt à échanger vos appareils ?</h3>
                    <p class="text-gray-300 mb-6 max-w-2xl mx-auto">
                        Créez un compte ou connectez-vous pour proposer vos appareils en échange et accéder à notre système d'échange complet.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('login') }}" 
                           class="bg-gradient-to-r from-cyan-500 to-blue-600 text-white px-8 py-3 rounded-xl font-semibold hover:from-cyan-600 hover:to-blue-700 transition-all duration-200 transform hover:scale-105">
                            Se connecter
                        </a>
                        <a href="{{ route('register') }}" 
                           class="bg-gradient-to-r from-gray-700 to-gray-800 text-white px-8 py-3 rounded-xl font-semibold hover:from-gray-600 hover:to-gray-700 transition-all duration-200 transform hover:scale-105 border border-gray-600">
                            Créer un compte
                        </a>
                    </div>
                </div>
            </div>
        @endguest
    </div>
</div>

<!-- Styles personnalisés -->
<style>
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: .5;
        }
    }
    
    /* Pagination personnalisée */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
    }
    
    .pagination .page-item .page-link {
        background: rgba(55, 65, 81, 0.5);
        border: 1px solid rgba(75, 85, 99, 1);
        color: #d1d5db;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        transition: all 0.2s;
    }
    
    .pagination .page-item .page-link:hover {
        background: rgba(6, 182, 212, 0.2);
        border-color: rgba(6, 182, 212, 0.5);
        color: #06b6d4;
    }
    
    .pagination .page-item.active .page-link {
        background: linear-gradient(to right, #06b6d4, #3b82f6);
        border-color: #06b6d4;
        color: white;
    }
</style>
@endsection 