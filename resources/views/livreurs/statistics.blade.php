@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-purple-50 to-pink-50 py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Statistiques et Performance</h1>
            <p class="mt-2 text-sm text-gray-600">Analysez vos performances et suivez vos objectifs</p>
        </div>

        <!-- Filtres de période -->
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
            <div class="flex flex-wrap items-center gap-4">
                <button class="btn btn-primary active">Aujourd'hui</button>
                <button class="btn btn-secondary">Cette semaine</button>
                <button class="btn btn-secondary">Ce mois</button>
                <button class="btn btn-secondary">Cette année</button>
                <div class="flex-grow"></div>
                <div class="relative">
                    <input type="date" class="form-input pr-10" value="{{ date('Y-m-d') }}">
                    <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </span>
                </div>
            </div>
        </div>

        <!-- Métriques principales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
            <!-- Livraisons complétées -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-green-600">+12.5%</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">156</h3>
                <p class="text-sm text-gray-600">Livraisons complétées</p>
                <div class="mt-4">
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-blue-600 rounded-full h-2" style="width: 85%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">85% de l'objectif mensuel</p>
                </div>
            </div>

            <!-- Temps moyen de livraison -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-green-600">-5.2%</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">28 min</h3>
                <p class="text-sm text-gray-600">Temps moyen de livraison</p>
                <div class="mt-4">
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-purple-600 rounded-full h-2" style="width: 92%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">92% dans les délais prévus</p>
                </div>
            </div>

            <!-- Note moyenne -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-green-600">+0.3</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">4.8/5</h3>
                <p class="text-sm text-gray-600">Note moyenne</p>
                <div class="mt-4">
                    <div class="flex items-center">
                        @for($i = 0; $i < 5; $i++)
                        <svg class="w-5 h-5 {{ $i < 4 ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        @endfor
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Basé sur 124 avis</p>
                </div>
            </div>

            <!-- Revenus -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-green-600">+8.1%</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">75 000 XOF</h3>
                <p class="text-sm text-gray-600">Revenus du mois</p>
                <div class="mt-4">
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-green-600 rounded-full h-2" style="width: 78%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">78% de l'objectif mensuel</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Graphique des livraisons -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">Évolution des livraisons</h2>
                <div class="h-80">
                    <canvas id="deliveriesChart"></canvas>
                </div>
            </div>

            <!-- Graphique des revenus -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">Évolution des revenus</h2>
                <div class="h-80">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- Carte des livraisons -->
            <div class="bg-white rounded-2xl shadow-xl p-6 lg:col-span-2">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">Carte des livraisons</h2>
                <div class="h-96 rounded-xl overflow-hidden">
                    <div id="deliveryMap" class="w-full h-full"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&callback=initMap" async defer></script>
<script>
// Graphique des livraisons
const deliveriesCtx = document.getElementById('deliveriesChart').getContext('2d');
new Chart(deliveriesCtx, {
    type: 'line',
    data: {
        labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
        datasets: [{
            label: 'Livraisons',
            data: [25, 32, 28, 35, 30, 28, 22],
            borderColor: 'rgb(99, 102, 241)',
            backgroundColor: 'rgba(99, 102, 241, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    display: false
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// Graphique des revenus
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
new Chart(revenueCtx, {
    type: 'bar',
    data: {
        labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
        datasets: [{
            label: 'Revenus',
            data: [15000, 18000, 16000, 20000, 17000, 16000, 12000],
            backgroundColor: 'rgba(16, 185, 129, 0.2)',
            borderColor: 'rgb(16, 185, 129)',
            borderWidth: 2,
            borderRadius: 4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    display: false
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// Carte des livraisons
function initMap() {
    const map = new google.maps.Map(document.getElementById('deliveryMap'), {
        zoom: 12,
        center: { lat: 14.6928, lng: -17.4467 }, // Coordonnées de Dakar
        styles: [
            {
                featureType: 'water',
                elementType: 'geometry',
                stylers: [{ color: '#e9e9e9' }, { lightness: 17 }]
            },
            {
                featureType: 'landscape',
                elementType: 'geometry',
                stylers: [{ color: '#f5f5f5' }, { lightness: 20 }]
            },
            {
                featureType: 'road.highway',
                elementType: 'geometry.fill',
                stylers: [{ color: '#ffffff' }, { lightness: 17 }]
            },
            {
                featureType: 'road.highway',
                elementType: 'geometry.stroke',
                stylers: [{ color: '#ffffff' }, { lightness: 29 }, { weight: 0.2 }]
            },
            {
                featureType: 'road.arterial',
                elementType: 'geometry',
                stylers: [{ color: '#ffffff' }, { lightness: 18 }]
            },
            {
                featureType: 'road.local',
                elementType: 'geometry',
                stylers: [{ color: '#ffffff' }, { lightness: 16 }]
            },
            {
                featureType: 'poi',
                elementType: 'geometry',
                stylers: [{ color: '#f5f5f5' }, { lightness: 21 }]
            },
            {
                featureType: 'poi.park',
                elementType: 'geometry',
                stylers: [{ color: '#dedede' }, { lightness: 21 }]
            },
            {
                elementType: 'labels.text.stroke',
                stylers: [{ visibility: 'on' }, { color: '#ffffff' }, { lightness: 16 }]
            },
            {
                elementType: 'labels.text.fill',
                stylers: [{ saturation: 36 }, { color: '#333333' }, { lightness: 40 }]
            },
            {
                elementType: 'labels.icon',
                stylers: [{ visibility: 'off' }]
            },
            {
                featureType: 'transit',
                elementType: 'geometry',
                stylers: [{ color: '#f2f2f2' }, { lightness: 19 }]
            },
            {
                featureType: 'administrative',
                elementType: 'geometry.fill',
                stylers: [{ color: '#fefefe' }, { lightness: 20 }]
            },
            {
                featureType: 'administrative',
                elementType: 'geometry.stroke',
                stylers: [{ color: '#fefefe' }, { lightness: 17 }, { weight: 1.2 }]
            }
        ]
    });

    // Exemple de points de livraison
    const deliveryPoints = [
        { lat: 14.6928, lng: -17.4467, status: 'delivered' },
        { lat: 14.7000, lng: -17.4500, status: 'pending' },
        { lat: 14.6900, lng: -17.4400, status: 'in_progress' }
    ];

    deliveryPoints.forEach(point => {
        const color = point.status === 'delivered' ? '#10B981' : 
                     point.status === 'pending' ? '#EF4444' : '#6366F1';
        
        new google.maps.Marker({
            position: { lat: point.lat, lng: point.lng },
            map: map,
            icon: {
                path: google.maps.SymbolPath.CIRCLE,
                scale: 8,
                fillColor: color,
                fillOpacity: 1,
                strokeWeight: 2,
                strokeColor: '#ffffff',
            }
        });
    });
}
</script>
@endpush
@endsection 