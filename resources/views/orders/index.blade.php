@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white">
    <div class="container-nike py-12">
        
        <!-- Header - Style Nike -->
        <div class="text-center mb-16">
            <h1 class="nike-title mb-4">COMMANDES</h1>
            <p class="nike-text text-gray-600">Suivez l'état de vos commandes et consultez votre historique</p>
        </div>

        @if($orders->count() > 0)
            <div class="space-y-8">
                @foreach($orders as $order)
                    <div class="product-card-nike">
                        <!-- En-tête de la commande -->
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-black mb-2">
                                    Commande #{{ $order->order_number }}
                                </h3>
                                <p class="text-gray-600">
                                    Passée le {{ $order->created_at->format('d/m/Y à H:i') }}
                                </p>
                            </div>
                            
                            <!-- Statut de la commande -->
                            <div class="mt-4 lg:mt-0">
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
                                
                                <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold {{ $statusColor }}">
                                    {{ $statusLabel }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Articles de la commande -->
                        <div class="space-y-4 mb-6">
                            @if($order->products && $order->products->count() > 0)
                                @foreach($order->products as $product)
                                <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                                    <!-- Image du produit -->
                                    <div class="flex-shrink-0">
                                        @if($product->images && count($product->images) > 0)
                                            <img src="{{ asset('storage/' . $product->images->first()->path) }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="w-16 h-16 object-cover rounded-lg">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-image text-gray-400"></i>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Informations du produit -->
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-black">
                                            {{ $product->name ?? 'Produit supprimé' }}
                                        </h4>
                                        <p class="text-sm text-gray-600">
                                            Quantité : {{ $product->pivot->quantity }}
                                        </p>
                                    </div>
                                    
                                    <!-- Prix -->
                                    <div class="text-right">
                                        <p class="font-semibold text-black">
                                            {{ number_format($product->pivot->price * $product->pivot->quantity) }} FCFA
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center text-gray-500 py-4">
                                    <p>Aucun article trouvé pour cette commande</p>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Résumé de la commande -->
                        <div class="border-t border-gray-200 pt-6">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                                <div class="mb-4 lg:mb-0">
                                    <div class="flex items-center space-x-6 text-sm text-gray-600">
                                        <span>
                                            <i class="fas fa-map-marker-alt mr-2"></i>
                                            {{ $order->delivery_address ?? 'Adresse non spécifiée' }}
                                        </span>
                                        <span>
                                            <i class="fas fa-credit-card mr-2"></i>
                                            {{ $order->payment_method ?? 'Méthode non spécifiée' }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-black mb-2">
                                        Total : {{ number_format($order->total) }} FCFA
                    </div>
                                    
                                    <!-- Actions -->
                                    <div class="flex items-center space-x-3">
                                        @if(auth()->user()->hasAnyRole(['admin', 'vendeur']))
                                            <a href="{{ route('admin.orders.manage', $order) }}" class="btn-nike-outline">
                                                <i class="fas fa-cogs mr-2"></i>
                                                Gérer commande
                                            </a>
                                        @else
                                            <a href="{{ route('orders.show', $order) }}" class="btn-nike-outline">
                                                <i class="fas fa-eye mr-2"></i>
                                                Voir détails
                                            </a>
                                        @endif
                                        
                                        @if($order->status === 'delivered')
                                            <a href="{{ route('orders.review', $order) }}" class="btn-nike">
                                                <i class="fas fa-star mr-2"></i>
                                                Évaluer
                                            </a>
                @endif

                                        @if($order->status === 'pending')
                                            <form action="{{ route('orders.cancel', $order) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="text-red-500 hover:text-red-700 transition-colors font-medium" 
                                                        onclick="return confirm('Êtes-vous sûr de vouloir annuler cette commande ?')">
                                                    <i class="fas fa-times mr-2"></i>
                                                    Annuler
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                    </div>
            
            <!-- Pagination - Style Nike -->
            @if($orders->hasPages())
                <div class="mt-16 flex justify-center">
                    <div class="flex space-x-2">
                        @if($orders->onFirstPage())
                            <span class="px-4 py-2 text-gray-400 border border-gray-200">Précédent</span>
                @else
                            <a href="{{ $orders->previousPageUrl() }}" class="px-4 py-2 border border-gray-200 text-black hover:bg-gray-50 transition-colors">
                                Précédent
                            </a>
                        @endif
                        
                        @foreach($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                            @if($page == $orders->currentPage())
                                <span class="px-4 py-2 bg-black text-white border border-black">{{ $page }}</span>
                                        @else
                                <a href="{{ $url }}" class="px-4 py-2 border border-gray-200 text-black hover:bg-gray-50 transition-colors">
                                    {{ $page }}
                                            </a>
                                        @endif
                                @endforeach
                        
                        @if($orders->hasMorePages())
                            <a href="{{ $orders->nextPageUrl() }}" class="px-4 py-2 border border-gray-200 text-black hover:bg-gray-50 transition-colors">
                                Suivant
                            </a>
                        @else
                            <span class="px-4 py-2 text-gray-400 border border-gray-200">Suivant</span>
                        @endif
                    </div>
                    </div>
            @endif
            
        @else
            <!-- Aucune commande - Style Nike -->
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-shopping-bag text-2xl text-gray-400"></i>
                </div>
                <h3 class="nike-heading mb-4">Aucune commande trouvée</h3>
                <p class="nike-text text-gray-600 mb-8">
                    Vous n'avez pas encore passé de commande. Découvrez nos produits et commencez votre shopping !
                </p>
                <a href="{{ route('products.index') }}" class="btn-nike">
                    EXPLORER LES PRODUITS
                </a>
                    </div>
                @endif
        
        <!-- Informations supplémentaires -->
        <div class="mt-20 border-t border-gray-200 pt-16">
            <div class="grid-nike grid-nike-3 gap-nike-lg">
                <div class="text-center">
                    <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-truck text-white text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-black mb-2">Livraison rapide</h3>
                    <p class="text-gray-600">Livraison gratuite et rapide dans toute la France</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-black mb-2">Paiement sécurisé</h3>
                    <p class="text-gray-600">Vos informations de paiement sont protégées</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-white text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-black mb-2">Support client</h3>
                    <p class="text-gray-600">Notre équipe est disponible 24/7 pour vous aider</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection