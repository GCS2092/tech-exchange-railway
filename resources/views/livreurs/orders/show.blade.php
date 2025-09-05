@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-slate-50 to-slate-100 py-6 sm:py-12">
    <div class="container max-w-5xl mx-auto px-4 sm:px-6">
        
        <!-- Navigation et redirections -->
        <x-livreur-smart-nav currentPage="order-details" :orderId="$order->id" />
        
        <!-- En-tête avec statut -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 sm:mb-8 gap-4">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-slate-800">
                Commande <span class="text-black font-extrabold">#{{ $order->id }}</span>
            </h1>
            <div class="flex items-center space-x-3">
                <span class="inline-flex items-center px-3 sm:px-4 py-1.5 rounded-full text-xs sm:text-sm font-medium
                    @switch($order->status)
                        @case('pending') bg-amber-100 text-amber-800 border border-amber-200 @break
                        @case('processing') bg-blue-100 text-blue-800 border border-blue-200 @break
                        @case('completed') bg-emerald-100 text-emerald-800 border border-emerald-200 @break
                        @case('cancelled') bg-rose-100 text-rose-800 border border-rose-200 @break
                    @endswitch
                ">
                    <span class="relative flex h-2 w-2 mr-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75
                            @switch($order->status)
                                @case('pending') bg-amber-500 @break
                                @case('processing') bg-blue-500 @break
                                @case('completed') bg-emerald-500 @break
                                @case('cancelled') bg-rose-500 @break
                            @endswitch
                        "></span>
                        <span class="relative inline-flex rounded-full h-2 w-2
                            @switch($order->status)
                                @case('pending') bg-amber-600 @break
                                @case('processing') bg-blue-600 @break
                                @case('completed') bg-emerald-600 @break
                                @case('cancelled') bg-rose-600 @break
                            @endswitch
                        "></span>
                    </span>
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>

        <!-- Carte principale -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg sm:shadow-xl overflow-hidden mb-6 sm:mb-8">
            <!-- Section Client & Récapitulatif -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 p-4 sm:p-6 border-b border-gray-100">
                <!-- Informations client -->
                <div class="space-y-4 sm:space-y-6">
                    <div class="flex items-center">
                        <h2 class="text-lg sm:text-xl font-semibold text-black">Informations Client</h2>
                        <div class="ml-3 bg-indigo-100 text-black text-xs font-semibold px-2 py-0.5 rounded-full">Client</div>
                    </div>
                    
                    <div class="bg-slate-50 rounded-lg sm:rounded-xl p-3 sm:p-4">
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-indigo-100 p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-black" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="ml-3 text-sm sm:text-base text-gray-700 break-all">{{ $order->user->name }}</span>
                            </div>
                            
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-indigo-100 p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-black" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </div>
                                <span class="ml-3 text-sm sm:text-base text-gray-700 break-all">{{ $order->user->email }}</span>
                            </div>
                            
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-indigo-100 p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-black" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                    </svg>
                                </div>
                                <span class="ml-3 text-sm sm:text-base text-gray-700">{{ $order->phone_number }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Récapitulatif -->
                <div class="space-y-3 sm:space-y-4">
                    <div class="flex justify-between items-center pb-2 sm:pb-3 border-b border-indigo-100">
                        <span class="text-sm sm:text-base text-gray-600">Date de commande</span>
                        <span class="text-sm sm:text-base font-medium text-black">{{ $order->created_at->format('d/m/Y') }}</span>
                    </div>
                
                    <div class="flex justify-between items-center pb-2 sm:pb-3 border-b border-indigo-100">
                        <span class="text-sm sm:text-base text-gray-600">Nombre de produits</span>
                        <span class="text-sm sm:text-base font-medium text-black">{{ $order->products->count() }}</span>
                    </div>
                
                    @php
                        $promoUsage = $order->promoUsage ?? null;
                    @endphp
                
                    <div class="flex justify-between items-center pb-2 sm:pb-3 border-b border-indigo-100">
                        <span class="text-sm sm:text-base text-gray-600">Montant initial</span>
                        <span class="text-sm sm:text-base font-medium text-black">
                                                            {{ isset($promoUsage) ? number_format($promoUsage->original_amount, 0, ',', ' ') : number_format($order->total_price, 0, ',', ' ') }} FCFA
                        </span>
                    </div>
                
                    @if ($promoUsage)
                        <div class="flex justify-between items-center pb-2 sm:pb-3 border-b border-indigo-100">
                            <span class="text-sm sm:text-base text-gray-600">Réduction appliquée</span>
                            <span class="text-sm sm:text-base font-medium text-red-600">- {{ number_format($promoUsage->discount_amount, 0, ',', ' ') }} FCFA</span>
                        </div>
                
                        <div class="flex justify-between items-center pt-1 sm:pt-2">
                            <span class="text-sm sm:text-base text-gray-600">Total payé</span>
                            <span class="text-sm sm:text-base font-bold text-gray-900">{{ number_format($promoUsage->final_amount, 0, ',', ' ') }} FCFA</span>
                        </div>
                    @else
                        <div class="flex justify-between items-center pt-1 sm:pt-2">
                            <span class="text-sm sm:text-base text-gray-600">Total payé</span>
                            <span class="text-sm sm:text-base font-bold text-gray-900">{{ number_format($order->total_price, 0, ',', ' ') }} FCFA</span>
                        </div>
                    @endif
                </div>
                
            </div>


            
            <!-- Section Produits -->
            <div class="p-4 sm:p-6">
                <h2 class="text-lg sm:text-xl font-semibold text-black mb-4 sm:mb-6">
                    <span class="inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-black" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
                        </svg>
                        Produits Commandés
                    </span>
                </h2>
                
                <div class="overflow-x-auto rounded-lg sm:rounded-xl border border-gray-100 shadow">
                    <table class="w-full min-w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-indigo-50 to-purple-50 text-gray-700 text-xs sm:text-sm uppercase tracking-wider">
                                <th class="py-2 sm:py-3 px-2 sm:px-4 text-left font-semibold">Produit</th>
                                <th class="py-2 sm:py-3 px-2 sm:px-4 text-center font-semibold">Image</th>
                                <th class="py-2 sm:py-3 px-2 sm:px-4 text-right font-semibold">Prix</th>
                                <th class="py-2 sm:py-3 px-2 sm:px-4 text-right font-semibold">Qté</th>
                                <th class="py-2 sm:py-3 px-2 sm:px-4 text-right font-semibold">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($order->products as $product)
                            <tr class="hover:bg-slate-50 transition-colors duration-150">
                                <td class="py-3 sm:py-4 px-2 sm:px-4">
                                    <div class="font-medium text-xs sm:text-sm text-black break-words">{{ $product->name }}</div>
                                    <div class="text-xs text-gray-500 mt-1">{{ Str::limit($product->description, 50) }}</div>
                                </td>
                                <td class="py-3 sm:py-4 px-2 sm:px-4 text-center">
                                    <div class="relative flex justify-center">
                                        <img src="{{ asset('storage/'.$product->image) }}" 
                                             class="w-12 h-12 sm:w-16 sm:h-16 object-cover rounded-lg shadow-sm border border-gray-200" 
                                             alt="{{ $product->name }}">
                                    </div>
                                </td>
                                <td class="py-3 sm:py-4 px-2 sm:px-4 text-right text-xs sm:text-sm text-gray-700">{{ number_format($product->price, 2) }} FCFA</td>
                                <td class="py-3 sm:py-4 px-2 sm:px-4 text-right">
                                    <span class="inline-flex items-center justify-center bg-indigo-100 text-indigo-800 rounded-full w-6 h-6 sm:w-8 sm:h-8 text-xs sm:text-sm font-medium">
                                        {{ $product->pivot->quantity }}
                                    </span>
                                </td>
                                <td class="py-3 sm:py-4 px-2 sm:px-4 text-right text-xs sm:text-sm font-bold text-black">
                                    {{ number_format($product->price * $product->pivot->quantity, 2) }} FCFA
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-slate-50 font-semibold text-black">
                                <td colspan="4" class="py-3 sm:py-4 px-3 sm:px-6 text-right text-xs sm:text-sm">Total</td>
                                <td class="py-3 sm:py-4 px-2 sm:px-4 text-right text-sm sm:text-lg text-black font-bold">
                                    {{ number_format($order->total_price, 2) }} FCFA
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Historique de la commande -->
            <div class="p-4 sm:p-6 border-t border-gray-100 bg-gray-50">
                <h2 class="text-lg sm:text-xl font-semibold text-black mb-3 sm:mb-4">
                    <span class="inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-black" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                        </svg>
                        Historique de la commande
                    </span>
                </h2>
                
                <div class="relative pl-8 border-l-2 border-indigo-200 space-y-4">
                    <!-- Création de la commande -->
                    <div class="relative">
                        <div class="absolute -left-10 mt-1 w-5 h-5 rounded-full bg-indigo-600 border-4 border-white shadow"></div>
                        <div class="bg-white p-3 rounded-lg shadow-sm">
                            <div class="text-xs text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                            <div class="font-medium text-black">Commande créée</div>
                            <div class="text-sm text-gray-600">Commande #{{ $order->id }} créée par {{ $order->user->name }}</div>
                        </div>
                    </div>
                    
                    <!-- Ajoutez d'autres événements d'historique si disponibles -->
                    @if($order->updated_at->gt($order->created_at))
                    <div class="relative">
                        <div class="absolute -left-10 mt-1 w-5 h-5 rounded-full bg-blue-500 border-4 border-white shadow"></div>
                        <div class="bg-white p-3 rounded-lg shadow-sm">
                            <div class="text-xs text-gray-500">{{ $order->updated_at->format('d/m/Y H:i') }}</div>
                            <div class="font-medium text-black">Mise à jour du statut</div>
                            <div class="text-sm text-gray-600">Statut modifié en <span class="font-medium
                                @switch($order->status)
                                    @case('pending') text-amber-600 @break
                                    @case('processing') text-blue-600 @break
                                    @case('completed') text-emerald-600 @break
                                    @case('cancelled') text-rose-600 @break
                                @endswitch
                            ">{{ ucfirst($order->status) }}</span></div>
                        </div>
                    </div>
                    @endif
                    
                    @if($order->livreur_id)
                    <div class="relative">
                        <div class="absolute -left-10 mt-1 w-5 h-5 rounded-full bg-green-500 border-4 border-white shadow"></div>
                        <div class="bg-white p-3 rounded-lg shadow-sm">
                            <div class="text-xs text-gray-500">{{ $order->updated_at->format('d/m/Y H:i') }}</div>
                            <div class="font-medium text-black">Livreur assigné</div>
                            <div class="text-sm text-gray-600">
                                Livraison assignée à 
                                <span class="font-medium text-black">{{ $livreurs->where('id', $order->livreur_id)->first()->name ?? 'Inconnu' }}</span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Mise à jour du statut -->
            <div class="p-4 sm:p-6 bg-white border-t border-gray-100">
                <h2 class="text-lg sm:text-xl font-semibold text-black mb-3 sm:mb-4">
                    <span class="inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-black" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                        </svg>
                        Modifier le statut
                    </span>
                </h2>
                
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4">
                    @csrf
                    @method('PUT')
                    <div class="relative flex-grow">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Nouveau statut :</label>
                        <select name="status" id="status" class="block w-full pl-3 sm:pl-4 pr-8 sm:pr-10 py-2 sm:py-3 text-sm sm:text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-lg shadow-sm appearance-none">
                            @foreach (\App\Models\Order::STATUSES as $key => $label)
                                <option value="{{ $key }}" {{ $order->status === $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 pt-5 text-gray-700">
                            <svg class="h-4 w-4 sm:h-5 sm:w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <div class="pt-6">
                        <button type="submit" class="flex items-center justify-center w-full sm:w-auto px-4 sm:px-6 py-2 sm:py-3 bg-indigo-600 text-white text-sm sm:text-base font-medium rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-300 transform hover:-translate-y-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                            </svg>
                            <span>Mettre à jour</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Boutons d'action -->
        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center sm:justify-end">
            <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 border border-gray-300 shadow-sm text-sm sm:text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                <span>Retour</span>
            </a>
            <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank"
       class="inline-flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 border border-transparent shadow-sm text-sm sm:text-base font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                </svg>
                <span>Télécharger la facture</span>
            </a>
            
            @if($order->status !== 'cancelled')
            <button type="button" 
                onclick="if(confirm('Êtes-vous sûr de vouloir annuler cette commande ?')) { document.getElementById('cancel-form').submit(); }"
                class="inline-flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 border border-transparent shadow-sm text-sm sm:text-base font-medium rounded-lg text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                <span>Annuler la commande</span>
            </button>
            
            <form id="cancel-form" action="{{ route('admin.orders.index', $order->id) }}" method="POST" class="hidden">
                @csrf
                @method('PUT')
            </form>
            @endif  
        </div>
        
        <!-- Notification en cas de succès -->
        @if(session('status'))
        <div class="mt-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md animate-pulse">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-black" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">{{ session('status') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button type="button" onclick="this.parentElement.parentElement.parentElement.remove()" 
                                class="inline-flex rounded-md p-1.5 text-black hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <span class="sr-only">Dismiss</span>
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Informations de livraison (si livreur assigné) -->
        @if($order->livreur_id && isset($livreurs) && ($livreur = $livreurs->where('id', $order->livreur_id)->first()))
        <div class="mt-6 bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 bg-gradient-to-r from-indigo-500 to-purple-600">
                <h3 class="text-lg leading-6 font-medium text-white">Informations de livraison</h3>
                <p class="mt-1 max-w-2xl text-sm text-indigo-100">Détails concernant le livreur assigné</p>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-black mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm font-medium text-gray-600">Nom du livreur:</span>
                            <span class="ml-2 text-sm text-gray-900">{{ $livreur->name }}</span>
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-black mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                            <span class="text-sm font-medium text-gray-600">Email:</span>
                            <span class="ml-2 text-sm text-gray-900">{{ $livreur->email }}</span>
                        </div>
                        @if(isset($livreur->phone))
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-black mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                            </svg>
                            <span class="text-sm font-medium text-gray-600">Téléphone:</span>
                            <span class="ml-2 text-sm text-gray-900">{{ $livreur->phone }}</span>
                        </div>
                        @endif
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="text-sm font-medium text-gray-700 mb-2">Statut de livraison</div>
                        @php
                            $deliveryStatus = $order->delivery_status ?? 'pending';
                            $statusColors = [
                                'pending' => 'bg-amber-100 text-amber-800',
                                'in_transit' => 'bg-blue-100 text-blue-800',
                                'delivered' => 'bg-green-100 text-green-800',
                                'failed' => 'bg-red-100 text-red-800'
                            ];
                            $statusText = [
                                'pending' => 'En attente',
                                'in_transit' => 'En transit',
                                'delivered' => 'Livré',
                                'failed' => 'Échec de livraison'
                            ];
                        @endphp
                        
                        <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $statusColors[$deliveryStatus] ?? $statusColors['pending'] }}">
                            {{ $statusText[$deliveryStatus] ?? 'En attente' }}
                        </div>
                        
                        <div class="mt-3 text-xs text-gray-600">
                            @if($deliveryStatus === 'delivered')
                                Livré le {{ now()->format('d/m/Y à H:i') }}
                            @elseif($deliveryStatus === 'in_transit')
                                En cours de livraison
                            @elseif($deliveryStatus === 'failed')
                                Échec de livraison - voir commentaires
                            @else
                                En attente de prise en charge
                            @endif
                        </div>
                    </div>
                </div>
                
                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'livreur')
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h4 class="text-base font-medium text-black mb-3">Notes de livraison</h4>
                    <form action="{{ route('admin.orders.updateDeliveryNotes', $order->id) }}" method="POST" class="space-y-3">
                        @csrf
                        @method('PUT')
                        <textarea name="delivery_notes" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Ajoutez des notes concernant la livraison...">{{ $order->delivery_notes ?? '' }}</textarea>
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Enregistrer les notes
                            </button>
                        </div>
                    </form>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

@endsection