@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 p-6">
    <!-- En-tête avec animation -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 space-y-4 md:space-y-0">
        <div class="space-y-2">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-gradient-to-r from-red-500 to-pink-600 rounded-lg shadow-lg animate-pulse">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                    Analytics en Temps Réel
                </h1>
            </div>
            <p class="text-gray-600 font-medium">Surveillance en direct de l'activité du site</p>
        </div>
        
        <div class="flex items-center space-x-4">
            <div class="flex items-center space-x-2 bg-green-100 text-green-800 px-4 py-2 rounded-full">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                <span class="font-medium">En ligne</span>
        </div>
            <button class="bg-gradient-to-r from-red-500 to-pink-600 text-white px-6 py-3 rounded-xl font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Actualiser
            </button>
        </div>
    </div>

    <!-- Statistiques en temps réel avec animations -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <!-- Visiteurs Actuels -->
        <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 group">
            <div class="flex items-center justify-between">
                <div class="space-y-2">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Visiteurs Actuels</p>
                    <p class="text-3xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">
                        {{ $activeVisitors ?? 0 }}
                    </p>
                        </div>
                <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-200">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                        </div>
                    </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex items-center space-x-2 text-sm">
                    <span class="text-green-600 font-medium">+5</span>
                    <span class="text-gray-500">cette minute</span>
                </div>
            </div>
        </div>

        <!-- Pages Vues Aujourd'hui -->
        <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 group">
            <div class="flex items-center justify-between">
                <div class="space-y-2">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Pages Vues (Aujourd'hui)</p>
                    <p class="text-3xl font-bold text-gray-900 group-hover:text-green-600 transition-colors duration-200">
                        {{ number_format($todayViews ?? 0) }}
                    </p>
                        </div>
                <div class="p-3 bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-200">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                        </div>
                    </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex items-center space-x-2 text-sm">
                    <span class="text-green-600 font-medium">+12</span>
                    <span class="text-gray-500">cette minute</span>
                </div>
            </div>
        </div>

        <!-- Sessions Actives -->
        <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 group">
            <div class="flex items-center justify-between">
                <div class="space-y-2">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Sessions Actives</p>
                    <p class="text-3xl font-bold text-gray-900 group-hover:text-purple-600 transition-colors duration-200">
                        {{ $activeSessions ?? 0 }}
                    </p>
                        </div>
                <div class="p-3 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-200">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                        </div>
                    </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex items-center space-x-2 text-sm">
                    <span class="text-green-600 font-medium">+3</span>
                    <span class="text-gray-500">cette minute</span>
                </div>
            </div>
        </div>

        <!-- Taux de Rebond -->
        <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 group">
            <div class="flex items-center justify-between">
                <div class="space-y-2">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Taux de Rebond</p>
                    <p class="text-3xl font-bold text-gray-900 group-hover:text-amber-600 transition-colors duration-200">
                        {{ $bounceRate ?? 0 }}<span class="text-lg text-gray-500">%</span>
                    </p>
                        </div>
                <div class="p-3 bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-200">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                    </svg>
                        </div>
                    </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex items-center space-x-2 text-sm">
                    <span class="text-red-600 font-medium">-2%</span>
                    <span class="text-gray-500">cette heure</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques et visualisations -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mb-8">
        <!-- Graphique d'activité en temps réel -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Activité en Temps Réel (24h)
                </h3>
                        </div>
            <div class="p-6">
                <canvas id="realtimeChart" width="400" height="200"></canvas>
                    </div>
                </div>

        <!-- Répartition géographique -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Répartition Géographique
                </h3>
                    </div>
            <div class="p-6">
                <canvas id="geoChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

    <!-- Visiteurs en temps réel -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
                Visiteurs Actuels
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @for($i = 0; $i < 6; $i++)
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-4 border border-blue-100">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-sm">{{ chr(65 + $i) }}</span>
                </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">Visiteur {{ $i + 1 }}</p>
                            <p class="text-sm text-gray-600">{{ ['Accueil', 'Produits', 'Panier', 'Profil', 'Contact', 'À propos'][$i] }}</p>
                            </div>
                            <div class="text-right">
                            <p class="text-xs text-gray-500">{{ rand(1, 59) }}s</p>
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                            </div>
                        </div>
                </div>
                @endfor
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Graphique en temps réel
const realtimeCtx = document.getElementById('realtimeChart').getContext('2d');
const realtimeChart = new Chart(realtimeCtx, {
    type: 'line',
    data: {
        labels: Array.from({length: 24}, (_, i) => `${i}:00`),
        datasets: [{
            label: 'Visiteurs actifs',
            data: Array.from({length: 24}, () => Math.floor(Math.random() * 50) + 10),
            borderColor: 'rgb(239, 68, 68)',
            backgroundColor: 'rgba(239, 68, 68, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        },
        animation: {
            duration: 1000
        }
    }
});

// Graphique géographique
const geoCtx = document.getElementById('geoChart').getContext('2d');
new Chart(geoCtx, {
    type: 'doughnut',
    data: {
        labels: ['Sénégal', 'France', 'États-Unis', 'Canada', 'Autres'],
        datasets: [{
            data: [45, 25, 15, 10, 5],
            backgroundColor: [
                'rgb(34, 197, 94)',
                'rgb(59, 130, 246)',
                'rgb(239, 68, 68)',
                'rgb(168, 85, 247)',
                'rgb(156, 163, 175)'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Simulation de données en temps réel
setInterval(() => {
    // Mettre à jour les données du graphique
    const newData = realtimeChart.data.datasets[0].data.map(() => Math.floor(Math.random() * 50) + 10);
    realtimeChart.data.datasets[0].data = newData;
    realtimeChart.update('none');
    
    // Mettre à jour les compteurs
    const counters = document.querySelectorAll('.text-3xl');
    counters.forEach(counter => {
        const currentValue = parseInt(counter.textContent.replace(/,/g, ''));
        const newValue = currentValue + Math.floor(Math.random() * 3);
        counter.textContent = newValue.toLocaleString();
    });
}, 5000);
</script>
@endsection
