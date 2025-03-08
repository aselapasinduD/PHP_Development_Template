<?php

namespace Core;

/**
 * Views Core Model - Manage every views files and give access to the view files.
 * Warning - Do not delete this file.
 * @since 1.0.0
 */
class Views{
    public static function Home(){
        // return "Hello World! Asela";
        include ROOT_DIR . 'app/views/404.php';
        return;
    }
}