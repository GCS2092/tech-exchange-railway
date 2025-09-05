@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 p-6">
    <!-- En-tête avec animation -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 space-y-4 md:space-y-0">
        <div class="space-y-2">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                    Analytics des Visites
                </h1>
            </div>
            <p class="text-gray-600 font-medium">Statistiques détaillées du trafic de votre site</p>
        </div>
        
        <div class="flex items-center space-x-4">
            <div class="relative">
                <select id="timeRange" class="appearance-none bg-white border border-gray-200 rounded-xl px-4 py-3 pr-10 text-gray-700 font-medium shadow-sm hover:shadow-md transition-all duration-200 focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                    <option value="7">7 derniers jours</option>
                    <option value="30" selected>30 derniers jours</option>
                    <option value="90">90 derniers jours</option>
                    <option value="365">1 an</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>
            <button class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-3 rounded-xl font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Exporter
            </button>
        </div>
        </div>

    <!-- Statistiques avec animations et gradients -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <!-- Vues totales -->
        <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 group">
                <div class="flex items-center justify-between">
                <div class="space-y-2">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Vues Totales</p>
                    <p class="text-3xl font-bold text-gray-900 group-hover:text-black transition-colors duration-200">
                        {{ number_format($performanceStats['total_page_views']) }}
                    </p>
                    </div>
                <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-200">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex items-center space-x-2 text-sm">
                    <span class="text-black font-medium">+15.2%</span>
                    <span class="text-gray-500">vs période précédente</span>
                </div>
            </div>
            </div>

        <!-- Visiteurs uniques -->
        <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 group">
                <div class="flex items-center justify-between">
                <div class="space-y-2">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Visiteurs Uniques</p>
                    <p class="text-3xl font-bold text-gray-900 group-hover:text-black transition-colors duration-200">
                        {{ number_format($performanceStats['total_unique_visitors']) }}
                    </p>
                    </div>
                <div class="p-3 bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-200">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                    </div>
                </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex items-center space-x-2 text-sm">
                    <span class="text-black font-medium">+8.7%</span>
                    <span class="text-gray-500">vs période précédente</span>
                </div>
            </div>
            </div>

        <!-- Durée moyenne -->
        <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 group">
                <div class="flex items-center justify-between">
                <div class="space-y-2">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Durée Moyenne</p>
                    <p class="text-3xl font-bold text-gray-900 group-hover:text-black transition-colors duration-200">
                        {{ $performanceStats['avg_session_duration'] }}<span class="text-lg text-gray-500">s</span>
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
                    <span class="text-black font-medium">+12.3%</span>
                    <span class="text-gray-500">vs période précédente</span>
                </div>
            </div>
            </div>

        <!-- Pages par session -->
        <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 group">
                <div class="flex items-center justify-between">
                <div class="space-y-2">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Pages/Session</p>
                    <p class="text-3xl font-bold text-gray-900 group-hover:text-amber-600 transition-colors duration-200">
                        {{ $performanceStats['pages_per_session'] }}
                    </p>
                    </div>
                <div class="p-3 bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-200">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex items-center space-x-2 text-sm">
                    <span class="text-black font-medium">+5.8%</span>
                    <span class="text-gray-500">vs période précédente</span>
                </div>
            </div>
            </div>
        </div>

        <!-- Statistiques par période -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Aujourd'hui -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-4">
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Aujourd'hui
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-600 font-medium">Vues</span>
                    <span class="font-bold text-gray-900">{{ number_format($stats['today']['total_views'] ?? 0) }}</span>
                    </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-600 font-medium">Visiteurs uniques</span>
                    <span class="font-bold text-gray-900">{{ number_format($stats['today']['unique_visitors'] ?? 0) }}</span>
                    </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-600 font-medium">Durée moyenne</span>
                    <span class="font-bold text-gray-900">{{ round($stats['today']['avg_duration'] ?? 0) }}s</span>
                    </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-gray-600 font-medium">Taux de rebond</span>
                    <span class="font-bold text-gray-900">{{ round($stats['today']['bounce_rate'] ?? 0, 1) }}%</span>
                    </div>
                </div>
            </div>

            <!-- Cette semaine -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Cette Semaine
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-600 font-medium">Vues</span>
                    <span class="font-bold text-gray-900">{{ number_format($stats['week']['total_views'] ?? 0) }}</span>
                    </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-600 font-medium">Visiteurs uniques</span>
                    <span class="font-bold text-gray-900">{{ number_format($stats['week']['unique_visitors'] ?? 0) }}</span>
                    </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-600 font-medium">Durée moyenne</span>
                    <span class="font-bold text-gray-900">{{ round($stats['week']['avg_duration'] ?? 0) }}s</span>
                    </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-gray-600 font-medium">Taux de rebond</span>
                    <span class="font-bold text-gray-900">{{ round($stats['week']['bounce_rate'] ?? 0, 1) }}%</span>
                    </div>
                </div>
            </div>

            <!-- Ce mois -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-6 py-4">
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Ce Mois
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-600 font-medium">Vues</span>
                    <span class="font-bold text-gray-900">{{ number_format($stats['month']['total_views'] ?? 0) }}</span>
                    </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-600 font-medium">Visiteurs uniques</span>
                    <span class="font-bold text-gray-900">{{ number_format($stats['month']['unique_visitors'] ?? 0) }}</span>
                    </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-600 font-medium">Durée moyenne</span>
                    <span class="font-bold text-gray-900">{{ round($stats['month']['avg_duration'] ?? 0) }}s</span>
                    </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-gray-600 font-medium">Taux de rebond</span>
                    <span class="font-bold text-gray-900">{{ round($stats['month']['bounce_rate'] ?? 0, 1) }}%</span>
                    </div>
                </div>
            </div>
        </div>

    <!-- Graphiques et visualisations -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
        <!-- Graphique des visites -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    Évolution des Visites
                </h3>
                    </div>
            <div class="p-6">
                <canvas id="visitsChart" width="400" height="200"></canvas>
                    </div>
                </div>

        <!-- Répartition par appareil -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    Répartition par Appareil
                </h3>
                    </div>
            <div class="p-6">
                <canvas id="deviceChart" width="400" height="200"></canvas>
                    </div>
                </div>
                    </div>
                </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Graphique des visites
const visitsCtx = document.getElementById('visitsChart').getContext('2d');
new Chart(visitsCtx, {
    type: 'line',
    data: {
        labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
        datasets: [{
            label: 'Visites',
            data: [65, 59, 80, 81, 56, 55, 40],
            borderColor: 'rgb(59, 130, 246)',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
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
        }
    }
});

// Graphique des appareils
const deviceCtx = document.getElementById('deviceChart').getContext('2d');
new Chart(deviceCtx, {
    type: 'doughnut',
    data: {
        labels: ['Desktop', 'Mobile', 'Tablet'],
        datasets: [{
            data: [45, 40, 15],
            backgroundColor: [
                'rgb(59, 130, 246)',
                'rgb(34, 197, 94)',
                'rgb(168, 85, 247)'
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
</script>
@endsection
