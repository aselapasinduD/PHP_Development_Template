<?php
// Main Controller - Don't Delete this file.

namespace Core;

use Core\Views;

/**
 * Controller Core Model - Provide extendable functionalities to the controllers.
 * Warning - Do not delete core/Views.php file.
 * @since 1.0.0
 */
class Controller{
    public $views;

    public function __construct()
    {
        $this->views = Views::class;
    }
}