<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    $redis = new Redis();
    $redis->connect('redis', 6379);
    echo "Connected to Redis successfully\n";
    
    // Test simple set/get
    $redis->set('test_key', 'Hello Redis!');
    echo "Value from Redis: " . $redis->get('test_key') . "\n";
    
    // Test avec Laravel Cache
    Cache::put('test_cache', 'Hello Cache!', 60);
    echo "Value from Cache: " . Cache::get('test_cache') . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
} 