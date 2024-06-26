<?php
return [
    'name' => 'MiniPHP',
    'version' => '1.0.0',
    'url' => 'http://localhost:3000',
    'assetsUrl' => 'assets',
    'run' => [
        'web' => [
            'routes/web.php'
        ],
        'console' => [
            'routes/console.php'
        ],
    ]
];