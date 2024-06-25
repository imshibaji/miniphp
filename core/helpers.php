<?php 

function partial($template, $data = []){
    $view = new \Shibaji\Core\View();
    echo $view->partial($template, $data);
}

function view($template, $data = [])
{
    $view = new \Shibaji\Core\View();
    foreach ($data as $key => $value) {
        $view->with($key, $value);
    }
    $view->render($template);
}
function active($url){
    echo $url == $_SERVER['REQUEST_URI'] ? 'active' : '';
}
function to($link){
    $config = require 'config.php';
    $url = trim($config['url'], '/');
    return header('Location: '.$url . $link);
}

function assets($value){
    $config = require 'config.php';
    $url = trim($config['url'], '/');
    $assets = trim($config['assetsUrl'], '/');
    return $url . '/'. $assets. '/' . trim($value, '/') ;
}

function __($value){
    $t = htmlspecialchars($value ?? '', ENT_QUOTES);
    $t = nl2br($t);
    $t = trim($t);
    echo $t;
}

function e($value){
    echo htmlspecialchars($value ?? '', ENT_QUOTES);
}

function _n($value){
    echo nl2br($value);
}

function _t($value){
    echo trim($value);
}

function _l($value){
    echo strlen($value);
}

function _c($value){
    echo count($value);
}

function _i($value){
    echo intval($value);
}

function _f($value){
    echo floatval($value);
}

function _r($value){
    echo round($value);
}

function _m($value){
    echo md5($value);
}

function _hmac($value){
    echo hash_hmac('sha256', $value, 'secret');
}

function _sha1($value){
    echo sha1($value);
}

function _sha256($value){
    echo hash('sha256', $value);
}

function _sha512($value){
    echo hash('sha512', $value);
}

function _s($value){
    echo $value;
}

function _d($value){
    var_dump($value);
}

function _arr($value){
    print_r($value);
}

function json($value){
    echo json_encode($value);
}

function _json($value){
    echo json_decode($value);
}

function _b($value){
    echo base64_encode($value);
}

function _b64($value){
    echo base64_encode($value);
}

function _b64d($value){
    echo base64_decode($value);
}