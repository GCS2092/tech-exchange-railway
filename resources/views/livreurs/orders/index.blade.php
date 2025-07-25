@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- En-tête modernisé -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-extrabold text-indigo-700 flex items-center gap-2">
            <span class="inline-block bg-gradient-to-r from-pink-500 to-purple-500 text-white rounded-full px-3 py-1 mr-2">🚚</span> Mes Livraisons
        </h1>
        <div class="text-base font-semibold text-indigo-600">Livreur: <span class="underline">{{ Auth::user()->name }}</span></div>
    </div>

    <!-- Message de succès -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded shadow">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <!-- Centre de notifications -->
    <div class="bg-white rounded-xl shadow p-4 mb-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-3 flex items-center gap-2"><i class="fas fa-bell text-yellow-400"></i> Notifications</h2>
        <div class="max-h-40 overflow-y-auto">
            @forelse(Auth::user()->unreadNotifications as $notification)
                <div class="bg-blue-50 p-3 rounded mb-2 flex justify-between items-center">
                    <div>
                        <p class="text-sm">{{ $notification->data['message'] ?? 'Notification' }}</p>
                        <p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>
                    <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="inline">
                        @csrf
                        <button class="text-xs text-blue-500 hover:text-blue-700">Marquer comme lue</button>
                    </form>
                </div>
            @empty
                <p class="text-gray-500 text-sm">Pas de nouvelles notifications</p>
            @endforelse
        </div>
        @if(Auth::user()->unreadNotifications->count() > 0)
            <div class="mt-2 text-right">
                <form action="{{ route('notifications.markAllAsRead') }}" method="POST" class="inline">
                    @csrf
                    <button class="text-sm text-blue-500 hover:text-blue-700">Marquer toutes comme lues</button>
                </form>
            </div>
        @endif
    </div>

    <!-- Tableau de bord modernisé -->
    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl shadow-xl p-6 mb-8">
        <h2 class="text-xl font-bold text-indigo-700 mb-4 flex items-center gap-2"><i class="fas fa-chart-bar"></i> Tableau de bord</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-blue-100 p-6 rounded-xl text-center shadow hover:scale-105 transition">
                <p class="text-sm text-gray-600">Livraisons du jour</p>
                <p class="text-3xl font-extrabold text-blue-700">{{ $todayOrders->count() }}</p>
            </div>
            <div class="bg-yellow-100 p-6 rounded-xl text-center shadow hover:scale-105 transition">
                <p class="text-sm text-gray-600">En attente</p>
                <p class="text-3xl font-extrabold text-yellow-700">{{ $pendingOrders->count() }}</p>
            </div>
            <div class="bg-green-100 p-6 rounded-xl text-center shadow hover:scale-105 transition">
                <p class="text-sm text-gray-600">Livraisons complétées</p>
                <p class="text-3xl font-extrabold text-green-700">{{ $deliveredOrders->count() }}</p>
            </div>
            <div class="bg-purple-100 p-6 rounded-xl text-center shadow hover:scale-105 transition">
                <p class="text-sm text-gray-600">Distance parcourue</p>
                <p class="text-3xl font-extrabold text-purple-700">{{ $totalDistance ?? 0 }} km</p>
            </div>
        </div>
    </div>

    <!-- Section Carte d'aperçu avec Leaflet -->
    @if($pendingOrders->count())
        <div class="bg-white rounded-lg shadow-lg p-4 mb-6">
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-lg font-semibold text-gray-700">📍 Aperçu des livraisons</h2>
                <button id="toggleMapBtn" class="bg-indigo-500 text-white px-3 py-1 rounded hover:bg-indigo-600">
                    Afficher la carte
                </button>
            </div>
            <div id="overview-map" class="w-full h-96 rounded-lg shadow-md hidden"></div>
            <div id="route-preview" class="w-full hidden mt-4">
                <h3 class="text-md font-semibold text-gray-700 mb-2">Détails du trajet</h3>
                <div id="route-details" class="bg-gray-50 p-3 rounded">
                    <p class="text-sm text-gray-500">Sélectionnez une commande sur la carte pour voir les détails du trajet</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Accès aux outils des livreurs modernisé -->
    <div class="bg-white rounded-xl shadow p-4 mb-8 flex flex-col md:flex-row items-center gap-4">
        <h2 class="text-lg font-semibold text-gray-700 mb-0 flex items-center gap-2"><i class="fas fa-link"></i> Accès rapide</h2>
        <div class="flex gap-4 ml-4">
            <!-- <a href="{{ route('livreurs.route_liste') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-700 transition"><i class="fas fa-list"></i> Liste des routes</a> -->
            <a href="{{ route('livreurs.planning') }}" class="inline-flex items-center gap-2 bg-green-600 text-white px-5 py-2 rounded-lg shadow hover:bg-green-700 transition"><i class="fas fa-calendar-alt"></i> Planning</a>
        </div>
    </div>

    <!-- Commandes en attente -->
    <div class="bg-white rounded-lg shadow-lg p-4 mb-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-3">📦 Commandes en attente</h2>
        @if($pendingOrders->count())
            <div class="overflow-x-auto">
                <table class="w-full table-auto text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 border">ID</th>
                            <th class="px-4 py-2 border">Client</th>
                            <th class="px-4 py-2 border">Téléphone</th>
                            <th class="px-4 py-2 border">Adresse</th>
                            <th class="px-4 py-2 border">Distance</th>
                            <th class="px-4 py-2 border">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingOrders as $order)
                        <tr data-order-id="{{ $order->id }}" class="hover:bg-gray-50 order-row">
                            <td class="px-4 py-2 border">{{ $order->id }}</td>
                            <td class="px-4 py-2 border">{{ $order->user->name ?? 'Client inconnu' }}</td>
                            <td class="px-4 py-2 border">{{ $order->user->phone ?? 'N/A' }}</td>
                            <td class="px-4 py-2 border">{{ $order->delivery_address }}</td>
                            <td class="px-4 py-2 border">
                                @if($order->latitude && $order->longitude)
                                    {{ \App\Http\Controllers\LivreurController::haversine(14.6928, -17.4467, $order->latitude, $order->longitude) }} km
                                @else
                                    N/A km
                                @endif
                            </td>
                            <td class="px-4 py-2 border">
                                <div class="flex space-x-2">
                                    <button class="view-route-btn bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600"
                                            data-order-id="{{ $order->id }}"
                                            data-lat="{{ $order->latitude }}"
                                            data-lng="{{ $order->longitude }}"
                                            data-address="{{ $order->delivery_address }}">
                                        Voir trajet
                                    </button>
                                    <form action="{{ route('livreur.commande.complete', $order->id) }}" method="POST" onsubmit="return confirm('Confirmer la livraison ?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                                            Livré
                                        </button>
                                    </form>
                                    @if($order->latitude && $order->longitude)
                                    <a href="https://www.openstreetmap.org/?mlat={{ $order->latitude }}&mlon={{ $order->longitude }}&zoom=15"
                                       target="_blank"
                                       class="bg-indigo-500 text-white px-3 py-1 rounded hover:bg-indigo-600 flex items-center gap-1">
                                        <i class="fas fa-map-marker-alt"></i> OSM
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">Aucune commande en attente.</p>
        @endif
    </div>

    <!-- Commandes livrées -->
    <div class="bg-white rounded-lg shadow-lg p-4 mb-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-3">✅ Commandes livrées aujourd'hui</h2>
        @if($deliveredOrders->count())
            <div class="overflow-x-auto">
                <table class="w-full table-auto text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 border">ID</th>
                            <th class="px-4 py-2 border">Client</th>
                            <th class="px-4 py-2 border">Adresse</th>
                            <th class="px-4 py-2 border">Heure de livraison</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($deliveredOrders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border">{{ $order->id }}</td>
                                <td class="px-4 py-2 border">{{ $order->user->name ?? 'Client inconnu' }}</td>
                                <td class="px-4 py-2 border">{{ $order->delivery_address }}</td>
                                <td class="px-4 py-2 border">{{ $order->updated_at->format('H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">Aucune commande livrée aujourd'hui.</p>
        @endif
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let map, routingControl;
    
    function initMap() {
        const mapContainer = document.getElementById('overview-map');
        if (!mapContainer) return;

        // Centrer sur la première commande en attente ou Dakar par défaut
        let center = [14.6928, -17.4467]; // Dakar
        @if($pendingOrders->count())
            @php $firstOrder = $pendingOrders->first(); @endphp
            center = [{{ $firstOrder->latitude ?? 14.6928 }}, {{ $firstOrder->longitude ?? -17.4467 }}];
        @endif

        map = L.map('overview-map').setView(center, 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Ajouter les marqueurs pour chaque commande en attente
        @foreach($pendingOrders as $order)
            @if($order->latitude && $order->longitude)
                L.marker([{{ $order->latitude }}, {{ $order->longitude }}])
                    .addTo(map)
                    .bindPopup("Commande #{{ $order->id }}<br>{{ $order->delivery_address }}");
            @endif
        @endforeach
    }

    function showRoute(lat, lng, address) {
        if (!map) return;
        map.setView([lat, lng], 15);
        L.popup()
            .setLatLng([lat, lng])
            .setContent(address)
            .openOn(map);
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Gestionnaire pour le bouton d'affichage de la carte
        const toggleMapBtn = document.getElementById('toggleMapBtn');
        if (toggleMapBtn) {
            toggleMapBtn.addEventListener('click', () => {
                const mapContainer = document.getElementById('overview-map');
                mapContainer.classList.toggle('hidden');
                
                toggleMapBtn.textContent = mapContainer.classList.contains('hidden') 
                    ? 'Afficher la carte' 
                    : 'Masquer la carte';
                
                if (!map && !mapContainer.classList.contains('hidden')) {
                    initMap();
                }
            });
        }
        
        // Gestionnaire pour les boutons de visualisation de trajet
        document.querySelectorAll('.view-route-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const orderId = this.getAttribute('data-order-id');
                const lat = parseFloat(this.getAttribute('data-lat'));
                const lng = parseFloat(this.getAttribute('data-lng'));
                const address = this.getAttribute('data-address');
                
                const mapContainer = document.getElementById('overview-map');
                if (mapContainer.classList.contains('hidden')) {
                    mapContainer.classList.remove('hidden');
                    document.getElementById('toggleMapBtn').textContent = 'Masquer la carte';
                    
                    if (!map) {
                        initMap();
                        setTimeout(() => showRoute(lat, lng, address), 500);
                    } else {
                        showRoute(lat, lng, address);
                    }
                } else {
                    if (!map) {
                        initMap();
                        setTimeout(() => showRoute(lat, lng, address), 500);
                    } else {
                        showRoute(lat, lng, address);
                    }
                }
                
                // Mise en évidence de la ligne sélectionnée
                document.querySelectorAll('.order-row').forEach(row => {
                    row.classList.remove('bg-blue-50');
                });
                document.querySelector(`.order-row[data-order-id="${orderId}"]`).classList.add('bg-blue-50');
            });
        });
    });
</script>
@endpush
@endsection