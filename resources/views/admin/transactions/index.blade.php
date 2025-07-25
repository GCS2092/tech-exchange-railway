@extends('layouts.admin')
@section('content')

<div class="container mx-auto px-2 sm:px-4 py-6">
    <!-- En-tête avec statistiques -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-3xl font-bold text-gray-800">Transactions</h1>
            <div class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
                <a href="{{ route('admin.transactions.create') }}" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg shadow flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Nouvelle Transaction
                </a>
                <a href="{{ route('admin.transactions.export') }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Exporter CSV
                </a>
            </div>
        </div>

        <!-- Histogramme des commandes par statut -->
        <div class="flex flex-col md:flex-row gap-6 mb-8">
            <div class="w-full md:w-64 lg:w-72 bg-white rounded-lg shadow p-4 flex flex-col items-center justify-center">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Commandes par statut</h2>
                <canvas id="ordersStatusBarChart" height="220"></canvas>
            </div>
            <div class="flex-1 min-w-0">
                <!-- Statistiques existantes -->
                @if(isset($stats))
                    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-white rounded-lg shadow p-4 flex items-center">
                            <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs sm:text-sm font-medium text-gray-600">Total Transactions</p>
                                <p class="text-lg sm:text-2xl font-semibold text-gray-900">{{ $stats['total_transactions'] }}</p>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg shadow p-4 flex items-center">
                            <div class="p-2 rounded-full bg-green-100 text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs sm:text-sm font-medium text-gray-600">Montant Total</p>
                                <p class="text-lg sm:text-2xl font-semibold text-gray-900">{{ number_format($stats['total_amount'], 0, ',', ' ') }} FCFA</p>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg shadow p-4 flex items-center">
                            <div class="p-2 rounded-full bg-yellow-100 text-yellow-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs sm:text-sm font-medium text-gray-600">En Attente</p>
                                <p class="text-lg sm:text-2xl font-semibold text-gray-900">{{ $stats['pending_transactions'] }}</p>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg shadow p-4 flex items-center">
                            <div class="p-2 rounded-full bg-red-100 text-red-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs sm:text-sm font-medium text-gray-600">Échouées</p>
                                <p class="text-lg sm:text-2xl font-semibold text-gray-900">{{ $stats['failed_transactions'] }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <!-- Fin histogramme -->
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Filtres</h2>
        <form method="GET" action="{{ route('admin.transactions.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Statut</label>
                <select name="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Tous</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Payé</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Échoué</option>
                    <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Remboursé</option>
                </select>
            </div>
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Méthode</label>
                <select name="payment_method" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Toutes</option>
                    <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Espèces</option>
                    <option value="card" {{ request('payment_method') == 'card' ? 'selected' : '' }}>Carte</option>
                    <option value="mobile_money" {{ request('payment_method') == 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                    <option value="bank_transfer" {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Virement</option>
                </select>
            </div>
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Date début</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Date fin</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Montant min</label>
                <input type="number" name="min_amount" value="{{ request('min_amount') }}" placeholder="0" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Montant max</label>
                <input type="number" name="max_amount" value="{{ request('max_amount') }}" placeholder="100000" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="sm:col-span-2 md:col-span-3 lg:col-span-6 flex flex-col sm:flex-row gap-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md w-full sm:w-auto">Filtrer</button>
                <a href="{{ route('admin.transactions.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md w-full sm:w-auto">Réinitialiser</a>
            </div>
        </form>
    </div>

    <!-- Tableau des transactions -->
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <!-- Table classique pour sm et + -->
        <div class="hidden sm:block">
            <table class="w-full min-w-[700px] whitespace-nowrap text-xs sm:text-sm">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 sm:px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Commande</th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Méthode</th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Status</th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Date</th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($transactions as $transaction)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 sm:px-6 py-4 text-gray-900">{{ $transaction->id }}</td>
                        <td class="px-4 sm:px-6 py-4 text-gray-900">
                            <a href="{{ route('admin.orders.show', $transaction->order_id) }}" class="text-blue-600 hover:text-blue-900">
                                #{{ $transaction->order_id }}
                            </a>
                        </td>
                        <td class="px-4 sm:px-6 py-4 text-gray-900">{{ $transaction->user->name ?? '—' }}</td>
                        <td class="px-4 sm:px-6 py-4 font-medium text-gray-900">{{ $transaction->formatted_amount }}</td>
                        <td class="px-4 sm:px-6 py-4 text-gray-900 hidden md:table-cell">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}
                            </span>
                        </td>
                        <td class="px-4 sm:px-6 py-4 text-gray-900 hidden md:table-cell">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaction->status_class }}">
                                {{ $transaction->status_label }}
                            </span>
                        </td>
                        <td class="px-4 sm:px-6 py-4 text-gray-900 hidden lg:table-cell">{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 sm:px-6 py-4 font-medium hidden md:table-cell">
                            <div class="flex flex-wrap items-center space-x-2">
                                <a href="{{ route('admin.transactions.show', $transaction) }}" class="text-indigo-600 hover:text-indigo-900">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                @if($transaction->isPending())
                                <form action="{{ route('admin.transactions.mark-completed', $transaction) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900" title="Marquer comme payé">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                                @if($transaction->isPending())
                                <form action="{{ route('admin.transactions.mark-failed', $transaction) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Marquer comme échoué">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                                @if($transaction->isCompleted())
                                <form action="{{ route('admin.transactions.mark-refunded', $transaction) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-pink-600 hover:text-pink-900" title="Marquer comme remboursé">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-4 text-center text-gray-500">
                            Aucune transaction trouvée
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Affichage cartes pour mobile -->
        <div class="sm:hidden">
            @forelse ($transactions as $transaction)
            <div class="bg-white rounded-lg shadow mb-4 p-4 flex flex-col gap-2">
                <div class="flex justify-between items-center">
                    <span class="font-bold text-indigo-700">#{{ $transaction->order_id }}</span>
                    <span class="text-xs text-gray-500">{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Client :</span>
                    <span class="font-medium">{{ $transaction->user->name ?? '—' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Montant :</span>
                    <span class="font-semibold">{{ $transaction->formatted_amount }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Méthode :</span>
                    <span>{{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Statut :</span>
                    <span class="font-semibold {{ $transaction->status_class }}">{{ $transaction->status_label }}</span>
                </div>
                <div class="flex gap-2 mt-2">
                    <a href="{{ route('admin.transactions.show', $transaction) }}" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white text-xs px-2 py-2 rounded-md text-center">Voir</a>
                    @if($transaction->isPending())
                    <form action="{{ route('admin.transactions.mark-completed', $transaction) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white text-xs px-2 py-2 rounded-md">Payé</button>
                    </form>
                    <form action="{{ route('admin.transactions.mark-failed', $transaction) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white text-xs px-2 py-2 rounded-md">Échoué</button>
                    </form>
                    @endif
                    @if($transaction->isCompleted())
                    <form action="{{ route('admin.transactions.mark-refunded', $transaction) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full bg-pink-600 hover:bg-pink-700 text-white text-xs px-2 py-2 rounded-md">Remboursé</button>
                    </form>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center text-gray-500 py-8">Aucune transaction trouvée</div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $transactions->links() }}
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('ordersStatusBarChart').getContext('2d');
        var data = {
            labels: {!! json_encode(array_values($orderStatusLabels ?? [])) !!},
            datasets: [{
                label: 'Nombre de commandes',
                data: {!! json_encode(array_values($orderStatusCounts ?? [])) !!},
                backgroundColor: [
                    '#fbbf24', '#3b82f6', '#a78bfa', '#6366f1', '#f59e42', '#10b981', '#ef4444', '#6b7280', '#ec4899'
                ],
                borderRadius: 6,
                borderWidth: 1
            }]
        };
        var options = {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: true }
            },
            scales: {
                x: { grid: { display: false } },
                y: { beginAtZero: true, grid: { color: '#f3f4f6' } }
            }
        };
        new Chart(ctx, { type: 'bar', data: data, options: options });
    });
</script>
@endpush

@endsection