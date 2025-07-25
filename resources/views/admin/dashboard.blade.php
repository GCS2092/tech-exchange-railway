@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-indigo-50 to-blue-50 py-12" style="padding-top:6rem;">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <!-- En-tête du tableau de bord -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <div class="text-center md:text-left mb-6 md:mb-0">
                <h1 class="text-3xl md:text-4xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-blue-600">
                    Tableau de bord Administrateur
                </h1>
                <p class="mt-2 text-lg text-gray-600">Gestion complète de la plateforme</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="bg-white shadow-lg rounded-xl px-4 py-2 flex items-center">
                    <span class="text-sm font-medium text-gray-600 mr-2">Rôle:</span>
                    <span class="px-3 py-1 rounded-full text-sm font-semibold bg-indigo-100 text-indigo-800">
                        {{ auth()->user()->getRoleNames()->first() ?? 'Administrateur' }}
                    </span>
                </div>
                <a href="{{ route('profile.edit') }}" class="bg-white shadow-lg rounded-xl p-3 hover:bg-gray-50 transition-all duration-300 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 group-hover:text-indigo-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Statistiques principales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-xl p-6 transform transition-all duration-300 hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Utilisateurs</p>
                        <p class="text-2xl font-bold text-indigo-600">{{ $totalUsers }}</p>
                    </div>
                    <div class="bg-indigo-100 rounded-lg p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm text-green-600 font-medium">+{{ $activeUsers }} actifs</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-6 transform transition-all duration-300 hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Produits</p>
                        <p class="text-2xl font-bold text-blue-600">{{ isset($products) ? count($products) : 0 }}</p>
                    </div>
                    <div class="bg-blue-100 rounded-lg p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm text-gray-600">Gestion des stocks</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-6 transform transition-all duration-300 hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Commandes</p>
                        <p class="text-2xl font-bold text-purple-600">{{ $stats['total_orders'] ?? 0 }}</p>
                    </div>
                    <div class="bg-purple-100 rounded-lg p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm text-gray-600">Suivi des commandes</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-6 transform transition-all duration-300 hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Transactions</p>
                        <p class="text-2xl font-bold text-green-600">{{ $stats['total_transactions'] ?? 0 }}</p>
                    </div>
                    <div class="bg-green-100 rounded-lg p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm text-gray-600">{{ number_format($stats['total_amount'] ?? 0, 0, ',', ' ') }} FCFA</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-6 transform transition-all duration-300 hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Administrateurs</p>
                        <p class="text-2xl font-bold text-orange-600">{{ $adminsCount }}</p>
                    </div>
                    <div class="bg-orange-100 rounded-lg p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm text-gray-600">Gestion des accès</span>
                </div>
            </div>
        </div>

        <!-- Histogramme compact des commandes par statut -->
        <div class="w-full md:w-1/2 lg:w-1/3 mx-auto mb-8">
            <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center">
                <h2 class="text-base font-semibold text-gray-800 mb-2">Commandes par statut</h2>
                <canvas id="ordersStatusBarChartDashboard" height="120"></canvas>
            </div>
        </div>
        <!-- Fin histogramme -->

        <!-- Actions rapides -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Actions rapides</h2>
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('products.create') }}" class="bg-indigo-600 text-white p-4 rounded-xl hover:bg-indigo-700 transition-colors text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Ajouter un produit
                    </a>
                    <a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white p-4 rounded-xl hover:bg-blue-700 transition-colors text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Ajouter un utilisateur
                    </a>
                    <a href="{{ route('categories.create') }}" class="bg-purple-600 text-white p-4 rounded-xl hover:bg-purple-700 transition-colors text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        Gérer les catégories
                    </a>
                    <a href="{{ route('promos.create') }}" class="bg-green-600 text-white p-4 rounded-xl hover:bg-green-700 transition-colors text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Gérer les codes promos
                    </a>
                    <a href="{{ route('admin.transactions.index') }}" class="bg-yellow-600 text-white p-4 rounded-xl hover:bg-yellow-700 transition-colors text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                        </svg>
                        Gérer les transactions
                    </a>
                    <a href="{{ route('notifications.index') }}" class="bg-red-600 text-white p-4 rounded-xl hover:bg-red-700 transition-colors text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        Notifications
                    </a>
                </div>
            </div>

            <!-- Liste des commandes récentes -->
            <div class="bg-white rounded-2xl shadow-xl p-6 lg:col-span-2">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Commandes récentes</h2>
                    <a href="{{ route('admin.orders.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Voir toutes les commandes
                    </a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg overflow-hidden">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @if(isset($stats['recent_orders']) && count($stats['recent_orders']) > 0)
                                @foreach ($stats['recent_orders'] as $order)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $order->id }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ optional($order->user)->name ?? 'Inconnu' }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ number_format($order->total_price, 2) }} {{ $order->currency }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $order->status == 'en attente' ? 'bg-yellow-100 text-yellow-800' : ($order->status == 'expédié' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="px-4 py-3 text-center text-sm text-gray-500">
                                        Aucune commande récente disponible
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Liste des produits -->
            <div class="bg-white rounded-2xl shadow-xl p-6 lg:col-span-2">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Produits récents</h2>
                    <div class="flex space-x-4">
                        <form action="{{ route('admin.dashboard') }}" method="GET" class="flex items-center">
                            <select name="filter" class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg shadow-sm" onchange="this.form.submit()">
                                <option value="name_asc" {{ request('filter') == 'name_asc' ? 'selected' : '' }}>A-Z</option>
                                <option value="name_desc" {{ request('filter') == 'name_desc' ? 'selected' : '' }}>Z-A</option>
                                <option value="price_asc" {{ request('filter') == 'price_asc' ? 'selected' : '' }}>Prix ↑</option>
                                <option value="price_desc" {{ request('filter') == 'price_desc' ? 'selected' : '' }}>Prix ↓</option>
                            </select>
                        </form>
                        <form action="{{ route('admin.dashboard') }}" method="GET" class="flex items-center">
                            <input type="text" name="name" value="{{ request('name') }}" class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg shadow-sm" placeholder="Rechercher" onchange="this.form.submit()">
                        </form>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg overflow-hidden">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catégorie</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @if(isset($products) && count($products) > 0)
                                @foreach ($products->take(5) as $product)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-lg object-cover" src="{{ $product->image }}" alt="{{ $product->name }}">
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                        {{ number_format($product->price, 0, ',', ' ') }}
                                        @if(isset($product->currency) && $product->currency === 'XOF')
                                            FCFA
                                        @else
                                            {{ $product->currency ?? '€' }}
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-indigo-100 text-indigo-800">
                                            {{ optional($product->category)->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('products.edit', $product->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="px-4 py-3 text-center text-sm text-gray-500">
                                        Aucun produit disponible
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Liste des utilisateurs -->
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Utilisateurs récents</h2>
                <a href="{{ route('admin.users.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Ajouter un utilisateur
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg overflow-hidden">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôle</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @if(isset($users) && count($users) > 0)
                            @foreach ($users->take(5) as $user)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-indigo-100 text-indigo-800">
                                        {{ $user->roles->first()->name ?? 'user' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        @if ($user->id !== auth()->id())
                                            <button onclick="showBlockModal({{ $user->id }}, '{{ $user->name }}', {{ $user->is_blocked ? 'true' : 'false' }})" class="flex items-center gap-1 px-3 py-1 font-bold uppercase tracking-wide rounded-lg shadow-sm transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 {{ $user->is_blocked ? 'bg-green-100 text-green-800 border border-green-300 hover:bg-green-200' : 'bg-red-600 text-white border border-red-700 hover:bg-red-700' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11V7a4 4 0 118 0v4m-4 4v4m0 0H8m4 0h4" />
                                                </svg>
                                                {{ $user->is_blocked ? 'Débloquer' : 'Bloquer' }}
                                            </button>
                                            <button type="button" class="text-red-600 hover:text-red-900" onclick="openDeleteModal('{{ $user->id }}', '{{ $user->name }}')">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="px-4 py-3 text-center text-sm text-gray-500">
                                    Aucun utilisateur disponible
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal de confirmation de suppression -->
        <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-2xl bg-white">
                <div class="mt-3 text-center">
                    <h3 class="text-lg font-medium text-gray-900">Confirmer la suppression</h3>
                    <div class="mt-2 px-7 py-3">
                        <p class="text-sm text-gray-500">Vous êtes sur le point de supprimer l'utilisateur <span id="userName" class="font-semibold"></span>. Veuillez entrer votre mot de passe pour confirmer.</p>
                        <form id="deleteUserForm" method="POST" class="mt-4">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="user_id" id="userId">
                            <div class="mb-4">
                                <input type="password" name="password" id="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Mot de passe" required>
                            </div>
                            <div class="flex justify-end space-x-3">
                                <button type="button" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition-colors" onclick="closeDeleteModal()">Annuler</button>
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">Supprimer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de confirmation de blocage/déblocage (réutilisé) -->
        <div id="blockModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-2xl rounded-3xl bg-white/95 backdrop-blur-md border-white/20">
                <div class="mt-3 text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4" id="blockModalIconBg">
                        <svg id="blockModalIcon" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11V7a4 4 0 118 0v4m-4 4v4m0 0H8m4 0h4" />
                        </svg>
                    </div>
                    <h3 id="blockModalTitle" class="text-xl font-bold text-gray-900 mb-2">Confirmer l'action</h3>
                    <div class="mt-2 px-7 py-3">
                        <p id="blockModalText" class="text-sm text-gray-600 mb-4"></p>
                        <form id="blockForm" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="user_id" id="blockUserId">
                            <div class="mb-6">
                                <input type="password" name="password" id="blockPassword" class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-300" placeholder="Mot de passe admin" required>
                            </div>
                            <div class="flex justify-end space-x-3">
                                <button type="button" class="px-6 py-3 bg-gray-200 text-gray-800 rounded-xl hover:bg-gray-300 transition-all duration-300 transform hover:scale-105 font-medium" onclick="hideBlockModal()">Annuler</button>
                                <button type="submit" id="blockActionBtn" class="px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-300 transform hover:scale-105 shadow-lg font-medium">Confirmer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('ordersStatusBarChartDashboard');
        if (ctx) {
            var chart = new Chart(ctx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode(array_values($orderStatusLabels ?? [])) !!},
                    datasets: [{
                        label: 'Commandes',
                        data: {!! json_encode(array_values($orderStatusCounts ?? [])) !!},
                        backgroundColor: [
                            '#fbbf24', '#3b82f6', '#a78bfa', '#6366f1', '#f59e42', '#10b981', '#ef4444', '#6b7280', '#ec4899'
                        ],
                        borderRadius: 6,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: true }
                    },
                    scales: {
                        x: { grid: { display: false } },
                        y: { beginAtZero: true, grid: { color: '#f3f4f6' } }
                    }
                }
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.bg-white');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'all 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });

    function openDeleteModal(userId, userName) {
        document.getElementById('userId').value = userId;
        document.getElementById('userName').textContent = userName;
        document.getElementById('deleteUserForm').action = `/admin/users/${userId}`;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('password').focus();
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('password').value = '';
        document.getElementById('userId').value = '';
        document.getElementById('userName').textContent = '';
    }

    function showBlockModal(userId, userName, isBlocked) {
        document.getElementById('blockUserId').value = userId;
        document.getElementById('blockPassword').value = '';
        document.getElementById('blockModal').classList.remove('hidden');
        document.getElementById('blockModalTitle').textContent = isBlocked ? 'Confirmer le déblocage' : 'Confirmer le blocage';
        document.getElementById('blockModalText').textContent = isBlocked
            ? `Vous êtes sur le point de débloquer l'utilisateur ${userName}. Veuillez entrer votre mot de passe pour confirmer.`
            : `Vous êtes sur le point de bloquer l'utilisateur ${userName}. Veuillez entrer votre mot de passe pour confirmer.`;
        document.getElementById('blockForm').action = isBlocked
            ? `/admin/users/${userId}/unblock`
            : `/admin/users/${userId}/block`;
        document.getElementById('blockActionBtn').textContent = isBlocked ? 'Débloquer' : 'Bloquer';
        // Couleur dynamique du modal
        const iconBg = document.getElementById('blockModalIconBg');
        const icon = document.getElementById('blockModalIcon');
        if (isBlocked) {
            iconBg.className = 'mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4';
            icon.className = 'h-6 w-6 text-green-600';
        } else {
            iconBg.className = 'mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4';
            icon.className = 'h-6 w-6 text-red-600';
        }
        setTimeout(() => document.getElementById('blockPassword').focus(), 200);
    }
    function hideBlockModal() {
        document.getElementById('blockModal').classList.add('hidden');
        document.getElementById('blockUserId').value = '';
        document.getElementById('blockPassword').value = '';
    }
</script>
@endpush
@endsection