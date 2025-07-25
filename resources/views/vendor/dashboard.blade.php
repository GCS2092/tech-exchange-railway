@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 py-10">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-indigo-700">Tableau de bord Vendeur</h1>
                <p class="text-gray-600 mt-1">Bienvenue, {{ auth()->user()->name }} !</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('vendeur.products.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg shadow font-semibold flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Nouveau produit
                </a>
                <a href="{{ route('vendeur.livreurs.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg shadow font-semibold flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 01-8 0M12 11v2m0 4h.01"/></svg>
                    Mes livreurs
                </a>
                <a href="{{ route('vendeur.quickmanage') }}" class="nav-link text-white tooltip" data-tooltip="Gestion rapide">Gestion rapide</a>
            </div>
        </div>
        <div class="flex flex-wrap gap-4 mb-8">
    <a href="{{ route('vendeur.products.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg shadow font-semibold flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
        Nouveau produit
    </a>
    <a href="{{ route('vendeur.categories.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg shadow font-semibold flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
        Nouvelle catégorie
    </a>
    <a href="{{ route('vendeur.livreurs.create') }}" class="bg-pink-600 hover:bg-pink-700 text-white px-5 py-2 rounded-lg shadow font-semibold flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
        Nouveau livreur
    </a>
</div>
        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
                <div class="text-3xl font-bold text-indigo-700">{{ $stats['products_count'] ?? 0 }}</div>
                <div class="text-gray-500 mt-2">Produits</div>
            </div>
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
                <div class="text-3xl font-bold text-indigo-700">{{ $stats['orders_count'] ?? 0 }}</div>
                <div class="text-gray-500 mt-2">Commandes</div>
            </div>
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
                <div class="text-3xl font-bold text-green-600">{{ number_format($stats['total_sales'] ?? 0, 0, ',', ' ') }} FCFA</div>
                <div class="text-gray-500 mt-2">Ventes totales</div>
            </div>
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
                <div class="text-3xl font-bold text-pink-600">{{ number_format($totalProductsValue ?? 0, 0, ',', ' ') }} FCFA</div>
                <div class="text-gray-500 mt-2">Valeur totale stock</div>
            </div>
        </div>
        <!-- Tableau produits -->
        <h2 class="text-xl font-bold mb-4">Mes produits</h2>
        <div class="overflow-x-auto bg-white rounded-xl shadow p-6">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2">Image</th>
                        <th class="px-4 py-2">Nom</th>
                        <th class="px-4 py-2">Description</th>
                        <th class="px-4 py-2">Catégorie</th>
                        <th class="px-4 py-2">Prix</th>
                        <th class="px-4 py-2">Stock</th>
                        <th class="px-4 py-2">Statut</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($products as $product)
                    <tr>
                        <td class="px-4 py-2">
                            @if($product->image)
                                <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded">
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 font-semibold">{{ $product->name }}</td>
                        <td class="px-4 py-2">{{ Str::limit($product->description, 40) }}</td>
                        <td class="px-4 py-2">{{ optional($product->category)->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ number_format($product->price, 0, ',', ' ') }} FCFA</td>
                        <td class="px-4 py-2">{{ $product->quantity }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded-full text-xs {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td class="px-4 py-2 flex gap-2">
                            <a href="{{ route('vendeur.products.edit', $product->id) }}" class="text-blue-600 hover:underline">Éditer</a>
                            <form action="{{ route('vendeur.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Supprimer ce produit ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                            </form>
                            <form action="{{ route('vendeur.products.toggle', $product->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-xs px-2 py-1 rounded {{ $product->is_active ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $product->is_active ? 'Désactiver' : 'Activer' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-4 text-center text-gray-500">Aucun produit trouvé.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">{{ $products->links() }}</div>
        </div>
        <!-- Commandes récentes -->
        <div class="bg-white rounded-xl shadow p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Commandes récentes</h2>
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">#</th>
                        <th class="px-4 py-2 text-left">Client</th>
                        <th class="px-4 py-2 text-left">Total</th>
                        <th class="px-4 py-2 text-left">Statut</th>
                        <th class="px-4 py-2 text-left">Date</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($orders as $order)
                    <tr>
                        <td class="px-4 py-2">#{{ $order->id }}</td>
                        <td class="px-4 py-2">{{ optional($order->user)->name ?? 'Inconnu' }}</td>
                        <td class="px-4 py-2">{{ number_format($order->total_price, 0, ',', ' ') }} FCFA</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded-full text-xs {{ $order->status_class }}">{{ $order->status_label }}</span>
                        </td>
                        <td class="px-4 py-2">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('orders.show', $order->id) }}" class="text-blue-600 hover:underline">Voir</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-4 text-center text-gray-500">Aucune commande récente.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Notifications -->
        <div class="bg-white rounded-xl shadow p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Notifications</h2>
            <ul>
                @forelse($notifications as $notification)
                <li class="mb-2 text-sm text-gray-700">{{ $notification->data['message'] ?? $notification->type }} <span class="text-xs text-gray-400">({{ $notification->created_at->diffForHumans() }})</span></li>
                @empty
                <li class="text-gray-500">Aucune notification.</li>
                @endforelse
            </ul>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <!-- Statistiques avancées -->
    <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center">
        <h2 class="text-base font-semibold text-gray-800 mb-2">Ventes par mois (12 derniers mois)</h2>
        <ul class="w-full text-sm text-gray-700">
            @foreach($salesByMonth as $month => $amount)
                <li class="flex justify-between border-b py-1">
                    <span>{{ $month }}</span>
                    <span class="font-semibold">{{ number_format($amount, 0, ',', ' ') }} FCFA</span>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center">
        <h2 class="text-base font-semibold text-gray-800 mb-2">Produits les plus vendus</h2>
        <ul class="w-full text-sm text-gray-700">
            @foreach($topProducts as $product)
                <li class="flex justify-between border-b py-1">
                    <span>{{ $product->name }}</span>
                    <span class="font-semibold">{{ $product->sold_count }} ventes</span>
                </li>
            @endforeach
        </ul>
    </div>
</div>
<!-- Alertes stock bas -->
@if(count($lowStockProducts) > 0)
<div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded">
    <strong>Attention :</strong> Certains produits sont en stock bas :
    <ul class="list-disc ml-6">
        @foreach($lowStockProducts as $product)
            <li>{{ $product->name }} ({{ $product->quantity }} en stock)</li>
        @endforeach
    </ul>
</div>
@endif
<!-- Notifications récentes -->
@if(count($recentNotifications) > 0)
<div class="bg-blue-50 border-l-4 border-blue-400 text-blue-800 p-4 mb-6 rounded">
    <strong>Notifications récentes :</strong>
    <ul class="list-disc ml-6">
        @foreach($recentNotifications as $notif)
            <li>{{ $notif->data['message'] ?? $notif->data['title'] ?? 'Notification' }} <span class="text-xs text-gray-500">({{ $notif->created_at->diffForHumans() }})</span></li>
        @endforeach
    </ul>
</div>
@endif
    </div>
</div>
@endsection 