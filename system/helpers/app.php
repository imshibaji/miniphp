<?php 
function dd($value){
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
    exit;
}

function __($value){
    if(!isset($value)) return;
    $t = htmlspecialchars($value ?? '', ENT_QUOTES);
    $t = nl2br($t);
    $t = trim($t);
    echo $t;
}

function json($value){
    echo json_encode($value);
}

function _json($value){
    echo json_decode($value);
}