<?php
namespace Shibaji\App\Controllers;

use Shibaji\Core\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct('Home Page');
        // $this->addTitle('Dynamic Page Example');
        $this->meta('description', 'This is a dynamic page example.');

        // $this->with('name', 'Shibaji Debnath');
        $this->with('items', ['Item 1', 'Item 2', 'Item 3']);

        $this->with('time', date('Y-m-d H:i:s'));
    }

    public function index()
    {
        $this->render('home', ['name' => 'Shibaji']);
    }   
}
