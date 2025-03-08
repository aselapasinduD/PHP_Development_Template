<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/../config.php";

spl_autoload_register(function($class){
    if(str_contains($class, '\\') || strpos($class, '\\') > 0){
        $class2 = explode('\\', $class);
        $class = end($class2);
    }
    // if (is_readable(ROOT_DIR . '/app/controllers/'.$class . '.Controller.php')) {
    //     include_once ROOT_DIR . '/app/controllers/'.$class . '.Controller.php';
    // }  else
    if (is_readable(ROOT_DIR . 'app/models/' . $class . '.Model.php')) {
        include_once ROOT_DIR . 'app/models/' . $class . '.Model.php';
    } else if (is_readable(ROOT_DIR . '/app/controllers/Controller.php')) {
        include_once ROOT_DIR . 'app/controllers/Controller.php';
    }
});