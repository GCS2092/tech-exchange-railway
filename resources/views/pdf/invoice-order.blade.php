<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture #{{ $order->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; padding: 40px; }
        h1 { color: #4f46e5; }
        .header, .footer { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .footer { font-size: 10px; color: #777; border-top: 1px solid #ccc; padding-top: 10px; margin-top: 40px; }
        .section { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border-bottom: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f4f4f4; }
        tfoot td { font-weight: bold; }
        .qr-code { position: absolute; bottom: 40px; right: 40px; text-align: center; }
        .qr-code img { width: 80px; height: 80px; }
        .badge { display: inline-block; padding: 5px 10px; font-size: 10px; border-radius: 10px; color: #fff; }
        .badge-success { background: #16a34a; }
        .badge-pending { background: #f59e0b; }
    </style>
</head>
<body>

    <div class="header">
        <div>
            <h1>Facture</h1>
            <p>N° {{ $order->invoice_number ?? ('INV-'.str_pad($order->id, 6, '0', STR_PAD_LEFT)) }}</p>
            <p>Date : {{ $order->created_at->format('d/m/Y') }}</p>
        </div>
        <div>
            <strong>{{ config('app.name', 'Entreprise') }}</strong><br>
            contact@votreentreprise.com<br>
            +237 6XX XXX XXX
        </div>
    </div>

    <div class="section">
        <strong>Client :</strong><br>
        {{ $user->name ?? 'N/A' }}<br>
        {{ $user->email ?? '' }}<br>
        {{ $order->phone_number ?? $user->phone ?? '—' }}
    </div>

    <div class="section">
        <strong>Statut :</strong>
        <span class="badge {{ $order->status === 'completed' ? 'badge-success' : 'badge-pending' }}">
            {{ ucfirst($order->status) }}
        </span><br>
        <strong>Méthode de paiement :</strong> {{ ucfirst($order->payment_method ?? 'Non spécifiée') }}
    </div>

    <div class="section">
        <strong>Adresse de livraison :</strong><br>
        {{ $order->delivery_address ?? 'Non spécifiée' }}<br>

        @if($order->latitude && $order->longitude)
        <small>
            Coordonnées : {{ $order->latitude }}, {{ $order->longitude }}<br>
            <a href="https://www.openstreetmap.org/?mlat={{ $order->latitude }}&mlon={{ $order->longitude }}&zoom=16" target="_blank" style="color: #1d4ed8; text-decoration: underline;">
                📍 Voir sur OpenStreetMap
            </a>
        </small>
    @endif
    </div>

    <div class="section">
        <strong>Détails de la commande :</strong>
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix unitaire</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td>{{ number_format($product->pivot->price ?? $product->price, 0, ',', ' ') }} FCFA</td>
                        <td>{{ number_format(($product->pivot->price ?? $product->price) * $product->pivot->quantity, 0, ',', ' ') }} FCFA</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">Montant total</td>
                    <td>{{ number_format($order->getTotalCalculated(), 0, ',', ' ') }} FCFA</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="footer">
        <div>
            {{ config('app.name', 'Votre entreprise') }} | RCCM: AB-XXX-XXX | NIU: PXXXXXXXXX
        </div>
        <div>
            contact@votreentreprise.com | +237 6XX XXX XXX
        </div>
    </div>

    <div class="qr-code">
        @inject('barcode', 'Milon\Barcode\DNS2D')
        <img src="data:image/png;base64,{{ $barcode->getBarcodePNG(route('invoices.verify', ['id' => $order->id, 'token' => md5($order->id.$order->created_at)]), 'QRCODE') }}" alt="QR Code">
        <p style="font-size: 9px;">Vérifier la facture</p>
    </div>

</body>
</html>
