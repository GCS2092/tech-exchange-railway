@extends('layouts.app')

@section('title', 'Mes Commandes - Vendeur')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Mes Commandes</h1>
        
        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Commandes</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_orders'] }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">En Attente</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['pending_orders'] }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Livrées</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['completed_orders'] }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Revenus</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_revenue'], 2) }} XOF</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Filtres -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <form method="GET" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-48">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                    <select name="status" id="status" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Tous les statuts</option>
                        <option value="en attente" {{ request('status') == 'en attente' ? 'selected' : '' }}>En attente</option>
                        <option value="en préparation" {{ request('status') == 'en préparation' ? 'selected' : '' }}>En préparation</option>
                        <option value="expédié" {{ request('status') == 'expédié' ? 'selected' : '' }}>Expédié</option>
                        <option value="en livraison" {{ request('status') == 'en livraison' ? 'selected' : '' }}>En livraison</option>
                        <option value="livré" {{ request('status') == 'livré' ? 'selected' : '' }}>Livré</option>
                    </select>
                </div>
                
                <div class="flex-1 min-w-48">
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                    <input type="date" name="date" id="date" value="{{ request('date') }}" 
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Filtrer
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Liste des commandes -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($orders->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Commande #
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Client
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Mes Produits
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total (Mes produits)
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($orders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $order->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $order->user->name ?? 'Client inconnu' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    @php
                                        $vendorProducts = $order->products->where('seller_id', auth()->id());
                                        $vendorTotal = 0;
                                    @endphp
                                    <ul class="list-disc list-inside">
                                        @foreach($vendorProducts as $product)
                                            @php
                                                $quantity = $product->pivot->quantity ?? 1;
                                                $price = $product->pivot->price ?? $product->price;
                                                $vendorTotal += $quantity * $price;
                                            @endphp
                                            <li>{{ $product->name }} (x{{ $quantity }})</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ number_format($vendorTotal, 2) }} XOF
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        @if($order->status == 'en attente') bg-yellow-100 text-yellow-800
                                        @elseif($order->status == 'en préparation') bg-blue-100 text-blue-800
                                        @elseif($order->status == 'expédié') bg-purple-100 text-purple-800
                                        @elseif($order->status == 'en livraison') bg-indigo-100 text-indigo-800
                                        @elseif($order->status == 'livré') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('vendeur.orders.show', $order->id) }}" 
                                       class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        Voir
                                    </a>
                                    @if($order->status == 'en attente')
                                        <form method="POST" action="{{ route('vendeur.orders.prepare', $order->id) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900">
                                                Marquer comme préparé
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $orders->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune commande</h3>
                <p class="mt-1 text-sm text-gray-500">Vous n'avez pas encore reçu de commandes pour vos produits.</p>
            </div>
        @endif
    </div>
</div>
@endsection 