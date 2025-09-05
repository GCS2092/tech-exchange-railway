@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-purple-50 to-pink-50 py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <!-- En-tête avec animation -->
        <div class="text-center mb-12 transform transition duration-700 hover:scale-105">
            <h1 class="text-2xl md:text-xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-purple-600 to-pink-600 mb-4">
                Codes Promos
            </h1>
            <div class="h-1 w-24 bg-gradient-to-r from-purple-500 to-pink-500 mx-auto rounded-full"></div>
        </div>

        <!-- Filtres et recherche -->
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-8 transform transition duration-300 hover:-translate-y-1 hover:shadow-2xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="searchPromo" class="block text-sm font-medium text-gray-700 mb-2">Rechercher un code</label>
                    <div class="relative">
                        <input type="text" id="searchPromo" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Entrez un code promo...">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>
                <div>
                    <label for="statusFilter" class="block text-sm font-medium text-gray-700 mb-2">Filtrer par statut</label>
                    <select id="statusFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="all">Tous les codes</option>
                        <option value="active">Actifs</option>
                        <option value="expired">Expirés</option>
                        <option value="used">Utilisés</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="flex justify-end mb-6">
            @if(auth()->check() && auth()->user()->is_admin)
                <a href="{{ route('promos.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all duration-300 transform hover:-translate-y-1">
                    <i class="fas fa-plus mr-2"></i> Ajouter un code promo
                </a>
            @endif
        </div>

        @if(count($promos) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($promos as $promo)
                    @php
                        $isExpired = $promo->expires_at && \Carbon\Carbon::parse($promo->expires_at)->isPast();
                        $isUsed = ($promo->uses_count ?? 0) > 0;
                        $isActive = !$isExpired && (!$promo->max_uses || ($promo->max_uses > ($promo->uses_count ?? 0)));
                        $usageClass = $isUsed ? 'used' : 'unused';
                    @endphp
                    
                    <div class="bg-white rounded-2xl shadow-xl p-6 transform transition duration-300 hover:-translate-y-1 hover:shadow-2xl {{ $isExpired ? 'opacity-75' : '' }}">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center space-x-2">
                                <span class="text-2xl font-bold text-purple-600">{{ $promo->code }}</span>
                                <button class="copy-btn p-2 text-gray-400 hover:text-purple-600 transition-colors duration-150" data-code="{{ $promo->code }}" title="Copier le code">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                @if($isExpired) bg-gray-100 text-gray-600
                                @elseif($isActive) bg-green-100 text-green-600
                                @else bg-yellow-100 text-yellow-600 @endif">
                                @if($isExpired) Expiré
                                @elseif($isActive) Actif
                                @else Inactif @endif
                            </span>
                        </div>

                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Type</span>
                                <span class="font-medium {{ $promo->type === 'percent' ? 'text-blue-600' : 'text-green-600' }}">
                                    {{ $promo->type === 'percent' ? 'Pourcentage' : 'Montant fixe' }}
                                </span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Valeur</span>
                                <span class="font-bold text-lg {{ $promo->type === 'percent' ? 'text-blue-600' : 'text-green-600' }}">
                                    {{ $promo->type === 'percent' ? number_format($promo->value, 2, ',', ' ') . '%' : \App\Helpers\CurrencyHelper::formatXOF($promo->value) }}
                                </span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Expiration</span>
                                <span class="font-medium {{ $isExpired ? 'text-red-600' : 'text-gray-600' }}">
                                    @if($promo->expires_at)
                                        {{ \Carbon\Carbon::parse($promo->expires_at)->format('d/m/Y') }}
                                    @else
                                        <span class="text-gray-400 italic">Pas d'expiration</span>
                                    @endif
                                </span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Utilisations</span>
                                <span class="font-medium text-gray-600">
                                    {{ $promo->uses_count ?? 0 }}
                                    @if($promo->max_uses)
                                        / {{ $promo->max_uses }}
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-between items-center">
                            <a href="{{ route('promos.usage-history', $promo->id) }}" class="usage-history-btn text-sm text-purple-600 hover:text-purple-800 transition-colors duration-150">
                                <i class="fas fa-history mr-1"></i> Historique
                            </a>
                            @if(auth()->check() && auth()->user()->is_admin)
                                <div class="flex space-x-2">
                                    <a href="{{ route('promos.edit', $promo) }}" class="text-sm text-blue-600 hover:text-blue-800 transition-colors duration-150">
                                        <i class="fas fa-edit mr-1"></i> Modifier
                                    </a>
                                    <form action="{{ route('promos.destroy', $promo) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-600 hover:text-red-800 transition-colors duration-150">
                                            <i class="fas fa-trash mr-1"></i> Supprimer
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
                <div class="text-purple-500 text-2xl mb-4">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <h3 class="text-2xl font-semibold text-gray-800 mb-2">Aucun code promo disponible</h3>
                <p class="text-gray-600 mb-6">Vous n'avez pas encore créé de codes promo.</p>
                @if(auth()->check() && auth()->user()->is_admin)
                    <a href="{{ route('promos.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all duration-300 transform hover:-translate-y-1">
                        <i class="fas fa-plus mr-2"></i> Créer le premier code
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Modal pour l'historique d'utilisation -->
<div id="usageHistoryModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl mx-4">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-semibold text-gray-800">Historique d'utilisation: <span id="modalPromoCode" class="text-purple-600"></span></h2>
                <button class="close-modal text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
        </div>
        <div class="p-6">
            <div class="loading text-center py-8">
                <i class="fas fa-spinner fa-spin text-2xl text-purple-600"></i>
                <p class="mt-4 text-gray-600">Chargement de l'historique...</p>
            </div>
            <div id="usageHistoryContent" class="space-y-4"></div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .copy-btn {
        transition: all 0.3s ease;
    }
    .copy-btn:hover {
        transform: scale(1.1);
    }
    .usage-history-btn:hover {
        text-decoration: underline;
    }
</style>
@endpush