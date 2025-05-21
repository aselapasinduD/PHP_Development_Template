<?php

namespace Core;

/**
 * Views Core Model - Manage every views files and give access to the view files.
 * Warning - Do not delete this file.
 * @since 1.0.0
 */
class Views{
    public static function home(){
        return "Hello World! Asela";
    }
    public static function _404(){
        if(file_exists(ROOT_DIR . 'app/views/404.php')){
            include ROOT_DIR . 'app/views/404.php';
        }else if(!file_exists(ROOT_DIR . 'app/views/404.php') && $_SERVER['HTTP_HOST'] === 'localhost'){
            echo '<span style="text-align:center">
                    <h1>404: Page not found.</h1> <p>The requested URL was not found on this server.</p><hr>
                    <p><i>You can customize the 404 page by add your custom 404 page file </i><b>(NB: name the file 404.php)</b> <i>to "views" folder</i></p>
                </span>
            ';
            exit();
        }else{
            echo '<span style="text-align:center">
                <h1>404: Page not found.</h1> <p>The requested URL was not found on this server.</p><hr>
            </span>
        ';
        exit();
        }
    }
}