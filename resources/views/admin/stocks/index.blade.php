@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- En-tête simple -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">📊 Gestion des Stocks</h1>
            <p class="text-muted">Surveillance et gestion des niveaux de stock</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.stocks.export') }}" class="btn btn-success">
                <i class="fas fa-download"></i> Exporter CSV
            </a>
            <form action="{{ route('admin.stocks.send-report') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-warning" onclick="return confirm('Envoyer le rapport des stocks faibles ?')">
                    <i class="fas fa-envelope"></i> Envoyer Rapport
                </button>
            </form>
        </div>
    </div>

    <!-- Statistiques simples -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Produits</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_products'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                En Rupture</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['critical_stock'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Stock Faible</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['low_stock'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Stock Normal</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['normal_stock'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres simples -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filtres</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.stocks.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="stock_status" class="form-label">Statut du stock</label>
                    <select name="stock_status" id="stock_status" class="form-control">
                        <option value="">Tous</option>
                        <option value="critical" {{ request('stock_status') == 'critical' ? 'selected' : '' }}>En rupture</option>
                        <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Stock faible</option>
                        <option value="normal" {{ request('stock_status') == 'normal' ? 'selected' : '' }}>Stock normal</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="search" class="form-label">Recherche</label>
                    <input type="text" name="search" id="search" class="form-control" 
                           value="{{ request('search') }}" placeholder="Nom, description...">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search"></i> Filtrer
                    </button>
                    <a href="{{ route('admin.stocks.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Réinitialiser
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tableau des produits -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste des Produits</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Prix</th>
                            <th>Stock</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $product->image_url ?? '/images/default-avatar.png' }}" 
                                             alt="{{ $product->name }}" 
                                             class="rounded-circle" 
                                             width="40" 
                                             height="40"
                                             onerror="this.src='/images/default-avatar.png'">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">{{ $product->name }}</h6>
                                        <small class="text-muted">{{ $product->brand ?? 'Sans marque' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ number_format($product->price, 2) }} €</td>
                            <td>
                                <span class="badge {{ $product->quantity == 0 ? 'bg-danger' : ($product->quantity <= ($product->min_stock_alert ?? 5) ? 'bg-warning' : 'bg-success') }}">
                                    {{ $product->quantity }}
                                </span>
                            </td>
                            <td>
                                @if($product->quantity == 0)
                                    <span class="badge bg-danger">En rupture</span>
                                @elseif($product->quantity <= ($product->min_stock_alert ?? 5))
                                    <span class="badge bg-warning">Stock faible</span>
                                @else
                                    <span class="badge bg-success">Normal</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#updateStockModal{{ $product->id }}">
                                    <i class="fas fa-edit"></i> Modifier
                                </button>
                            </td>
                        </tr>

                        <!-- Modal de mise à jour du stock -->
                        <div class="modal fade" id="updateStockModal{{ $product->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('admin.stocks.update', $product->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Mettre à jour le stock</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="quantity" class="form-label">Stock actuel</label>
                                                <input type="number" name="quantity" id="quantity" 
                                                       class="form-control" value="{{ $product->quantity }}" min="0" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="min_stock_alert" class="form-label">Seuil d'alerte minimum</label>
                                                <input type="number" name="min_stock_alert" id="min_stock_alert" 
                                                       class="form-control" value="{{ $product->min_stock_alert ?? 5 }}" min="0">
                                            </div>
                                            <div class="mb-3">
                                                <label for="max_stock_alert" class="form-label">Seuil d'alerte maximum</label>
                                                <input type="number" name="max_stock_alert" id="max_stock_alert" 
                                                       class="form-control" value="{{ $product->max_stock_alert ?? 50 }}" min="0">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Aucun produit trouvé</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show position-fixed" 
         style="top: 20px; right: 20px; z-index: 1050;" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('info'))
    <div class="alert alert-info alert-dismissible fade show position-fixed" 
         style="top: 20px; right: 20px; z-index: 1050;" role="alert">
        {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@endsection

@push('scripts')
<script>
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);
</script>
@endpush
