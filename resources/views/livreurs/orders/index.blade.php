@extends('layouts.livreur')

@section('content')
<div class="min-h-screen bg-white">
    <div class="container-nike py-12">
        
        <!-- Navigation et redirections -->
        <x-livreur-nav-buttons />
        
        <!-- Header - Style Nike -->
        <div class="text-center mb-16">
            <h1 class="nike-title mb-4">MES LIVRAISONS</h1>
            <p class="nike-text text-gray-600">Gérez vos livraisons avec style</p>
            <div class="mt-4">
                <span class="inline-block bg-black text-white px-4 py-2 rounded-lg text-sm font-semibold">
                    Livreur: {{ Auth::user()->name }}
                </span>
            </div>
        </div>

        <!-- Message de succès -->
        @if(session('success'))
            <div class="card-nike mb-8">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                    <p class="text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Centre de notifications -->
        <div class="card-nike mb-8">
            <h2 class="nike-heading mb-6 flex items-center space-x-3">
                <i class="fas fa-bell text-black"></i>
                <span>Notifications</span>
            </h2>
            <div class="max-h-40 overflow-y-auto">
                @forelse(Auth::user()->unreadNotifications as $notification)
                    <div class="bg-gray-50 p-4 rounded-lg mb-3 flex justify-between items-center border border-gray-200">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $notification->data['message'] ?? 'Notification' }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                        <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="inline">
                            @csrf
                            <button class="text-xs text-black hover:text-gray-600 font-medium">Marquer comme lue</button>
                        </form>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm text-center py-4">Pas de nouvelles notifications</p>
                @endforelse
            </div>
            @if(Auth::user()->unreadNotifications->count() > 0)
                <div class="mt-4 text-right">
                    <form action="{{ route('notifications.markAllAsRead') }}" method="POST" class="inline">
                        @csrf
                        <button class="text-sm text-black hover:text-gray-600 font-medium">Marquer toutes comme lues</button>
                    </form>
                </div>
            @endif
        </div>

        <!-- Tableau de bord - Style Nike -->
        <div class="card-nike mb-8">
            <h2 class="nike-heading mb-6 flex items-center space-x-3">
                <i class="fas fa-chart-bar text-black"></i>
                <span>Tableau de bord</span>
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-gray-50 p-6 rounded-lg text-center border border-gray-200 hover:shadow-lg transition-shadow">
                    <p class="text-sm text-gray-600 mb-2">Livraisons du jour</p>
                    <p class="text-3xl font-bold text-black">{{ $todayOrders->count() }}</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-lg text-center border border-gray-200 hover:shadow-lg transition-shadow">
                    <p class="text-sm text-gray-600 mb-2">En attente</p>
                    <p class="text-3xl font-bold text-black">{{ $pendingOrders->count() }}</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-lg text-center border border-gray-200 hover:shadow-lg transition-shadow">
                    <p class="text-sm text-gray-600 mb-2">Livraisons complétées</p>
                    <p class="text-3xl font-bold text-black">{{ $deliveredOrders->count() }}</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-lg text-center border border-gray-200 hover:shadow-lg transition-shadow">
                    <p class="text-sm text-gray-600 mb-2">Distance parcourue</p>
                    <p class="text-3xl font-bold text-black">{{ $totalDistance ?? 0 }} km</p>
                </div>
        </div>
        
            <!-- Graphique des statistiques -->
            @if(count($statusCounts) > 0)
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <h3 class="text-lg font-semibold text-black mb-4">Répartition des commandes</h3>
                <div class="h-64">
                    <canvas id="ordersChart"></canvas>
                </div>
            </div>
            @endif
        </div>

        <!-- Section Carte d'aperçu avec Leaflet -->
        @if($pendingOrders->count())
            <div class="card-nike mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="nike-heading flex items-center space-x-3">
                        <i class="fas fa-map-marker-alt text-black"></i>
                        <span>Aperçu des livraisons</span>
                    </h2>
                    <button id="toggleMapBtn" class="btn-nike">
                        Afficher la carte
                    </button>
                </div>
                <div id="overview-map" class="w-full h-96 rounded-lg shadow-md hidden"></div>
                <div id="route-preview" class="w-full hidden mt-4">
                    <h3 class="text-md font-semibold text-black mb-2">Détails du trajet</h3>
                    <div id="route-details" class="bg-gray-50 p-3 rounded border border-gray-200">
                        <p class="text-sm text-gray-500">Sélectionnez une commande sur la carte pour voir les détails du trajet</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Accès aux outils des livreurs - Style Nike -->
        <div class="card-nike mb-8">
            <h2 class="nike-heading mb-6 flex items-center space-x-3">
                <i class="fas fa-link text-black"></i>
                <span>Accès rapide</span>
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('livreur.planning') }}" class="btn-nike-outline text-center">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    Planning
                </a>
                <a href="{{ route('livreur.profile') }}" class="btn-nike-outline text-center">
                    <i class="fas fa-user mr-2"></i>
                    Profil
                </a>
                <a href="{{ route('livreur.statistics') }}" class="btn-nike-outline text-center">
                    <i class="fas fa-chart-line mr-2"></i>
                    Statistiques
                </a>
                <a href="{{ route('livreur.settings') }}" class="btn-nike-outline text-center">
                    <i class="fas fa-cog mr-2"></i>
                    Paramètres
                </a>
            </div>
        </div>

        <!-- Commandes en attente -->
        <div class="card-nike mb-8">
            <h2 class="nike-heading mb-6 flex items-center space-x-3">
                <i class="fas fa-box text-black"></i>
                <span>Commandes en attente</span>
            </h2>
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
                                    <a href="{{ route('livreur.orders.show', $order->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                        Détails
                                    </a>
                                    <a href="{{ route('livreur.orders.route', $order->id) }}" class="bg-purple-500 text-white px-3 py-1 rounded hover:bg-purple-600">
                                        Itinéraire
                                    </a>
                                    <button class="view-route-btn bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600"
                                            data-order-id="{{ $order->id }}"
                                            data-lat="{{ $order->latitude }}"
                                            data-lng="{{ $order->longitude }}"
                                            data-address="{{ $order->delivery_address }}">
                                        Carte
                                    </button>
                                    <form action="{{ route('livreur.orders.complete', $order->id) }}" method="POST" onsubmit="return confirm('Confirmer la livraison ?')">
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
                            <th class="px-4 py-2 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($deliveredOrders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border">{{ $order->id }}</td>
                                <td class="px-4 py-2 border">{{ $order->user->name ?? 'Client inconnu' }}</td>
                                <td class="px-4 py-2 border">{{ $order->delivery_address }}</td>
                                <td class="px-4 py-2 border">{{ $order->updated_at->format('H:i') }}</td>
                                <td class="px-4 py-2 border">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('livreur.orders.show', $order->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">
                                            Détails
                                        </a>
                                        <a href="{{ route('livreur.orders.route', $order->id) }}" class="bg-purple-500 text-white px-3 py-1 rounded hover:bg-purple-600 text-sm">
                                            Itinéraire
                                        </a>
                                    </div>
                                </td>
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

<!-- Navigation flottante pour mobile -->
<x-livreur-floating-nav />

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let map, routingControl;
    
    // Initialisation du graphique des commandes
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('ordersChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode(array_keys($statusCounts)) !!},
                    datasets: [{
                        data: {!! json_encode(array_values($statusCounts)) !!},
                        backgroundColor: [
                            '#FCD34D', // Jaune pour en attente
                            '#10B981', // Vert pour livrées
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        }
    });
    
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