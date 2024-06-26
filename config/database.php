<?php
return [
    'host' => env('DB_HOST', 'localhost'),
    'name' => env('DB_NAME', 'miniphp'),
    'username' => env('DB_USERNAME', 'root'),
    'password' => env('DB_PASSWORD', ''),
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
];