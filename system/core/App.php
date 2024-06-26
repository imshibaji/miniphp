<?php
namespace Shibaji\Core;
class App{
    private $app;
    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        // Configuration Files
        if(file_exists('config/app.php')){
            $this->app = require 'config/app.php';
            define('APP', $this->app);
        }else{
            $this->app = require 'system/config/app.php';
            define('APP', $this->app);
        }
        // Load Helpers
        if(file_exists('config/helpers.php')){
            $helpers = require 'config/helpers.php';
            $this->register('helpers', $helpers);
        }else{
            $helpers = require 'system/config/helpers.php';
            $this->register('helpers', $helpers);
        }
        // generate helpers
        foreach ($this->app['helpers'] as $helper) {
            require $helper;
        }

        // Database
        if(file_exists('config/database.php')){
            $db = require 'config/database.php';
        }else{
            $db = require 'system/config/database.php';
        }
        $this->register('db', $db);
    }

    public function run()
    {
        foreach ($this->app['run']['web'] as $route) {
            $router = require $route;
            $router->resolve();
        }
    }

    public function get($key){
        return $this->app[$key];
    }

    public function exec(){
        Console::welcome();
        foreach ($this->app['run']['console'] as $console) {
            require_once $console;
        }
        Console::runQuick();
        
        return $this->app;
    }

    public function build(){
        return $this->app;
    }

    public function register($key, $value){
        $this->app[$key] = $value;
    }

    public function __destruct()
    {
        unset($this->app);
    }
}