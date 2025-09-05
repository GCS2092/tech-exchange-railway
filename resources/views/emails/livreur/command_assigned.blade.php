@extends('emails.layouts.email')

@section('content')
<h2>🚚 Nouvelle commande assignée</h2>

<p>Bonjour <strong>{{ $user->name }}</strong>,</p>

<p>Une nouvelle commande vous a été assignée pour livraison. Voici tous les détails nécessaires :</p>

<div class="order-summary">
    <h3>📋 Détails de la commande</h3>
    
    <div class="summary-row">
        <span class="summary-label">Numéro de commande :</span>
        <span class="summary-value">#{{ $order->id }}</span>
    </div>
    
    <div class="summary-row">
        <span class="summary-label">Date de commande :</span>
        <span class="summary-value">{{ $order->created_at->format('d/m/Y à H:i') }}</span>
    </div>
    
    <div class="summary-row">
        <span class="summary-label">Statut :</span>
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
</div>

<div class="order-summary">
    <h3>📍 Adresse de livraison</h3>
    
    <div class="info-box">
        <strong>Adresse complète :</strong><br>
        {{ $order->delivery_address ?? 'Adresse non spécifiée' }}
    </div>
    
    @if($order->delivery_instructions)
    <div class="info-box">
        <strong>Instructions de livraison :</strong><br>
        {{ $order->delivery_instructions }}
    </div>
    @endif
</div>

<div class="order-summary">
    <h3>📦 Produits commandés</h3>
    
    @foreach($order->products as $product)
    <div class="product-item">
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image" onerror="this.src='{{ asset('images/default-device.jpg') }}'">
        <div class="product-details">
            <div class="product-name">{{ $product->name }}</div>
            <div style="color: #666; font-size: 14px;">
                Quantité : {{ $product->pivot->quantity }} | 
                Prix unitaire : {{ \App\Helpers\CurrencyHelper::formatXOF($product->pivot->price) }}
            </div>
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

<div class="info-box">
    <h4>⚠️ Actions requises</h4>
    <ol>
        <li>Confirmez la réception de cette commande dans votre application</li>
        <li>Contactez le client pour confirmer l'heure de livraison</li>
        <li>Mettez à jour le statut de la commande après la livraison</li>
    </ol>
</div>

<div style="text-align: center; margin: 30px 0;">
    <a href="{{ route('livreur.orders.index') }}" class="btn">Voir la commande</a>
    <a href="{{ route('livreur.planning') }}" class="btn">Voir mon planning</a>
</div>

<p style="margin-top: 30px; padding: 15px; background-color: #e3f2fd; border-radius: 6px; border-left: 4px solid #2196f3;">
    <strong>💡 Conseil :</strong> N'oubliez pas de vérifier l'état des produits avant la livraison et de demander une signature du client lors de la remise.
</p>

<p>Merci pour votre professionnalisme !</p>

<p>Cordialement,<br>
<strong>L'équipe TechExchange</strong></p>
@endsection 