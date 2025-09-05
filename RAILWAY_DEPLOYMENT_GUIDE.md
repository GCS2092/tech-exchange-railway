# 🚀 Guide de Déploiement Railway - TechExchange

## 📋 Prérequis

1. **Compte GitHub** avec votre code
2. **Compte Railway** (gratuit)
3. **Compte Google Cloud** (pour OAuth)
4. **Compte Flutterwave** (pour les paiements)
5. **Compte PayPal** (pour les paiements)

## 🔧 ÉTAPE 1 : Préparation du Code

### 1.1 Pousser le code sur GitHub
```bash
# Initialiser Git si pas déjà fait
git init
git add .
git commit -m "Initial commit - TechExchange ready for Railway"

# Ajouter votre repo GitHub
git remote add origin https://github.com/votre-username/tech-exchange.git
git push -u origin main
```

### 1.2 Vérifier les fichiers créés
- ✅ `Procfile` - Configuration du serveur web
- ✅ `.htaccess` - Règles Apache
- ✅ `railway.json` - Configuration Railway
- ✅ `railway.env.example` - Variables d'environnement

## 🌐 ÉTAPE 2 : Configuration Railway

### 2.1 Créer un compte Railway
1. Allez sur [railway.app](https://railway.app)
2. Cliquez sur "Login" → "Login with GitHub"
3. Autorisez Railway à accéder à vos repos

### 2.2 Créer un nouveau projet
1. Cliquez sur "New Project"
2. Sélectionnez "Deploy from GitHub repo"
3. Choisissez votre repo `tech-exchange`
4. Railway va automatiquement détecter que c'est un projet Laravel

### 2.3 Ajouter une base de données PostgreSQL
1. Dans votre projet Railway, cliquez sur "New"
2. Sélectionnez "Database" → "PostgreSQL"
3. Railway va créer automatiquement une base de données
4. Notez les informations de connexion (host, port, database, username, password)

## ⚙️ ÉTAPE 3 : Configuration des Variables d'Environnement

### 3.1 Variables de base
Dans Railway → Settings → Variables, ajoutez :

```env
APP_NAME=TechExchange
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-app.railway.app

# Base de données (Railway fournit automatiquement)
DB_CONNECTION=pgsql
DB_HOST=containers-us-west-xxx.railway.app
DB_PORT=5432
DB_DATABASE=railway
DB_USERNAME=postgres
DB_PASSWORD=votre_mot_de_passe_railway
```

### 3.2 Générer la clé d'application
```bash
# En local
php artisan key:generate --show
# Copiez la clé générée et ajoutez-la comme APP_KEY dans Railway
```

### 3.3 Configuration Google OAuth
1. Allez sur [Google Cloud Console](https://console.cloud.google.com)
2. Créez un nouveau projet ou sélectionnez un existant
3. Activez l'API Google+ et Google OAuth2
4. Créez des identifiants OAuth 2.0
5. Ajoutez l'URI de redirection : `https://votre-app.railway.app/auth/google/callback`

Variables à ajouter dans Railway :
```env
GOOGLE_CLIENT_ID=votre_google_client_id
GOOGLE_CLIENT_SECRET=votre_google_client_secret
GOOGLE_REDIRECT_URI=https://votre-app.railway.app/auth/google/callback
```

### 3.4 Configuration Flutterwave
1. Créez un compte sur [Flutterwave](https://flutterwave.com)
2. Obtenez vos clés API
3. Ajoutez dans Railway :
```env
FLUTTERWAVE_PUBLIC_KEY=votre_public_key
FLUTTERWAVE_SECRET_KEY=votre_secret_key
FLUTTERWAVE_ENCRYPTION_KEY=votre_encryption_key
```

### 3.5 Configuration PayPal
1. Créez un compte développeur PayPal
2. Obtenez vos clés API
3. Ajoutez dans Railway :
```env
PAYPAL_MODE=sandbox
PAYPAL_CLIENT_ID=votre_paypal_client_id
PAYPAL_CLIENT_SECRET=votre_paypal_client_secret
```

### 3.6 Configuration Email
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre-email@gmail.com
MAIL_PASSWORD=votre_mot_de_passe_app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@techexchange.com
MAIL_FROM_NAME="TechExchange"
```

## 🚀 ÉTAPE 4 : Déploiement

### 4.1 Déploiement automatique
1. Railway va automatiquement détecter votre projet Laravel
2. Il va installer les dépendances PHP et Node.js
3. Il va construire vos assets
4. Il va démarrer votre application

### 4.2 Exécuter les migrations
1. Allez dans Railway → Deployments
2. Cliquez sur votre déploiement
3. Ouvrez la console
4. Exécutez :
```bash
php artisan migrate --force
php artisan db:seed
```

### 4.3 Vérifier le déploiement
1. Votre app sera disponible sur `https://votre-app.railway.app`
2. Testez toutes les fonctionnalités :
   - Inscription/Connexion
   - Navigation
   - Système d'échange
   - Paiements (en mode sandbox)

## 🔧 ÉTAPE 5 : Optimisations Post-Déploiement

### 5.1 Configuration du cache
```bash
# Dans la console Railway
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 5.2 Configuration des permissions
```bash
# Créer les rôles et permissions
php artisan db:seed --class=CompleteDatabaseSeeder
```

### 5.3 Test des fonctionnalités
- ✅ Page d'accueil
- ✅ Inscription/Connexion
- ✅ Connexion Google
- ✅ Système d'échange
- ✅ Paiements Flutterwave
- ✅ Paiements PayPal
- ✅ Notifications

## 📊 ÉTAPE 6 : Monitoring et Maintenance

### 6.1 Logs
- Consultez les logs dans Railway → Deployments → Logs
- Surveillez les erreurs et performances

### 6.2 Base de données
- Railway fournit un dashboard pour PostgreSQL
- Surveillez l'utilisation de l'espace disque

### 6.3 Mises à jour
- Poussez vos modifications sur GitHub
- Railway redéploiera automatiquement

## 🚨 Dépannage

### Problèmes courants :

1. **Erreur 500** : Vérifiez les variables d'environnement
2. **Base de données** : Vérifiez les credentials PostgreSQL
3. **Assets manquants** : Vérifiez que `npm run build` s'exécute
4. **Permissions** : Exécutez `php artisan migrate --force`

### Commandes utiles :
```bash
# Voir les logs
railway logs

# Accéder à la console
railway shell

# Redémarrer l'application
railway restart
```

## 💰 Coûts

- **Gratuit** : 500h/mois (environ 16h/jour)
- **Payant** : $5/mois pour usage illimité
- **Base de données** : Incluse dans le plan

## 🎉 Félicitations !

Votre application TechExchange est maintenant en ligne sur Railway !

**URL de votre app** : `https://votre-app.railway.app`

N'oubliez pas de :
- Tester toutes les fonctionnalités
- Configurer un nom de domaine personnalisé (optionnel)
- Mettre en place des backups
- Surveiller les performances
