<?php

namespace App\Controllers;

use App\Repositories\ExerciseRepository;

class ProgressController
{
    public function index(): string
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $exerciseRepo = new ExerciseRepository();
        $exercises = $exerciseRepo->findAll();

        ob_start();
        require __DIR__ . '/../Views/progress.php';
        return ob_get_clean();
    }
}
