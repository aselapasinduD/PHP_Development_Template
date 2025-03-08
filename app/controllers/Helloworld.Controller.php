<?php

// namespace App\Controllers;

class Helloworld{
    public function Home(){
        echo "Hello World!";
    }
    public function Home2($value){
        echo "Hello 2 World! - " . print_r($value);
    }
}
