<p>Bonjour {{ $order->livreur ? $order->livreur->name : 'Livreur inconnu' }},</p>
<p>Vous avez été assigné à la commande #{{ $order->id }}.</p>
<p>Voici les détails de la commande :</p>
<ul>
    <li><strong>Client :</strong> {{ $order->user->name ?? 'Client inconnu' }}</li>
    <li><strong>Adresse :</strong> {{ $order->delivery_address }}</li>
                    <li><strong>Montant :</strong> {{ number_format($order->total_price, 2, ',', ' ') }} FCFA</li>
</ul>
