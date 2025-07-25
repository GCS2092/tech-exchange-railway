<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture #{{ $order->id }}</title>
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
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #E5E7EB;
        }
        .company-info {
            flex: 1;
        }
        .invoice-info {
            text-align: right;
        }
        .client-info {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #F9FAFB;
            border-radius: 8px;
        }
        .table-container {
            margin: 20px 0;
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
        .total-section {
            margin-top: 20px;
            padding: 20px;
            background-color: #F9FAFB;
            border-radius: 8px;
        }
        .total-row {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 10px;
        }
        .total-label {
            width: 200px;
            text-align: right;
            padding-right: 20px;
        }
        .total-value {
            width: 150px;
            text-align: right;
            font-weight: 600;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #E5E7EB;
            text-align: center;
            color: #6B7280;
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
    </style>
</head>
<body class="bg-white">
    <div class="header">
        <div class="company-info">
            <h1 class="text-2xl font-bold text-indigo-600">Votre Boutique de Cosmétiques</h1>
            <p class="text-gray-600">BP: 1234, Ville</p>
            <p class="text-gray-600">Tel: +XXX XXX XXX XXX</p>
            <p class="text-gray-600">Email: contact@votreboutique.com</p>
        </div>
        <div class="invoice-info">
            <h2 class="text-xl font-bold text-gray-800">FACTURE</h2>
            <p class="text-gray-600">N° {{ $order->id }}</p>
            <p class="text-gray-600">Date: {{ $order->created_at->format('d/m/Y') }}</p>
            <span class="status-badge status-{{ $order->status }}">
                {{ ucfirst($order->status) }}
            </span>
        </div>
    </div>

    <div class="client-info">
        <h3 class="text-lg font-semibold mb-2">Client</h3>
        <p class="text-gray-700">{{ $order->user->name }}</p>
        <p class="text-gray-600">{{ $order->delivery_address }}</p>
        <p class="text-gray-600">Tel: {{ $order->phone_number }}</p>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix unitaire</th>
                    <th>Quantité</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ number_format($product->pivot->price, 2) }} FCFA</td>
                    <td>{{ $product->pivot->quantity }}</td>
                    <td>{{ number_format($product->pivot->price * $product->pivot->quantity, 2) }} FCFA</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="total-section">
        <div class="total-row">
            <div class="total-label">Sous-total:</div>
            <div class="total-value">{{ number_format($order->total_price, 2) }} FCFA</div>
        </div>
        @if($order->promo_code)
        <div class="total-row">
            <div class="total-label">Code promo ({{ $order->promo_code }}):</div>
            <div class="total-value">-{{ number_format($order->discount_amount, 2) }} FCFA</div>
        </div>
        @endif
        <div class="total-row">
            <div class="total-label">Total TTC:</div>
            <div class="total-value text-xl font-bold text-indigo-600">
                {{ number_format($order->total_price - ($order->discount_amount ?? 0), 2) }} FCFA
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Merci de votre confiance !</p>
        <p class="text-sm mt-2">© {{ date('Y') }} Votre Boutique de Cosmétiques - Tous droits réservés</p>
    </div>
</body>
</html> 