<?php
return [
    'name' => env('APP_NAME', 'Miniphp'),
    'version' => env('APP_VERSION', '1.0.0'),
    'env' => 'local',
    'debug' => env('APP_DEBUG', false),
    'timezone' => 'Asia/Kolkata',
    'url' => env('APP_URL', 'http://localhost'),
    'assetsUrl' => 'assets',
    'run' => [
        'console' => [
            'routes/console.php'
        ],
        'web' => [
            'routes/web.php'
        ],
    ]
];