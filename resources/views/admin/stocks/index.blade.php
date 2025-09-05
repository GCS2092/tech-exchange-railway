@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-white">
    <div class="container-nike py-12">
        <!-- Header - Style Nike -->
        <div class="text-center mb-16">
            <h1 class="nike-title mb-4">GESTION DES STOCKS</h1>
            <p class="nike-text text-gray-600">Surveillance et gestion des niveaux de stock</p>
        </div>

        <!-- Actions rapides -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
            <a href="{{ route('admin.stocks.export') }}" class="bg-black text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-800 transition-all duration-300 text-center">
                <i class="fas fa-download mr-2"></i>Exporter CSV
            </a>
            <form action="{{ route('admin.stocks.send-report') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-700 transition-all duration-300" onclick="return confirm('Envoyer le rapport des stocks faibles ?');">
                    <i class="fas fa-envelope mr-2"></i>Envoyer Rapport
                </button>
            </form>
        </div>

        <!-- Statistiques - Style Nike -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="card-nike text-center">
                <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-box text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-black mb-2">{{ $stats['total_products'] ?? 0 }}</h3>
                <p class="text-gray-600">Total Produits</p>
            </div>
            
            <div class="card-nike text-center">
                <div class="w-16 h-16 bg-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-exclamation-triangle text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-black mb-2">{{ $stats['critical_stock'] ?? 0 }}</h3>
                <p class="text-gray-600">En Rupture</p>
            </div>
            
            <div class="card-nike text-center">
                <div class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-exclamation-circle text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-black mb-2">{{ $stats['low_stock'] ?? 0 }}</h3>
                <p class="text-gray-600">Stock Faible</p>
            </div>
            
            <div class="card-nike text-center">
                <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check-circle text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-black mb-2">{{ $stats['normal_stock'] ?? 0 }}</h3>
                <p class="text-gray-600">Stock Normal</p>
            </div>
        </div>

        <!-- Filtres - Style Nike -->
        <div class="card-nike mb-8">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-black mb-4">Filtres</h3>
                <form method="GET" action="{{ route('admin.stocks.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="stock_status" class="block text-sm font-medium text-gray-700 mb-2">Statut du stock</label>
                        <select name="stock_status" id="stock_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                            <option value="">Tous</option>
                            <option value="critical" {{ request('stock_status') == 'critical' ? 'selected' : '' }}>En rupture</option>
                            <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Stock faible</option>
                            <option value="normal" {{ request('stock_status') == 'normal' ? 'selected' : '' }}>Stock normal</option>
                        </select>
                    </div>
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Recherche</label>
                        <input type="text" name="search" id="search" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent" 
                               value="{{ request('search') }}" placeholder="Nom, description...">
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="bg-black text-white px-4 py-2 rounded-lg font-medium hover:bg-gray-800 transition-colors">
                            <i class="fas fa-search mr-2"></i>Filtrer
                        </button>
                        <a href="{{ route('admin.stocks.index') }}" class="bg-gray-300 text-black px-4 py-2 rounded-lg font-medium hover:bg-gray-400 transition-colors">
                            <i class="fas fa-times mr-2"></i>Réinitialiser
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tableau des produits - Style Nike -->
        <div class="card-nike">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-black mb-4">Liste des Produits</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 font-semibold text-black">Produit</th>
                                <th class="text-left py-3 px-4 font-semibold text-black">Prix</th>
                                <th class="text-center py-3 px-4 font-semibold text-black">Stock</th>
                                <th class="text-center py-3 px-4 font-semibold text-black">Statut</th>
                                <th class="text-center py-3 px-4 font-semibold text-black">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-4 px-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <img src="{{ $product->image_url ?? '/images/default-avatar.png' }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="rounded-full w-10 h-10 object-cover"
                                                 onerror="this.src='/images/default-avatar.png'">
                                        </div>
                                        <div class="ml-3">
                                            <h6 class="font-medium text-black">{{ $product->name }}</h6>
                                            <p class="text-sm text-gray-600">{{ $product->brand ?? 'Sans marque' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-black">{{ number_format($product->price, 0, ',', ' ') }} FCFA</td>
                                <td class="py-4 px-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $product->quantity == 0 ? 'bg-red-100 text-red-800' : ($product->quantity <= ($product->min_stock_alert ?? 5) ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                        {{ $product->quantity }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    @if($product->quantity == 0)
                                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">En rupture</span>
                                    @elseif($product->quantity <= ($product->min_stock_alert ?? 5))
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">Stock faible</span>
                                    @else
                                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Normal</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <button type="button" class="bg-black text-white px-4 py-2 rounded-lg font-medium hover:bg-gray-800 transition-colors" 
                                            onclick="openModal('updateStockModal{{ $product->id }}')">
                                        <i class="fas fa-edit mr-2"></i>Modifier
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal de mise à jour du stock - Style Nike -->
                            <div id="updateStockModal{{ $product->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                                <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
                                    <form action="{{ route('admin.stocks.update', $product->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="flex justify-between items-center mb-4">
                                            <h3 class="text-lg font-semibold text-black">Mettre à jour le stock</h3>
                                            <button type="button" class="text-gray-500 hover:text-gray-700" onclick="closeModal('updateStockModal{{ $product->id }}')">
                                                <i class="fas fa-times text-xl"></i>
                                            </button>
                                        </div>
                                        <div class="space-y-4">
                                            <div>
                                                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Stock actuel</label>
                                                <input type="number" name="quantity" id="quantity" 
                                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent" 
                                                       value="{{ $product->quantity }}" min="0" required>
                                            </div>
                                            <div>
                                                <label for="min_stock_alert" class="block text-sm font-medium text-gray-700 mb-2">Seuil d'alerte minimum</label>
                                                <input type="number" name="min_stock_alert" id="min_stock_alert" 
                                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent" 
                                                       value="{{ $product->min_stock_alert ?? 5 }}" min="0">
                                            </div>
                                            <div>
                                                <label for="max_stock_alert" class="block text-sm font-medium text-gray-700 mb-2">Seuil d'alerte maximum</label>
                                                <input type="number" name="max_stock_alert" id="max_stock_alert" 
                                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent" 
                                                       value="{{ $product->max_stock_alert ?? 50 }}" min="0">
                                            </div>
                                        </div>
                                        <div class="flex gap-3 mt-6">
                                            <button type="button" class="flex-1 bg-gray-300 text-black py-2 px-4 rounded-lg font-medium hover:bg-gray-400 transition-colors" 
                                                    onclick="closeModal('updateStockModal{{ $product->id }}')">Annuler</button>
                                            <button type="submit" class="flex-1 bg-black text-white py-2 px-4 rounded-lg font-medium hover:bg-gray-800 transition-colors">Mettre à jour</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-8">
                                    <i class="fas fa-box-open text-4xl text-gray-400 mb-3"></i>
                                    <p class="text-gray-600">Aucun produit trouvé</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="flex justify-center mt-6">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="fixed top-4 right-4 bg-green-100 border border-green-200 text-green-800 px-6 py-3 rounded-lg shadow-lg z-50">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
            <button type="button" class="ml-4 text-green-600 hover:text-green-800" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
@endif

@if(session('info'))
    <div class="fixed top-4 right-4 bg-blue-100 border border-blue-200 text-blue-800 px-6 py-3 rounded-lg shadow-lg z-50">
        <div class="flex items-center">
            <i class="fas fa-info-circle mr-2"></i>
            {{ session('info') }}
            <button type="button" class="ml-4 text-blue-600 hover:text-blue-800" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
@endif

@endsection

@push('scripts')
<script>
    // Fonctions pour les modals
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    // Fermer les modals en cliquant à l'extérieur
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('bg-black') && e.target.classList.contains('bg-opacity-50')) {
            e.target.classList.add('hidden');
            e.target.classList.remove('flex');
        }
    });

    // Auto-hide alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const alerts = document.querySelectorAll('.fixed.top-4.right-4');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(function() {
                    if (alert.parentNode) {
                        alert.remove();
                    }
                }, 500);
            });
        }, 5000);
    });
</script>
@endpush
