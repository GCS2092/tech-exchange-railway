# Documentation du Projet E-commerce de Cosmétiques

## Table des matières
1. [Introduction](#introduction)
2. [Architecture du Projet](#architecture)
3. [Fonctionnalités](#fonctionnalités)
4. [Installation et Configuration](#installation)
5. [Structure des Dossiers](#structure)
6. [Base de Données](#base-de-données)
7. [Sécurité](#sécurité)
8. [API](#api)
9. [Déploiement](#déploiement)
10. [Maintenance](#maintenance)

## Introduction <a name="introduction"></a>

### Présentation du Projet
Ce projet est une plateforme e-commerce spécialisée dans la vente de produits cosmétiques. Il a été développé avec Laravel 11 et utilise une architecture moderne basée sur les meilleures pratiques de développement web.

### Objectifs
- Fournir une expérience d'achat en ligne fluide et sécurisée
- Gérer efficacement le catalogue de produits cosmétiques
- Offrir un système de gestion des commandes robuste
- Implémenter un système de livraison fiable
- Assurer une gestion administrative complète

## Architecture du Projet <a name="architecture"></a>

### Technologies Utilisées
- **Backend**: Laravel 11
- **Frontend**: 
  - Blade Templates
  - Tailwind CSS
  - JavaScript (Vanilla)
- **Base de données**: MySQL
- **Système d'authentification**: Laravel Sanctum
- **Gestion des paiements**: Intégration avec les principales plateformes de paiement

### Architecture Technique
- Architecture MVC (Model-View-Controller)
- API RESTful pour les services externes
- Système d'événements pour les notifications
- Gestion des rôles et permissions
- Système de cache pour les performances

## Fonctionnalités <a name="fonctionnalités"></a>

### 1. Gestion des Utilisateurs
- Inscription multi-étapes avec vérification par email
- Connexion sécurisée
- Profil utilisateur personnalisable
- Gestion des rôles (Admin, Client, Livreur)
- Système de réinitialisation de mot de passe

### 2. Catalogue de Produits
- Affichage des produits par catégories
- Filtrage et recherche avancée
- Gestion des stocks
- Système de favoris
- Évaluations et commentaires

### 3. Panier et Commandes
- Panier persistant
- Application de codes promo
- Calcul des frais de livraison
- Suivi des commandes en temps réel
- Historique des commandes

### 4. Système de Livraison
- Attribution automatique des livreurs
- Suivi en temps réel des livraisons
- Système de notation des livreurs
- Gestion des retours

### 5. Administration
- Dashboard complet
- Gestion des utilisateurs
- Gestion des produits
- Gestion des commandes
- Statistiques et rapports
- Génération de factures PDF

### 6. Fonctionnalités Avancées
- Système de fidélité
- Notifications en temps réel
- Support multilingue
- Gestion des devises
- Système de messagerie interne

## Installation et Configuration <a name="installation"></a>

### Prérequis
- PHP 8.3 ou supérieur
- Composer
- MySQL 5.7 ou supérieur
- Node.js et NPM
- Serveur web (Apache/Nginx)

### Étapes d'Installation
1. Cloner le projet
```bash
git clone [url-du-projet]
```

2. Installer les dépendances
```bash
composer install
npm install
```

3. Configurer l'environnement
```bash
cp .env.example .env
php artisan key:generate
```

4. Configurer la base de données
```bash
php artisan migrate
php artisan db:seed
```

5. Compiler les assets
```bash
npm run dev
```

6. Démarrer le serveur
```bash
php artisan serve
```

## Structure des Dossiers <a name="structure"></a>

```
mon-site-cosmetique/
├── app/
│   ├── Console/
│   ├── Events/
│   ├── Exceptions/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   ├── API/
│   │   │   └── Auth/
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/
│   ├── Notifications/
│   └── Services/
├── bootstrap/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   ├── js/
│   ├── lang/
│   └── views/
│       ├── admin/
│       ├── auth/
│       ├── components/
│       └── layouts/
├── routes/
├── storage/
└── tests/
```

## Base de Données <a name="base-de-données"></a>

### Tables Principales
- users
- products
- categories
- orders
- order_items
- payments
- deliveries
- reviews
- notifications
- promotions

### Relations
- Un utilisateur peut avoir plusieurs commandes
- Une commande contient plusieurs produits
- Un produit appartient à une catégorie
- Un livreur peut avoir plusieurs livraisons

## Sécurité <a name="sécurité"></a>

### Mesures de Sécurité Implémentées
- Authentification à deux facteurs
- Protection CSRF
- Validation des entrées
- Sanitization des données
- Protection contre les injections SQL
- Gestion sécurisée des mots de passe
- Limitation des tentatives de connexion

### Bonnes Pratiques
- Utilisation de HTTPS
- Stockage sécurisé des informations sensibles
- Journalisation des activités
- Sauvegardes régulières
- Mises à jour de sécurité

## API <a name="api"></a>

### Endpoints Principaux
- `/api/products` - Gestion des produits
- `/api/orders` - Gestion des commandes
- `/api/users` - Gestion des utilisateurs
- `/api/auth` - Authentification
- `/api/deliveries` - Suivi des livraisons

### Documentation API
La documentation complète de l'API est disponible via Swagger UI à l'adresse `/api/documentation`

## Déploiement <a name="déploiement"></a>

### Environnements
- Développement (local)
- Staging
- Production

### Procédure de Déploiement
1. Mise à jour du code
2. Installation des dépendances
3. Migration de la base de données
4. Compilation des assets
5. Mise en cache des configurations
6. Vérification des permissions
7. Tests de sécurité

## Maintenance <a name="maintenance"></a>

### Tâches Régulières
- Sauvegarde de la base de données
- Nettoyage des fichiers temporaires
- Mise à jour des dépendances
- Vérification des logs
- Optimisation des performances

### Monitoring
- Surveillance des performances
- Alertes en cas d'erreurs
- Suivi des utilisateurs
- Analyse des logs
- Rapports de sécurité

## Support et Contact

Pour toute question ou assistance :
- Email : support@monsitecosmetique.com
- Documentation technique : docs.monsitecosmetique.com
- Support technique : 24/7

## Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails. 

# Documentation - Gestion des rôles, permissions et améliorations gratuites

## Gestion des rôles et permissions

Le site utilise le package Spatie Laravel Permission pour une gestion avancée des rôles et permissions. Les rôles principaux sont :
- **super_admin** : Accès total à toutes les fonctionnalités, y compris la gestion des rôles et permissions.
- **admin** : Gestion globale des utilisateurs, produits, commandes, transactions, etc.
- **manager** : Gestion d'équipe, rapports, support client.
- **supervisor** : Supervision opérationnelle.
- **vendeur** : Peut ajouter/éditer/supprimer ses produits, gérer son stock, voir ses commandes et ses clients/abonnés.
- **livreur** : Gestion des livraisons qui lui sont assignées.
- **support** : Gestion du support client, tickets, avis.
- **client** : Utilisateur final, peut commander et laisser des avis.

### Attribution des rôles
- Les rôles sont attribuables depuis l'interface d'administration (édition utilisateur).
- Les permissions sont attribuées automatiquement selon le rôle, mais peuvent être personnalisées.

### Commande artisan de rapport
Pour vérifier à tout moment l'état des rôles et permissions, utiliser :

```bash
php artisan roles:report
```

Cette commande affiche :
- Tous les rôles existants et leur nombre de permissions
- Toutes les permissions existantes
- Les permissions orphelines (non attribuées à un rôle)
- Les rôles recommandés manquants

---

## Améliorations gratuites réalisées

- **Unification et nettoyage du système de rôles** (Spatie Permission)
- **Ajout du rôle vendeur** avec toutes les permissions nécessaires :
  - Ajout/édition/suppression de ses produits
  - Gestion de son stock
  - Accès à ses commandes et clients/abonnés
- **Séparation claire des accès** entre super_admin, admin, vendeur, livreur, support, client
- **Gestion avancée des permissions** (création, édition, suppression, gestion des stocks, commandes, etc.)
- **Vues d'administration améliorées** :
  - Dashboard admin avec bouton Transactions et statistiques
  - Gestion des utilisateurs avec attribution de rôles et permissions
  - Gestion des rôles et permissions (création, édition, suppression)
- **Seeder unifié** pour initialiser tous les rôles et permissions recommandés
- **Commande artisan de rapport** pour audit rapide
- **Aucune permission orpheline**
- **Architecture évolutive** pour marketplace ou mono-boutique

---

## Rôles et fonctionnalités principales

### 1. **Admin**
- Gestion complète du site (utilisateurs, produits, commandes, transactions, stocks, rôles, permissions)
- Dashboard avancé avec statistiques, histogrammes, exports, notifications
- Attribution et gestion des rôles (admin, vendeur, livreur, etc.)

### 2. **Vendeur**
- Dashboard vendeur moderne et responsive :
    - Statistiques de ventes, produits, commandes
    - Liste de ses produits (CRUD complet)
    - Commandes récentes liées à ses produits
    - Notifications (nouvelles commandes, changements de statut)
- Ne voit que ses propres produits et commandes
- Reçoit un mail de bienvenue à la création de son compte

### 3. **Client**
- Navigation catalogue, panier, commandes, paiement
- Suivi de ses commandes et notifications

### 4. **Livreur**
- Accès à ses livraisons, planning, notifications
- Peut marquer les commandes comme livrées

---

## Logique des permissions et sécurité
- Système unifié basé sur Spatie Permission
- Granularité des accès selon le rôle
- Sécurisation des routes (middleware)
- Attribution automatique du rôle à la création (admin, vendeur, etc.)

---

## Fonctionnalités e-commerce avancées
- Gestion des statuts de commande et transaction synchronisés
- Stock avancé, notifications de seuil bas
- Exports CSV/PDF, rapports quotidiens automatiques
- Responsive design (admin, vendeur, client)

---

Pour toute question, voir la documentation détaillée ou contacter l'équipe technique.

**Toutes les améliorations gratuites demandées ont été réalisées et documentées.**

Pour toute évolution ou besoin de personnalisation, il suffit d'adapter le seeder, les vues ou les contrôleurs selon la logique métier souhaitée. 

### Nouveautés dashboard vendeur (100% gratuites, sans dépendance externe)
- Statistiques avancées : ventes par mois (12 derniers mois), top 5 produits les plus vendus
- Alertes automatiques de stock bas (produits <= 5 en stock)
- Affichage des 5 notifications récentes (commandes, statuts, etc.)
- Tout est calculé côté backend (Eloquent), aucune dépendance payante ou API externe 