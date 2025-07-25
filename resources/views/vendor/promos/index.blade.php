@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-purple-50 to-pink-50 py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <div class="text-center mb-12 transform transition duration-700 hover:scale-105">
            <h1 class="text-4xl md:text-5xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-purple-600 to-pink-600 mb-4">
                Mes codes promos
            </h1>
            <div class="h-1 w-24 bg-gradient-to-r from-purple-500 to-pink-500 mx-auto rounded-full"></div>
        </div>
        <div class="flex justify-end mb-6">
            <a href="{{ route('vendeur.promos.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all duration-300 transform hover:-translate-y-1">
                <i class="fas fa-plus mr-2"></i> Nouveau code promo
            </a>
        </div>
        @if($promos->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($promos as $promo)
                    @php
                        $isExpired = $promo->expires_at && \Carbon\Carbon::parse($promo->expires_at)->isPast();
                        $isActive = !$isExpired;
                    @endphp
                    <div class="bg-white rounded-2xl shadow-xl p-6 transform transition duration-300 hover:-translate-y-1 hover:shadow-2xl {{ $isExpired ? 'opacity-75' : '' }}">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center space-x-2">
                                <span class="text-2xl font-bold text-purple-600">{{ $promo->code }}</span>
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
                                <span class="text-gray-600">Réduction</span>
                                <span class="font-bold text-lg text-blue-600">{{ $promo->discount }}%</span>
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
                        </div>
                        <div class="mt-6 flex justify-end items-center space-x-2">
                            <a href="{{ route('vendeur.promos.edit', $promo) }}" class="text-sm text-blue-600 hover:text-blue-800 transition-colors duration-150">
                                <i class="fas fa-edit mr-1"></i> Modifier
                            </a>
                            <form action="{{ route('vendeur.promos.destroy', $promo) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 hover:text-red-800 transition-colors duration-150">
                                    <i class="fas fa-trash mr-1"></i> Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8">{{ $promos->links() }}</div>
        @else
            <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
                <div class="text-purple-500 text-6xl mb-4">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <h3 class="text-2xl font-semibold text-gray-800 mb-2">Aucun code promo disponible</h3>
                <p class="text-gray-600 mb-6">Vous n'avez pas encore créé de codes promo.</p>
                <a href="{{ route('vendeur.promos.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all duration-300 transform hover:-translate-y-1">
                    <i class="fas fa-plus mr-2"></i> Créer le premier code
                </a>
            </div>
        @endif
    </div>
</div>
@endsection 