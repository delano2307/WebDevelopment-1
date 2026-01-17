<?php

namespace App\Controllers;

use App\Repositories\UserRepository;
use App\Repositories\WorkoutRepository;
use App\Repositories\ExerciseRepository;
use App\Repositories\SetRepository;

class DashboardController
{
    private UserRepository $users;
    private WorkoutRepository $workouts;
    private ExerciseRepository $exercises;
    private SetRepository $sets;

    public function __construct()
    {
        $this->users = new UserRepository();
        $this->workouts = new WorkoutRepository();
        $this->exercises = new ExerciseRepository();
        $this->sets = new SetRepository();
    }

    public function index(): string
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userId = (int)$_SESSION['user_id'];

        $user = $this->users->findById($userId);

        if (!$user) {
            session_destroy();
            header('Location: /login');
            exit;
        }

        $workouts = $this->workouts->findLastFiveByUserId($userId);
        $exercises = $this->exercises->findAll();

        $lastExerciseId = $this->sets->findLastLoggedExerciseIdByUserId($userId);

        $lastExercise = null;
        if (!empty($lastExerciseId)) {
            $lastExercise = $this->exercises->findById((int)$lastExerciseId);
        }


        ob_start();
        require __DIR__ . '/../Views/dashboard.php';
        return ob_get_clean();
    }
}
