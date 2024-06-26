<?php
require 'vendor/autoload.php';
use Shibaji\Core\App;
use Shibaji\Core\SpeedTest;


$speed = new SpeedTest();
$speed->run(function(){
    $app = new App();
    $app->run();
});
$speed->printConsoleElapsedTime();
?>