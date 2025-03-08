<?php


$router = new App\Models\Router();

$router->newRoute('/', 'Helloworld@Home');
$router->newRoute('/home2', 'Helloworld@Home2');

$router->run();