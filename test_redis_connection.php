<?php

require_once 'vendor/autoload.php';

// Initialize Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;

// Test Redis connection
try {
    // Test basic connection
    Redis::set('test_key', 'test_value');
    $value = Redis::get('test_key');
    
    echo "✅ Redis connection successful!\n";
    echo "Test value retrieved: $value\n";
    
    // Test cache
    Cache::put('test_cache', 'cache_value', 60);
    $cacheValue = Cache::get('test_cache');
    
    echo "✅ Cache test successful!\n";
    echo "Cache value retrieved: $cacheValue\n";
    
    // Clean up
    Redis::del('test_key');
    Cache::forget('test_cache');
    
    echo "✅ Redis is working perfectly!\n";
    
} catch (Exception $e) {
    echo "❌ Redis connection failed: " . $e->getMessage() . "\n";
} 