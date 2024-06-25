<?php
require 'vendor/autoload.php';
use Shibaji\Core\App;
use Shibaji\Core\SpeedTest;


$speed = new SpeedTest();
$speed->run(function(){
    new App();
});
// $speed->printConsoleElapsedTime();
?>