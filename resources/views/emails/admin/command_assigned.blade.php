@extends('emails.layouts.email')

@section('content')
<h2>📊 Nouvelle commande assignée à un livreur</h2>

<p>Bonjour <strong>{{ $user->name }}</strong>,</p>

<p>Une nouvelle commande a été assignée à un livreur. Voici un résumé complet de la situation :</p>

<div class="order-summary">
    <h3>📋 Informations de la commande</h3>
    
    <div class="summary-row">
        <span class="summary-label">Numéro de commande :</span>
        <span class="summary-value">#{{ $order->id }}</span>
    </div>
    
    <div class="summary-row">
        <span class="summary-label">Date de commande :</span>
        <span class="summary-value">{{ $order->created_at->format('d/m/Y à H:i') }}</span>
    </div>
    
    <div class="summary-row">
        <span class="summary-label">Statut actuel :</span>
        <span class="status-badge status-{{ $order->status }}">
            @switch($order->status)
                @case('pending') En attente @break
                @case('processing') En cours @break
                @case('completed') Terminée @break
                @case('cancelled') Annulée @break
                @default {{ ucfirst($order->status) }}
            @endswitch
        </span>
    </div>
    
    <div class="summary-row">
        <span class="summary-label">Livreur assigné :</span>
        <span class="summary-value">{{ $order->livreur->name ?? 'Non assigné' }}</span>
    </div>
</div>

<div class="order-summary">
    <h3>👤 Informations client</h3>
    
    <div class="summary-row">
        <span class="summary-label">Nom du client :</span>
        <span class="summary-value">{{ $order->user->name ?? 'Client inconnu' }}</span>
    </div>
    
    <div class="summary-row">
        <span class="summary-label">Email :</span>
        <span class="summary-value">{{ $order->user->email ?? 'Non disponible' }}</span>
    </div>
    
    <div class="summary-row">
        <span class="summary-label">Téléphone :</span>
        <span class="summary-value">{{ $order->user->phone ?? 'Non disponible' }}</span>
    </div>
    
    <div class="summary-row">
        <span class="summary-label">Client depuis :</span>
        <span class="summary-value">{{ $order->user->created_at->format('d/m/Y') ?? 'Non disponible' }}</span>
    </div>
</div>

<div class="order-summary">
    <h3>📦 Détail des produits</h3>
    
    @foreach($order->products as $product)
    <div class="product-item">
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image" onerror="this.src='{{ asset('images/default-device.jpg') }}'">
        <div class="product-details">
            <div class="product-name">{{ $product->name }}</div>
            <div style="color: #666; font-size: 14px;">
                Quantité : {{ $product->pivot->quantity }} | 
                Prix unitaire : {{ \App\Helpers\CurrencyHelper::formatXOF($product->pivot->price) }}
            </div>
            @if($product->brand)
            <div style="color: #999; font-size: 12px;">Marque : {{ $product->brand }}</div>
            @endif
            @if($product->seller)
            <div style="color: #999; font-size: 12px;">Vendeur : {{ $product->seller->name }}</div>
            @endif
        </div>
        <div class="product-price">
            {{ \App\Helpers\CurrencyHelper::formatXOF($product->pivot->price * $product->pivot->quantity) }}
        </div>
    </div>
    @endforeach
    
    <div class="summary-row total-row">
        <span class="summary-label">Total de la commande :</span>
        <span class="summary-value total-value">{{ \App\Helpers\CurrencyHelper::formatXOF($order->total_price) }}</span>
    </div>
</div>

<div class="order-summary">
    <h3>📍 Informations de livraison</h3>
    
    <div class="summary-row">
        <span class="summary-label">Adresse de livraison :</span>
        <span class="summary-value">{{ $order->delivery_address ?? 'Non spécifiée' }}</span>
    </div>
    
    @if($order->delivery_instructions)
    <div class="summary-row">
        <span class="summary-label">Instructions spéciales :</span>
        <span class="summary-value">{{ $order->delivery_instructions }}</span>
    </div>
    @endif
    
    @if($order->livreur)
    <div class="summary-row">
        <span class="summary-label">Livreur responsable :</span>
        <span class="summary-value">{{ $order->livreur->name }} ({{ $order->livreur->email }})</span>
    </div>
    @endif
</div>

<div class="info-box">
    <h4>📈 Métriques importantes</h4>
    <ul>
        <li><strong>Valeur de la commande :</strong> {{ \App\Helpers\CurrencyHelper::formatXOF($order->total_price) }}</li>
        <li><strong>Nombre de produits :</strong> {{ $order->products->count() }}</li>
        <li><strong>Quantité totale :</strong> {{ $order->products->sum('pivot.quantity') }} articles</li>
        @if($order->user)
        <li><strong>Historique client :</strong> {{ $order->user->orders->count() }} commandes précédentes</li>
        @endif
    </ul>
</div>

<div style="text-align: center; margin: 30px 0;">
    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn">Voir la commande</a>
    <a href="{{ route('admin.dashboard') }}" class="btn">Tableau de bord</a>
</div>

<div style="background-color: #fff3e0; border-radius: 6px; padding: 15px; margin: 20px 0; border-left: 4px solid #ff9800;">
    <h4 style="margin-top: 0; color: #e65100;">⚠️ Actions recommandées</h4>
    <ul style="margin-bottom: 0;">
        <li>Surveillez le statut de la livraison</li>
        <li>Vérifiez la satisfaction client après livraison</li>
        <li>Assurez-vous que le livreur met à jour le statut</li>
    </ul>
</div>

<p>Cette commande est maintenant en cours de traitement.</p>

<p>Cordialement,<br>
<strong>Système TechExchange</strong></p>
@endsection 