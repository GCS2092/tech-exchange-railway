<p>Bonjour {{ $user->name }},</p>
<p>Une nouvelle commande vous a été assignée.</p>
<p>Détails de la livraison :</p>
<ul>
    <li><strong>ID Commande :</strong> #{{ $order->id }}</li>
    <li><strong>Client :</strong> {{ $order->user->name ?? 'Client inconnu' }}</li>
    <li><strong>Adresse :</strong> {{ $order->delivery_address }}</li>
    <li><strong>Montant :</strong> {{ number_format($order->total_price, 2, ',', ' ') }} {{ $order->currency ?? '€' }}</li>
    <li><strong>Instructions :</strong> {{ $order->delivery_instructions ?? 'Aucune instruction spécifique' }}</li>
</ul>
<p>Merci de confirmer la réception de cette commande dans votre application.</p> 