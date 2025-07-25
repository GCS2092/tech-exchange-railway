@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-purple-50 to-pink-50 py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <!-- En-tête modernisé -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-extrabold text-indigo-700 flex items-center gap-2">
                    <span class="inline-block bg-gradient-to-r from-pink-500 to-purple-500 text-white rounded-full px-3 py-1 mr-2">📅</span> Planning des livraisons
                </h1>
                <p class="mt-2 text-lg text-gray-600">Gérez votre emploi du temps et vos livraisons à venir</p>
            </div>
            <a href="{{ route('livreurs.orders.index') }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white px-5 py-2 rounded-lg shadow hover:bg-indigo-700 transition"><i class="fas fa-arrow-left"></i> Retour au dashboard</a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Calendrier et livraisons -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Navigation du calendrier -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-4">
                            <button class="btn btn-icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <h2 class="text-xl font-semibold text-gray-800">Novembre 2023</h2>
                            <button class="btn btn-icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="btn btn-secondary">Aujourd'hui</button>
                            <select id="view-type" class="form-select">
                                <option value="day">Vue journalière</option>
                                <option value="month">Vue mensuelle</option>
                                <option value="year">Vue annuelle</option>
                            </select>
                            <input type="date" id="view-date" class="form-input" value="{{ now()->toDateString() }}">
                        </div>
                    </div>

                    <!-- Calendrier -->
                    <div class="border border-gray-200 rounded-xl overflow-hidden">
                        <!-- Jours de la semaine -->
                        <div class="grid grid-cols-7 bg-gray-50">
                            @foreach(['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'] as $day)
                            <div class="py-2 text-center text-sm font-medium text-gray-700">
                                {{ $day }}
                            </div>
                            @endforeach
                        </div>

                        <!-- Dates -->
                        <div class="grid grid-cols-7 border-t border-gray-200">
                            @for($i = 1; $i <= 35; $i++)
                            <div class="min-h-[120px] p-2 border-b border-r border-gray-200 {{ $i == 15 ? 'bg-blue-50' : '' }}">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm {{ $i == 15 ? 'font-bold text-blue-600' : 'text-gray-700' }}">{{ $i }}</span>
                                    @if($i == 15)
                                    <span class="flex h-2 w-2 rounded-full bg-blue-600"></span>
                                    @endif
                                </div>
                                @if($i == 15)
                                <div class="text-xs bg-blue-100 text-blue-800 rounded p-1 mb-1">3 livraisons</div>
                                @endif
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>

                <!-- Liste des livraisons du jour -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Livraisons du jour</h2>
                    <div class="space-y-4">
                        @forelse($todayDeliveries as $order)
                        <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                                    <span class="text-blue-600 font-medium">{{ $order->created_at->format('H:i') }}</span>
                                </div>
                            </div>
                            <div class="flex-grow">
                                <h3 class="text-sm font-medium text-gray-900">Commande #{{ $order->id }}</h3>
                                <p class="text-sm text-gray-600">{{ $order->products->count() }} produits • {{ $order->distance_km ?? '?' }} km</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('livreur.view-route', $order->id) }}" class="btn btn-secondary btn-sm">Voir détails</a>
                                @if($order->status !== 'livré')
                                    <form action="{{ route('livreur.commande.complete', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-primary btn-sm">Commencer</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-500">Aucune livraison prévue aujourd'hui.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Disponibilité -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Disponibilité</h2>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700">Status actuel</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>

                        <!-- Horaires de la semaine -->
                        <div class="border-t border-gray-100 pt-4">
                            <h3 class="text-sm font-medium text-gray-700 mb-4">Horaires de travail</h3>
                            @foreach(['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'] as $day)
                            <div class="flex items-center justify-between py-2">
                                <span class="text-sm text-gray-600">{{ $day }}</span>
                                <div class="flex items-center space-x-2">
                                    <select class="form-select form-select-sm">
                                        <option>08:00</option>
                                        <option>09:00</option>
                                        <option>10:00</option>
                                    </select>
                                    <span class="text-gray-500">-</span>
                                    <select class="form-select form-select-sm">
                                        <option>17:00</option>
                                        <option>18:00</option>
                                        <option>19:00</option>
                                    </select>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <button class="btn btn-primary w-full">
                            Enregistrer les horaires
                        </button>
                    </div>
                </div>

                <!-- Zones de livraison -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Zones de livraison</h2>
                    <div class="space-y-4">
                        @foreach(['Dakar Plateau', 'Médina', 'Almadies'] as $zone)
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" class="form-checkbox text-blue-600 rounded" checked>
                            <span class="text-sm text-gray-700">{{ $zone }}</span>
                        </label>
                        @endforeach
                        <button class="btn btn-secondary w-full mt-4">
                            Gérer les zones
                        </button>
                    </div>
                </div>

                <!-- Statistiques rapides -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Aujourd'hui</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-blue-50 rounded-xl p-4">
                            <p class="text-sm font-medium text-blue-600">À livrer</p>
                            <p class="mt-2 text-2xl font-bold text-blue-900">8</p>
                        </div>
                        <div class="bg-green-50 rounded-xl p-4">
                            <p class="text-sm font-medium text-green-600">Livrées</p>
                            <p class="mt-2 text-2xl font-bold text-green-900">5</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialisation du calendrier
    const today = new Date();
    const currentDay = today.getDate();
    // Mise en évidence du jour actuel
    const calendarDays = document.querySelectorAll('.grid-cols-7 > div');
    calendarDays.forEach(day => {
        const dayNumber = parseInt(day.querySelector('span')?.textContent);
        if (dayNumber === currentDay) {
            day.classList.add('bg-blue-50');
            day.querySelector('span')?.classList.add('font-bold', 'text-blue-600');
        }
    });

    // --- Géolocalisation et actualisation des livraisons ---
    function updateLivreurLocation(callback) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                fetch('/livreur/update-location', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (callback) callback();
                });
            });
        } else {
            alert("La géolocalisation n'est pas supportée par ce navigateur.");
        }
    }

    function fetchDeliveries() {
        const type = document.getElementById('view-type').value;
        const date = document.getElementById('view-date').value;
        fetch('/livreur/fetch-deliveries', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ type, date })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                refreshTodayDeliveries(data.deliveries);
            }
        });
    }

    // Rafraîchit dynamiquement la liste des livraisons du jour
    function refreshTodayDeliveries(todayDeliveries) {
        const container = document.querySelector('.space-y-4');
        if (!container) return;
        container.innerHTML = '';
        if (todayDeliveries.length === 0) {
            container.innerHTML = '<p class="text-gray-500">Aucune livraison prévue pour cette période.</p>';
            return;
        }
        todayDeliveries.forEach(order => {
            const div = document.createElement('div');
            div.className = 'flex items-center space-x-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition';
            div.innerHTML = `
                <div class=\"flex-shrink-0\">
                    <div class=\"w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center\">
                        <span class=\"text-blue-600 font-medium\">${order.created_at ? (new Date(order.created_at)).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : ''}</span>
                    </div>
                </div>
                <div class=\"flex-grow\">
                    <h3 class=\"text-sm font-medium text-gray-900\">Commande #${order.id}</h3>
                    <p class=\"text-sm text-gray-600\">${order.products ? order.products.length : '?'} produits • ${order.distance_km !== null ? order.distance_km + ' km' : '? km'}</p>
                </div>
                <div class=\"flex items-center space-x-2\">
                    <a href=\"/livreurs/view-route/${order.id}\" class=\"btn btn-secondary btn-sm\">Voir détails</a>
                    ${order.status !== 'livré' ? `<form action=\"/livreurs/orders/${order.id}\" method=\"POST\" onsubmit=\"event.preventDefault();\"><input type=\"hidden\" name=\"_token\" value=\"${document.querySelector('meta[name=csrf-token]').getAttribute('content')}\"><input type=\"hidden\" name=\"_method\" value=\"PATCH\"><button class=\"btn btn-primary btn-sm\">Commencer</button></form>` : ''}
                </div>
            `;
            container.appendChild(div);
        });
    }

    // Rafraîchit à chaque changement de vue ou de date
    document.getElementById('view-type').addEventListener('change', function() {
        updateLivreurLocation(fetchDeliveries);
    });
    document.getElementById('view-date').addEventListener('change', function() {
        updateLivreurLocation(fetchDeliveries);
    });

    // Appel initial : position + fetch
    updateLivreurLocation(fetchDeliveries);
});
</script>
@endpush
@endsection 