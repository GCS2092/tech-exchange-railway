@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 max-w-7xl">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 flex items-center">
            <span class="bg-blue-100 text-blue-700 p-2 rounded-lg shadow-sm mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7m16 0l-8 4m-8-4l8 4" />
                </svg>
            </span>
            Dernières commandes
        </h1>

        <div class="flex flex-wrap items-center gap-3">
            <!-- Sélecteur de devise -->
            <div class="relative">
                <label for="currency-selector" class="block text-xs font-medium text-gray-700 mb-1">Devise:</label>
                <div class="relative inline-flex">
                    <select id="currency-selector" class="appearance-none bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm">
                        <option value="XOF">FCFA</option>
                        <option value="EUR">EUR (€)</option>
                        <option value="USD">USD ($)</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Export PDF -->
            <a href="{{ route('orders.exportPdf') }}" target="_blank" 
               class="inline-flex items-center px-4 py-2 bg-gradient-to-br from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white rounded-md shadow-sm text-sm font-medium transition duration-150 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Télécharger PDF
            </a>
        </div>
    </div>

    @if(count($orders) > 0)
        <div class="bg-white shadow-md rounded-xl overflow-hidden border border-gray-100">
            @foreach ($orders as $order)
                <div class="p-5 hover:bg-gray-50 transition-all duration-150 border-b border-gray-100 last:border-b-0">
                    <div class="flex flex-col lg:flex-row justify-between gap-6">
                        <!-- Infos commande -->
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-3 mb-2">
                                <div class="text-gray-900 font-bold text-lg">Commande #{{ $order->id }}</div>
                                <span class="px-3 py-1 rounded-full text-xs font-medium 
                                    @switch($order->status)
                                        @case('en attente') bg-yellow-100 text-yellow-800 border border-yellow-200 @break
                                        @case('expédié') bg-blue-100 text-blue-800 border border-blue-200 @break
                                        @case('livré') bg-green-100 text-green-800 border border-green-200 @break
                                        @default bg-gray-100 text-gray-800 border border-gray-200
                                    @endswitch">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                <div class="flex items-start gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-500">Client:</p>
                                        <p class="text-sm font-medium text-gray-800">{{ $order->user->email ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-500">Date:</p>
                                        <p class="text-sm font-medium text-gray-800">{{ $order->created_at->format('d/m/Y à H:i') }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-500">Paiement:</p>
                                        <p class="text-sm font-medium text-gray-800">{{ ucfirst($order->payment_method ?? 'non défini') }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-500">Montant:</p>
                                        <p class="text-sm font-medium text-blue-600 order-price" data-price="{{ $order->total_price }}">
                                            {{ number_format($order->total_price, 2) }} FCFA
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Section pour l'adresse et la localisation -->
                            <div class="mt-4 border-t border-gray-100 pt-4">
                                <div class="flex items-start gap-2 mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">Adresse de livraison:</p>
                                        <p class="text-sm text-gray-600">{{ $order->shipping_address ?? 'Non renseignée' }}</p>
                                    </div>
                                </div>

                                <!-- Mini carte et informations de localisation -->
                                @if($order->latitude && $order->longitude)
                                    <div class="mt-2 border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                                        <div class="flex items-center justify-between bg-gray-50 p-3 border-b border-gray-200">
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                                </svg>
                                                <span class="text-sm font-medium text-gray-700">Distance: <span class="text-blue-600">{{ round($order->distance_km ?? 0, 1) }} km</span></span>
                                            </div>
                                            <a href="https://www.openstreetmap.org/?mlat={{ $order->latitude }}&mlon={{ $order->longitude }}&zoom=15" 
                                               target="_blank" 
                                               class="inline-flex items-center text-xs bg-blue-100 hover:bg-blue-200 text-blue-700 px-2 py-1 rounded transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                </svg>
                                                Voir sur OpenStreetMap
                                            </a>
                                        </div>
                                        
                                        <div id="map-{{ $order->id }}" 
                                             class="h-40 w-full shadow-inner"
                                             data-lat="{{ $order->latitude }}" 
                                             data-lng="{{ $order->longitude }}" 
                                             data-store-lat="{{ config('app.store_lat', '14.6928') }}" 
                                             data-store-lng="{{ config('app.store_lng', '-17.4467') }}">
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="mt-4 flex flex-wrap items-center gap-3">
                                <a href="{{ route('admin.orders.invoice', $order) }}" target="_blank"
                                   class="inline-flex items-center px-3 py-1.5 border border-indigo-200 bg-indigo-50 hover:bg-indigo-100 text-sm text-indigo-700 rounded transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Télécharger la facture
                                </a>
                                
                                <!-- Bouton d'action complémentaire -->
                                <button type="button" class="inline-flex items-center px-3 py-1.5 border border-gray-200 bg-gray-50 hover:bg-gray-100 text-sm text-gray-700 rounded transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                    Modifier le statut
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-6">
            @if(method_exists($orders, 'links'))
                {{ $orders->links() }}
            @endif
        </div>
    @else
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded-md shadow-sm">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-yellow-400 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1 4v-4m-1 4H9m4-6h.01M12 4a8 8 0 100 16 8 8 0 000-16z" />
                </svg>
                <span class="text-sm text-yellow-800">Aucune commande trouvée pour le moment.</span>
            </div>
        </div>
    @endif

    <div class="mt-8 flex justify-between items-center">
        <a href="{{ route('admin.dashboard') }}" 
           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-md shadow-sm transition focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Retour au tableau de bord
        </a>
        
        <!-- Filtres additionnels (exemple) -->
        <div class="flex items-center gap-2">
            <span class="text-sm text-gray-600">Filtrer par:</span>
            <select class="form-select rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm">
                <option value="">Tous les statuts</option>
                <option value="en attente">En attente</option>
                <option value="expédié">Expédié</option>
                <option value="livré">Livré</option>
            </select>
        </div>
    </div>
</div>

<!-- Chargement Leaflet CSS et JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Script pour la conversion de devise
        const selector = document.getElementById('currency-selector');
        const prices = document.querySelectorAll('.order-price');

        const rates = {
            XOF: 1,
            EUR: 0.0015,
            USD: 0.0017
        };

        const symbols = {
            XOF: 'FCFA',
            EUR: '€',
            USD: '$'
        };

        selector.addEventListener('change', function () {
            const currency = this.value;
            const rate = rates[currency];
            const symbol = symbols[currency];

            prices.forEach(el => {
                const original = parseFloat(el.dataset.price);
                const converted = (original * rate).toFixed(2);
                el.textContent = `${converted} ${symbol}`;
            });
        });

        // Script d'initialisation des cartes
        const mapElements = document.querySelectorAll('[id^="map-"]');
        
        if (mapElements.length > 0) {
            mapElements.forEach(function(mapElement) {
                const lat = parseFloat(mapElement.dataset.lat);
                const lng = parseFloat(mapElement.dataset.lng);
                const storeLat = parseFloat(mapElement.dataset.storeLat);
                const storeLng = parseFloat(mapElement.dataset.storeLng);
                
                if (!isNaN(lat) && !isNaN(lng)) {
                    // Initialisation de la carte avec meilleur contraste
                    const map = L.map(mapElement.id, {
                        zoomControl: false, // Désactiver les contrôles de zoom pour une interface plus propre
                        attributionControl: false // Masquer l'attribution pour économiser de l'espace
                    }).setView([lat, lng], 13);
                    
                    // Ajout de la couche OpenStreetMap
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
                    
                    // Style amélioré pour les marqueurs
                    const deliveryIcon = L.divIcon({
                        html: `<div class="flex items-center justify-center w-6 h-6 bg-red-500 text-white rounded-full shadow-md border-2 border-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                              </div>`,
                        className: '',
                        iconSize: [24, 24],
                        iconAnchor: [12, 24]
                    });
                    
                    const storeIcon = L.divIcon({
                        html: `<div class="flex items-center justify-center w-6 h-6 bg-blue-500 text-white rounded-full shadow-md border-2 border-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                              </div>`,
                        className: '',
                        iconSize: [24, 24],
                        iconAnchor: [12, 24]
                    });
                    
                    // Marqueur pour l'adresse de livraison
                    L.marker([lat, lng], {icon: deliveryIcon}).addTo(map)
                        .bindPopup('<strong>Client</strong><br>Point de livraison');
                    
                    // Marqueur pour le magasin si les coordonnées sont définies
                    if (!isNaN(storeLat) && !isNaN(storeLng)) {
                        L.marker([storeLat, storeLng], {icon: storeIcon}).addTo(map)
                            .bindPopup('<strong>Magasin</strong><br>Point de départ');
                            
                        // Tracé du trajet avec style amélioré
                        const polyline = L.polyline([
                            [storeLat, storeLng],
                            [lat, lng]
                        ], {
                            color: '#3B82F6',
                            weight: 4,
                            opacity: 0.7,
                            dashArray: '8, 5',
                            lineCap: 'round'
                        }).addTo(map);
                        
                        // Ajuster la vue pour voir les deux marqueurs avec padding
                        const bounds = L.latLngBounds([
                            [storeLat, storeLng],
                            [lat, lng]
                        ]);
                        map.fitBounds(bounds, {padding: [40, 40]});
                    }
                    
                    // Désactiver l'interaction pour une meilleure UX dans la mini carte
                    map.dragging.disable();
                    map.touchZoom.disable();
                    map.doubleClickZoom.disable();
                    map.scrollWheelZoom.disable();
                    
                    // Ajouter le bouton qui ouvre OpenStreetMap directement sur la carte
                    L.control.attribution({
                        position: 'bottomright',
                        prefix: '<a href="https://www.openstreetmap.org/copyright" target="_blank">© OpenStreetMap</a>'
                    }).addTo(map);
                }
            });
        }
    });
</script>
@endsection