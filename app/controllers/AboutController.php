<?php 
namespace Shibaji\App\Controllers;

use Shibaji\Core\Request;

class AboutController extends Controller
{
    public function __construct()
    {
        parent::__construct('About Page');
    }

    public function index(Request $request)
    {
        $this->render('about', ['name' => $request->name ?? 'John']);
    }
}