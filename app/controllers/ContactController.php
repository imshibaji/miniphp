<?php 
namespace Shibaji\App\Controllers;

use Shibaji\Core\Request;

class ContactController extends Controller
{
    public function __construct()
    {
        parent::__construct('Contact Page');
    }

    public function index(Request $request)
    {
        $this->with('name', 'Shibaji Debnath');
        $this->render('contact');
    }
}