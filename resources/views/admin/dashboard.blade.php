@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-white">
    <div class="container-nike py-12">
        
        <!-- Header - Style Nike -->
        <div class="text-center mb-16">
            <h1 class="nike-title mb-4">DASHBOARD ADMINISTRATEUR</h1>
            <div class="text-2xl font-bold text-black mb-4">
                {{ number_format($stats['revenue']['total_revenue'] ?? 0, 0, ',', ' ') }} FCFA
            </div>
            <p class="nike-text text-gray-600">Vue d'ensemble de votre plateforme</p>
        </div>

        <!-- Métriques principales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="card-nike">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Utilisateurs</p>
                        <p class="text-2xl font-bold text-black">{{ number_format($stats['users']['total_users'] ?? 0) }}</p>
                        <p class="text-xs text-gray-600">+{{ $stats['users']['new_users_this_month'] ?? 0 }} ce mois</p>
                    </div>
                    <div class="p-3 bg-gray-100 rounded-lg">
                        <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card-nike">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Commandes</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['orders']['total_orders'] ?? 0) }}</p>
                        <p class="text-xs text-gray-600">{{ $stats['orders']['orders_this_month'] ?? 0 }} ce mois</p>
                    </div>
                    <div class="p-3 bg-gray-100 rounded-lg">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card-nike">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Chiffre d'affaires</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['revenue']['total_revenue'] ?? 0, 0, ',', ' ') }} FCFA</p>
                        <p class="text-xs text-gray-600">{{ number_format($stats['revenue']['revenue_this_month'] ?? 0, 0, ',', ' ') }} ce mois</p>
                    </div>
                    <div class="p-3 bg-gray-100 rounded-lg">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card-nike">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Stock</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['inventory']['total_value'] ?? 0, 0, ',', ' ') }} FCFA</p>
                        <p class="text-xs text-gray-600">{{ $stats['inventory']['low_stock'] ?? 0 }} produits en stock faible</p>
                    </div>
                    <div class="p-3 bg-gray-100 rounded-lg">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistiques de visites -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="card-nike">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Visites aujourd'hui</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['visits']['today'] ?? 0) }}</p>
                        <p class="text-xs text-gray-600">{{ number_format($stats['visits']['unique_today'] ?? 0) }} visiteurs uniques</p>
                    </div>
                    <div class="p-3 bg-gray-100 rounded-lg">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card-nike">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Visites cette semaine</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['visits']['this_week'] ?? 0) }}</p>
                        <p class="text-xs text-gray-600">{{ number_format($stats['visits']['unique_week'] ?? 0) }} visiteurs uniques</p>
                    </div>
                    <div class="p-3 bg-gray-100 rounded-lg">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card-nike">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Durée moyenne</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['visits']['avg_duration'] ?? 0 }}s</p>
                        <p class="text-xs text-gray-600">Temps sur le site</p>
                    </div>
                    <div class="p-3 bg-gray-100 rounded-lg">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card-nike">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Taux de rebond</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['visits']['bounce_rate'] ?? 0 }}%</p>
                        <p class="text-xs text-gray-600">Visites d'une seule page</p>
                    </div>
                    <div class="p-3 bg-gray-100 rounded-lg">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphiques et statistiques -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            
            <!-- Ventes mensuelles -->
            <div class="card-nike">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Ventes mensuelles</h3>
                <div class="h-64 flex items-end justify-between space-x-2">
                    @php
                        $months = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai'];
                        $sales = [80000, 95000, 120000, 150000, 180000];
                        $maxSales = max($sales);
                    @endphp
                    @foreach($months as $index => $month)
                        @php
                            $height = ($sales[$index] / $maxSales) * 100;
                            $colors = ['bg-gray-200', 'bg-gray-300', 'bg-gray-400', 'bg-gray-500', 'bg-gray-600'];
                        @endphp
                        <div class="flex flex-col items-center flex-1">
                            <div class="w-full bg-gray-200 rounded-t-lg relative">
                                <div class="{{ $colors[$index] }} rounded-t-lg transition-all duration-500" style="height: {{ $height }}%"></div>
                            </div>
                            <span class="text-xs text-gray-600 mt-2">{{ $month }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Répartition des ventes -->
            <div class="card-nike">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Répartition des ventes</h3>
                <div class="flex items-center space-x-6">
                    <div class="relative w-32 h-32">
                        <svg class="w-32 h-32 transform -rotate-90" viewBox="0 0 36 36">
                            <path class="text-gray-200" stroke="currentColor" stroke-width="2" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                            <path class="text-gray-700" stroke="currentColor" stroke-width="2" fill="none" stroke-dasharray="40, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                            <path class="text-gray-500" stroke="currentColor" stroke-width="2" fill="none" stroke-dasharray="30, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                            <path class="text-gray-600" stroke="currentColor" stroke-width="2" fill="none" stroke-dasharray="20, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                            <path class="text-gray-700" stroke="currentColor" stroke-width="2" fill="none" stroke-dasharray="10, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                        </svg>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-4 h-4 bg-gray-400 rounded"></div>
                            <span class="text-sm text-gray-700">Apple</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-4 h-4 bg-gray-500 rounded"></div>
                            <span class="text-sm text-gray-700">Samsung</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-4 h-4 bg-gray-600 rounded"></div>
                            <span class="text-sm text-gray-700">Huawei</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-4 h-4 bg-gray-300 rounded"></div>
                            <span class="text-sm text-gray-700">Autres</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistiques de stock -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- État du stock -->
            <div class="card-nike">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">État du stock</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-gray-500 rounded-full"></div>
                            <span class="font-medium text-gray-900">En stock</span>
                        </div>
                        <span class="font-bold text-gray-900">{{ $stats['inventory']['in_stock'] ?? 0 }} produits</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-gray-600 rounded-full"></div>
                            <span class="font-medium text-gray-900">Stock faible</span>
                        </div>
                        <span class="font-bold text-gray-900">{{ $stats['inventory']['low_stock'] ?? 0 }} produits</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-gray-700 rounded-full"></div>
                            <span class="font-medium text-gray-900">Rupture de stock</span>
                        </div>
                        <span class="font-bold text-gray-900">{{ $stats['inventory']['out_of_stock'] ?? 0 }} produits</span>
                    </div>
                </div>
            </div>

            <!-- Produits les plus vendus -->
            <div class="card-nike">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Produits les plus vendus</h3>
                <div class="space-y-4">
                    @if(isset($stats['products']['top_selling_products']) && $stats['products']['top_selling_products']->count() > 0)
                        @foreach($stats['products']['top_selling_products']->take(3) as $product)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 bg-gray-500 rounded-full"></div>
                                <span class="font-medium text-gray-900">{{ $product->name }}</span>
                            </div>
                            <span class="font-bold text-gray-900">{{ number_format($product->price, 0, ',', ' ') }} FCFA</span>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center text-gray-500 py-4">
                            <p>Aucun produit vendu pour le moment</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
            <a href="{{ route('admin.users.index') }}" class="card-nike hover:shadow-md transition-shadow">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-gray-100 rounded-lg">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Gestion Utilisateurs</h4>
                        <p class="text-sm text-gray-600">Gérer les comptes</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.orders.index') }}" class="card-nike hover:shadow-md transition-shadow">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-gray-100 rounded-lg">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Commandes</h4>
                        <p class="text-sm text-gray-600">Suivre les livraisons</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.stocks.index') }}" class="card-nike hover:shadow-md transition-shadow">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-gray-100 rounded-lg">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Gestion Stock</h4>
                        <p class="text-sm text-gray-600">Contrôler l'inventaire</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.analytics.index') }}" class="card-nike hover:shadow-md transition-shadow">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-gray-100 rounded-lg">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Analytics Visites</h4>
                        <p class="text-sm text-gray-600">Statistiques détaillées</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('trades.search') }}" class="card-nike hover:shadow-md transition-shadow">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-gray-100 rounded-lg">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Système de Troc</h4>
                        <p class="text-sm text-gray-600">Gérer les échanges</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Section Codes Promos -->
        <div class="card-nike mb-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">🎫 Gestion des Codes Promos</h3>
                    <p class="text-gray-600">Créer et gérer les codes de réduction</p>
                </div>
                <a href="{{ route('admin.promos.index') }}" class="bg-black hover:bg-gray-800 text-white px-6 py-3 rounded-lg font-semibold shadow-lg hover:shadow-lg transition-all duration-300">
                    <i class="fas fa-plus mr-2"></i>Gérer les Codes Promos
                </a>
            </div>
            
            <!-- Statistiques des codes promos -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Codes</p>
                            <p class="text-2xl font-bold text-black">{{ $promoStats['total'] ?? 0 }}</p>
                        </div>
                        <div class="p-2 bg-gray-200 rounded-lg">
                            <i class="fas fa-ticket-alt text-gray-600"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Codes Actifs</p>
                            <p class="text-2xl font-bold text-black">{{ $promoStats['active'] ?? 0 }}</p>
                        </div>
                        <div class="p-2 bg-gray-200 rounded-lg">
                            <i class="fas fa-check-circle text-gray-600"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Codes Expirés</p>
                            <p class="text-2xl font-bold text-black">{{ $promoStats['expired'] ?? 0 }}</p>
                        </div>
                        <div class="p-2 bg-gray-200 rounded-lg">
                            <i class="fas fa-clock text-gray-600"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Codes Utilisés</p>
                            <p class="text-2xl font-bold text-black">{{ $promoStats['used'] ?? 0 }}</p>
                        </div>
                        <div class="p-2 bg-gray-200 rounded-lg">
                            <i class="fas fa-users text-gray-600"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Actions rapides -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('admin.promos.create') }}" class="bg-white border-2 border-gray-200 hover:border-gray-300 rounded-lg p-4 text-center transition-all duration-200 hover:shadow-md">
                    <i class="fas fa-plus-circle text-2xl text-gray-600 mb-2"></i>
                    <h4 class="font-semibold text-gray-900">Nouveau Code</h4>
                    <p class="text-sm text-gray-600">Créer un code promo</p>
                </a>
                
                <a href="{{ route('admin.promos.index') }}" class="bg-white border-2 border-gray-200 hover:border-gray-300 rounded-lg p-4 text-center transition-all duration-200 hover:shadow-md">
                    <i class="fas fa-list text-2xl text-gray-600 mb-2"></i>
                    <h4 class="font-semibold text-gray-900">Voir Tous</h4>
                    <p class="text-sm text-gray-600">Liste des codes promos</p>
                </a>
                
                <a href="{{ route('admin.promos.export') }}" class="bg-white border-2 border-gray-200 hover:border-gray-300 rounded-lg p-4 text-center transition-all duration-200 hover:shadow-md">
                    <i class="fas fa-download text-2xl text-gray-600 mb-2"></i>
                    <h4 class="font-semibold text-gray-900">Exporter</h4>
                    <p class="text-sm text-gray-600">Télécharger en CSV</p>
                </a>
            </div>
        </div>

        <!-- Commandes récentes -->
        @if(isset($stats['orders']['recent_orders']) && $stats['orders']['recent_orders']->count() > 0)
        <div class="card-nike">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Commandes récentes</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-gray-600 hover:text-black text-sm font-medium">Voir tout →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($stats['orders']['recent_orders']->take(5) as $order)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $order->user->name ?? 'N/A' }}</div>
                                <div class="text-sm text-gray-500">{{ $order->user->email ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format($order->total_price, 0, ',', ' ') }} FCFA
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($order->status === 'livré') bg-gray-100 text-green-800
                                    @elseif($order->status === 'en attente') bg-gray-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection