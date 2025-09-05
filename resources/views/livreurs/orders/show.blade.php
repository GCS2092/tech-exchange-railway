@extends('layouts.livreur')

@section('content')
<div class="min-h-screen bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Navigation -->
        <div class="mb-8">
            <div class="flex items-center space-x-4 mb-6">
                <a href="{{ route('livreur.orders.index') }}" class="text-gray-600 hover:text-black transition-colors">
                    ← Retour aux commandes
                </a>
                <span class="text-gray-400">/</span>
                <span class="text-black font-semibold">Commande #{{ $order->id }}</span>
            </div>
        </div>

        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-black mb-4 text-black">COMMANDE #{{ $order->id }}</h1>
            <div class="inline-block px-4 py-2 rounded-lg text-sm font-semibold
                @if($order->status === 'livré') bg-green-100 text-green-800
                @elseif($order->status === 'en attente') bg-yellow-100 text-yellow-800
                @else bg-gray-100 text-gray-800 @endif">
                {{ ucfirst($order->status) }}
            </div>
                    </div>
                    
        <!-- Informations de la commande -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Informations client -->
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-black mb-4 flex items-center">
                    <i class="fas fa-user mr-2"></i>
                    Informations client
                </h3>
                        <div class="space-y-3">
                    <div>
                        <span class="text-gray-600">Nom:</span>
                        <span class="font-semibold text-black ml-2">{{ $order->user->name ?? 'N/A' }}</span>
                                </div>
                    <div>
                        <span class="text-gray-600">Email:</span>
                        <span class="font-semibold text-black ml-2">{{ $order->user->email ?? 'N/A' }}</span>
                            </div>
                    <div>
                        <span class="text-gray-600">Téléphone:</span>
                        <span class="font-semibold text-black ml-2">{{ $order->phone_number ?? $order->user->phone_number ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
                
            <!-- Informations de livraison -->
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-black mb-4 flex items-center">
                    <i class="fas fa-map-marker-alt mr-2"></i>
                    Adresse de livraison
                </h3>
                <div class="space-y-3">
                    <div>
                        <span class="text-gray-600">Adresse:</span>
                        <span class="font-semibold text-black ml-2">{{ $order->delivery_address ?? $order->shipping_address ?? 'N/A' }}</span>
                    </div>
                    @if($order->latitude && $order->longitude)
                    <div>
                        <span class="text-gray-600">Coordonnées GPS:</span>
                        <span class="font-semibold text-black ml-2">{{ $order->latitude }}, {{ $order->longitude }}</span>
                        </div>
                    @endif
                </div>
                </div>
            </div>

        <!-- Détails des produits -->
        <div class="bg-white border border-gray-200 rounded-lg p-6 mb-8">
            <h3 class="text-lg font-semibold text-black mb-4 flex items-center">
                <i class="fas fa-box mr-2"></i>
                Produits commandés
            </h3>
            <div class="space-y-4">
                @if($order->products && $order->products->count() > 0)
                    @foreach($order->products as $product)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-4">
                                @if($product->image)
                                    @if(filter_var($product->image, FILTER_VALIDATE_URL))
                                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded-lg" onerror="this.src='{{ asset('images/default-device.svg') }}'">
                                    @else
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded-lg" onerror="this.src='{{ asset('images/default-device.svg') }}'">
                                    @endif
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <img src="{{ asset('images/default-device.svg') }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    </div>
                                @endif
                                <div>
                                    <h4 class="font-semibold text-black">{{ $product->name ?? 'Produit supprimé' }}</h4>
                                    <p class="text-gray-600 text-sm">Quantité: {{ $product->pivot->quantity }}</p>
                        </div>
                    </div>
                            <div class="text-right">
                                <p class="font-semibold text-black">{{ number_format($product->pivot->price * $product->pivot->quantity, 0, ',', ' ') }} FCFA</p>
                                <p class="text-gray-600 text-sm">{{ number_format($product->pivot->price, 0, ',', ' ') }} FCFA × {{ $product->pivot->quantity }}</p>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-box text-2xl text-gray-400"></i>
                            </div>
                        <p class="text-gray-600 mb-2">Aucun détail de produit disponible</p>
                        <p class="text-sm text-gray-500">Cette commande ne contient pas d'items détaillés</p>
                    </div>
                    @endif
                </div>
            </div>

        <!-- Informations de la commande -->
        <div class="bg-white border border-gray-200 rounded-lg p-6 mb-8">
            <h3 class="text-lg font-semibold text-black mb-4 flex items-center">
                <i class="fas fa-info-circle mr-2"></i>
                Informations de la commande
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-3">
                    <div>
                        <span class="text-gray-600">Date de commande:</span>
                        <span class="font-semibold text-black ml-2">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    <div>
                        <span class="text-gray-600">Total:</span>
                        <span class="font-semibold text-black ml-2">{{ number_format($order->total_price, 0) }} FCFA</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Méthode de paiement:</span>
                        <span class="font-semibold text-black ml-2">{{ ucfirst($order->payment_method ?? 'N/A') }}</span>
            </div>
        </div>
                <div class="space-y-3">
                    @if($order->delivered_at)
                        <div>
                            <span class="text-gray-600">Date de livraison:</span>
                            <span class="font-semibold text-black ml-2">{{ $order->delivered_at->format('d/m/Y H:i') }}</span>
        </div>
        @endif
                    <div>
                        <span class="text-gray-600">Statut:</span>
                        <span class="font-semibold text-black ml-2">{{ ucfirst($order->status) }}</span>
            </div>
                    @if($order->notes)
                        <div>
                            <span class="text-gray-600">Notes:</span>
                            <span class="font-semibold text-black ml-2">{{ $order->notes }}</span>
                        </div>
                            @endif
                        </div>
                    </div>
                </div>
                
        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @if($order->status !== 'livré')
                <form method="POST" action="{{ route('livreur.orders.complete', $order) }}" class="inline">
                        @csrf
                    @method('PATCH')
                    <button type="submit" class="w-full sm:w-auto bg-green-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-600 transition-colors">
                        <i class="fas fa-check mr-2"></i>
                        Marquer comme livré
                            </button>
                    </form>
            @endif
            
            @if($order->latitude && $order->longitude)
                <a href="{{ route('livreur.orders.route', $order) }}" class="w-full sm:w-auto bg-blue-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-600 transition-colors text-center">
                    <i class="fas fa-route mr-2"></i>
                    Voir l'itinéraire
                </a>
                @endif
            
            <a href="{{ route('livreur.orders.index') }}" class="w-full sm:w-auto bg-gray-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-gray-600 transition-colors text-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour
            </a>
            </div>
    </div>
</div>

<!-- Navigation flottante pour mobile -->
<x-livreur-floating-nav />
@endsection