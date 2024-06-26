<?php
return [
    'name' => 'MiniPHP',
    'version' => '1.0.0',
    'url' => 'http://localhost:3000',
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