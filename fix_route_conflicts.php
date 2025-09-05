<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Route;

// Charger l'application Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Identification des conflits de routes ===\n";

// Récupérer toutes les routes
$routes = Route::getRoutes();

$routeNames = [];
$conflicts = [];

foreach ($routes as $route) {
    $name = $route->getName();
    if ($name) {
        if (isset($routeNames[$name])) {
            $conflicts[$name][] = $route->uri();
        } else {
            $routeNames[$name] = [$route->uri()];
        }
    }
}

if (empty($conflicts)) {
    echo "✓ Aucun conflit de routes trouvé\n";
} else {
    echo "✗ Conflits de routes trouvés :\n";
    foreach ($conflicts as $name => $uris) {
        echo "  - Nom: {$name}\n";
        foreach ($uris as $uri) {
            echo "    URI: {$uri}\n";
        }
        echo "\n";
    }
}

echo "=== Script terminé ===\n";
