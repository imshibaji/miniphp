<?php

use Shibaji\Core\Console;



// Register commands
Console::command('hello', function () {
    Console::writeLine("Hello, world!");
});

Console::command('hello {name}', function ($name) {
    Console::writeLine("Hello, $name!");
});

// Register the serve command to start the PHP built-in server
Console::command('serve', function ($host = '127.0.0.1', $port = '3000') {
    Console::writeLine("Starting server on http://$host:$port...");
    passthru("php -S $host:$port");
});

Console::command('greet {name}', function ($name) {
    Console::writeLine("Hello, $name!");
});

Console::command('sum {a} {b}', function ($a, $b) {
    $result = $a + $b;
    Console::writeLine("Sum of $a and $b is: $result");
});

Console::command('exit', function () {
    Console::writeLine("Goodbye!");
    exit;
});

// Register the list command to list all commands
Console::command('list', function () {
    Console::listCommands();
});

Console::purpose('hello', 'Display a hello message');
Console::purpose('hello {name}', 'Greet someone by name');
Console::purpose('serve {port}', 'Start a PHP server on the specified port');
Console::purpose('greet {name}', 'Greet someone by name');
Console::purpose('sum {a} {b}', 'Calculate the sum of two numbers');
Console::purpose('exit', 'Exit the console application');
Console::purpose('list', 'List all available commands');