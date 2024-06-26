<?php

use Shibaji\Core\Request;
use Shibaji\Core\Router;

$router = new Router();
$router->get('/', '\Shibaji\App\Controllers\HomeController@index');

// $router->get('/', function (Request $request) {
//     view('home', ['name' => 'John']);
//  });

$router->post('/', function (Request $request) {
    echo $request->getJsonBody();
    echo $request->getPath();
});

$router->get('/about', function(){
    view('about');
});

$router->get('/contact', function(){
    view('contact');
});

$router->setNotFoundHandler(function () {
    echo '404 Not Found';
});

return $router;