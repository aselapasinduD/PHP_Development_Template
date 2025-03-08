<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/../config.php";

spl_autoload_register(function($class){
    if(str_contains($class, '\\') || strpos($class, '\\') > 0){
        $class2 = explode('\\', $class);
        $class = end($class2);
    }

    $coreClassPaths = [
        ROOT_DIR . 'core/Controller.php',
        ROOT_DIR . 'core/Views.php',
        ROOT_DIR . 'core/Router.php',
    ];

    $paths = [
        ROOT_DIR . 'app/models/' . $class . '.Model.php'
    ];

    foreach ($coreClassPaths as $path){
        if (is_readable($path)){
            include_once $path;
        }
    }
    foreach ($paths as $path){
        if(is_readable($path)){
            include_once $path;
        }
    }
});