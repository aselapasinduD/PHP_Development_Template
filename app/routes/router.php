<?php

use Core\Router;
use App\Controllers\Dashboard;

$router = new Router();

$router->newRoute('/home', [Dashboard::class, 'home']); // define the router controller function as a Array.
$router->newRoute('/home2', 'Home2@Dashboard'); // define the router controller function as a String.
$router->newRoute('/home3', function () {
    $dashboard = new Dashboard();
    return $dashboard->home();
}); // define the router controller function as a Callable.

// Router::newRoute('/', 'Home@Dashboard');
// Router::newRoute('/home2', 'Home2@Dashboard');

$router();
// Router::run();