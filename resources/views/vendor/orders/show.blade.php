@extends('layouts.app')

@section('title', 'Détails de la Commande #' . $order->id)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('vendeur.orders.index') }}" class="text-indigo-600 hover:text-indigo-900 mb-4 inline-flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Retour aux commandes
        </a>
        
        <h1 class="text-3xl font-bold text-gray-900">Commande #{{ $order->id }}</h1>
        <p class="text-gray-600 mt-2">Détails de la commande pour vos produits</p>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Informations principales -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Informations de la commande</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Statut</h3>
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                            @if($order->status == 'en attente') bg-yellow-100 text-yellow-800
                            @elseif($order->status == 'en préparation') bg-blue-100 text-blue-800
                            @elseif($order->status == 'expédié') bg-purple-100 text-purple-800
                            @elseif($order->status == 'en livraison') bg-indigo-100 text-indigo-800
                            @elseif($order->status == 'livré') bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Date de commande</h3>
                        <p class="text-sm text-gray-900">{{ $order->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Total de la commande</h3>
                        <p class="text-sm text-gray-900">{{ number_format($order->total_price, 2) }} XOF</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Vos produits (Total)</h3>
                        <p class="text-lg font-semibold text-indigo-600">{{ number_format($vendorTotal, 2) }} XOF</p>
                    </div>
                </div>
            </div>
            
            <!-- Vos produits dans cette commande -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Vos produits commandés</h2>
                
                <div class="space-y-4">
                    @foreach($vendorProducts as $product)
                        @php
                            $quantity = $product->pivot->quantity ?? 1;
                            $price = $product->pivot->price ?? $product->price;
                            $subtotal = $quantity * $price;
                        @endphp
                        <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
                            <div class="flex-shrink-0">
                                <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-16 h-16 object-cover rounded-lg">
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <h3 class="text-sm font-medium text-gray-900">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $product->description }}</p>
                                <div class="mt-1 flex items-center space-x-4">
                                    <span class="text-sm text-gray-600">Quantité: {{ $quantity }}</span>
                                    <span class="text-sm text-gray-600">Prix unitaire: {{ number_format($price, 2) }} XOF</span>
                                    <span class="text-sm font-medium text-gray-900">Sous-total: {{ number_format($subtotal, 2) }} XOF</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Informations client et actions -->
        <div class="space-y-6">
            <!-- Informations client -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Informations client</h2>
                
                <div class="space-y-3">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Nom</h3>
                        <p class="text-sm text-gray-900">{{ $order->user->name ?? 'Client inconnu' }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Email</h3>
                        <p class="text-sm text-gray-900">{{ $order->user->email ?? 'Non renseigné' }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Téléphone</h3>
                        <p class="text-sm text-gray-900">{{ $order->user->phone_number ?? 'Non renseigné' }}</p>
                    </div>
                    
                    @if($order->delivery_address)
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Adresse de livraison</h3>
                            <p class="text-sm text-gray-900">{{ $order->delivery_address }}</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Actions</h2>
                
                @if($order->status == 'en attente')
                    <form method="POST" action="{{ route('vendeur.orders.prepare', $order->id) }}">
                        @csrf
                        <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 mb-3">
                            Marquer comme préparé
                        </button>
                    </form>
                @endif
                
                @if($order->status == 'en préparation')
                    <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    Vos produits sont marqués comme préparés. La commande sera expédiée une fois que tous les vendeurs auront préparé leurs produits.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                
                @if(in_array($order->status, ['expédié', 'en livraison', 'livré']))
                    <div class="bg-green-50 border border-green-200 rounded-md p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">
                                    La commande a été traitée et est en cours de livraison.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 