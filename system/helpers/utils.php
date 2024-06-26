<?php
function env($value, $default = null){
    return $_ENV[$value] ?? $default;
}