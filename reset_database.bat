@echo off
echo ========================================
echo    RESET COMPLET DE LA BASE DE DONNEES
echo ========================================
echo.

echo [1/6] Nettoyage du cache...
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

echo.
echo [2/6] Suppression des tables existantes...
php artisan migrate:reset --force

echo.
echo [3/6] Exécution des migrations...
php artisan migrate --force

echo.
echo [4/6] Exécution du seeder complet...
php artisan db:seed --class=CompleteDatabaseSeeder --force

echo.
echo [5/6] Création du lien symbolique storage...
php artisan storage:link

echo.
echo [6/6] Optimisation de l'application...
php artisan optimize

echo.
echo ========================================
echo    RESET TERMINE AVEC SUCCES !
echo ========================================
echo.
echo Utilisateurs créés :
echo - Admin Principal: slovengama@gmail.com (admin123)
echo - Admin Secondaire: stemk2151@gmail.com (admin123)
echo - Vendeur 1: vendeur1@techexchange.com (vendor123)
echo - Vendeur 2: vendeur2@techexchange.com (vendor123)
echo - Livreur 1: livreur1@techexchange.com (delivery123)
echo - Livreur 2: livreur2@techexchange.com (delivery123)
echo - Utilisateur 1: user1@techexchange.com (user123)
echo - Utilisateur 2: user2@techexchange.com (user123)
echo.
echo 10 appareils électroniques créés avec système de troc !
echo.
pause 