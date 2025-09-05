#!/bin/bash

# Script de déploiement Railway pour TechExchange
echo "🚀 Déploiement de TechExchange sur Railway..."

# 1. Vérifier que nous sommes dans le bon répertoire
if [ ! -f "composer.json" ]; then
    echo "❌ Erreur: composer.json non trouvé. Assurez-vous d'être dans le répertoire du projet."
    exit 1
fi

# 2. Installer les dépendances
echo "📦 Installation des dépendances..."
composer install --no-dev --optimize-autoloader

# 3. Construire les assets
echo "🎨 Construction des assets..."
npm install
npm run build

# 4. Optimiser Laravel pour la production
echo "⚡ Optimisation de Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Générer la clé d'application si nécessaire
if [ -z "$APP_KEY" ]; then
    echo "🔑 Génération de la clé d'application..."
    php artisan key:generate
fi

echo "✅ Préparation terminée !"
echo "📝 N'oubliez pas de :"
echo "   1. Pousser le code sur GitHub"
echo "   2. Connecter Railway à votre repo"
echo "   3. Configurer les variables d'environnement"
echo "   4. Ajouter la base de données PostgreSQL"
echo "   5. Exécuter les migrations : php artisan migrate"
