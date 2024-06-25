<?php
namespace Shibaji\App;

use Shibaji\Core\Html;

class Page{
    private Html $html;
    public function __construct() {
        $this->html = new Html('My Home Page');
        $this->links();
      
        $this->html->css('h1', 'color: red; background-color: yellow; padding: 10px;');
        // $this->html->cssLink('/assets/styles.css');
        $this->html->addElement('<h1>My Another Website</h1>');
        // $this->html->js('alert("Hello World");');

        
        $this->form('/', 'POST');
        $this->table(
            ['Name', 'Email', 'Password', 'Gender'], 
            [
                ['John', 'john@gmail.com', '123456', 'Male'],
                ['Steve', 'steve@gmail.com', '123456', 'Male']
            ]
        );
        
    }

    private function links(){
        $this->html->cssLink('https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css');
        $this->html->jsLink('https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js');
    }

    private function form($path, $method){
        $this->html->form($path, $method, function ($el) {
            $el->container(function ($el) {
                $el->column(function ($el) {
                    $el->text('Full Name',['placeholder' => "Enter your name", 'style'=>"margin: 5px;"]);
                    $el->text('Email',['placeholder' => "Enter your email", 'style'=>"margin: 5px;"]);
                    $el->text('Password',['placeholder' => "Enter your password", 'style'=>"margin: 5px;"]);
                    $el->text('Confirm Password',['placeholder' => "Confirm your password", 'style'=>"margin: 5px;"]);
                    $el->column(function ($el) {
                        $el->tag('h3','Gender');
                        $el->row(function ($el) {
                            $el->radio('Gender', "M", ['label' => "Male"]);
                            $el->radio('Gender', "F", ['label' => "Female"]);
                        });
                    },['style' => "margin: 5px;"]);
                    $el->button('Submit','submit');
                });
            });
        });
    }

    private function table($headers, $rows) {
        $this->html->table(
            function ($el) use ($rows) {
                foreach ($rows as $row) {
                    $el->tr(function ($el) use ($row) {
                        foreach ($row as $value) {
                            $el->td($value);
                        }
                    });
                }
            },
            [
                'headers' => $headers,
                'class' => 'table table-striped table-hover table-bordered m-3',
            ]
        );
    }

    // public function run(){
    //     $this->html->render();
    // }
}
