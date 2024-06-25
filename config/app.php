<?php
return [
    'url' => 'http://localhost:3000',
    'assetsUrl' => 'assets',
    'database' => [
        'host' => 'localhost',
        'name' => 'souvik',
        'username' => 'root',
        'password' => 'password',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ]
];