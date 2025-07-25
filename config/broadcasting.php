<?php

return [

    'default' => env('BROADCAST_DRIVER', 'pusher'),

    'connections' => [

        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                // ✅ En local (Laravel Echo Server) → host, port, no TLS
                'host' => env('APP_ENV') === 'local' ? '127.0.0.1' : null,
                'port' => env('APP_ENV') === 'local' ? 6001 : null,
                'scheme' => env('APP_ENV') === 'local' ? 'http' : 'https',
                'encrypted' => env('APP_ENV') !== 'local',
                'useTLS' => env('APP_ENV') !== 'local',
                'cluster' => env('APP_ENV') !== 'local' ? env('PUSHER_APP_CLUSTER') : null,
            ],
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
        ],

        'log' => [
            'driver' => 'log',
        ],

        'null' => [
            'driver' => 'null',
        ],

    ],
    'options' => [
    'cluster' => env('PUSHER_APP_CLUSTER'),
    'useTLS' => false,
    'host' => env('PUSHER_HOST', '127.0.0.1'),
    'port' => env('PUSHER_PORT', 6001),
    'scheme' => env('PUSHER_SCHEME', 'http'),
    'encrypted' => false,
],


];
