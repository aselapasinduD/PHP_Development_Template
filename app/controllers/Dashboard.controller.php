<?php

namespace App\Controllers;

use Core\Controller;

class Dashboard extends Controller{
    public function Home(){
        return $this->views::Home();
    }

    public function Home2($value){
        return "Hello World - " . print_r($value);
    }
}
