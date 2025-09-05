# 🚀 Railway - Déploiement Rapide TechExchange

## ⚡ DÉMARRAGE RAPIDE (5 minutes)

### 1. **Préparer le code** ✅
```bash
# Vos fichiers sont déjà créés :
- Procfile ✅
- .htaccess ✅  
- railway.json ✅
- railway.env.example ✅
- deploy-railway.ps1 ✅
```

### 2. **Pousser sur GitHub**
```bash
git add .
git commit -m "Ready for Railway deployment"
git push origin main
```

### 3. **Créer le projet Railway**
1. Allez sur [railway.app](https://railway.app)
2. Login avec GitHub
3. "New Project" → "Deploy from GitHub repo"
4. Sélectionnez votre repo

### 4. **Ajouter PostgreSQL**
1. Dans votre projet → "New" → "Database" → "PostgreSQL"
2. Railway crée automatiquement la DB

### 5. **Configurer les variables d'environnement**
Dans Railway → Settings → Variables :

```env
# OBLIGATOIRE
APP_NAME=TechExchange
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:9wLahAWln+1u0Pt9ESq1/IrXY23RLltO2RQOBXzddMk=
APP_URL=https://votre-app.railway.app

# Base de données (Railway fournit automatiquement)
DB_CONNECTION=pgsql
DB_HOST=containers-us-west-xxx.railway.app
DB_PORT=5432
DB_DATABASE=railway
DB_USERNAME=postgres
DB_PASSWORD=votre_mot_de_passe_railway

# Google OAuth (à configurer)
GOOGLE_CLIENT_ID=votre_google_client_id
GOOGLE_CLIENT_SECRET=votre_google_client_secret
GOOGLE_REDIRECT_URI=https://votre-app.railway.app/auth/google/callback

# Flutterwave (à configurer)
FLUTTERWAVE_PUBLIC_KEY=votre_public_key
FLUTTERWAVE_SECRET_KEY=votre_secret_key

# PayPal (à configurer)
PAYPAL_MODE=sandbox
PAYPAL_CLIENT_ID=votre_paypal_client_id
PAYPAL_CLIENT_SECRET=votre_paypal_client_secret
```

### 6. **Exécuter les migrations**
Dans Railway → Console :
```bash
php artisan migrate --force
php artisan db:seed --class=CompleteDatabaseSeeder
```

## 🎯 **VOTRE APP SERA DISPONIBLE SUR :**
`https://votre-app.railway.app`

## 🔧 **Configuration Google OAuth**

1. [Google Cloud Console](https://console.cloud.google.com)
2. Créer un projet
3. Activer Google+ API
4. Créer OAuth 2.0 credentials
5. URI de redirection : `https://votre-app.railway.app/auth/google/callback`

## 💳 **Configuration Flutterwave**

1. [Flutterwave Dashboard](https://dashboard.flutterwave.com)
2. Obtenir les clés API
3. Ajouter dans Railway

## 🚨 **Dépannage**

- **Erreur 500** : Vérifiez APP_KEY et variables DB
- **Assets manquants** : Vérifiez que npm run build s'exécute
- **Base de données** : Vérifiez les credentials PostgreSQL

## 💰 **Coûts**
- **Gratuit** : 500h/mois (16h/jour)
- **Payant** : $5/mois illimité

## 📞 **Support**
- [Railway Docs](https://docs.railway.app)
- [Laravel on Railway](https://docs.railway.app/guides/laravel)
