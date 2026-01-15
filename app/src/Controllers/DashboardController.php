<?php

namespace App\Controllers;

use App\Repositories\UserRepository;
use App\Repositories\WorkoutRepository;

class DashboardController
{
    public function index(): string
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userId = (int)$_SESSION['user_id'];

        $userRepo = new UserRepository();
        $user = $userRepo->findById($userId);

        // Als user niet (meer) bestaat: session kill + terug naar login
        if (!$user) {
            session_destroy();
            header('Location: /login');
            exit;
        }

        // ---- Workouts ophalen voor deze user ----
        $workoutRepo = new WorkoutRepository();
        $workouts = $workoutRepo->findLastFiveByUserId($userId);

        // ---- View renderen met $user en $workouts ----
        ob_start();
        require __DIR__ . '/../Views/dashboard.php';
        return ob_get_clean();
    }
}
