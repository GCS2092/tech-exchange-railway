@extends('layouts.admin')

@section('title', 'Détails du Code Promo')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- En-tête de la page -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-ticket-alt text-yellow-500 mr-3"></i>
                Détails du Code Promo
            </h1>
            <p class="text-gray-600 mt-2">Informations détaillées sur le code promo</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.promos.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour à la liste
            </a>
            <a href="{{ route('admin.promos.edit', $promo->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-edit mr-2"></i>
                Modifier
            </a>
        </div>
    </div>

    <!-- Informations principales -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Carte des informations du code promo -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                Informations du Code Promo
            </h2>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center py-3 border-b border-gray-200">
                    <span class="font-medium text-gray-700">Code :</span>
                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full font-mono text-lg font-bold">
                        {{ $promo->code }}
                    </span>
                </div>
                
                <div class="flex justify-between items-center py-3 border-b border-gray-200">
                    <span class="font-medium text-gray-700">Description :</span>
                    <span class="text-gray-900">{{ $promo->description }}</span>
                </div>
                
                <div class="flex justify-between items-center py-3 border-b border-gray-200">
                    <span class="font-medium text-gray-700">Type de réduction :</span>
                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $promo->discount_type === 'percentage' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                        {{ $promo->discount_type === 'percentage' ? 'Pourcentage (%)' : 'Montant fixe (FCFA)' }}
                    </span>
                </div>
                
                <div class="flex justify-between items-center py-3 border-b border-gray-200">
                    <span class="font-medium text-gray-700">Valeur de la réduction :</span>
                    <span class="text-lg font-bold text-green-600">
                        {{ $promo->discount_value }}
                        {{ $promo->discount_type === 'percentage' ? '%' : 'FCFA' }}
                    </span>
                </div>
                
                <div class="flex justify-between items-center py-3 border-b border-gray-200">
                    <span class="font-medium text-gray-700">Montant minimum :</span>
                    <span class="text-gray-900">
                        {{ $promo->min_order_amount ? number_format($promo->min_order_amount) . ' FCFA' : 'Aucun' }}
                    </span>
                </div>
                
                <div class="flex justify-between items-center py-3 border-b border-gray-200">
                    <span class="font-medium text-gray-700">Utilisations max :</span>
                    <span class="text-gray-900">
                        {{ $promo->max_usage ?: 'Illimité' }}
                    </span>
                </div>
                
                <div class="flex justify-between items-center py-3 border-b border-gray-200">
                    <span class="font-medium text-gray-700">Date d'expiration :</span>
                    <span class="text-gray-900">
                        {{ $promo->expires_at ? $promo->expires_at->format('d/m/Y H:i') : 'Aucune' }}
                    </span>
                </div>
                
                <div class="flex justify-between items-center py-3">
                    <span class="font-medium text-gray-700">Statut :</span>
                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $promo->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $promo->is_active ? 'Actif' : 'Inactif' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Carte des statistiques -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-chart-bar text-purple-500 mr-2"></i>
                Statistiques d'utilisation
            </h2>
            
            <div class="space-y-6">
                <div class="bg-blue-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-blue-600 font-medium">Utilisations actuelles</p>
                            <p class="text-2xl font-bold text-blue-900">{{ $promo->usage_count }}</p>
                        </div>
                        <div class="text-blue-500">
                            <i class="fas fa-users text-3xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-green-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-green-600 font-medium">Utilisations restantes</p>
                            <p class="text-2xl font-bold text-green-900">
                                {{ $promo->max_usage ? ($promo->max_usage - $promo->usage_count) : '∞' }}
                            </p>
                        </div>
                        <div class="text-green-500">
                            <i class="fas fa-ticket-alt text-3xl"></i>
                        </div>
                    </div>
                </div>
                
                @if($promo->max_usage)
                <div class="bg-yellow-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-yellow-600 font-medium">Taux d'utilisation</p>
                            <p class="text-2xl font-bold text-yellow-900">
                                {{ round(($promo->usage_count / $promo->max_usage) * 100, 1) }}%
                            </p>
                        </div>
                        <div class="text-yellow-500">
                            <i class="fas fa-percentage text-3xl"></i>
                        </div>
                    </div>
                </div>
                @endif
                
                <div class="bg-purple-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-purple-600 font-medium">Date de création</p>
                            <p class="text-lg font-semibold text-purple-900">
                                {{ $promo->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <div class="text-purple-500">
                            <i class="fas fa-calendar-plus text-3xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="mt-8 bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
            <i class="fas fa-cogs text-gray-500 mr-2"></i>
            Actions
        </h2>
        
        <div class="flex flex-wrap gap-4">
            <form action="{{ route('admin.promos.toggle-status', $promo->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 rounded-lg font-medium {{ $promo->is_active ? 'bg-red-500 hover:bg-red-600 text-white' : 'bg-green-500 hover:bg-green-600 text-white' }}">
                    <i class="fas {{ $promo->is_active ? 'fa-pause' : 'fa-play' }} mr-2"></i>
                    {{ $promo->is_active ? 'Désactiver' : 'Activer' }}
                </button>
            </form>
            
            <a href="{{ route('admin.promos.edit', $promo->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium">
                <i class="fas fa-edit mr-2"></i>
                Modifier
            </a>
            
            @if($promo->usage_count === 0)
            <form action="{{ route('admin.promos.destroy', $promo->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce code promo ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium">
                    <i class="fas fa-trash mr-2"></i>
                    Supprimer
                </button>
            </form>
            @else
            <button disabled class="bg-gray-300 text-gray-500 px-4 py-2 rounded-lg font-medium cursor-not-allowed" title="Impossible de supprimer un code promo qui a été utilisé">
                <i class="fas fa-trash mr-2"></i>
                Supprimer
            </button>
            @endif
        </div>
    </div>

    <!-- Historique des utilisations (si disponible) -->
    @if($promo->usage_count > 0)
    <div class="mt-8 bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
            <i class="fas fa-history text-indigo-500 mr-2"></i>
            Historique des utilisations
        </h2>
        
        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-gray-600">
                <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                Ce code promo a été utilisé {{ $promo->usage_count }} fois.
                @if($promo->max_usage)
                    Il reste {{ $promo->max_usage - $promo->usage_count }} utilisations possibles.
                @endif
            </p>
        </div>
    </div>
    @endif
</div>
@endsection
