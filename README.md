# E-commerce de Cosmétiques

Une plateforme e-commerce moderne spécialisée dans la vente de produits cosmétiques, développée avec Laravel 11.

## Fonctionnalités Principales

- 🛍️ Catalogue de produits cosmétiques
- 👤 Gestion multi-rôles (Admin, Client, Livreur)
- 🛒 Panier et système de commande
- 🚚 Suivi de livraison en temps réel
- 📊 Dashboard administratif complet
- 💳 Système de paiement sécurisé
- 📱 Interface responsive
- 🔔 Notifications en temps réel

## Prérequis

- PHP 8.3+
- MySQL 5.7+
- Composer
- Node.js & NPM

## Installation

1. Cloner le projet
```bash
git clone [url-du-projet]
cd mon-site-cosmetique
```

2. Installer les dépendances
```bash
composer install
npm install
```

3. Configuration
```bash
cp .env.example .env
php artisan key:generate
```

4. Base de données
```bash
php artisan migrate
php artisan db:seed
```

5. Démarrer le serveur
```bash
php artisan serve
npm run dev
```

## Documentation

Pour une documentation complète, consultez [DOCUMENTATION.md](DOCUMENTATION.md)

## Support

Pour toute question ou assistance :
- Email : support@monsitecosmetique.com
- Documentation : docs.monsitecosmetique.com

## Licence

MIT License - Voir le fichier [LICENSE](LICENSE) pour plus de détails.
