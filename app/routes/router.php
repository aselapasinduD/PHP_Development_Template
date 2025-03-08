<?php

use Core\Router;

$router = new Router();

$router->newRoute('/', 'Home@Helloworld');
$router->newRoute('/home2', 'Home2@Helloworld');

$router->run();