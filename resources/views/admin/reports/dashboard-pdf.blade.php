<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport Dashboard - {{ date('d/m/Y') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #2563eb;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .section {
            margin-bottom: 25px;
        }
        .section h2 {
            color: #1f2937;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
            margin-bottom: 15px;
            font-size: 16px;
        }
        .stats-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }
        .stats-row {
            display: table-row;
        }
        .stats-cell {
            display: table-cell;
            padding: 8px;
            border: 1px solid #e5e7eb;
            text-align: center;
            width: 25%;
        }
        .stats-cell.header {
            background-color: #f3f4f6;
            font-weight: bold;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #e5e7eb;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f3f4f6;
            font-weight: bold;
        }
        .highlight {
            background-color: #fef3c7;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>TechExchange - Rapport Dashboard</h1>
        <p>Généré le {{ date('d/m/Y à H:i') }}</p>
        <p>Vue d'ensemble complète de la plateforme</p>
    </div>

    <div class="section">
        <h2>Statistiques Générales</h2>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stats-cell header">Métrique</div>
                <div class="stats-cell header">Valeur</div>
                <div class="stats-cell header">Métrique</div>
                <div class="stats-cell header">Valeur</div>
            </div>
            <div class="stats-row">
                <div class="stats-cell">Utilisateurs totaux</div>
                <div class="stats-cell highlight">{{ number_format($stats['total_users']) }}</div>
                <div class="stats-cell">Produits totaux</div>
                <div class="stats-cell highlight">{{ number_format($stats['total_products']) }}</div>
            </div>
            <div class="stats-row">
                <div class="stats-cell">Commandes totales</div>
                <div class="stats-cell highlight">{{ number_format($stats['total_orders']) }}</div>
                <div class="stats-cell">Troc totaux</div>
                <div class="stats-cell highlight">{{ number_format($stats['total_trades']) }}</div>
            </div>
            <div class="stats-row">
                <div class="stats-cell">Revenus totaux</div>
                <div class="stats-cell highlight">{{ number_format($stats['revenue']['total_revenue'] ?? 0, 0, ',', ' ') }} FCFA</div>
                <div class="stats-cell">-</div>
                <div class="stats-cell">-</div>
            </div>
        </div>
    </div>

    <div class="section">
        <h2>Statistiques du Mois en Cours</h2>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stats-cell header">Métrique</div>
                <div class="stats-cell header">Valeur</div>
                <div class="stats-cell header">Métrique</div>
                <div class="stats-cell header">Valeur</div>
            </div>
            <div class="stats-row">
                <div class="stats-cell">Nouveaux utilisateurs</div>
                <div class="stats-cell highlight">{{ $monthlyStats['new_users'] }}</div>
                <div class="stats-cell">Nouvelles commandes</div>
                <div class="stats-cell highlight">{{ $monthlyStats['new_orders'] }}</div>
            </div>
            <div class="stats-row">
                <div class="stats-cell">Commandes complétées</div>
                <div class="stats-cell highlight">{{ $monthlyStats['completed_orders'] }}</div>
                <div class="stats-cell">Nouveaux trocs</div>
                <div class="stats-cell highlight">{{ $monthlyStats['new_trades'] }}</div>
            </div>
            <div class="stats-row">
                <div class="stats-cell">Revenus du mois</div>
                <div class="stats-cell highlight">{{ number_format($monthlyStats['monthly_revenue'], 0, ',', ' ') }} FCFA</div>
                <div class="stats-cell">Troc acceptés</div>
                <div class="stats-cell highlight">{{ $monthlyStats['accepted_trades'] ?? 0 }}</div>
            </div>
        </div>
    </div>

    <div class="section">
        <h2>Analyse des Performances</h2>
        <p><strong>Taux de conversion des commandes :</strong> 
            @if($monthlyStats['new_orders'] > 0 && $monthlyStats['completed_orders'] > 0)
                {{ number_format(($monthlyStats['completed_orders'] / $monthlyStats['new_orders']) * 100, 1) }}%
            @else
                0%
            @endif
        </p>
        <p><strong>Revenu moyen par commande :</strong> 
            @if($monthlyStats['completed_orders'] > 0)
                {{ number_format($monthlyStats['monthly_revenue'] / $monthlyStats['completed_orders'], 0, ',', ' ') }} FCFA
            @else
                0 FCFA
            @endif
        </p>
        <p><strong>Taux d'acceptation des trocs :</strong> 
            @if($monthlyStats['new_trades'] > 0 && isset($monthlyStats['accepted_trades']))
                {{ number_format(($monthlyStats['accepted_trades'] / $monthlyStats['new_trades']) * 100, 1) }}%
            @else
                0%
            @endif
        </p>
    </div>

    <div class="section">
        <h2>Recommandations</h2>
        <ul>
            @if($monthlyStats['new_users'] < 10)
                <li>Augmenter les efforts de marketing pour attirer plus d'utilisateurs</li>
            @endif
            @if($monthlyStats['completed_orders'] < $monthlyStats['new_orders'] * 0.7)
                <li>Améliorer le processus de conversion des commandes</li>
            @endif
            @if($monthlyStats['monthly_revenue'] < 1000000)
                <li>Développer des stratégies pour augmenter les revenus</li>
            @endif
            @if($monthlyStats['new_trades'] < 5)
                <li>Promouvoir davantage le système de troc</li>
            @endif
        </ul>
    </div>

    <div class="footer">
        <p>Ce rapport a été généré automatiquement par TechExchange</p>
        <p>Pour plus d'informations, contactez l'équipe d'administration</p>
    </div>
</body>
</html> 