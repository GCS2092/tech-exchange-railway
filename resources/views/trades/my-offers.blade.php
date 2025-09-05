@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-xl font-bold text-gray-900 mb-2">Mes offres de troc</h1>
            <p class="text-gray-600">Gérez vos offres d'échange d'appareils électroniques</p>
        </div>

        <!-- Onglets -->
        <div class="mb-8">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <button onclick="showTab('received')" id="tab-received" 
                            class="tab-button py-2 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600">
                        Offres reçues ({{ $receivedOffers->count() }})
                    </button>
                    <button onclick="showTab('sent')" id="tab-sent" 
                            class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700">
                        Offres envoyées ({{ $sentOffers->count() }})
                    </button>
                </nav>
            </div>
        </div>

        <!-- Offres reçues -->
        <div id="received-offers" class="tab-content">
            @if($receivedOffers->count() > 0)
                <div class="space-y-6">
                    @foreach($receivedOffers as $offer)
                        <div class="bg-white rounded-2xl shadow-lg p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img src="{{ asset('storage/' . $offer->product->image) }}" 
                                             alt="{{ $offer->product->name }}" 
                                             class="w-16 h-16 object-cover rounded-lg">
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $offer->product->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $offer->product->brand }} - {{ $offer->product->model }}</p>
                                        <p class="text-sm text-gray-500">Proposé par {{ $offer->user->name }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                 {{ $offer->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                    ($offer->status === 'accepted' ? 'bg-green-100 text-green-800' : 
                                                    'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($offer->status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 pt-4">
                                <h4 class="font-medium text-gray-900 mb-3">Appareil proposé en échange :</h4>
                                <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                                    <img src="{{ asset('storage/' . $offer->offeredProduct->image) }}" 
                                         alt="{{ $offer->offeredProduct->name }}" 
                                         class="w-12 h-12 object-cover rounded-lg">
                                    <div class="flex-1">
                                        <h5 class="font-medium text-gray-900">{{ $offer->offeredProduct->name }}</h5>
                                        <p class="text-sm text-gray-600">{{ $offer->offeredProduct->brand }} - {{ $offer->offeredProduct->model }}</p>
                                        <p class="text-sm text-gray-500">{{ $offer->offeredProduct->formatted_condition }}</p>
                                    </div>
                                </div>

                                @if($offer->message)
                                    <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                                        <h5 class="font-medium text-gray-900 mb-2">Message :</h5>
                                        <p class="text-gray-700">{{ $offer->message }}</p>
                                    </div>
                                @endif

                                @if($offer->isPending())
                                    <div class="mt-4 flex space-x-3">
                                        <form action="{{ route('trades.accept-offer', $offer) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-full bg-green-600 text-white font-medium py-2 px-4 rounded-lg hover:bg-green-700 transition-colors">
                                                Accepter l'offre
                                            </button>
                                        </form>
                                        <form action="{{ route('trades.reject-offer', $offer) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-full bg-red-600 text-white font-medium py-2 px-4 rounded-lg hover:bg-red-700 transition-colors">
                                                Rejeter l'offre
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune offre reçue</h3>
                    <p class="text-gray-600">Vous n'avez pas encore reçu d'offres de troc pour vos appareils.</p>
                </div>
            @endif
        </div>

        <!-- Offres envoyées -->
        <div id="sent-offers" class="tab-content hidden">
            @if($sentOffers->count() > 0)
                <div class="space-y-6">
                    @foreach($sentOffers as $offer)
                        <div class="bg-white rounded-2xl shadow-lg p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img src="{{ asset('storage/' . $offer->product->image) }}" 
                                             alt="{{ $offer->product->name }}" 
                                             class="w-16 h-16 object-cover rounded-lg">
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $offer->product->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $offer->product->brand }} - {{ $offer->product->model }}</p>
                                        <p class="text-sm text-gray-500">Propriétaire : {{ $offer->product->seller->name }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                 {{ $offer->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                    ($offer->status === 'accepted' ? 'bg-green-100 text-green-800' : 
                                                    'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($offer->status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 pt-4">
                                <h4 class="font-medium text-gray-900 mb-3">Votre appareil proposé :</h4>
                                <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                                    <img src="{{ asset('storage/' . $offer->offeredProduct->image) }}" 
                                         alt="{{ $offer->offeredProduct->name }}" 
                                         class="w-12 h-12 object-cover rounded-lg">
                                    <div class="flex-1">
                                        <h5 class="font-medium text-gray-900">{{ $offer->offeredProduct->name }}</h5>
                                        <p class="text-sm text-gray-600">{{ $offer->offeredProduct->brand }} - {{ $offer->offeredProduct->model }}</p>
                                        <p class="text-sm text-gray-500">{{ $offer->offeredProduct->formatted_condition }}</p>
                                    </div>
                                </div>

                                @if($offer->message)
                                    <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                                        <h5 class="font-medium text-gray-900 mb-2">Votre message :</h5>
                                        <p class="text-gray-700">{{ $offer->message }}</p>
                                    </div>
                                @endif

                                @if($offer->isPending())
                                    <div class="mt-4">
                                        <form action="{{ route('trades.cancel-offer', $offer) }}" method="POST">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-full bg-red-600 text-white font-medium py-2 px-4 rounded-lg hover:bg-red-700 transition-colors">
                                                Annuler l'offre
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune offre envoyée</h3>
                    <p class="text-gray-600">Vous n'avez pas encore envoyé d'offres de troc.</p>
                    <a href="{{ route('trades.search') }}" 
                       class="inline-flex items-center px-4 py-2 mt-4 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        Découvrir des appareils
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function showTab(tabName) {
    // Masquer tous les contenus d'onglets
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Retirer la classe active de tous les boutons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('border-blue-500', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Afficher le contenu de l'onglet sélectionné
    document.getElementById(tabName + '-offers').classList.remove('hidden');
    
    // Activer le bouton de l'onglet sélectionné
    document.getElementById('tab-' + tabName).classList.remove('border-transparent', 'text-gray-500');
    document.getElementById('tab-' + tabName).classList.add('border-blue-500', 'text-blue-600');
}
</script>
@endsection 