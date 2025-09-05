@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Gestion des Commandes</h1>
            <p class="text-gray-600">Filtrez, triez et gérez toutes les commandes de votre plateforme</p>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Commandes</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_orders']) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Chiffre d'Affaires</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_revenue'], 0, ',', ' ') }} FCFA</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">En Attente</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['by_status']['en attente']['count'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Livrées</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['by_status']['livré']['count'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtres -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Filtres et Recherche</h3>
                
                <form method="GET" action="{{ route('admin.orders.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                    <!-- Recherche -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
                        <input type="text" name="search" value="{{ $filters['search'] }}" 
                               placeholder="ID, nom, email..." 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Statut -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Tous les statuts</option>
                            @foreach(\App\Models\Order::STATUSES as $status => $label)
                                <option value="{{ $status }}" {{ $filters['status'] == $status ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date de début -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                        <input type="date" name="date_from" value="{{ $filters['date_from'] }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Date de fin -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                        <input type="date" name="date_to" value="{{ $filters['date_to'] }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Livreur -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Livreur</label>
                        <select name="livreur_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Tous les livreurs</option>
                            @foreach($livreurs as $livreur)
                                <option value="{{ $livreur->id }}" {{ $filters['livreur_id'] == $livreur->id ? 'selected' : '' }}>
                                    {{ $livreur->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Boutons -->
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Filtrer
                        </button>
                        <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Actions en masse -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <input type="checkbox" id="select-all" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <label for="select-all" class="text-sm font-medium text-gray-700">Sélectionner tout</label>
                        
                        <select id="bulk-status" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Changer le statut</option>
                            @foreach(\App\Models\Order::STATUSES as $status => $label)
                                <option value="{{ $status }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        
                        <button id="bulk-update-btn" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 disabled:opacity-50" disabled>
                            Mettre à jour
                        </button>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('admin.orders.export-pdf', request()->query()) }}" 
                           class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Exporter PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des commandes -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <input type="checkbox" id="select-all-table" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'id', 'sort_order' => request('sort_by') == 'id' && request('sort_order') == 'asc' ? 'desc' : 'asc']) }}" 
                                   class="hover:text-gray-700">
                                    Commande
                                    @if(request('sort_by') == 'id')
                                        @if(request('sort_order') == 'asc')
                                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produits</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'total_price', 'sort_order' => request('sort_by') == 'total_price' && request('sort_order') == 'asc' ? 'desc' : 'asc']) }}" 
                                   class="hover:text-gray-700">
                                    Total
                                    @if(request('sort_by') == 'total_price')
                                        @if(request('sort_order') == 'asc')
                                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'created_at', 'sort_order' => request('sort_by') == 'created_at' && request('sort_order') == 'asc' ? 'desc' : 'asc']) }}" 
                                   class="hover:text-gray-700">
                                    Date
                                    @if(request('sort_by') == 'created_at')
                                        @if(request('sort_order') == 'asc')
                                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" class="order-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500" 
                                           value="{{ $order->id }}">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">#{{ $order->id }}</div>
                                    <div class="text-sm text-gray-500">{{ $order->payment_method ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $order->user->name ?? 'N/A' }}</div>
                                    <div class="text-sm text-gray-500">{{ $order->user->email ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $order->products->count() }} produit(s)</div>
                                    <div class="text-sm text-gray-500">
                                        @foreach($order->products->take(2) as $product)
                                            {{ $product->name }}{{ !$loop->last ? ', ' : '' }}
                                        @endforeach
                                        @if($order->products->count() > 2)
                                            +{{ $order->products->count() - 2 }} autres
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ number_format($order->total_price, 0, ',', ' ') }} FCFA</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <select class="status-select text-sm border-0 bg-transparent focus:ring-2 focus:ring-blue-500 rounded" 
                                            data-order-id="{{ $order->id }}">
                                        @foreach(\App\Models\Order::STATUSES as $status => $label)
                                            <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.orders.manage', $order) }}" 
                                           class="text-blue-600 hover:text-blue-900">Voir</a>
                                        <a href="{{ route('admin.orders.export-pdf', ['order_ids' => [$order->id]]) }}" 
                                           class="text-red-600 hover:text-red-900">PDF</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune commande trouvée</h3>
                                    <p class="mt-1 text-sm text-gray-500">Essayez de modifier vos filtres de recherche.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal pour les notes -->
<div id="notes-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Ajouter des notes</h3>
                <textarea id="notes-textarea" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Notes optionnelles..."></textarea>
                <div class="mt-4 flex justify-end space-x-3">
                    <button id="cancel-notes" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">Annuler</button>
                    <button id="save-notes" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Sauvegarder</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sélection multiple
    const selectAllCheckbox = document.getElementById('select-all');
    const selectAllTableCheckbox = document.getElementById('select-all-table');
    const orderCheckboxes = document.querySelectorAll('.order-checkbox');
    const bulkUpdateBtn = document.getElementById('bulk-update-btn');
    const bulkStatusSelect = document.getElementById('bulk-status');

    // Synchroniser les checkboxes "sélectionner tout"
    function syncSelectAll() {
        const checkedBoxes = document.querySelectorAll('.order-checkbox:checked');
        const allBoxes = document.querySelectorAll('.order-checkbox');
        
        selectAllCheckbox.checked = checkedBoxes.length === allBoxes.length && allBoxes.length > 0;
        selectAllTableCheckbox.checked = selectAllCheckbox.checked;
        
        bulkUpdateBtn.disabled = checkedBoxes.length === 0 || !bulkStatusSelect.value;
    }

    selectAllCheckbox.addEventListener('change', function() {
        orderCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        selectAllTableCheckbox.checked = this.checked;
        syncSelectAll();
    });

    selectAllTableCheckbox.addEventListener('change', function() {
        orderCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        selectAllCheckbox.checked = this.checked;
        syncSelectAll();
    });

    orderCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', syncSelectAll);
    });

    bulkStatusSelect.addEventListener('change', syncSelectAll);

    // Mise à jour en masse
    bulkUpdateBtn.addEventListener('click', function() {
        const selectedOrders = Array.from(document.querySelectorAll('.order-checkbox:checked')).map(cb => cb.value);
        const newStatus = bulkStatusSelect.value;
        
        if (selectedOrders.length === 0 || !newStatus) return;

        // Afficher le modal pour les notes
        document.getElementById('notes-modal').classList.remove('hidden');
        
        document.getElementById('save-notes').onclick = function() {
            const notes = document.getElementById('notes-textarea').value;
            
            fetch('{{ route("admin.orders.bulk-update-status") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    order_ids: selectedOrders,
                    status: newStatus,
                    notes: notes
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Erreur: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erreur lors de la mise à jour');
            });
            
            document.getElementById('notes-modal').classList.add('hidden');
        };
    });

    document.getElementById('cancel-notes').addEventListener('click', function() {
        document.getElementById('notes-modal').classList.add('hidden');
    });

    // Mise à jour individuelle du statut
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', function() {
            const orderId = this.dataset.orderId;
            const newStatus = this.value;
            
            fetch(`/admin/orders/${orderId}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    status: newStatus
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Optionnel: afficher une notification de succès
                    console.log('Statut mis à jour avec succès');
                } else {
                    alert('Erreur: ' + data.message);
                    // Restaurer l'ancien statut
                    this.value = this.dataset.originalValue || 'en attente';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erreur lors de la mise à jour du statut');
                this.value = this.dataset.originalValue || 'en attente';
            });
        });
        
        // Sauvegarder la valeur originale
        select.dataset.originalValue = select.value;
    });
});
</script>
@endsection