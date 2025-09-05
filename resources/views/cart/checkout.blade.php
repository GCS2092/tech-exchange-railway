@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-blue-50 py-12 relative overflow-hidden">
    <!-- Animated background elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-indigo-400/20 to-purple-400/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-tr from-blue-400/20 to-indigo-400/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-r from-purple-400/10 to-pink-400/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 4s;"></div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl relative z-10">
        <!-- Enhanced Header with floating animation -->
        <div class="text-center mb-12 transform transition duration-700 hover:scale-105">
            <div class="inline-block relative">
                <h1 class="text-xl md:text-2xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-purple-600 to-blue-600 mb-4 animate-gradient">
                    Finaliser votre commande
                </h1>
                <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-32 h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-blue-500 rounded-full animate-pulse"></div>
            </div>
            <p class="text-lg text-gray-600 mt-4 max-w-2xl mx-auto">Complétez vos informations pour finaliser votre commande en toute sécurité</p>
        </div>

        <div class="lg:flex gap-8 items-start">
            <!-- Enhanced Left column: Order summary -->
            <div class="lg:w-1/2 mb-8 lg:mb-0">
                <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden border border-white/20 transition-all duration-500 hover:shadow-indigo-200/50 hover:scale-[1.02] group">
                    <!-- Enhanced Summary header -->
                    <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-blue-600 px-8 py-6 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent"></div>
                        <div class="relative z-10">
                            <h2 class="text-2xl font-bold text-white flex items-center">
                                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3 backdrop-blur-sm">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                                Résumé de votre commande
                            </h2>
                            <p class="text-indigo-100 mt-1">Vérifiez vos articles avant de confirmer</p>
                        </div>
                    </div>
                    
                    <!-- Enhanced Product list -->
                    <div class="p-8">
                        <div class="space-y-4 max-h-80 overflow-y-auto custom-scrollbar">
                            @foreach ($cart as $item)
                            <div class="flex justify-between items-center p-4 rounded-2xl transition-all duration-300 hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 border border-transparent hover:border-indigo-100 group transform hover:scale-[1.02] hover:shadow-lg">
                                <div class="flex items-center">
                                    <div class="w-20 h-20 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-2xl overflow-hidden shadow-lg group-hover:shadow-xl transition-all duration-300 transform group-hover:scale-110 relative">
                                        <img src="{{ $item['image'] ?? asset('images/default-product.png') }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover" onerror="this.onerror=null;this.src='{{ asset('images/default-product.png') }}';">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="font-semibold text-gray-800 group-hover:text-indigo-700 transition-colors duration-300 text-lg">{{ $item['name'] }}</h3>
                                        <div class="flex items-center mt-2">
                                            <span class="px-3 py-1 bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-700 rounded-full text-sm font-medium border border-indigo-200">
                                                Qté: {{ $item['quantity'] }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="font-bold text-gray-800 bg-gradient-to-r from-indigo-50 to-purple-50 px-4 py-2 rounded-xl shadow-sm item-price transition-all duration-300 border border-indigo-100" data-price="{{ $item['price'] * $item['quantity'] }}">
                                        {{ \App\Helpers\CurrencyHelper::format($item['price'] * $item['quantity'], 'XOF') }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <!-- Enhanced animated separator -->
                        <div class="relative h-1 w-full bg-gradient-to-r from-gray-100 to-gray-200 my-8 overflow-hidden rounded-full">
                            <div class="absolute top-0 left-0 h-full w-1/2 bg-gradient-to-r from-indigo-500 via-purple-500 to-blue-500 animate-pulse rounded-full"></div>
                        </div>
                        
                        <!-- Enhanced Total with animation -->
                        <div class="flex justify-between items-center py-6 transform transition duration-500 hover:scale-105 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl px-6 border border-indigo-100">
                            <div>
                                <span class="text-2xl font-bold text-gray-700">Total:</span>
                                <p class="text-sm text-gray-500 mt-1">Inclut tous les frais</p>
                            </div>
                            <div class="text-right">
                                <span id="summary-total" class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-purple-600 to-blue-600" data-total="{{ $total }}">
                                    {{ \App\Helpers\CurrencyHelper::format($total, 'XOF') }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Enhanced Currency selector -->
                        <div class="mt-8">
                            <label for="currency-selector" class="block text-sm font-medium text-gray-700 mb-3 flex items-center">
                                <div class="w-6 h-6 bg-gradient-to-r from-indigo-100 to-purple-100 rounded-lg flex items-center justify-center mr-2">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                Choisir votre devise:
                            </label>
                            <div class="relative group">
                                <select id="currency-selector" class="w-full appearance-none bg-white border-2 border-indigo-200 text-gray-700 py-4 px-6 pr-12 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-[1.02]">
                                    <option value="XOF">FCFA</option>
                                    <option value="XOF">XOF (FCFA)</option>
                                    <option value="USD">USD ($)</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-indigo-500">
                                    <svg class="fill-current h-6 w-6 transition-transform duration-300 group-hover:rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Enhanced Return button -->
                        <div class="mt-8">
                            <a href="{{ route('cart.index') }}" class="w-full bg-gradient-to-r from-gray-50 to-gray-100 border-2 border-indigo-200 text-indigo-700 hover:from-indigo-50 hover:to-purple-50 hover:border-indigo-300 font-semibold py-4 px-6 rounded-2xl flex items-center justify-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-[1.02] group">
                                <svg class="w-5 h-5 mr-3 transform transition group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Retour au panier
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Enhanced Right column: Payment form -->
            <div class="lg:w-1/2">
                <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden border border-white/20 transition-all duration-500 hover:shadow-indigo-200/50 hover:scale-[1.02] group">
                    <!-- Enhanced Form header -->
                    <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-blue-600 px-8 py-6 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent"></div>
                        <div class="relative z-10">
                            <h2 class="text-2xl font-bold text-white flex items-center">
                                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3 backdrop-blur-sm">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                Informations de paiement
                            </h2>
                            <p class="text-indigo-100 mt-1">Remplissez vos informations pour finaliser</p>
                        </div>
                    </div>
                    
                    <div class="p-8">
                        <form id="paymentForm" action="{{ route('order.store') }}" method="POST">
                            @csrf
                            <!-- Selected currency -->
                            <input type="hidden" name="currency" id="selected-currency" value="XOF">
                            
                            <!-- Enhanced Alert message -->
                            @if ($total < 100)
                            <div class="relative overflow-hidden bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 text-red-700 p-6 rounded-2xl mb-8 animate-pulse shadow-lg">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold">Montant minimum requis</p>
                                        <p class="text-sm mt-1">Le montant minimum pour passer une commande est de <strong>100 FCFA</strong>.</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            <!-- Enhanced Phone number -->
                            <div class="mb-8 transform transition duration-300 hover:translate-x-1">
                                <label for="phone_number" class="block text-gray-700 mb-3 font-semibold flex items-center">
                                    <div class="w-6 h-6 bg-gradient-to-r from-indigo-100 to-purple-100 rounded-lg flex items-center justify-center mr-2">
                                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                    </div>
                                    Numéro de téléphone
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-indigo-400 group-focus-within:text-indigo-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                    </div>
                                    <input type="tel" name="phone_number" id="phone_number" placeholder="Votre numéro" 
                                           pattern="\+?\d{8,15}" 
                                           title="Le numéro doit contenir entre 8 et 15 chiffres, avec un + optionnel au début"
                                           class="w-full bg-gray-50 border-2 border-gray-200 rounded-2xl py-4 pl-12 pr-4 text-gray-800 focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-300 shadow-lg focus:shadow-xl placeholder-gray-400 transform focus:scale-[1.02]" required>
                                </div>
                            </div>

                            <!-- Enhanced Payment method -->
                            <div class="mb-8 transform transition duration-300 hover:translate-x-1">
                                <label for="payment_method" class="block text-gray-700 mb-3 font-semibold flex items-center">
                                    <div class="w-6 h-6 bg-gradient-to-r from-indigo-100 to-purple-100 rounded-lg flex items-center justify-center mr-2">
                                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                        </svg>
                                    </div>
                                    Mode de paiement
                                </label>
                                <div class="relative group">
                                    <select name="payment_method" id="payment_method" required
                                           class="w-full bg-gray-50 border-2 border-gray-200 rounded-2xl py-4 px-4 text-gray-800 focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-300 shadow-lg focus:shadow-xl appearance-none transform focus:scale-[1.02]">
                                        <option value="">-- Choisir --</option>
                                        <option value="livraison" class="py-2">Paiement à la livraison</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-indigo-500">
                                        <svg class="fill-current h-6 w-6 transition-transform duration-300 group-hover:rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Enhanced Delivery address -->
                            <div class="mb-8 transform transition duration-300 hover:translate-x-1">
                                <label for="delivery_address" class="block text-gray-700 mb-3 font-semibold flex items-center">
                                    <div class="w-6 h-6 bg-gradient-to-r from-indigo-100 to-purple-100 rounded-lg flex items-center justify-center mr-2">
                                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    Adresse de livraison
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-indigo-400 group-focus-within:text-indigo-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" name="delivery_address" id="delivery_address" placeholder="Votre adresse complète" 
                                           class="w-full bg-gray-50 border-2 border-gray-200 rounded-2xl py-4 pl-12 pr-4 text-gray-800 focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-300 shadow-lg focus:shadow-xl placeholder-gray-400 transform focus:scale-[1.02]" required>
                                </div>
                            </div>

                            <!-- Enhanced Confirmation checkbox -->
                            <div class="mb-8">
                                <label class="flex items-center gap-4 cursor-pointer select-none {{ $total < 100 ? 'opacity-50' : '' }} hover:text-indigo-700 transition-colors p-4 rounded-2xl hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50">
                                    <input type="checkbox" id="confirmOrder" name="confirm_order" class="sr-only" required {{ $total < 100 ? 'disabled' : '' }}>
                                    <div class="w-7 h-7 border-2 border-gray-300 rounded-lg flex items-center justify-center transition-all duration-300 hover:border-indigo-400 hover:scale-110">
                                        <div class="checkbox-checked w-5 h-5 text-white scale-0 transition duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    </div>
                                    <span class="text-gray-700 font-medium">Je confirme ma commande et accepte les conditions</span>
                                </label>
                            </div>
                            
                            <!-- Enhanced Payment button -->
                            <div class="flex flex-col gap-4">
                                <button type="submit" class="group w-full relative overflow-hidden bg-gradient-to-r from-green-500 via-emerald-500 to-teal-500 hover:from-green-600 hover:via-emerald-600 hover:to-teal-600 text-white py-5 rounded-2xl font-bold flex items-center justify-center transition-all duration-300 transform hover:scale-[1.02] {{ $total < 100 ? 'opacity-50 cursor-not-allowed' : '' }} shadow-2xl hover:shadow-green-500/25" {{ $total < 100 ? 'disabled' : '' }}>
                                    <span class="relative z-10 flex items-center text-lg">
                                        <svg class="w-6 h-6 mr-3 transition-transform group-hover:rotate-[-10deg]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Confirmer et payer à la livraison
                                    </span>
                                    <div class="absolute top-0 -inset-full h-full w-1/2 z-5 block transform -skew-x-12 bg-gradient-to-r from-transparent to-white opacity-20 group-hover:animate-shine"></div>
                                </button>
                            </div>

                            <!-- Hidden geolocation fields -->
                            <input type="hidden" name="latitude" id="latitude">
                            <input type="hidden" name="longitude" id="longitude">
                        </form>

                        <!-- Enhanced Geolocation information section -->
                        <div class="mt-8 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl border border-blue-200 shadow-lg">
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-gradient-to-r from-blue-100 to-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-blue-800 text-lg">Localisation pour la livraison</h3>
                                    <p class="text-blue-600 mt-2">Votre position sera utilisée pour faciliter la livraison. Notre livreur utilisera ces coordonnées pour vous trouver facilement.</p>
                                    <div class="flex items-center mt-3">
                                        <div id="geolocation-status" class="flex items-center">
                                            <span class="inline-block w-3 h-3 rounded-full bg-gray-300 mr-2 animate-pulse"></span>
                                            <span class="text-sm text-gray-500">En attente de localisation...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Enhanced Secure delivery information -->
                        <div class="mt-6 flex items-center justify-center text-sm text-gray-500 bg-gradient-to-r from-green-50 to-emerald-50 p-4 rounded-2xl border border-green-200">
                            <div class="w-5 h-5 bg-gradient-to-r from-green-100 to-emerald-100 rounded-lg flex items-center justify-center mr-2">
                                <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                </svg>
                            </div>
                            Livraison suivie par géolocalisation
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(isset($order->estimated_time_min))
<div class="mt-6 text-center">
    <div class="inline-flex items-center bg-gradient-to-r from-orange-50 to-yellow-50 px-6 py-3 rounded-2xl border border-orange-200 shadow-lg">
        <svg class="w-5 h-5 text-orange-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span class="text-orange-700 font-medium">
            Livraison estimée dans <strong>{{ $order->estimated_time_min }} minutes</strong>
            (distance : {{ $order->distance_km }} km)
        </span>
    </div>
</div>
@endif

<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 8px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: #f3f4f6;
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: linear-gradient(to bottom, #6366f1, #8b5cf6);
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(to bottom, #4f46e5, #7c3aed);
}

@keyframes shine {
    100% {
        left: 125%;
    }
}
.animate-shine {
    animation: shine 1.5s;
}

@keyframes gradient {
    0%, 100% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
}
.animate-gradient {
    background-size: 200% 200%;
    animation: gradient 3s ease infinite;
}

/* Enhanced hover effects */
.group:hover .group-hover\:scale-\[1\.02\] {
    transform: scale(1.02);
}

/* Smooth transitions for all elements */
* {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 300ms;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const paymentForm = document.getElementById('paymentForm');
    const phoneNumberInput = document.getElementById('phone_number');
    const confirmOrderCheckbox = document.getElementById('confirmOrder');
    const geoStatusElement = document.getElementById('geolocation-status');
    const currencySelector = document.getElementById('currency-selector');
    const summaryTotal = document.getElementById('summary-total');
    const selectedCurrency = document.getElementById('selected-currency');
    const itemPrices = document.querySelectorAll('.item-price');
    
    // Currency configuration
    const currencies = {
        'XOF': { rate: 1, symbol: 'FCFA' },
        'XOF': { rate: 1, symbol: 'FCFA' },
        'USD': { rate: 0.0017, symbol: '$' }
    };
    
    // 1. Enhanced Checkbox styling
    if (confirmOrderCheckbox) {
        confirmOrderCheckbox.addEventListener('change', function() {
            const checkBox = this.parentElement.querySelector('div:nth-child(2)');
            const checkIcon = this.parentElement.querySelector('.checkbox-checked');
            
            if (this.checked) {
                checkBox.classList.add('bg-gradient-to-r', 'from-indigo-600', 'to-purple-600', 'border-indigo-600');
                checkIcon.classList.replace('scale-0', 'scale-100');
            } else {
                checkBox.classList.remove('bg-gradient-to-r', 'from-indigo-600', 'to-purple-600', 'border-indigo-600');
                checkIcon.classList.replace('scale-100', 'scale-0');
            }
        });
    }
    
    // 2. Enhanced Phone number validation
    if (phoneNumberInput) {
        phoneNumberInput.addEventListener('blur', function() {
            const phoneRegex = /^\+?\d{8,15}$/;
            const errorClass = 'border-red-500';
            const errorMsgClass = 'error-message';
            
            // Find existing error message if any
            let errorMsg = this.nextElementSibling;
            if (errorMsg && !errorMsg.classList.contains(errorMsgClass)) {
                errorMsg = null;
            }
            
            if (!phoneRegex.test(this.value) && this.value !== '') {
                // Add error class
                this.classList.add(errorClass);
                
                // Add error message if it doesn't exist
                if (!errorMsg) {
                    errorMsg = document.createElement('p');
                    errorMsg.className = 'text-red-500 text-sm mt-2 ' + errorMsgClass;
                    errorMsg.textContent = 'Le numéro doit contenir entre 8 et 15 chiffres, avec un + optionnel au début';
                    this.parentNode.appendChild(errorMsg);
                }
            } else {
                this.classList.remove(errorClass);
                // Remove error message if it exists
                if (errorMsg) {
                    errorMsg.remove();
                }
            }
        });
    }
    
    // 3. Enhanced Form submission with geolocation
    if (paymentForm) {
        paymentForm.addEventListener('submit', function(e) {
            // Validate currency selection
            const selectedCurrencyValue = document.getElementById('selected-currency').value;
            const validCurrencies = ['XOF', 'USD'];
            
            if (!validCurrencies.includes(selectedCurrencyValue)) {
                e.preventDefault();
                alert('Veuillez sélectionner une devise valide.');
                return false;
            }
            
            // Check geolocation data
            if (!document.getElementById('latitude').value || !document.getElementById('longitude').value) {
                if (navigator.geolocation) {
                    e.preventDefault();
                    requestGeolocation(function() {
                        // Submit form once geolocation is obtained
                        paymentForm.submit();
                    });
                    return false;
                }
            }
        });
    }
    
    // 4. Enhanced Currency conversion with better animations
    if (currencySelector) {
        currencySelector.addEventListener('change', function() {
            const currency = this.value;
            const rate = currencies[currency].rate;
            const symbol = currencies[currency].symbol;
            
            // Enhanced animation for price transitions
            itemPrices.forEach(item => {
                item.classList.add('opacity-0', 'transform', 'translate-y-4');
            });
            summaryTotal.classList.add('opacity-0', 'transform', 'translate-y-4');
            
            // Update selected currency in form
            selectedCurrency.value = currency;
            
            setTimeout(() => {
                // Update item prices
                itemPrices.forEach(item => {
                    const originalPrice = parseFloat(item.getAttribute('data-price'));
                    const convertedPrice = originalPrice * rate;
                    item.textContent = new Intl.NumberFormat('fr-FR', { 
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2 
                    }).format(convertedPrice) + ' ' + symbol;
                    item.classList.remove('opacity-0', 'transform', 'translate-y-4');
                });
                
                // Update total
                const originalTotal = parseFloat(summaryTotal.getAttribute('data-total'));
                const convertedTotal = originalTotal * rate;
                const formattedTotal = new Intl.NumberFormat('fr-FR', { 
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2 
                }).format(convertedTotal) + ' ' + symbol;
                
                summaryTotal.textContent = formattedTotal;
                summaryTotal.classList.remove('opacity-0', 'transform', 'translate-y-4');
            }, 300);
        });
    }
    
    // 5. Enhanced Input field visual effects
    const inputFields = document.querySelectorAll('input[type="text"], input[type="tel"], select');
    inputFields.forEach(field => {
        field.addEventListener('focus', function() {
            this.parentElement.classList.add('scale-105');
            this.classList.add('shadow-xl');
        });
        
        field.addEventListener('blur', function() {
            this.parentElement.classList.remove('scale-105');
            this.classList.remove('shadow-xl');
        });
    });
    
    // 6. Initialize geolocation
    initGeolocation();
    
    // GEOLOCATION FUNCTIONS
    
    function updateGeoStatus(success, message) {
        if (success) {
            geoStatusElement.innerHTML = `
                <span class="inline-block w-3 h-3 rounded-full bg-green-500 mr-2 animate-pulse"></span>
                <span class="text-sm text-green-600 font-medium">${message}</span>
            `;
        } else {
            geoStatusElement.innerHTML = `
                <span class="inline-block w-3 h-3 rounded-full bg-red-500 mr-2 animate-pulse"></span>
                <span class="text-sm text-red-600 font-medium">${message}</span>
            `;
        }
    }
    
    function requestGeolocation(callback) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                document.getElementById('latitude').value = position.coords.latitude;
                document.getElementById('longitude').value = position.coords.longitude;
                updateGeoStatus(true, "Position obtenue avec succès!");
                
                if (typeof callback === 'function') {
                    callback();
                }
            }, function(error) {
                console.warn("Erreur de géolocalisation :", error.message);
                let errorMsg;
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        errorMsg = "Accès refusé à la géolocalisation";
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMsg = "Information de localisation indisponible";
                        break;
                    case error.TIMEOUT:
                        errorMsg = "Délai d'attente dépassé";
                        break;
                    default:
                        errorMsg = "Erreur inconnue";
                }
                updateGeoStatus(false, errorMsg);
            }, {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            });
        } else {
            console.warn("La géolocalisation n'est pas supportée par ce navigateur.");
            updateGeoStatus(false, "Géolocalisation non supportée");
        }
    }
    
    function initGeolocation() {
        // Update status to indicate we're requesting location
        geoStatusElement.innerHTML = `
            <span class="inline-block w-3 h-3 rounded-full bg-yellow-500 animate-pulse mr-2"></span>
            <span class="text-sm text-yellow-600 font-medium">Demande de localisation en cours...</span>
        `;
        
        // Request geolocation
        requestGeolocation();
    }
});
</script>
@endsection