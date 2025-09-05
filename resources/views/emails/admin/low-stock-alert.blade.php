<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Alerte Stock Faible</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 20px; }
        .content { background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .alert { background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .button { display: inline-block; background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
        .info { background: #e7f3ff; padding: 15px; border-radius: 5px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0; color: #dc3545;">🚨 Alerte Stock Faible</h1>
        </div>
        
        <div class="content">
            <div class="alert">
                <h2>Le stock du produit <strong>{{ $product->name }}</strong> est passé sous le seuil critique.</h2>
            </div>
            
            <div class="info">
                <h3>Détails du produit :</h3>
                <ul>
                    <li><strong>Nom :</strong> {{ $product->name }}</li>
                    <li><strong>Stock restant :</strong> <span style="color: #dc3545; font-weight: bold;">{{ $product->quantity }}</span></li>
                    <li><strong>Prix :</strong> {{ number_format($product->price, 0, ',', ' ') }} FCFA</li>
                    <li><strong>Catégorie :</strong> {{ $product->category->name ?? 'Non définie' }}</li>
                </ul>
            </div>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/admin/products/' . $product->id . '/edit') }}" class="button">
                    🔧 Gérer le produit
                </a>
            </div>
            
            <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin-top: 20px;">
                <p style="margin: 0; font-style: italic;">
                    Merci de réapprovisionner ce produit rapidement pour éviter la rupture de stock.
                </p>
            </div>
        </div>
    </div>
</body>
</html> 