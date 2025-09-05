@extends('emails.layouts.email')

@section('content')
<h2>✅ Votre commande a été confirmée !</h2>

<p>Bonjour <strong>{{ $order->user->name }}</strong>,</p>

<p>Nous sommes ravis de vous confirmer que votre commande a été reçue et est en cours de traitement. Voici tous les détails :</p>

<div class="order-summary">
    <h3>📋 Détails de votre commande</h3>
    
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
                @case('processing') En cours de traitement @break
                @case('completed') Terminée @break
                @case('cancelled') Annulée @break
                @default {{ ucfirst($order->status) }}
            @endswitch
        </span>
    </div>
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
            @if($product->brand)
            <div style="color: #999; font-size: 12px;">Marque : {{ $product->brand }}</div>
            @endif
        </div>
        <div class="product-price">
            {{ \App\Helpers\CurrencyHelper::formatXOF($product->pivot->price * $product->pivot->quantity) }}
        </div>
    </div>
    @endforeach
    
    <div class="summary-row total-row">
        <span class="summary-label">Total de votre commande :</span>
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
        <span class="summary-label">Instructions :</span>
        <span class="summary-value">{{ $order->delivery_instructions }}</span>
    </div>
    @endif
</div>

<div class="info-box">
    <h4>📞 Prochaines étapes</h4>
    <ol>
        <li><strong>Confirmation :</strong> Votre commande est en cours de préparation</li>
        <li><strong>Livraison :</strong> Un livreur vous contactera pour confirmer l'heure de livraison</li>
        <li><strong>Réception :</strong> Vérifiez vos produits à la réception et signez le bon de livraison</li>
    </ol>
</div>

<div style="text-align: center; margin: 30px 0;">
    <a href="{{ route('orders.show', $order->id) }}" class="btn">Suivre ma commande</a>
    <a href="{{ route('dashboard') }}" class="btn">Mon tableau de bord</a>
</div>

<div style="background-color: #f3e5f5; border-radius: 6px; padding: 15px; margin: 20px 0; border-left: 4px solid #9c27b0;">
    <h4 style="margin-top: 0; color: #7b1fa2;">💡 Besoin d'aide ?</h4>
    <p style="margin-bottom: 0;">
        Si vous avez des questions concernant votre commande, n'hésitez pas à nous contacter :<br>
        📧 <strong>support@techexchange.com</strong> | 📞 <strong>+33 1 23 45 67 89</strong>
    </p>
</div>

<p>Merci de votre confiance !</p>

<p>Cordialement,<br>
<strong>L'équipe TechExchange</strong></p>
@endsection 