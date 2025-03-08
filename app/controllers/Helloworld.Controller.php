<?php

use Core\Controller;
use Core\Views;

class Helloworld extends Controller{
    public function Home(){
        echo Views::Home();
    }

    public function Home2($value){
        echo "Hello World - " . print_r($value);
    }
}
