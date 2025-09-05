<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Code de vérification</title>
    <style>
        /* Reset de base */
        body, html {
            margin: 0;
            padding: 0;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            line-height: 1.5;
            color: #1f2937;
            background-color: #f9fafb;
        }
        
        /* Conteneur principal */
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* En-tête */
        .header {
            text-align: center;
            padding: 20px 0;
            background-color: #4f46e5;
            color: white;
            border-radius: 8px 8px 0 0;
        }
        
        /* Corps de l'email */
        .content {
            background-color: white;
            padding: 30px;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        /* Code de vérification */
        .code-container {
            margin: 30px 0;
            text-align: center;
        }
        
        .verification-code {
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 2px;
            color: #4f46e5;
            background-color: #eef2ff;
            padding: 15px 25px;
            border-radius: 8px;
            display: inline-block;
        }
        
        /* Message informatif */
        .info {
            padding: 15px;
            background-color: #f3f4f6;
            border-left: 4px solid #9ca3af;
            margin: 20px 0;
            border-radius: 4px;
        }
        
        /* Pied de page */
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #6b7280;
        }
        
        /* Bouton */
        .btn {
            display: inline-block;
            background-color: #4f46e5;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            margin-top: 15px;
        }
        
        /* Responsive */
        @media (max-width: 600px) {
            .container {
                width: 100%;
                padding: 10px;
            }
            
            .content {
                padding: 20px;
            }
            
            .verification-code {
                font-size: 24px;
                padding: 12px 18px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Confirmation de votre inscription</h1>
        </div>
        <div class="content">
            <h2>Bonjour,</h2>
            <p>Merci de vous être inscrit sur notre plateforme. Pour finaliser votre inscription, veuillez utiliser le code de vérification ci-dessous :</p>
            
            <div class="code-container">
                <div class="verification-code">{{ $formattedCode }}</div>
            </div>
            
            <p>Ce code est valable pendant 30 minutes. Si vous n'avez pas demandé cette inscription, vous pouvez ignorer cet email.</p>
            
            <div class="info">
                <p><strong>Note :</strong> Ne partagez jamais ce code avec quiconque, y compris notre équipe. Nous ne vous demanderons jamais votre code par téléphone ou par email.</p>
            </div>
            
            <p>Si vous avez des questions ou besoin d'aide, n'hésitez pas à contacter notre équipe de support.</p>
            
            <p>Cordialement,<br>L'équipe de support</p>
        </div>
        <div class="footer">
            <p>Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
            <p>&copy; {{ date('Y') }} Votre Entreprise. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>