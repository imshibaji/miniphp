<?php 

function partial($template, $data = [], $cache = false){
    $view = new \Shibaji\Core\Template();
    echo $view->render($template, $data, $cache);
}

function view($template, $data = [], $cache = false)
{
    $view = new \Shibaji\Core\Template();
    echo $view->render($template, $data, $cache);
}
function active($url){
    echo $url == $_SERVER['REQUEST_URI'] ? 'active' : '';
}

function assets($value){
    $app =  APP;
    $url = trim($app['url'], '/');
    $assets = trim($app['assetsUrl'], '/');
    echo $url . '/'. $assets. '/' . trim($value, '/') ;
}