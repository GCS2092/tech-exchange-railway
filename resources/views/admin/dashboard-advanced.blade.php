@extends('layouts.admin')

@section('title', 'Tableau de Bord Avancé - Admin')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header avec boutons d'export -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Tableau de Bord Avancé</h1>
                    <p class="text-gray-600 mt-1">Vue d'ensemble complète de votre plateforme</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.dashboard.export.pdf') }}" 
                       class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"></path>
                        </svg>
                        Exporter PDF
                    </a>
                    <a href="{{ route('admin.dashboard.export.excel') }}" 
                       class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" clip-rule="evenodd"></path>
                        </svg>
                        Exporter Excel
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Statistiques générales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Utilisateurs totaux</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_users']) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Produits totaux</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_products']) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Commandes totales</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_orders']) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Troc totaux</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_trades']) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistiques du mois -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Statistiques du mois en cours</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="text-center">
                    <p class="text-sm text-gray-600">Nouveaux utilisateurs</p>
                    <p class="text-xl font-bold text-blue-600">{{ $monthlyStats['new_users'] }}</p>
                    @if(isset($lastMonthStats['new_users']) && $lastMonthStats['new_users'] > 0)
                        @php $growth = (($monthlyStats['new_users'] - $lastMonthStats['new_users']) / $lastMonthStats['new_users']) * 100; @endphp
                        <p class="text-sm {{ $growth >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $growth >= 0 ? '+' : '' }}{{ number_format($growth, 1) }}% vs mois dernier
                        </p>
                    @endif
                </div>
                <div class="text-center">
                    <p class="text-sm text-gray-600">Nouvelles commandes</p>
                    <p class="text-xl font-bold text-green-600">{{ $monthlyStats['new_orders'] }}</p>
                    @if(isset($lastMonthStats['new_orders']) && $lastMonthStats['new_orders'] > 0)
                        @php $growth = (($monthlyStats['new_orders'] - $lastMonthStats['new_orders']) / $lastMonthStats['new_orders']) * 100; @endphp
                        <p class="text-sm {{ $growth >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $growth >= 0 ? '+' : '' }}{{ number_format($growth, 1) }}% vs mois dernier
                        </p>
                    @endif
                </div>
                <div class="text-center">
                    <p class="text-sm text-gray-600">Revenus du mois</p>
                    <p class="text-xl font-bold text-purple-600">{{ \App\Helpers\CurrencyHelper::formatXOF($monthlyStats['monthly_revenue']) }}</p>
                    @if(isset($lastMonthStats['monthly_revenue']) && $lastMonthStats['monthly_revenue'] > 0)
                        @php $growth = (($monthlyStats['monthly_revenue'] - $lastMonthStats['monthly_revenue']) / $lastMonthStats['monthly_revenue']) * 100; @endphp
                        <p class="text-sm {{ $growth >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $growth >= 0 ? '+' : '' }}{{ number_format($growth, 1) }}% vs mois dernier
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Graphiques et visualisations -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Évolution des utilisateurs -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Évolution des utilisateurs (6 derniers mois)</h3>
                <div class="h-64">
                    <canvas id="userEvolutionChart"></canvas>
                </div>
            </div>

            <!-- Répartition des utilisateurs par rôle -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Répartition des utilisateurs par rôle</h3>
                <div class="h-64">
                    <canvas id="usersByRoleChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Commandes et Troc -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Répartition des commandes par statut -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Répartition des commandes par statut</h3>
                <div class="h-64">
                    <canvas id="ordersByStatusChart"></canvas>
                </div>
            </div>

            <!-- Répartition des trocs par type d'appareil -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Troc par type d'appareil</h3>
                <div class="h-64">
                    <canvas id="tradesByDeviceTypeChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Stock et Produits -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Stock disponible par catégorie -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Stock disponible par catégorie</h3>
                <div class="space-y-3">
                    @foreach($stockByCategory as $category)
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700">{{ $category->name }}</span>
                            <span class="text-sm font-bold text-blue-600">{{ number_format($category->total_stock) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Top 5 des produits les plus vendus -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Top 5 des produits les plus vendus</h3>
                <div class="space-y-3">
                    @foreach($topProducts as $product)
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700 truncate">{{ $product->name }}</span>
                            <span class="text-sm font-bold text-green-600">{{ number_format($product->total_sold) }} vendus</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Activité récente -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Commandes récentes -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Commandes récentes</h3>
                <div class="space-y-3">
                    @foreach($recentOrders as $order)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="text-sm font-medium text-gray-900">#{{ $order->id }}</p>
                                <p class="text-xs text-gray-600">{{ $order->user->name ?? 'Utilisateur supprimé' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-gray-900">{{ \App\Helpers\CurrencyHelper::formatXOF($order->total_price) }}</p>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                       ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                       'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Troc récents -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Troc récents</h3>
                <div class="space-y-3">
                    @foreach($recentTrades as $trade)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $trade->product->name ?? 'Produit supprimé' }}</p>
                                <p class="text-xs text-gray-600">{{ $trade->user->name ?? 'Utilisateur supprimé' }}</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $trade->status === 'accepted' ? 'bg-green-100 text-green-800' : 
                                   ($trade->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   'bg-red-100 text-red-800') }}">
                                {{ ucfirst($trade->status) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Statistiques des codes promos et visites -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Codes promos -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Codes promos</h3>
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div>
                        <p class="text-2xl font-bold text-purple-600">{{ $promoStats['total_promos'] }}</p>
                        <p class="text-sm text-gray-600">Total</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-green-600">{{ $promoStats['active_promos'] }}</p>
                        <p class="text-sm text-gray-600">Actifs</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-blue-600">{{ $promoStats['total_usage'] }}</p>
                        <p class="text-sm text-gray-600">Utilisations</p>
                    </div>
                </div>
            </div>

            <!-- Visites -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Visites</h3>
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div>
                        <p class="text-2xl font-bold text-indigo-600">{{ number_format($visits['today']) }}</p>
                        <p class="text-sm text-gray-600">Aujourd'hui</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-indigo-600">{{ number_format($visits['this_week']) }}</p>
                        <p class="text-sm text-gray-600">Cette semaine</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-indigo-600">{{ number_format($visits['this_month']) }}</p>
                        <p class="text-sm text-gray-600">Ce mois</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Évolution des utilisateurs
    const userEvolutionCtx = document.getElementById('userEvolutionChart').getContext('2d');
    new Chart(userEvolutionCtx, {
        type: 'line',
        data: {
            labels: @json(collect($userEvolution)->pluck('month')),
            datasets: [{
                label: 'Nouveaux utilisateurs',
                data: @json(collect($userEvolution)->pluck('users')),
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Répartition des utilisateurs par rôle
    const usersByRoleCtx = document.getElementById('usersByRoleChart').getContext('2d');
    new Chart(usersByRoleCtx, {
        type: 'doughnut',
        data: {
            labels: @json(collect($usersByRole)->pluck('name')),
            datasets: [{
                data: @json(collect($usersByRole)->pluck('count')),
                backgroundColor: [
                    'rgb(59, 130, 246)',
                    'rgb(16, 185, 129)',
                    'rgb(245, 158, 11)',
                    'rgb(239, 68, 68)',
                    'rgb(139, 92, 246)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Répartition des commandes par statut
    const ordersByStatusCtx = document.getElementById('ordersByStatusChart').getContext('2d');
    new Chart(ordersByStatusCtx, {
        type: 'pie',
        data: {
            labels: @json(collect($ordersByStatus)->pluck('status')),
            datasets: [{
                data: @json(collect($ordersByStatus)->pluck('count')),
                backgroundColor: [
                    'rgb(16, 185, 129)',
                    'rgb(245, 158, 11)',
                    'rgb(239, 68, 68)',
                    'rgb(107, 114, 128)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Répartition des trocs par type d'appareil
    const tradesByDeviceTypeCtx = document.getElementById('tradesByDeviceTypeChart').getContext('2d');
    new Chart(tradesByDeviceTypeCtx, {
        type: 'bar',
        data: {
            labels: @json(collect($tradesByDeviceType)->pluck('device_type')),
            datasets: [{
                label: 'Nombre de trocs',
                data: @json(collect($tradesByDeviceType)->pluck('count')),
                backgroundColor: 'rgba(139, 92, 246, 0.8)',
                borderColor: 'rgb(139, 92, 246)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
@endsection 