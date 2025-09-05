<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport Quotidien - Stocks Faibles</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #dc3545, #c82333); color: white; padding: 30px; border-radius: 10px; margin-bottom: 30px; text-align: center; }
        .content { background: #fff; padding: 30px; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .summary { background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 30px; }
        .critical-section { background: #fff5f5; border: 2px solid #dc3545; padding: 20px; border-radius: 8px; margin-bottom: 30px; }
        .low-stock-section { background: #fffbf0; border: 2px solid #ffc107; padding: 20px; border-radius: 8px; margin-bottom: 30px; }
        .product-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .product-table th, .product-table td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        .product-table th { background: #f8f9fa; font-weight: bold; }
        .product-table tr:hover { background: #f8f9fa; }
        .stock-critical { color: #dc3545; font-weight: bold; }
        .stock-low { color: #ffc107; font-weight: bold; }
        .button { display: inline-block; background: #007bff; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 10px 5px; }
        .button:hover { background: #0056b3; }
        .footer { background: #f8f9fa; padding: 20px; border-radius: 8px; margin-top: 30px; text-align: center; }
        .stats { display: flex; justify-content: space-around; margin: 20px 0; }
        .stat-box { text-align: center; padding: 15px; border-radius: 8px; }
        .stat-critical { background: #dc3545; color: white; }
        .stat-low { background: #ffc107; color: #333; }
        .stat-total { background: #17a2b8; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0; font-size: 28px;">📊 RAPPORT QUOTIDIEN DES STOCKS</h1>
            <p style="margin: 10px 0 0 0; font-size: 16px; opacity: 0.9;">
                {{ now()->format('d/m/Y à H:i') }} - Bonjour {{ $admin->name }}
            </p>
        </div>
        
        <div class="content">
            <!-- Résumé statistiques -->
            <div class="summary">
                <h2 style="margin-top: 0; color: #333;">📈 Résumé de la situation</h2>
                <div class="stats">
                    <div class="stat-box stat-total">
                        <div style="font-size: 24px; font-weight: bold;">{{ $totalProducts }}</div>
                        <div>Total produits</div>
                    </div>
                    @if($criticalProducts->count() > 0)
                    <div class="stat-box stat-critical">
                        <div style="font-size: 24px; font-weight: bold;">{{ $criticalProducts->count() }}</div>
                        <div>En rupture</div>
                    </div>
                    @endif
                    @if($lowStockProducts->count() > 0)
                    <div class="stat-box stat-low">
                        <div style="font-size: 24px; font-weight: bold;">{{ $lowStockProducts->count() }}</div>
                        <div>Stock faible</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Produits en rupture critique -->
            @if($criticalProducts->count() > 0)
            <div class="critical-section">
                <h2 style="margin-top: 0; color: #dc3545;">🚨 PRODUITS EN RUPTURE DE STOCK</h2>
                <p style="color: #dc3545; font-weight: bold;">Ces produits ont un stock de 0 et nécessitent un réapprovisionnement URGENT !</p>
                
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Catégorie</th>
                            <th>Vendeur</th>
                            <th>Prix</th>
                            <th>Stock</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($criticalProducts as $product)
                        <tr>
                            <td><strong>{{ $product->name }}</strong></td>
                            <td>{{ $product->category->name ?? 'Non définie' }}</td>
                            <td>{{ $product->seller->name ?? 'Non assigné' }}</td>
                            <td>{{ number_format($product->price, 0, ',', ' ') }} FCFA</td>
                            <td class="stock-critical">{{ $product->quantity }} (RUPTURE)</td>
                            <td>
                                <a href="{{ url('/admin/products/' . $product->id . '/edit') }}" class="button" style="background: #dc3545;">
                                    🔧 Gérer
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <!-- Produits en stock faible -->
            @if($lowStockProducts->count() > 0)
            <div class="low-stock-section">
                <h2 style="margin-top: 0; color: #ffc107;">⚠️ PRODUITS EN STOCK FAIBLE</h2>
                <p style="color: #856404;">Ces produits ont un stock inférieur au seuil d'alerte et nécessitent une attention.</p>
                
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Catégorie</th>
                            <th>Vendeur</th>
                            <th>Prix</th>
                            <th>Stock actuel</th>
                            <th>Seuil d'alerte</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lowStockProducts as $product)
                        <tr>
                            <td><strong>{{ $product->name }}</strong></td>
                            <td>{{ $product->category->name ?? 'Non définie' }}</td>
                            <td>{{ $product->seller->name ?? 'Non assigné' }}</td>
                            <td>{{ number_format($product->price, 0, ',', ' ') }} FCFA</td>
                            <td class="stock-low">{{ $product->quantity }}</td>
                            <td>{{ $product->min_stock_alert ?? 5 }}</td>
                            <td>
                                <a href="{{ url('/admin/products/' . $product->id . '/edit') }}" class="button" style="background: #ffc107; color: #333;">
                                    🔧 Gérer
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <!-- Actions recommandées -->
            <div style="background: #e7f3ff; padding: 20px; border-radius: 8px; margin: 30px 0;">
                <h3 style="margin-top: 0; color: #0056b3;">🎯 Actions recommandées</h3>
                <ul style="margin: 0; padding-left: 20px;">
                    <li><strong>Priorité 1 :</strong> Réapprovisionner immédiatement les produits en rupture</li>
                    <li><strong>Priorité 2 :</strong> Planifier le réapprovisionnement des produits en stock faible</li>
                    <li><strong>Priorité 3 :</strong> Vérifier les seuils d'alerte et les ajuster si nécessaire</li>
                    <li><strong>Priorité 4 :</strong> Contacter les vendeurs concernés pour les produits critiques</li>
                </ul>
            </div>

            <!-- Boutons d'action -->
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/admin/products') }}" class="button">
                    📋 Voir tous les produits
                </a>
                <a href="{{ url('/admin/stocks') }}" class="button" style="background: #28a745;">
                    📊 Gestion des stocks
                </a>
                <a href="{{ url('/admin/reports') }}" class="button" style="background: #6c757d;">
                    📈 Rapports
                </a>
            </div>

            <div class="footer">
                <p style="margin: 0; font-style: italic; color: #666;">
                    Ce rapport est généré automatiquement chaque jour à 8h00.<br>
                    Vous recevez ce rapport car vous êtes administrateur du système.
                </p>
                <p style="margin: 10px 0 0 0; font-size: 12px; color: #999;">
                    TechHub - Système de gestion des stocks<br>
                    Généré le {{ now()->format('d/m/Y à H:i:s') }}
                </p>
            </div>
        </div>
    </div>
</body>
</html>
