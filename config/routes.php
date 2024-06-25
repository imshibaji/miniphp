<?php

use Shibaji\Core\Request;
use Shibaji\Core\Router;

$router = new Router();
$router->get('/', '\Shibaji\App\Controllers\HomeController@index');

$router->post('/', function (Request $request) {
    echo $request->getJsonBody();
    echo $request->getPath();
});
$router->get('/about','\Shibaji\App\Controllers\AboutController@index');
$router->get('/about/:name','\Shibaji\App\Controllers\AboutController@index');
$router->get('/contact', '\Shibaji\App\Controllers\ContactController@index');

$router->get('/user', '\Shibaji\App\Controllers\User@index');
$router->get('/user/:id', '\Shibaji\App\Controllers\User@index');

$router->get('/profile', function (Request $request) {
   view('home', ['name' => $request->name]);
});

$router->setNotFoundHandler(function () {
    echo '404 Not Found';
});

$router->resolve();