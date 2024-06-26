<?php
namespace Shibaji\App\Controllers;

use Shibaji\Core\Request;

class HomeController
{
    public function index()
    {
        view('home', ['name' => 'John']);
    }   
}
