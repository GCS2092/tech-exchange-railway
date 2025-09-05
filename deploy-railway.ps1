# Script de déploiement Railway pour TechExchange (PowerShell)
Write-Host "🚀 Déploiement de TechExchange sur Railway..." -ForegroundColor Green

# 1. Vérifier que nous sommes dans le bon répertoire
if (-not (Test-Path "composer.json")) {
    Write-Host "❌ Erreur: composer.json non trouvé. Assurez-vous d'être dans le répertoire du projet." -ForegroundColor Red
    exit 1
}

# 2. Installer les dépendances
Write-Host "📦 Installation des dépendances..." -ForegroundColor Yellow
composer install --no-dev --optimize-autoloader

# 3. Construire les assets
Write-Host "🎨 Construction des assets..." -ForegroundColor Yellow
npm install
npm run build

# 4. Optimiser Laravel pour la production
Write-Host "⚡ Optimisation de Laravel..." -ForegroundColor Yellow
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Générer la clé d'application si nécessaire
if (-not $env:APP_KEY) {
    Write-Host "🔑 Génération de la clé d'application..." -ForegroundColor Yellow
    php artisan key:generate
}

Write-Host "✅ Préparation terminée !" -ForegroundColor Green
Write-Host "📝 N'oubliez pas de :" -ForegroundColor Cyan
Write-Host "   1. Pousser le code sur GitHub" -ForegroundColor White
Write-Host "   2. Connecter Railway à votre repo" -ForegroundColor White
Write-Host "   3. Configurer les variables d'environnement" -ForegroundColor White
Write-Host "   4. Ajouter la base de données PostgreSQL" -ForegroundColor White
Write-Host "   5. Exécuter les migrations : php artisan migrate" -ForegroundColor White
