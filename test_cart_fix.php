<?php

// Test script pour vérifier l'ajout au panier
echo "=== Test de l'ajout au panier ===\n";

// Simuler une requête POST vers /cart/add
$url = 'http://127.0.0.1:8000/cart/add';
$data = [
    'product_id' => 1, // ID d'un produit existant
    'quantity' => 1
];

$options = [
    'http' => [
        'header' => [
            'Content-Type: application/json',
            'Accept: application/json',
            'X-CSRF-TOKEN: test-token'
        ],
        'method' => 'POST',
        'content' => json_encode($data)
    ]
];

$context = stream_context_create($options);

try {
    $result = file_get_contents($url, false, $context);
    echo "Réponse reçue:\n";
    echo $result . "\n";
} catch (Exception $e) {
    echo "Erreur: " . $e->getMessage() . "\n";
}

echo "=== Test terminé ===\n";
