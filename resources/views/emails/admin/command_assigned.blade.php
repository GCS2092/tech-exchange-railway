<p>Bonjour {{ $user->name }},</p>
<p>Une nouvelle commande a été assignée à un livreur.</p>
<p>Détails de la commande :</p>
<ul>
    <li><strong>ID Commande :</strong> #{{ $order->id }}</li>
    <li><strong>Livreur :</strong> {{ $order->livreur ? $order->livreur->name : 'Non assigné' }}</li>
    <li><strong>Client :</strong> {{ $order->user->name ?? 'Client inconnu' }}</li>
    <li><strong>Adresse :</strong> {{ $order->delivery_address }}</li>
    <li><strong>Montant :</strong> {{ number_format($order->total_price, 2, ',', ' ') }} {{ $order->currency ?? '€' }}</li>
    <li><strong>Statut :</strong> {{ $order->status }}</li>
</ul>
<p>Vous pouvez suivre cette commande dans le panneau d'administration.</p> 