<?php
namespace Shibaji\App\Controllers;
use Shibaji\Core\View;

class Controller extends View
{
    public function __construct($title = '', $siteTitle = null, $menus = [])
    {
        parent::__construct($title);
        $this->with('title', $title);
        $this->links();
        $this->headers($siteTitle, $menus);
    }

    private function headers($siteTitle = '', $menus = []){
        $this->with('siteTitle',  $siteTitle ?: 'My Demo Website');
        $this->with('menus', $menus ?: [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'About', 'url' => '/about'],
            ['label' => 'Services', 'url' => '/services', 'children' => [
                    ['label' => 'Service 1', 'url' => '/service/1'],
                    ['label' => 'Service 2', 'url' => '/service/2'],
                    ['label' => 'Service 3', 'url' => '/service/3'],
                ]
            ],
            ['label' => 'Contact', 'url' => '/contact'],
        ]);
        $this->render('common/header',[],false);
    }

    public function links(){
        $this->cssLink(assets('css/bootstrap.min.css'));
        $this->cssLink(assets('css/styles.css'));
        $this->jsLink(assets('js/bootstrap.bundle.min.js'));
        $this->jsLink(assets('js/theme.js'));
    }
}