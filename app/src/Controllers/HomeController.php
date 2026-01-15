<?php

namespace App\Controllers;

class HomeController
{
    public function home(): string
    {
        ob_start();
        require __DIR__ . '/../Views/home.php';
        return ob_get_clean();
    }

}
