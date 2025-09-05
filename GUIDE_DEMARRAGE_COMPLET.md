# 🚀 Guide de Démarrage Complet - TechExchange

## 📋 Prérequis

- Docker Desktop installé et en cours d'exécution
- Git installé
- Terminal PowerShell ou Command Prompt

## 🗄️ Réinitialisation Complète de la Base de Données

### Option 1 : Script Automatique (Recommandé)
```bash
# Exécuter le script de reset
reset_database.bat
```

### Option 2 : Commandes Manuelles
```bash
# 1. Nettoyer le cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# 2. Réinitialiser la base de données
php artisan migrate:reset --force

# 3. Exécuter les migrations
php artisan migrate --force

# 4. Exécuter le seeder complet
php artisan db:seed --class=CompleteDatabaseSeeder --force

# 5. Créer le lien symbolique storage
php artisan storage:link

# 6. Optimiser l'application
php artisan optimize
```

## 👥 Utilisateurs Créés

### 🔧 Administrateurs
- **Admin Principal** : `slovengama@gmail.com` / `admin123`
- **Admin Secondaire** : `stemk2151@gmail.com` / `admin123`

### 🏪 Vendeurs
- **Vendeur Tech** : `vendeur1@techexchange.com` / `vendor123`
- **Vendeur Electronique** : `vendeur2@techexchange.com` / `vendor123`

### 🚚 Livreurs
- **Livreur Express** : `livreur1@techexchange.com` / `delivery123`
- **Livreur Rapide** : `livreur2@techexchange.com` / `delivery123`

### 👤 Utilisateurs
- **Utilisateur Test** : `user1@techexchange.com` / `user123`
- **Utilisateur Demo** : `user2@techexchange.com` / `user123`

## 📱 Appareils Électroniques Créés

### Smartphones
1. **iPhone 14 Pro** - 899.99€ (Troc: 750€)
2. **Samsung Galaxy S23 Ultra** - 1199.99€ (Troc: 950€)
3. **Xiaomi 13 Ultra** - 999.99€ (Troc: 750€)

### Ordinateurs
4. **MacBook Pro 14" M2** - 1999.99€ (Troc: 1600€)
5. **Dell XPS 13 Plus** - 1499.99€ (Troc: 1100€)

### Tablettes
6. **iPad Pro 12.9" M2** - 1099.99€ (Troc: 850€)

### Accessoires
7. **Apple Watch Series 8** - 399.99€ (Troc: 300€)
8. **Sony WH-1000XM5** - 349.99€ (Troc: 250€)
9. **Nintendo Switch OLED** - 299.99€ (Troc: 200€)
10. **Canon EOS R6 Mark II** - 2499.99€ (Troc: 2000€)

## 🎯 Redirections des Dashboards

### ✅ Redirections Configurées
- **Admin** → `/admin/dashboard`
- **Vendeur** → `/vendeur/dashboard`
- **Livreur** → `/livreur/orders`
- **Utilisateur** → `/dashboard`

### 🔧 Middleware de Redirection
Le middleware `RedirectBasedOnRole` redirige automatiquement les utilisateurs vers leur dashboard approprié selon leur rôle.

## 🚀 Démarrage avec Docker

### 1. Démarrer les Services
```bash
docker-compose up -d
```

### 2. Vérifier les Containers
```bash
docker-compose ps
```

### 3. Accéder au Container
```bash
docker-compose exec app bash
```

### 4. Exécuter le Reset
```bash
# Dans le container
php artisan migrate:reset --force
php artisan migrate --force
php artisan db:seed --class=CompleteDatabaseSeeder --force
php artisan storage:link
php artisan optimize
```

## 🌐 Accès à l'Application

- **Application** : http://localhost
- **Base de données** : localhost:3306
- **Redis** : localhost:6379

## 🔍 Test des Fonctionnalités

### 1. Test de Connexion
- Connectez-vous avec chaque type d'utilisateur
- Vérifiez que la redirection vers le bon dashboard fonctionne

### 2. Test du Système de Troc
- Connectez-vous en tant qu'utilisateur
- Allez sur `/trades/search`
- Créez une offre de troc
- Testez l'acceptation/rejet d'offres

### 3. Test des Dashboards
- **Admin** : Vérifiez les statistiques et la gestion des utilisateurs
- **Vendeur** : Vérifiez la gestion des produits et commandes
- **Livreur** : Vérifiez la gestion des livraisons
- **Utilisateur** : Vérifiez les actions rapides et notifications

### 4. Test Upload d'Images
- Créez un nouveau produit
- Testez l'upload d'image depuis votre appareil

## 🛠️ Commandes Utiles

### Gestion des Containers
```bash
# Démarrer
docker-compose up -d

# Arrêter
docker-compose down

# Redémarrer
docker-compose restart

# Logs
docker-compose logs -f app
```

### Base de Données
```bash
# Accéder à MySQL
docker-compose exec db mysql -u root -p

# Reset complet
php artisan migrate:fresh --seed --class=CompleteDatabaseSeeder
```

### Cache et Optimisation
```bash
# Vider le cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Optimiser
php artisan optimize
```

## 🔧 Configuration des Permissions

### Rôles Créés
- **admin** : Toutes les permissions
- **vendor** : Gestion produits, commandes, trocs
- **delivery** : Gestion livraisons, rapports
- **user** : Dashboard, création offres de troc

### Permissions Principales
- `view_dashboard`
- `manage_products`
- `manage_users`
- `manage_orders`
- `manage_delivery`
- `manage_trades`
- `create_trade_offers`
- `accept_trade_offers`
- `reject_trade_offers`

## 📊 Statistiques Dashboard

### Dashboard Admin
- Nombre total d'utilisateurs
- Nombre total de produits
- Nombre total de commandes
- **Nombre total d'offres de troc** (nouveau)
- Actions rapides pour la gestion

### Dashboard Vendeur
- Produits en vente
- Commandes en cours
- Offres de troc reçues
- Statistiques de vente

### Dashboard Livreur
- Livraisons du jour
- Livraisons en cours
- Planning de livraison
- Historique des livraisons

### Dashboard Utilisateur
- Actions rapides pour appareils
- Notifications récentes
- Offres de troc
- Commandes en cours

## ✅ Vérification Finale

Après le démarrage, vérifiez que :

1. ✅ Tous les utilisateurs peuvent se connecter
2. ✅ Les redirections vers les dashboards fonctionnent
3. ✅ Le système de troc est opérationnel
4. ✅ Les uploads d'images fonctionnent
5. ✅ Les notifications sont envoyées
6. ✅ Les permissions sont respectées
7. ✅ L'interface est adaptée aux appareils électroniques

## 🎉 Félicitations !

Votre plateforme **TechExchange** est maintenant prête avec :
- ✅ Base de données complètement réinitialisée
- ✅ 8 utilisateurs avec rôles appropriés
- ✅ 10 appareils électroniques d'exemple
- ✅ Système de troc fonctionnel
- ✅ Redirections correctes vers les dashboards
- ✅ Upload d'images depuis appareil mobile
- ✅ Notifications automatiques

**Bonne utilisation de TechExchange !** 🚀 