<?php

// return [
//     'paths' => ['api/*', 'sanctum/csrf-cookie'],
//     'allowed_methods' => explode(',', env('CORS_ALLOWED_METHODS', '*')),
//     'allowed_origins' => explode(',', env('CORS_ALLOWED_ORIGINS', 'http://localhost:5173')),
//     'allowed_origins_patterns' => [],
//     'allowed_headers' => explode(',', env('CORS_ALLOWED_HEADERS', '*')),
//     'exposed_headers' => [],
//     'max_age' => 0,
//     'supports_credentials' => env('CORS_SUPPORTS_CREDENTIALS', true),
// ]; 
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Couvre les routes API et CSRF
    'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'], // Méthodes nécessaires
    'allowed_origins' => ['http://localhost:49350'], // Origine précise de votre frontend
    'allowed_origins_patterns' => [], // Pas de motifs dynamiques pour plus de sécurité
    'allowed_headers' => ['Content-Type', 'Authorization', 'X-CSRF-Token'], // En-têtes nécessaires pour Sanctum
    'exposed_headers' => [], // Aucun en-tête exposé supplémentaire
    'max_age' => 0, // Pas de mise en cache des pré-vérifications
    'supports_credentials' => true, // Requis pour Sanctum (cookies)
];