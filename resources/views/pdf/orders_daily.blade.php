<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport des Commandes - {{ now()->format('d/m/Y') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @page {
            margin: 0;
            size: A4;
        }
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header {
            background-color: #4F46E5;
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .stat-card {
            background-color: white;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .table-container {
            margin-top: 20px;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #E5E7EB;
        }
        th {
            background-color: #F3F4F6;
            font-weight: 600;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }
        .status-en_attente { background-color: #FEF3C7; color: #92400E; }
        .status-en_cours { background-color: #DBEAFE; color: #1E40AF; }
        .status-livré { background-color: #D1FAE5; color: #065F46; }
        .status-annulé { background-color: #FEE2E2; color: #991B1B; }
        .chart-container {
            margin-top: 20px;
            padding: 15px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #E5E7EB;
            text-align: center;
            color: #6B7280;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="header">
        <h1 class="text-2xl font-bold">Rapport des Commandes</h1>
        <p class="text-sm opacity-90">Date: {{ now()->format('d/m/Y') }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="stat-card">
            <h3 class="text-lg font-semibold text-gray-700">Total des Commandes</h3>
            <p class="text-3xl font-bold text-indigo-600">{{ $totalOrders }}</p>
        </div>
        <div class="stat-card">
            <h3 class="text-lg font-semibold text-gray-700">Revenu Total</h3>
            <p class="text-3xl font-bold text-green-600">{{ number_format($totalRevenue, 2) }} FCFA</p>
        </div>
        <div class="stat-card">
            <h3 class="text-lg font-semibold text-gray-700">Valeur Moyenne</h3>
            <p class="text-3xl font-bold text-blue-600">{{ number_format($averageOrderValue, 2) }} FCFA</p>
        </div>
    </div>

    <div class="table-container">
        <h2 class="text-xl font-semibold mb-4">Détail des Commandes</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td class="font-medium">#{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ number_format($order->total_price, 2) }} FCFA</td>
                    <td>
                        <span class="status-badge status-{{ $order->status }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="chart-container">
        <h2 class="text-xl font-semibold mb-4">Statistiques par Statut</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($statusStats as $stat)
            <div class="stat-card">
                <h3 class="text-lg font-semibold text-gray-700">{{ ucfirst($stat['name']) }}</h3>
                <p class="text-2xl font-bold text-indigo-600">{{ $stat['count'] }}</p>
                <p class="text-sm text-gray-500">{{ number_format($stat['revenue'], 2) }} FCFA</p>
            </div>
            @endforeach
        </div>
    </div>

    <div class="footer">
        <p>Généré le {{ now()->format('d/m/Y H:i') }}</p>
        <p class="text-sm mt-2">© {{ date('Y') }} Votre Boutique de Cosmétiques</p>
    </div>
</body>
</html>
