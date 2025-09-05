<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport des Commandes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        
        .header p {
            margin: 5px 0 0 0;
            color: #666;
        }
        
        .filters {
            background-color: #f8f9fa;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .filters h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #333;
        }
        
        .filters-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }
        
        .filter-item {
            font-size: 11px;
        }
        
        .filter-label {
            font-weight: bold;
            color: #555;
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .stat-card {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
        }
        
        .stat-number {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        
        .stat-label {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
            font-size: 11px;
        }
        
        .table td {
            font-size: 10px;
        }
        
        .status-badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-en-attente { background-color: #fff3cd; color: #856404; }
        .status-payé { background-color: #d1ecf1; color: #0c5460; }
        .status-en-préparation { background-color: #e2e3e5; color: #383d41; }
        .status-expédié { background-color: #cce5ff; color: #004085; }
        .status-en-livraison { background-color: #ffeaa7; color: #6c5ce7; }
        .status-livré { background-color: #d4edda; color: #155724; }
        .status-annulé { background-color: #f8d7da; color: #721c24; }
        .status-retourné { background-color: #e2e3e5; color: #383d41; }
        .status-remboursé { background-color: #f8d7da; color: #721c24; }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .summary {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .summary h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Rapport des Commandes</h1>
        <p>Généré le {{ now()->format('d/m/Y à H:i') }}</p>
    </div>

    <!-- Filtres appliqués -->
    @if(array_filter($filters))
        <div class="filters">
            <h3>Filtres appliqués :</h3>
            <div class="filters-grid">
                @if($filters['status'])
                    <div class="filter-item">
                        <span class="filter-label">Statut :</span> {{ \App\Models\Order::STATUSES[$filters['status']] ?? $filters['status'] }}
                    </div>
                @endif
                @if($filters['date_from'])
                    <div class="filter-item">
                        <span class="filter-label">Date de début :</span> {{ \Carbon\Carbon::parse($filters['date_from'])->format('d/m/Y') }}
                    </div>
                @endif
                @if($filters['date_to'])
                    <div class="filter-item">
                        <span class="filter-label">Date de fin :</span> {{ \Carbon\Carbon::parse($filters['date_to'])->format('d/m/Y') }}
                    </div>
                @endif
                @if($filters['search'])
                    <div class="filter-item">
                        <span class="filter-label">Recherche :</span> {{ $filters['search'] }}
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Statistiques -->
    <div class="stats">
        <div class="stat-card">
            <div class="stat-number">{{ number_format($stats['total_orders']) }}</div>
            <div class="stat-label">Total Commandes</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ number_format($stats['revenue']['total_revenue'] ?? 0, 0, ',', ' ') }} FCFA</div>
            <div class="stat-label">Chiffre d'Affaires</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['by_status']['en attente']['count'] ?? 0 }}</div>
            <div class="stat-label">En Attente</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $stats['by_status']['livré']['count'] ?? 0 }}</div>
            <div class="stat-label">Livrées</div>
        </div>
    </div>

    <!-- Résumé par statut -->
    <div class="summary">
        <h3>Répartition par statut :</h3>
        <div class="summary-grid">
            @foreach($stats['by_status'] as $status => $data)
                @if($data['count'] > 0)
                    <div>
                        <strong>{{ $data['label'] }} :</strong> 
                        {{ $data['count'] }} commande(s) 
                        ({{ $data['percentage'] }}%) - 
                        {{ number_format($data['revenue'], 0, ',', ' ') }} FCFA
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <!-- Tableau des commandes -->
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Email</th>
                <th>Produits</th>
                <th>Total</th>
                <th>Statut</th>
                <th>Date</th>
                <th>Livreur</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->user->name ?? 'N/A' }}</td>
                    <td>{{ $order->user->email ?? 'N/A' }}</td>
                    <td>
                        {{ $order->products->count() }} produit(s)
                        @if($order->products->count() > 0)
                            <br><small>
                                @foreach($order->products->take(3) as $product)
                                    • {{ $product->name }} ({{ $product->pivot->quantity }})
                                    @if(!$loop->last)<br>@endif
                                @endforeach
                                @if($order->products->count() > 3)
                                    <br>• +{{ $order->products->count() - 3 }} autres
                                @endif
                            </small>
                        @endif
                    </td>
                    <td>{{ number_format($order->total_price, 0, ',', ' ') }} FCFA</td>
                    <td>
                        <span class="status-badge status-{{ str_replace(' ', '-', $order->status) }}">
                            {{ \App\Models\Order::STATUSES[$order->status] ?? $order->status }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $order->livreur->name ?? 'Non assigné' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if($orders->count() === 0)
        <div style="text-align: center; padding: 40px; color: #666;">
            <p>Aucune commande trouvée avec les filtres appliqués.</p>
        </div>
    @endif

    <div class="footer">
        <p>Rapport généré automatiquement par le système de gestion des commandes</p>
        <p>Page 1 - {{ $orders->count() }} commande(s) affichée(s)</p>
    </div>
</body>
</html>
