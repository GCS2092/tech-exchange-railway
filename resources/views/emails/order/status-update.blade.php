<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Mise à jour de commande</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .container {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
            margin: 10px 0;
        }
        .status-en-attente { background: #fff3cd; color: #856404; }
        .status-payé { background: #d1ecf1; color: #0c5460; }
        .status-en-préparation { background: #d4edda; color: #155724; }
        .status-expédié { background: #cce5ff; color: #004085; }
        .status-en-livraison { background: #e2e3e5; color: #383d41; }
        .status-livré { background: #d4edda; color: #155724; }
        .status-annulé { background: #f8d7da; color: #721c24; }
        .status-retourné { background: #fff3cd; color: #856404; }
        .status-remboursé { background: #f8d7da; color: #721c24; }
        
        .order-details {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 5px;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #0056b3;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            color: #6c757d;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 Mise à jour de votre commande</h1>
            <p>Bonjour {{ $order->user->name ?? 'Client' }},</p>
            <p>Le statut de votre commande a été mis à jour.</p>
        </div>

        <div class="order-details">
            <h3>Commande #{{ $order->id }}</h3>
            <p><strong>Date de commande :</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Montant total :</strong> {{ number_format($order->total_price, 0, ',', ' ') }} FCFA</p>
            
            <div class="status-badge status-{{ str_replace(' ', '-', $newStatus) }}">
                Nouveau statut : {{ ucfirst($newStatus) }}
            </div>
        </div>

        @if($newStatus == 'en préparation')
        <div style="background: #e7f3ff; border-left: 4px solid #2196f3; padding: 15px; margin: 20px 0; border-radius: 5px;">
            <h4>📦 Votre commande est en cours de préparation</h4>
            <p>Nos équipes préparent actuellement votre commande avec soin. Vous recevrez une notification dès qu'elle sera expédiée.</p>
        </div>
        @endif

        @if($newStatus == 'expédié')
        <div style="background: #e8f5e8; border-left: 4px solid #4caf50; padding: 15px; margin: 20px 0; border-radius: 5px;">
            <h4>🚚 Votre commande a été expédiée</h4>
            <p>Votre commande est maintenant en route vers vous. Un livreur vous contactera bientôt pour organiser la livraison.</p>
        </div>
        @endif

        @if($newStatus == 'en livraison')
        <div style="background: #fff3e0; border-left: 4px solid #ff9800; padding: 15px; margin: 20px 0; border-radius: 5px;">
            <h4>🚛 Votre commande est en livraison</h4>
            <p>Un livreur se dirige vers votre adresse. Assurez-vous d'être disponible pour la réception.</p>
        </div>
        @endif

        @if($newStatus == 'livré')
        <div style="background: #e8f5e8; border-left: 4px solid #4caf50; padding: 15px; margin: 20px 0; border-radius: 5px;">
            <h4>✅ Votre commande a été livrée</h4>
            <p>Votre commande a été livrée avec succès ! Nous espérons que vous êtes satisfait de votre achat.</p>
        </div>
        @endif

        @if($newStatus == 'annulé')
        <div style="background: #ffebee; border-left: 4px solid #f44336; padding: 15px; margin: 20px 0; border-radius: 5px;">
            <h4>❌ Votre commande a été annulée</h4>
            <p>Votre commande a été annulée. Si vous avez des questions, n'hésitez pas à nous contacter.</p>
        </div>
        @endif

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('orders.show', $order) }}" class="btn">Voir les détails de ma commande</a>
            <a href="{{ route('home') }}" class="btn" style="background: #6c757d;">Retourner au site</a>
        </div>

        <div class="footer">
            <p>Ce message a été envoyé automatiquement par {{ config('app.name') }}.</p>
            <p>Pour toute question, contactez notre service client.</p>
        </div>
    </div>
</body>
</html>
