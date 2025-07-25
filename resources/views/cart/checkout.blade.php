@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-blue-50 py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
        <!-- Header with subtle animation -->
        <div class="text-center mb-10 transform transition duration-700 hover:scale-105">
            <h1 class="text-4xl md:text-5xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600 mb-2">Finaliser votre commande</h1>
            <div class="h-1 w-24 bg-gradient-to-r from-indigo-500 to-purple-500 mx-auto rounded-full"></div>
        </div>

        <div class="lg:flex gap-8 items-start">
            <!-- Left column: Order summary -->
            <div class="lg:w-1/2 mb-8 lg:mb-0">
                <div class="bg-white backdrop-blur-xl bg-opacity-95 rounded-3xl shadow-xl overflow-hidden border border-indigo-100 transition duration-300 hover:shadow-indigo-100">
                    <!-- Summary header -->
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-500 px-6 py-5">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Résumé de votre commande
                        </h2>
                    </div>
                    
                    <!-- Product list -->
                    <div class="p-6">
                        <div class="space-y-4 max-h-80 overflow-y-auto custom-scrollbar">
                            @foreach ($cart as $item)
                            <div class="flex justify-between items-center p-3 rounded-2xl transition duration-300 hover:bg-indigo-50 border border-transparent hover:border-indigo-100 group">
                                <div class="flex items-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-xl overflow-hidden shadow-sm group-hover:shadow-md transition duration-300 transform group-hover:scale-105">
                                        <img src="{{ $item['image'] ?? asset('images/default-product.png') }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover" onerror="this.onerror=null;this.src='{{ asset('images/default-product.png') }}';">
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="font-semibold text-gray-800 group-hover:text-indigo-700 transition-colors duration-300">{{ $item['name'] }}</h3>
                                        <div class="flex items-center mt-1">
                                            <span class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-medium">
                                                Qté: {{ $item['quantity'] }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <span class="font-bold text-gray-800 bg-gradient-to-r from-indigo-50 to-purple-50 px-4 py-2 rounded-xl shadow-sm item-price transition duration-300" data-price="{{ $item['price'] * $item['quantity'] }}">
                                    {{ \App\Helpers\CurrencyHelper::format($item['price'] * $item['quantity'], 'XOF') }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                        
                        <!-- Animated separator -->
                        <div class="relative h-0.5 w-full bg-gray-100 my-6 overflow-hidden">
                            <div class="absolute top-0 left-0 h-full w-1/2 bg-gradient-to-r from-indigo-500 to-purple-500 animate-pulse"></div>
                        </div>
                        
                        <!-- Total with animation -->
                        <div class="flex justify-between items-center py-4 transform transition duration-500 hover:scale-105">
                            <span class="text-xl font-bold text-gray-700">Total:</span>
                            <span id="summary-total" class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600" data-total="{{ $total }}">
                                {{ \App\Helpers\CurrencyHelper::format($total, 'XOF') }}
                            </span>
                        </div>
                        
                        <!-- Currency selector -->
                        <div class="mt-6">
                            <label for="currency-selector" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-1 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Choisir votre devise:
                            </label>
                            <div class="relative">
                                <select id="currency-selector" class="w-full appearance-none bg-white border border-indigo-200 text-gray-700 py-3 px-4 pr-8 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition shadow-sm hover:shadow-md">
                                    <option value="XOF">FCFA</option>
                                    <option value="EUR">EUR (€)</option>
                                    <option value="USD">USD ($)</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-indigo-500">
                                    <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Return button -->
                        <div class="mt-6">
                            <a href="{{ route('cart.index') }}" class="w-full bg-white border border-indigo-200 text-indigo-700 hover:bg-indigo-50 font-medium py-3 px-4 rounded-xl flex items-center justify-center transition duration-300 shadow-sm hover:shadow-md group">
                                <svg class="w-5 h-5 mr-2 transform transition group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Retour au panier
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right column: Payment form -->
            <div class="lg:w-1/2">
                <div class="bg-white backdrop-blur-xl bg-opacity-95 rounded-3xl shadow-xl overflow-hidden border border-indigo-100 transition duration-300 hover:shadow-indigo-100">
                    <!-- Form header -->
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-500 px-6 py-5">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Informations de paiement
                        </h2>
                    </div>
                    
                    <div class="p-6">
                        <form id="paymentForm" action="{{ route('order.store') }}" method="POST">
                            @csrf
                            <!-- Selected currency -->
                            <input type="hidden" name="currency" id="selected-currency" value="XOF">
                            
                            <!-- Alert message -->
                            @if ($total < 100)
                            <div class="relative overflow-hidden bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl mb-6 animate-pulse">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    <p>
                                        Le montant minimum pour passer une commande est de <strong>100 FCFA</strong>.
                                        <br>Veuillez ajouter d'autres articles.
                                    </p>
                                </div>
                                <div class="absolute inset-0 bg-red-200 opacity-10"></div>
                            </div>
                            @endif
                            
                            <!-- Phone number -->
                            <div class="mb-6 transform transition duration-300 hover:translate-x-1">
                                <label for="phone_number" class="block text-gray-700 mb-2 font-medium flex items-center">
                                    <svg class="w-5 h-5 mr-1 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    Numéro de téléphone
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-indigo-400 group-focus-within:text-indigo-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                    </div>
                                    <input type="tel" name="phone_number" id="phone_number" placeholder="Votre numéro" 
                                           pattern="\+?\d{8,15}" 
                                           title="Le numéro doit contenir entre 8 et 15 chiffres, avec un + optionnel au début"
                                           class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 pl-10 pr-3 text-gray-800 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition shadow-sm focus:shadow-md placeholder-gray-400" required>
                                    <div class="absolute bottom-0 left-0 h-0.5 w-0 bg-gradient-to-r from-indigo-500 to-purple-500 transition duration-300 group-focus-within:w-full"></div>
                                </div>
                            </div>

                            <!-- Payment method -->
                            <div class="mb-6 transform transition duration-300 hover:translate-x-1">
                                <label for="payment_method" class="block text-gray-700 mb-2 font-medium flex items-center">
                                    <svg class="w-5 h-5 mr-1 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                    Mode de paiement
                                </label>
                                <div class="relative group">
                                    <select name="payment_method" id="payment_method" required
                                           class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-3 text-gray-800 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition shadow-sm focus:shadow-md appearance-none">
                                        <option value="">-- Choisir --</option>
                                        <option value="livraison" class="py-2">Paiement à la livraison</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-indigo-500">
                                        <svg class="fill-current h-5 w-5 transition-transform duration-300 group-hover:rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                    </div>
                                    <div class="absolute bottom-0 left-0 h-0.5 w-0 bg-gradient-to-r from-indigo-500 to-purple-500 transition duration-300 group-focus-within:w-full"></div>
                                </div>
                            </div>

                            <!-- Delivery address -->
                            <div class="mb-6 transform transition duration-300 hover:translate-x-1">
                                <label for="delivery_address" class="block text-gray-700 mb-2 font-medium flex items-center">
                                    <svg class="w-5 h-5 mr-1 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Adresse de livraison
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-indigo-400 group-focus-within:text-indigo-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" name="delivery_address" id="delivery_address" placeholder="Votre adresse complète" 
                                           class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 pl-10 pr-3 text-gray-800 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition shadow-sm focus:shadow-md placeholder-gray-400" required>
                                    <div class="absolute bottom-0 left-0 h-0.5 w-0 bg-gradient-to-r from-indigo-500 to-purple-500 transition duration-300 group-focus-within:w-full"></div>
                                </div>
                            </div>

                            <!-- Confirmation checkbox -->
                            <div class="mb-8">
                                <label class="flex items-center gap-3 cursor-pointer select-none {{ $total < 100 ? 'opacity-50' : '' }} hover:text-indigo-700 transition-colors">
                                    <input type="checkbox" id="confirmOrder" name="confirm_order" class="sr-only" required {{ $total < 100 ? 'disabled' : '' }}>
                                    <div class="w-6 h-6 border-2 border-gray-300 rounded-md flex items-center justify-center transition duration-300 hover:border-indigo-400">
                                        <div class="checkbox-checked w-4 h-4 text-white scale-0 transition duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    </div>
                                    <span class="text-gray-700 group-hover:text-indigo-700 transition-colors">Je confirme ma commande</span>
                                </label>
                            </div>
                            
                            <!-- Payment button -->
                            <div class="flex flex-col gap-3">
                                <button type="submit" class="group w-full relative overflow-hidden bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white py-4 rounded-xl font-bold flex items-center justify-center transition duration-300 transform hover:scale-105 {{ $total < 100 ? 'opacity-50 cursor-not-allowed' : '' }} shadow-lg" {{ $total < 100 ? 'disabled' : '' }}>
                                    <span class="relative z-10 flex items-center">
                                        <svg class="w-5 h-5 mr-2 transition-transform group-hover:rotate-[-10deg]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

                        <!-- Geolocation information section -->
                        <div class="mt-4 p-4 bg-blue-50 rounded-xl border border-blue-200">
                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-blue-500 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <div>
                                    <h3 class="font-medium text-blue-700">Localisation pour la livraison</h3>
                                    <p class="text-sm text-blue-600 mt-1">Votre position sera utilisée pour faciliter la livraison. Notre livreur utilisera ces coordonnées pour vous trouver facilement.</p>
                                    <div class="flex items-center mt-2">
                                        <div id="geolocation-status" class="flex items-center">
                                            <span class="inline-block w-2 h-2 rounded-full bg-gray-300 mr-2"></span>
                                            <span class="text-sm text-gray-500">En attente de localisation...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Secure delivery information -->
                        <div class="mt-6 flex items-center justify-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            </svg>
                            Livraison suivie par géolocalisation
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(isset($order->estimated_time_min))
<div class="mt-3 text-sm text-gray-700">
    ⏱️ Livraison estimée dans <strong>{{ $order->estimated_time_min }} minutes</strong>
    (distance : {{ $order->distance_km }} km)
</div>
@endif

<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: #f3f4f6;
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(99, 102, 241, 0.5);
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(99, 102, 241, 0.8);
}
@keyframes shine {
    100% {
        left: 125%;
    }
}
.animate-shine {
    animation: shine 1.5s;
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
        'EUR': { rate: 0.0015, symbol: '€' },
        'USD': { rate: 0.0017, symbol: '$' }
    };
    
    // 1. Checkbox styling
    if (confirmOrderCheckbox) {
        confirmOrderCheckbox.addEventListener('change', function() {
            const checkBox = this.parentElement.querySelector('div:nth-child(2)');
            const checkIcon = this.parentElement.querySelector('.checkbox-checked');
            
            if (this.checked) {
                checkBox.classList.add('bg-indigo-600', 'border-indigo-600');
                checkIcon.classList.replace('scale-0', 'scale-100');
            } else {
                checkBox.classList.remove('bg-indigo-600', 'border-indigo-600');
                checkIcon.classList.replace('scale-100', 'scale-0');
            }
        });
    }
    
    // 2. Phone number validation
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
                    errorMsg.className = 'text-red-500 text-sm mt-1 ' + errorMsgClass;
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
    
    // 3. Form submission with geolocation
    if (paymentForm) {
        paymentForm.addEventListener('submit', function(e) {
            // Validate currency selection
            const selectedCurrencyValue = document.getElementById('selected-currency').value;
            const validCurrencies = ['XOF', 'EUR', 'USD'];
            
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
    
    // 4. Currency conversion
    if (currencySelector) {
        currencySelector.addEventListener('change', function() {
            const currency = this.value;
            const rate = currencies[currency].rate;
            const symbol = currencies[currency].symbol;
            
            // Animation for price transitions
            itemPrices.forEach(item => {
                item.classList.add('opacity-0');
                item.style.transform = 'translateY(-10px)';
            });
            summaryTotal.classList.add('opacity-0');
            
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
                    item.classList.remove('opacity-0');
                    item.style.transform = 'translateY(0)';
                });
                
                // Update total
                const originalTotal = parseFloat(summaryTotal.getAttribute('data-total'));
                const convertedTotal = originalTotal * rate;
                const formattedTotal = new Intl.NumberFormat('fr-FR', { 
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2 
                }).format(convertedTotal) + ' ' + symbol;
                
                summaryTotal.textContent = formattedTotal;
                summaryTotal.classList.remove('opacity-0');
            }, 200);
        });
    }
    
    // 5. Input field visual effects
    const inputFields = document.querySelectorAll('input[type="text"], input[type="tel"], select');
    inputFields.forEach(field => {
        field.addEventListener('focus', function() {
            this.parentElement.classList.add('scale-105');
            this.classList.add('shadow-md');
        });
        
        field.addEventListener('blur', function() {
            this.parentElement.classList.remove('scale-105');
            this.classList.remove('shadow-md');
        });
    });
    
    // 6. Initialize geolocation
    initGeolocation();
    
    // GEOLOCATION FUNCTIONS
    
    function updateGeoStatus(success, message) {
        if (success) {
            geoStatusElement.innerHTML = `
                <span class="inline-block w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                <span class="text-sm text-green-600">${message}</span>
            `;
        } else {
            geoStatusElement.innerHTML = `
                <span class="inline-block w-2 h-2 rounded-full bg-red-500 mr-2"></span>
                <span class="text-sm text-red-600">${message}</span>
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
            <span class="inline-block w-2 h-2 rounded-full bg-yellow-500 animate-pulse mr-2"></span>
            <span class="text-sm text-yellow-600">Demande de localisation en cours...</span>
        `;
        
        // Request geolocation
        requestGeolocation();
    }
});
 </script>
@endsection