@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-slate-50 to-slate-100 py-6 sm:py-12">
    <div class="container max-w-5xl mx-auto px-4 sm:px-6">
        <!-- En-tête avec statut -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 sm:mb-8 gap-4">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-slate-800">
                Commande <span class="text-indigo-600 font-extrabold">#{{ $order->id }}</span>
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
                        <h2 class="text-lg sm:text-xl font-semibold text-gray-800">Informations Client</h2>
                        <div class="ml-3 bg-indigo-100 text-indigo-700 text-xs font-semibold px-2 py-0.5 rounded-full">Client</div>
                    </div>
                    
                    <div class="bg-slate-50 rounded-lg sm:rounded-xl p-3 sm:p-4">
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-indigo-100 p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="ml-3 text-sm sm:text-base text-gray-700 break-all">{{ $order->user->name }}</span>
                            </div>
                            
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-indigo-100 p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </div>
                                <span class="ml-3 text-sm sm:text-base text-gray-700 break-all">{{ $order->user->email }}</span>
                            </div>
                            
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-indigo-100 p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
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
                        <span class="text-sm sm:text-base font-medium text-gray-800">{{ $order->created_at->format('d/m/Y') }}</span>
                    </div>
                
                    <div class="flex justify-between items-center pb-2 sm:pb-3 border-b border-indigo-100">
                        <span class="text-sm sm:text-base text-gray-600">Nombre de produits</span>
                        <span class="text-sm sm:text-base font-medium text-gray-800">{{ $order->products->count() }}</span>
                    </div>
                
                    <div class="flex justify-between items-center pb-2 sm:pb-3 border-b border-indigo-100">
                        <span class="text-sm sm:text-base text-gray-600">Montant initial</span>
                        <span class="text-sm sm:text-base font-medium text-gray-800">
                            {{ number_format($order->original_price ?? $order->total_price, 0, ',', ' ') }} FCFA
                        </span>
                    </div>
                
                    @if ($order->discount_amount > 0)
                        <div class="flex justify-between items-center pb-2 sm:pb-3 border-b border-indigo-100">
                            <span class="text-sm sm:text-base text-gray-600">Réduction appliquée</span>
                            <span class="text-sm sm:text-base font-medium text-red-600">- {{ number_format($order->discount_amount, 0, ',', ' ') }} FCFA</span>
                        </div>
                
                        <div class="flex justify-between items-center pt-1 sm:pt-2">
                            <span class="text-sm sm:text-base text-gray-600">Total payé</span>
                            <span class="text-sm sm:text-base font-bold text-gray-900">{{ number_format($order->total_price, 0, ',', ' ') }} FCFA</span>
                        </div>
                    @else
                        <div class="flex justify-between items-center pt-1 sm:pt-2">
                            <span class="text-sm sm:text-base text-gray-600">Total payé</span>
                            <span class="text-sm sm:text-base font-bold text-gray-900">{{ number_format($order->total_price, 0, ',', ' ') }} FCFA</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Formulaire d'assignation de livreur -->
            <div class="p-4 sm:p-6 border-b border-gray-100 bg-gray-50">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-800 mb-3 sm:mb-4">
                    <span class="inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1v-5h2a2 2 0 110 4h-1.05a2.5 2.5 0 014.9 0H17a1 1 0 001-1v-1a1 1 0 00-.29-.71l-4-4A1 1 0 0013 6h-1a1 1 0 00-1-1H3z" />
                        </svg>
                        Attribuer un livreur
                    </span>
                </h2>
                
                <form method="POST" action="{{ route('admin.orders.assignLivreur', $order->id) }}" class="space-y-3">
                    @csrf
                    <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                        <select name="livreur_id" id="livreur_id" class="flex-grow rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- Sélectionner un livreur --</option>
                            @foreach($livreurs as $livreur)
                                <option value="{{ $livreur->id }}" {{ $order->livreur_id == $livreur->id ? 'selected' : '' }}>
                                    {{ $livreur->name }} ({{ $livreur->email }})
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M8 9a3 3 0 100-6 3 3 0 000 6z" />
                                <path fill-rule="evenodd" d="M8 10a4 4 0 10-3.835-5.185.5.5 0 00-.871.49 5 5 0 01-1.207 5.186.5.5 0 00.034.707A4.001 4.001 0 008 10z" clip-rule="evenodd" />
                            </svg>
                            Assigner
                        </button>
                    </div>
                    
                    @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mt-3 rounded">
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                    @endif
                    
                    @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mt-3 rounded">
                        <p class="font-medium">{{ session('error') }}</p>
                    </div>
                    @endif
                </form>
            </div>
            
            <!-- Section Produits -->
            <div class="p-4 sm:p-6">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-800 mb-4 sm:mb-6">
                    <span class="inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
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
                            @foreach($order->products as $product)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4 text-sm text-gray-900">{{ $product->name }}</td>
                                <td class="py-3 px-4 text-center">
                                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="h-12 w-12 object-cover rounded-lg mx-auto">
                                </td>
                                <td class="py-3 px-4 text-sm text-right text-gray-900">{{ number_format($product->pivot->price, 0, ',', ' ') }} FCFA</td>
                                <td class="py-3 px-4 text-sm text-right text-gray-900">{{ $product->pivot->quantity }}</td>
                                <td class="py-3 px-4 text-sm text-right text-gray-900">{{ number_format($product->pivot->price * $product->pivot->quantity, 0, ',', ' ') }} FCFA</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Formulaire de changement de statut -->
            <div class="p-4 sm:p-6 border-t border-gray-100">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-800 mb-4">
                    <span class="inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                        </svg>
                        Changer le statut de la commande
                    </span>
                </h2>

                <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                        <select name="status" id="status" class="flex-grow rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach(\App\Models\Order::STATUSES as $key => $value)
                                <option value="{{ $key }}" {{ $order->status === $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        
                        <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                            </svg>
                            Mettre à jour le statut
                        </button>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
                            <p class="font-medium">{{ session('success') }}</p>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 