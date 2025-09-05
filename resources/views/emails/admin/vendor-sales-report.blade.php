<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport Ventes Vendeurs - {{ ucfirst($reportType) }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 1000px;
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
        .summary-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        .summary-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .summary-card h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
            opacity: 0.9;
        }
        .summary-card .value {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .summary-card .growth {
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
        .vendor-rank {
            background: #ffd700;
            color: #333;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
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
        .vendor-details {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin: 10px 0;
        }
        .vendor-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .vendor-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 15px;
        }
        .vendor-stat {
            text-align: center;
            padding: 10px;
            background: white;
            border-radius: 5px;
        }
        .vendor-stat .label {
            font-size: 12px;
            color: #6c757d;
            margin-bottom: 5px;
        }
        .vendor-stat .value {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Rapport Ventes Vendeurs {{ ucfirst($reportType) }}</h1>
            <p>Bonjour {{ $admin->name }},</p>
            <p>Voici le rapport complet des ventes de tous les vendeurs pour la période du {{ $period['label'] }}</p>
        </div>

        <div class="period-info">
            <h3>📅 Période analysée</h3>
            <p><strong>{{ $period['label'] }}</strong></p>
            <p>Rapport généré le {{ now()->format('d/m/Y à H:i') }}</p>
        </div>

        <!-- Résumé global -->
        <div class="summary-stats">
            <div class="summary-card">
                <h3>Total Commandes</h3>
                <div class="value">{{ $summaryData['total_orders'] }}</div>
                <div class="growth {{ $summaryData['orders_growth'] > 0 ? 'positive' : ($summaryData['orders_growth'] < 0 ? 'negative' : 'neutral') }}">
                    @if($summaryData['orders_growth'] != 0)
                        {{ $summaryData['orders_growth'] > 0 ? '+' : '' }}{{ number_format($summaryData['orders_growth'], 1) }}% vs période précédente
                    @else
                        Aucune variation
                    @endif
                </div>
            </div>

            <div class="summary-card">
                <h3>Chiffre d'Affaires Total</h3>
                <div class="value">{{ number_format($summaryData['total_revenue'], 0, ',', ' ') }} FCFA</div>
                <div class="growth {{ $summaryData['revenue_growth'] > 0 ? 'positive' : ($summaryData['revenue_growth'] < 0 ? 'negative' : 'neutral') }}">
                    @if($summaryData['revenue_growth'] != 0)
                        {{ $summaryData['revenue_growth'] > 0 ? '+' : '' }}{{ number_format($summaryData['revenue_growth'], 1) }}% vs période précédente
                    @else
                        Aucune variation
                    @endif
                </div>
            </div>

            <div class="summary-card">
                <h3>Produits Vendus</h3>
                <div class="value">{{ $summaryData['total_products_sold'] }}</div>
                <div class="growth">Unités vendues</div>
            </div>

            <div class="summary-card">
                <h3>Vendeurs Actifs</h3>
                <div class="value">{{ $summaryData['active_vendors'] }}/{{ $summaryData['total_vendors'] }}</div>
                <div class="growth">{{ number_format(($summaryData['active_vendors'] / $summaryData['total_vendors']) * 100, 1) }}% d'activité</div>
            </div>
        </div>

        @if($summaryData['top_vendors']->count() > 0)
        <div class="section">
            <h2>🏆 Top Vendeurs</h2>
            @foreach($summaryData['top_vendors'] as $index => $vendorData)
            <div class="vendor-details">
                <div class="vendor-header">
                    <div>
                        <span class="vendor-rank">#{{ $index + 1 }}</span>
                        <strong>{{ $vendorData['vendor']->name }}</strong>
                        <small style="color: #6c757d;">({{ $vendorData['vendor']->email }})</small>
                    </div>
                    <div style="text-align: right;">
                        <strong>{{ number_format($vendorData['total_revenue'], 0, ',', ' ') }} FCFA</strong><br>
                        <small>{{ $vendorData['total_orders'] }} commande(s)</small>
                    </div>
                </div>
                
                <div class="vendor-stats">
                    <div class="vendor-stat">
                        <div class="label">Commandes</div>
                        <div class="value">{{ $vendorData['total_orders'] }}</div>
                        <small class="growth {{ $vendorData['orders_growth'] > 0 ? 'positive' : ($vendorData['orders_growth'] < 0 ? 'negative' : 'neutral') }}">
                            {{ $vendorData['orders_growth'] > 0 ? '+' : '' }}{{ number_format($vendorData['orders_growth'], 1) }}%
                        </small>
                    </div>
                    <div class="vendor-stat">
                        <div class="label">Chiffre d'Affaires</div>
                        <div class="value">{{ number_format($vendorData['total_revenue'], 0, ',', ' ') }} FCFA</div>
                        <small class="growth {{ $vendorData['revenue_growth'] > 0 ? 'positive' : ($vendorData['revenue_growth'] < 0 ? 'negative' : 'neutral') }}">
                            {{ $vendorData['revenue_growth'] > 0 ? '+' : '' }}{{ number_format($vendorData['revenue_growth'], 1) }}%
                        </small>
                    </div>
                    <div class="vendor-stat">
                        <div class="label">Produits Vendus</div>
                        <div class="value">{{ $vendorData['total_products_sold'] }}</div>
                        <small>unités</small>
                    </div>
                </div>

                @if($vendorData['top_products']->count() > 0)
                <div style="margin-top: 15px;">
                    <strong>Top produits :</strong>
                    @foreach($vendorData['top_products'] as $productData)
                        <span style="background: #e9ecef; padding: 4px 8px; border-radius: 12px; font-size: 12px; margin: 2px;">
                            {{ $productData['product']->name }} ({{ number_format($productData['revenue'], 0, ',', ' ') }} FCFA)
                        </span>
                    @endforeach
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        @if($summaryData['top_products']->count() > 0)
        <div class="section">
            <h2>🔥 Top Produits Globaux</h2>
            <table>
                <thead>
                    <tr>
                        <th>Rang</th>
                        <th>Produit</th>
                        <th>Vendeur</th>
                        <th>Quantité Vendue</th>
                        <th>Chiffre d'Affaires</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($summaryData['top_products'] as $index => $productData)
                    <tr>
                        <td><span class="vendor-rank">#{{ $index + 1 }}</span></td>
                        <td>
                            <strong>{{ $productData['product']->name }}</strong><br>
                            <small style="color: #6c757d;">{{ $productData['product']->category->name ?? 'Sans catégorie' }}</small>
                        </td>
                        <td>{{ $productData['product']->seller->name ?? 'Vendeur inconnu' }}</td>
                        <td>{{ $productData['quantity_sold'] }} unités</td>
                        <td>{{ number_format($productData['revenue'], 0, ',', ' ') }} FCFA</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('admin.dashboard') }}" class="btn">Dashboard Admin</a>
            <a href="{{ route('admin.users.index') }}" class="btn">Gestion Vendeurs</a>
            <a href="{{ route('admin.orders.index') }}" class="btn">Toutes les Commandes</a>
        </div>

        <div class="footer">
            <p>Ce rapport est généré automatiquement par {{ config('app.name') }}.</p>
            <p>Les données incluent toutes les commandes validées de la période spécifiée.</p>
        </div>
    </div>
</body>
</html>
