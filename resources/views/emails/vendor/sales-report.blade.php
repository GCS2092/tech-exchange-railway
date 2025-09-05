<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport de Ventes - {{ ucfirst($reportType) }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .container {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #2c3e50;
            margin: 0;
            font-size: 28px;
        }
        .period-info {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .stat-card h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
            opacity: 0.9;
        }
        .stat-card .value {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .stat-card .growth {
            font-size: 12px;
            opacity: 0.8;
        }
        .growth.positive { color: #4caf50; }
        .growth.negative { color: #f44336; }
        .growth.neutral { color: #ff9800; }
        .section {
            margin: 30px 0;
        }
        .section h2 {
            color: #2c3e50;
            border-bottom: 2px solid #ecf0f1;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }
        th {
            background: #f8f9fa;
            font-weight: 600;
            color: #495057;
        }
        tr:hover {
            background: #f8f9fa;
        }
        .product-image {
            width: 40px;
            height: 40px;
            border-radius: 5px;
            object-fit: cover;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 5px;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #0056b3;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            color: #6c757d;
            font-size: 14px;
        }
        .no-data {
            text-align: center;
            color: #6c757d;
            font-style: italic;
            padding: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Rapport de Ventes {{ ucfirst($reportType) }}</h1>
            <p>Bonjour {{ $vendor->name }},</p>
            <p>Voici votre rapport de ventes pour la période du {{ $period['label'] }}</p>
        </div>

        <div class="period-info">
            <h3>📅 Période analysée</h3>
            <p><strong>{{ $period['label'] }}</strong></p>
            <p>Rapport généré le {{ now()->format('d/m/Y à H:i') }}</p>
        </div>

        <!-- Statistiques principales -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Commandes</h3>
                <div class="value">{{ $salesData['total_orders'] }}</div>
                <div class="growth {{ $salesData['orders_growth'] > 0 ? 'positive' : ($salesData['orders_growth'] < 0 ? 'negative' : 'neutral') }}">
                    @if($salesData['orders_growth'] != 0)
                        {{ $salesData['orders_growth'] > 0 ? '+' : '' }}{{ number_format($salesData['orders_growth'], 1) }}% vs période précédente
                    @else
                        Aucune variation
                    @endif
                </div>
            </div>

            <div class="stat-card">
                <h3>Chiffre d'Affaires</h3>
                <div class="value">{{ number_format($salesData['total_revenue'], 0, ',', ' ') }} FCFA</div>
                <div class="growth {{ $salesData['revenue_growth'] > 0 ? 'positive' : ($salesData['revenue_growth'] < 0 ? 'negative' : 'neutral') }}">
                    @if($salesData['revenue_growth'] != 0)
                        {{ $salesData['revenue_growth'] > 0 ? '+' : '' }}{{ number_format($salesData['revenue_growth'], 1) }}% vs période précédente
                    @else
                        Aucune variation
                    @endif
                </div>
            </div>

            <div class="stat-card">
                <h3>Produits Vendus</h3>
                <div class="value">{{ $salesData['total_products_sold'] }}</div>
                <div class="growth">Unités vendues</div>
            </div>
        </div>

        @if($salesData['top_products']->count() > 0)
        <div class="section">
            <h2>🏆 Top Produits</h2>
            <table>
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Quantité Vendue</th>
                        <th>Chiffre d'Affaires</th>
                        <th>Nombre de Commandes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salesData['top_products'] as $productData)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center;">
                                @if($productData['product']->image)
                                    <img src="{{ asset('storage/' . $productData['product']->image) }}" alt="{{ $productData['product']->name }}" class="product-image" style="margin-right: 10px;">
                                @endif
                                <div>
                                    <strong>{{ $productData['product']->name }}</strong><br>
                                    <small style="color: #6c757d;">{{ $productData['product']->category->name ?? 'Sans catégorie' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $productData['quantity_sold'] }} unités</td>
                        <td>{{ number_format($productData['revenue'], 0, ',', ' ') }} FCFA</td>
                        <td>{{ $productData['orders_count'] }} commande(s)</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="no-data">
            <h3>📭 Aucune vente pour cette période</h3>
            <p>Continuez à promouvoir vos produits pour augmenter vos ventes !</p>
        </div>
        @endif

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('vendeur.dashboard') }}" class="btn">Voir mon Dashboard</a>
            <a href="{{ route('vendeur.products.index') }}" class="btn">Gérer mes Produits</a>
            <a href="{{ route('vendeur.orders.index') }}" class="btn">Voir mes Commandes</a>
        </div>

        <div class="footer">
            <p>Ce rapport est généré automatiquement par {{ config('app.name') }}.</p>
            <p>Pour toute question concernant vos ventes, contactez notre équipe support.</p>
        </div>
    </div>
</body>
</html>
