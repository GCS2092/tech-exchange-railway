@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white">
    <div class="container-nike py-12">
    
            <!-- Navigation et redirections -->
        <x-livreur-smart-nav currentPage="order-route" :orderId="$order->id" />
    
    <!-- En-tête -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="nike-title flex items-center gap-2">
            <span class="inline-block bg-gradient-to-r from-pink-500 to-purple-500 text-white rounded-full px-3 py-1 mr-2">🗺️</span> Itinéraire de livraison
        </h1>
    </div>

    <!-- Informations de la commande -->
    <div class="card-nike mb-6">
        <h2 class="text-xl font-semibold text-black mb-4">Détails de la commande #{{ $order->id }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-medium text-gray-700 mb-2">Informations client</h3>
                <div class="space-y-2">
                    <p><strong>Nom :</strong> {{ $order->user->name ?? 'Client inconnu' }}</p>
                    <p><strong>Téléphone :</strong> {{ $order->user->phone ?? 'N/A' }}</p>
                    <p><strong>Email :</strong> {{ $order->user->email ?? 'N/A' }}</p>
                </div>
            </div>
            <div>
                <h3 class="text-lg font-medium text-gray-700 mb-2">Adresse de livraison</h3>
                <div class="space-y-2">
                    <p><strong>Adresse :</strong> {{ $order->delivery_address }}</p>
                    @if($order->latitude && $order->longitude)
                        <p><strong>Coordonnées :</strong> {{ $order->latitude }}, {{ $order->longitude }}</p>
                        <p><strong>Distance :</strong> {{ \App\Http\Controllers\LivreurController::haversine(14.6928, -17.4467, $order->latitude, $order->longitude) }} km</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Carte interactive -->
    @if($order->latitude && $order->longitude)
        <div class="card-nike mb-6">
            <h2 class="text-xl font-semibold text-black mb-4">Carte de l'itinéraire</h2>
            <div id="map" class="w-full h-96 rounded-lg shadow-md"></div>
        </div>

        <!-- Actions -->
        <div class="card-nike">
            <h2 class="text-xl font-semibold text-black mb-4">Actions</h2>
            <div class="flex flex-wrap gap-4">
                <a href="https://www.openstreetmap.org/?mlat={{ $order->latitude }}&mlon={{ $order->longitude }}&zoom=15" 
                   target="_blank"
                   class="inline-flex items-center gap-2 btn-nike transition">
                    <i class="fas fa-external-link-alt"></i> Ouvrir dans OpenStreetMap
                </a>
                
                <a href="https://www.google.com/maps?q={{ $order->latitude }},{{ $order->longitude }}" 
                   target="_blank"
                   class="inline-flex items-center gap-2 btn-nike transition">
                    <i class="fab fa-google"></i> Ouvrir dans Google Maps
                </a>

                @if($order->status !== 'livré')
                    <form action="{{ route('livreur.orders.complete', $order->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="inline-flex items-center gap-2 bg-red-600 text-white px-5 py-2 rounded-lg shadow hover:bg-red-700 transition"
                                onclick="return confirm('Confirmer la livraison de cette commande ?')">
                            <i class="fas fa-check"></i> Marquer comme livrée
                        </button>
                    </form>
                @else
                    <div class="inline-flex items-center gap-2 bg-gray-600 text-white px-5 py-2 rounded-lg">
                        <i class="fas fa-check-circle"></i> Commande livrée
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded">
            <p><strong>Attention :</strong> Les coordonnées GPS ne sont pas disponibles pour cette commande.</p>
        </div>
    @endif
</div>

@if($order->latitude && $order->longitude)
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser la carte
    var map = L.map('map').setView([{{ $order->latitude }}, {{ $order->longitude }}], 15);
    
    // Ajouter la couche OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    // Ajouter le marqueur de destination
    var destinationMarker = L.marker([{{ $order->latitude }}, {{ $order->longitude }}])
        .addTo(map)
        .bindPopup('<strong>Destination</strong><br>{{ $order->delivery_address }}');
    
    // Essayer de récupérer la position actuelle du livreur
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var livreurLat = position.coords.latitude;
            var livreurLng = position.coords.longitude;
            
            // Ajouter le marqueur du livreur
            var livreurMarker = L.marker([livreurLat, livreurLng], {
                icon: L.divIcon({
                    className: 'livreur-marker',
                    html: '<div style="background-color: #3B82F6; width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.3);"></div>',
                    iconSize: [20, 20],
                    iconAnchor: [10, 10]
                })
            }).addTo(map).bindPopup('<strong>Votre position</strong>');
            
            // Ajuster la vue pour inclure les deux marqueurs
            var bounds = L.latLngBounds([[livreurLat, livreurLng], [{{ $order->latitude }}, {{ $order->longitude }}]]);
            map.fitBounds(bounds, { padding: [20, 20] });
        }, function(error) {
            console.log('Erreur de géolocalisation:', error);
        });
    }
});
</script>
@endif
@endsection
