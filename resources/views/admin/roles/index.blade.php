@extends('layouts.admin')
@section('content')

<div class="container mx-auto px-4 py-6">
    <!-- En-tête -->
    <div class="mb-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Gestion des Rôles et Permissions</h1>
            <div class="flex gap-3">
                <a href="{{ route('admin.roles.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg shadow flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Nouveau Rôle
                </a>
                <a href="{{ route('admin.permissions.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Permissions
                </a>
            </div>
        </div>

        <!-- Statistiques des rôles -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Rôles</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $roles->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Permissions</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $permissions->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Utilisateurs Actifs</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $activeUsers }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Rôles Utilisés</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $usedRoles }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des rôles -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Rôles Disponibles</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateurs</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Permissions</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($roles as $role)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8">
                                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <span class="text-sm font-medium text-indigo-800">{{ strtoupper(substr($role->name, 0, 2)) }}</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ ucfirst($role->name) }}</div>
                                    <div class="text-sm text-gray-500">{{ $role->guard_name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $role->description ?? 'Aucune description' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $role->users_count ?? 0 }} utilisateurs
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                {{ $role->permissions_count ?? 0 }} permissions
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.roles.show', $role) }}" class="text-indigo-600 hover:text-indigo-900" title="Voir">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                
                                <a href="{{ route('admin.roles.edit', $role) }}" class="text-blue-600 hover:text-blue-900" title="Modifier">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>

                                @if(!in_array($role->name, ['admin', 'super-admin']))
                                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce rôle ?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Aucun rôle trouvé
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Rôles recommandés -->
    <div class="mt-8 bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Rôles Recommandés pour un Site E-commerce</h2>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Super Admin -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <div class="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Super Admin</h3>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">Accès complet à toutes les fonctionnalités du système</p>
                    <div class="flex flex-wrap gap-1">
                        <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded">Gestion complète</span>
                        <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded">Sécurité</span>
                        <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded">Configuration</span>
                    </div>
                </div>

                <!-- Admin -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Admin</h3>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">Gestion des produits, commandes et utilisateurs</p>
                    <div class="flex flex-wrap gap-1">
                        <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">Produits</span>
                        <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">Commandes</span>
                        <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">Utilisateurs</span>
                    </div>
                </div>

                <!-- Manager -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Manager</h3>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">Gestion des ventes et du service client</p>
                    <div class="flex flex-wrap gap-1">
                        <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Ventes</span>
                        <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Support</span>
                        <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Rapports</span>
                    </div>
                </div>

                <!-- Vendeur -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <div class="h-8 w-8 rounded-full bg-yellow-100 flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Vendeur</h3>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">Gestion des produits et des stocks</p>
                    <div class="flex flex-wrap gap-1">
                        <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded">Produits</span>
                        <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded">Stock</span>
                        <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded">Prix</span>
                    </div>
                </div>

                <!-- Livreur -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <div class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Livreur</h3>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">Gestion des livraisons et du suivi</p>
                    <div class="flex flex-wrap gap-1">
                        <span class="px-2 py-1 text-xs bg-purple-100 text-purple-800 rounded">Livraisons</span>
                        <span class="px-2 py-1 text-xs bg-purple-100 text-purple-800 rounded">Suivi</span>
                        <span class="px-2 py-1 text-xs bg-purple-100 text-purple-800 rounded">Planning</span>
                    </div>
                </div>

                <!-- Support -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 100 19.5 9.75 9.75 0 000-19.5z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Support</h3>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">Service client et assistance</p>
                    <div class="flex flex-wrap gap-1">
                        <span class="px-2 py-1 text-xs bg-indigo-100 text-indigo-800 rounded">Support</span>
                        <span class="px-2 py-1 text-xs bg-indigo-100 text-indigo-800 rounded">Tickets</span>
                        <span class="px-2 py-1 text-xs bg-indigo-100 text-indigo-800 rounded">FAQ</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection 