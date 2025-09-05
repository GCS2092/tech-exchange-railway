@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 p-6">
    <!-- En-tête avec animation -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 space-y-4 md:space-y-0">
        <div class="space-y-2">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-gradient-to-r from-orange-500 to-red-500 rounded-lg shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                    Pages les Plus Populaires
                </h1>
            </div>
            <p class="text-gray-600 font-medium">Analyse détaillée de vos pages les plus visitées</p>
        </div>
        
        <div class="flex items-center space-x-4">
            <div class="relative">
                <select id="timeRange" class="appearance-none bg-white border border-gray-200 rounded-xl px-4 py-3 pr-10 text-gray-700 font-medium shadow-sm hover:shadow-md transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
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
        <!-- Total Pages Vues -->
        <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 group">
            <div class="flex items-center justify-between">
                <div class="space-y-2">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Total Pages Vues</p>
                    <p class="text-3xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">
                        {{ number_format($totalViews ?? 0) }}
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
                    <span class="text-green-600 font-medium">+12.5%</span>
                    <span class="text-gray-500">vs période précédente</span>
                </div>
            </div>
        </div>

        <!-- Pages Uniques -->
        <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 group">
            <div class="flex items-center justify-between">
                <div class="space-y-2">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Pages Uniques</p>
                    <p class="text-3xl font-bold text-gray-900 group-hover:text-green-600 transition-colors duration-200">
                        {{ number_format(isset($topPages) ? $topPages->count() : 0) }}
                    </p>
                        </div>
                <div class="p-3 bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-200">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                        </div>
                    </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex items-center space-x-2 text-sm">
                    <span class="text-green-600 font-medium">+8.3%</span>
                    <span class="text-gray-500">vs période précédente</span>
                </div>
            </div>
        </div>

        <!-- Temps Moyen -->
        <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 group">
            <div class="flex items-center justify-between">
                <div class="space-y-2">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Temps Moyen</p>
                    <p class="text-3xl font-bold text-gray-900 group-hover:text-purple-600 transition-colors duration-200">
                        {{ isset($topPages) && $topPages->count() > 0 ? round($topPages->avg('avg_time'), 1) : 0 }} <span class="text-lg text-gray-500">min</span>
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
                    <span class="text-red-600 font-medium">-2.1%</span>
                    <span class="text-gray-500">vs période précédente</span>
                </div>
            </div>
        </div>

        <!-- Taux de Rebond -->
        <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 group">
            <div class="flex items-center justify-between">
                <div class="space-y-2">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Taux de Rebond</p>
                    <p class="text-3xl font-bold text-gray-900 group-hover:text-amber-600 transition-colors duration-200">
                        {{ 0 }}<span class="text-lg text-gray-500">%</span>
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
                    <span class="text-green-600 font-medium">-5.7%</span>
                    <span class="text-gray-500">vs période précédente</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <!-- Tableau des top pages -->
        <div class="xl:col-span-2">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Top 20 des Pages</h3>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Rang</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Page</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Vues</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">% du Total</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Temps</th>
                                </tr>
                            </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                                @if(isset($topPages) && count($topPages) > 0)
                                    @foreach($topPages as $index => $page)
                                <tr class="hover:bg-gray-50 transition-colors duration-150 group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($index < 3)
                                            <div class="flex items-center space-x-2">
                                                <div class="w-8 h-8 bg-gradient-to-r {{ $index == 0 ? 'from-yellow-400 to-yellow-500' : ($index == 1 ? 'from-gray-300 to-gray-400' : 'from-orange-400 to-orange-500') }} rounded-full flex items-center justify-center text-white font-bold text-sm">
                                                    {{ $index + 1 }}
                                                </div>
                                                @if($index == 0)
                                                    <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @endif
                                            </div>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                #{{ $index + 1 }}
                                            </span>
                                        @endif
                                        </td>
                                    <td class="px-6 py-4">
                                        <div class="space-y-1">
                                            <div class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">
                                                {{ $page->page_name ?? 'Page inconnue' }}
                                            </div>
                                            <div class="text-sm text-gray-500 font-mono bg-gray-50 rounded px-2 py-1 inline-block">
                                                {{ Str::limit($page->url ?? 'N/A', 40) }}
                                            </div>
                                        </div>
                                        </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-lg font-bold text-gray-900">{{ number_format($page->views ?? 0) }}</span>
                                            <div class="flex items-center text-green-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                                                </svg>
                                                </div>
                                            </div>
                                        </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full transition-all duration-500 ease-out" 
                                                 style="width: {{ $totalViews > 0 ? ($page->views / $totalViews) * 100 : 0 }}%">
                                            </div>
                                        </div>
                                        <div class="text-sm font-medium text-gray-700 mt-1">
                                            {{ $totalViews > 0 ? number_format(($page->views / $totalViews) * 100, 1) : 0 }}%
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                            {{ $page->avg_time ?? 0 }} min
                                        </span>
                                    </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                        <div class="space-y-3">
                                            <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <p class="text-lg font-medium">Aucune donnée disponible</p>
                                            <p class="text-sm">Les données apparaîtront ici une fois le trafic enregistré</p>
                                        </div>
                                    </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        <!-- Sidebar avec graphiques -->
        <div class="space-y-8">
            <!-- Répartition par appareil -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-gradient-to-r from-green-500 to-teal-600 rounded-lg">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Répartition par Appareil</h3>
        </div>
                </div>
                <div class="p-6">
                    <div class="relative h-64">
                        <canvas id="deviceChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Top navigateurs -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Top Navigateurs</h3>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    @if(isset($browserStats) && count($browserStats) > 0)
                        @foreach($browserStats as $index => $browser)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br {{ 
                                    $index == 0 ? 'from-blue-500 to-blue-600' : 
                                    ($index == 1 ? 'from-green-500 to-green-600' : 'from-purple-500 to-purple-600')
                                }} rounded-lg flex items-center justify-center text-white font-bold">
                                    {{ $index + 1 }}
                                </div>
                            <div>
                                    <div class="font-semibold text-gray-900">{{ $browser->browser ?? 'Inconnu' }}</div>
                                    <div class="text-sm text-gray-500">{{ number_format($browser->count) }} utilisateurs</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    {{ isset($totalUsers) && $totalUsers > 0 ? number_format(($browser->count / $totalUsers) * 100, 1) : 0 }}%
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"/>
                            </svg>
                            <p class="font-medium">Aucune donnée disponible</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Graphique des appareils avec style amélioré
const deviceCtx = document.getElementById('deviceChart').getContext('2d');
const deviceChart = new Chart(deviceCtx, {
    type: 'doughnut',
    data: {
        labels: @json($deviceLabels ?? ['Desktop', 'Mobile', 'Tablet']),
        datasets: [{
            data: @json($deviceData ?? [45, 35, 20]),
            backgroundColor: [
                'rgba(59, 130, 246, 0.8)',
                'rgba(16, 185, 129, 0.8)',
                'rgba(139, 92, 246, 0.8)',
                'rgba(245, 158, 11, 0.8)',
                'rgba(239, 68, 68, 0.8)'
            ],
            borderColor: [
                'rgba(59, 130, 246, 1)',
                'rgba(16, 185, 129, 1)',
                'rgba(139, 92, 246, 1)',
                'rgba(245, 158, 11, 1)',
                'rgba(239, 68, 68, 1)'
            ],
            borderWidth: 2,
            hoverOffset: 8
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
                    usePointStyle: true,
                    font: {
                        size: 12,
                        weight: '500'
                    }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                titleColor: '#fff',
                bodyColor: '#fff',
                borderColor: 'rgba(255, 255, 255, 0.2)',
                borderWidth: 1,
                cornerRadius: 8,
                displayColors: false
            }
        },
        cutout: '65%'
    }
});

// Animation au changement de période
document.getElementById('timeRange').addEventListener('change', function() {
    const period = this.value;
    
    // Animation de transition
    document.body.style.opacity = '0.7';
    setTimeout(() => {
    window.location.href = `{{ route('admin.analytics.top-pages') }}?period=${period}`;
    }, 200);
});

// Animation d'apparition au chargement
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.xl\\:col-span-2 > div, .space-y-8 > div');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease-out';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
@endpush
@endsection
