<?php

namespace App\Controllers;

use App\Repositories\UserRepository;

class DashboardController
{
    public function index(): string
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $repo = new UserRepository();
        $user = $repo->findById((int)$_SESSION['user_id']);

        if (!$user) {
            session_destroy();
            header('Location: /login');
            exit;
        }

        ob_start();
        require __DIR__ . '/../Views/dashboard.php';
        return ob_get_clean();
    }
}
