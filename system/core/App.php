<?php
namespace Shibaji\Core;
class App{

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $app = require 'config/app.php';
        define('APP', $app);
        
        require 'system/helpers/app.php';
        require 'config/routes.php';
    }
}