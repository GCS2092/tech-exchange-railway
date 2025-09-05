@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 p-4 md:p-6 lg:p-8">
    <!-- Header -->
    <header class="mb-8 animate-fade-in">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="space-y-2">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-clipboard-list text-white text-xl"></i>
                    </div>
        <div>
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">
                            📋 Gestion de la Commande #{{ $order->id }}
                        </h1>
                        <p class="text-gray-600 mt-1">Gestion complète et suivi de la commande</p>
                    </div>
                </div>
        </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center px-4 py-2 bg-white text-gray-700 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 border border-gray-200 hover:border-gray-300">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour aux commandes
                </a>
                <a href="{{ route('admin.orders.invoice', $order) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-500 to-green-600 text-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 hover:scale-105">
                    <i class="fas fa-download mr-2"></i>
                    Télécharger Facture
            </a>
        </div>
    </div>
    </header>

    <!-- Alertes -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg shadow-sm animate-slide-up">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500 text-lg"></i>
                </div>
                <div class="ml-3">
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
                <button type="button" class="ml-auto text-green-500 hover:text-green-700" data-bs-dismiss="alert">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 rounded-lg shadow-sm animate-slide-up">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
                </div>
                <div class="ml-3">
                    <p class="text-red-800 font-medium">{{ session('error') }}</p>
                </div>
                <button type="button" class="ml-auto text-red-500 hover:text-red-700" data-bs-dismiss="alert">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="xl:col-span-2 space-y-6">
            <!-- Détails de la commande -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden animate-fade-in">
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-semibold text-white">Détails de la Commande</h2>
                        <span class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-white text-sm font-medium">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                </div>
                <div class="p-6">
                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-user text-blue-500"></i>
                                Informations Client
                            </h3>
                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <span class="text-gray-600 min-w-20">Nom :</span>
                                    <span class="font-medium text-gray-900">{{ $order->user->name ?? 'Client inconnu' }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-gray-600 min-w-20">Email :</span>
                                    <span class="text-blue-600 hover:text-blue-800 cursor-pointer">{{ $order->user->email ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-gray-600 min-w-20">Téléphone :</span>
                                    <span class="text-gray-900">{{ $order->phone_number ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <span class="text-gray-600 min-w-20">Adresse :</span>
                                    <span class="text-gray-900">{{ $order->delivery_address ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-shopping-cart text-green-500"></i>
                                Informations Commande
                            </h3>
                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <span class="text-gray-600 min-w-24">Date :</span>
                                    <span class="text-gray-900">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-gray-600 min-w-24">Montant :</span>
                                    <span class="font-bold text-green-600 text-lg">{{ number_format($order->total_price, 0, ',', ' ') }} FCFA</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-gray-600 min-w-24">Paiement :</span>
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-lg text-sm">{{ ucfirst($order->payment_method ?? 'N/A') }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-gray-600 min-w-24">Livreur :</span>
                                    <span class="text-gray-900">{{ $order->livreur->name ?? 'Non assigné' }}</span>
                                </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Produits commandés -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden animate-fade-in">
                <div class="bg-gradient-to-r from-purple-500 to-pink-600 p-6">
                    <h2 class="text-xl font-semibold text-white flex items-center gap-2">
                        <i class="fas fa-box"></i>
                        Produits Commandés
                    </h2>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-3 text-gray-700 font-semibold">Produit</th>
                                    <th class="text-right py-3 text-gray-700 font-semibold">Prix unitaire</th>
                                    <th class="text-center py-3 text-gray-700 font-semibold">Quantité</th>
                                    <th class="text-right py-3 text-gray-700 font-semibold">Total</th>
                                    <th class="text-left py-3 text-gray-700 font-semibold">Vendeur</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->products as $product)
                                <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                                    <td class="py-4">
                                        <div class="flex items-center gap-3">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" 
                                                     alt="{{ $product->name }}" 
                                                     class="w-12 h-12 rounded-lg object-cover shadow-sm">
                                            @else
                                                <div class="w-12 h-12 bg-gradient-to-r from-blue-400 to-blue-600 rounded-lg flex items-center justify-center shadow-sm">
                                                    <i class="fas fa-box text-white"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $product->name }}</p>
                                                @if($product->brand)
                                                    <p class="text-sm text-gray-500">{{ $product->brand }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-right py-4 text-gray-900">{{ number_format($product->pivot->price, 0, ',', ' ') }} FCFA</td>
                                    <td class="text-center py-4">
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">{{ $product->pivot->quantity }}</span>
                                    </td>
                                    <td class="text-right py-4 font-semibold text-gray-900">{{ number_format($product->pivot->price * $product->pivot->quantity, 0, ',', ' ') }} FCFA</td>
                                    <td class="py-4 text-gray-700">{{ $product->seller->name ?? 'N/A' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Historique des statuts -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden animate-fade-in">
                <div class="bg-gradient-to-r from-indigo-500 to-blue-600 p-6">
                    <h2 class="text-xl font-semibold text-white flex items-center gap-2">
                        <i class="fas fa-history"></i>
                        Historique des Statuts
                    </h2>
                </div>
                <div class="p-6">
                    @if(count($statusHistory) > 0)
                        <div class="space-y-4">
                        @foreach($statusHistory as $history)
                            <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-gray-50 to-blue-50 rounded-lg border border-gray-100">
                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-clock text-white"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start">
                            <div>
                                            <p class="font-semibold text-gray-900">{{ ucfirst($history['status']) }}</p>
                                @if($history['notes'])
                                                <p class="text-sm text-gray-600">{{ $history['notes'] }}</p>
                                @endif
                            </div>
                            <div class="text-right">
                                            <p class="text-sm text-gray-500">{{ $history['date']->format('d/m/Y H:i') }}</p>
                                            <p class="text-xs text-gray-400">Par {{ $history['user']->name ?? 'Système' }}</p>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-history text-gray-300 text-4xl mb-3"></i>
                            <p class="text-gray-500">Aucun historique disponible</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Mise à jour du statut -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden animate-fade-in">
                <div class="bg-gradient-to-r from-orange-500 to-red-500 p-6">
                    <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                        <i class="fas fa-edit"></i>
                        Mettre à Jour le Statut
                    </h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Nouveau statut</label>
                            <select name="status" id="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" required>
                                <option value="en attente" {{ $order->status == 'en attente' ? 'selected' : '' }}>En attente</option>
                                <option value="payé" {{ $order->status == 'payé' ? 'selected' : '' }}>Payé</option>
                                <option value="en préparation" {{ $order->status == 'en préparation' ? 'selected' : '' }}>En préparation</option>
                                <option value="expédié" {{ $order->status == 'expédié' ? 'selected' : '' }}>Expédié</option>
                                <option value="en livraison" {{ $order->status == 'en livraison' ? 'selected' : '' }}>En livraison</option>
                                <option value="livré" {{ $order->status == 'livré' ? 'selected' : '' }}>Livré</option>
                                <option value="annulé" {{ $order->status == 'annulé' ? 'selected' : '' }}>Annulé</option>
                                <option value="retourné" {{ $order->status == 'retourné' ? 'selected' : '' }}>Retourné</option>
                                <option value="remboursé" {{ $order->status == 'remboursé' ? 'selected' : '' }}>Remboursé</option>
                            </select>
                        </div>
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes (optionnel)</label>
                            <textarea name="notes" id="notes" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" rows="3" placeholder="Ajouter des notes...">{{ $order->notes }}</textarea>
                        </div>
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 px-4 rounded-lg font-medium hover:from-blue-600 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
                            <i class="fas fa-save mr-2"></i>
                            Mettre à jour
                        </button>
                    </form>
                </div>
            </div>

            <!-- Assignation livreur -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden animate-fade-in">
                <div class="bg-gradient-to-r from-teal-500 to-cyan-600 p-6">
                    <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                        <i class="fas fa-truck"></i>
                        Assigner un Livreur
                    </h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.orders.assign-livreur', $order) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="livreur_id" class="block text-sm font-medium text-gray-700 mb-2">Sélectionner un livreur</label>
                            <select name="livreur_id" id="livreur_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" required>
                                <option value="">Choisir un livreur...</option>
                                @foreach($livreurs as $livreur)
                                    <option value="{{ $livreur->id }}" {{ $order->livreur_id == $livreur->id ? 'selected' : '' }}>
                                        {{ $livreur->name }} ({{ $livreur->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-gradient-to-r from-teal-500 to-cyan-600 text-white py-3 px-4 rounded-lg font-medium hover:from-teal-600 hover:to-cyan-700 transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
                            <i class="fas fa-user-plus mr-2"></i>
                            Assigner
                        </button>
                    </form>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden animate-fade-in">
                <div class="bg-gradient-to-r from-violet-500 to-purple-600 p-6">
                    <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                        <i class="fas fa-bolt"></i>
                        Actions Rapides
                    </h3>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('admin.orders.invoice', $order) }}" class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-emerald-500 to-green-600 text-white py-3 px-4 rounded-lg font-medium hover:shadow-lg transition-all duration-300 hover:scale-105">
                        <i class="fas fa-file-pdf"></i>
                        Télécharger Facture
                    </a>
                    <a href="mailto:{{ $order->user->email ?? '' }}" class="w-full flex items-center justify-center gap-2 bg-white border border-blue-300 text-blue-600 py-3 px-4 rounded-lg font-medium hover:bg-blue-50 transition-all duration-300">
                        <i class="fas fa-envelope"></i>
                        Contacter Client
                        </a>
                        @if($order->livreur)
                    <a href="mailto:{{ $order->livreur->email }}" class="w-full flex items-center justify-center gap-2 bg-white border border-teal-300 text-teal-600 py-3 px-4 rounded-lg font-medium hover:bg-teal-50 transition-all duration-300">
                        <i class="fas fa-truck"></i>
                        Contacter Livreur
                        </a>
                        @endif
                    <button type="button" onclick="window.print()" class="w-full flex items-center justify-center gap-2 bg-white border border-orange-300 text-orange-600 py-3 px-4 rounded-lg font-medium hover:bg-orange-50 transition-all duration-300">
                        <i class="fas fa-print"></i>
                        Imprimer
                        </button>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden animate-fade-in">
                <div class="bg-gradient-to-r from-pink-500 to-rose-600 p-6">
                    <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                        <i class="fas fa-chart-bar"></i>
                        Statistiques
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-100">
                            <div class="text-2xl font-bold text-blue-600 mb-1">{{ $order->products->count() }}</div>
                            <div class="text-sm text-gray-600">Produits</div>
                            </div>
                        <div class="text-center p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border border-green-100">
                            <div class="text-2xl font-bold text-green-600 mb-1">{{ number_format($order->total_price, 0, ',', ' ') }}</div>
                            <div class="text-sm text-gray-600">FCFA</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Confirmation pour les actions importantes
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        if (this.querySelector('select[name="status"]') && 
            this.querySelector('select[name="status"]').value === 'annulé') {
            if (!confirm('Êtes-vous sûr de vouloir annuler cette commande ?')) {
                e.preventDefault();
            }
        }
    });
});
</script>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes slideUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
    animation: fadeIn 0.5s ease-in-out;
}
.animate-slide-up {
    animation: slideUp 0.3s ease-out;
}
</style>
@endpush
@endsection
