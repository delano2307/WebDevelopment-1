<?php

namespace App\Controllers;

use App\Repositories\WorkoutRepository;
use App\Repositories\SetRepository;
use App\Repositories\ExerciseRepository;

class WorkoutController
{
    private WorkoutRepository $workouts;
    private SetRepository $sets;
    private ExerciseRepository $exercises;

    public function __construct()
    {
        $this->workouts  = new WorkoutRepository();
        $this->sets      = new SetRepository();
        $this->exercises = new ExerciseRepository();
    }

    public function index(): string
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userId = (int)$_SESSION['user_id'];
        $workouts = $this->workouts->findAllByUserId($userId);

        ob_start();
        require __DIR__ . '/../Views/workouts/index.php';
        return ob_get_clean();
    }

    public function create(): string
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $today = date('Y-m-d');

        ob_start();
        require __DIR__ . '/../Views/workouts/create.php';
        return ob_get_clean();
    }

    public function store(): void
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userId = (int)$_SESSION['user_id'];

        $name = trim($_POST['name'] ?? '');
        $date = $_POST['date'] ?? date('Y-m-d');

        if ($name === '' || strlen($name) > 100) {
            http_response_code(400);
            echo "Workout naam is verplicht (max 100 tekens).";
            return;
        }

        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            http_response_code(400);
            echo "Ongeldige datum.";
            return;
        }

        $newId = $this->workouts->create($userId, $name, $date);

        header("Location: /workouts/{$newId}");
        exit;
    }

    public function show(array $vars): string
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $workoutId = (int)($vars['id'] ?? 0);
        if ($workoutId <= 0) {
            http_response_code(400);
            echo "Workout ID ontbreekt.";
            exit;
        }

        $workout = $this->workouts->findById($workoutId);
        if (!$workout) {
            http_response_code(404);
            echo "Workout niet gevonden.";
            exit;
        }

        // Authorisatie: user mag alleen eigen workout zien
        $userId = (int)$_SESSION['user_id'];
        if ((int)$workout->userId !== $userId) {
            http_response_code(403);
            echo "Geen toegang tot deze workout.";
            exit;
        }

        $sets = $this->sets->findAllByWorkoutId($workoutId);
        $exercises = $this->exercises->findAll();

        ob_start();
        require __DIR__ . '/../Views/workouts/show.php';
        return ob_get_clean();
    }

    public function delete(array $vars): void
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $workoutId = (int)($vars['id'] ?? 0);
        if ($workoutId <= 0) {
            http_response_code(400);
            echo "Workout ID ontbreekt.";
            return;
        }

        $workout = $this->workouts->findById($workoutId);
        if (!$workout) {
            http_response_code(404);
            echo "Workout niet gevonden.";
            return;
        }

        if ((int)$workout->userId !== (int)$_SESSION['user_id']) {
            http_response_code(403);
            echo "Geen toegang.";
            return;
        }

        $this->workouts->deleteSetsByWorkoutId($workoutId);
        $this->workouts->delete($workoutId);

        header("Location: /workouts");
        exit;
    }


    public function edit(array $vars): string
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $workoutId = (int)($vars['id'] ?? 0);
        if ($workoutId <= 0) {
            http_response_code(400);
            echo "Workout ID ontbreekt.";
            exit;
        }

        $workout = $this->workouts->findById($workoutId);
        if (!$workout) {
            http_response_code(404);
            echo "Workout niet gevonden.";
            exit;
        }

        if ((int)$workout->userId !== (int)$_SESSION['user_id']) {
            http_response_code(403);
            echo "Geen toegang.";
            exit;
        }

        ob_start();
        require __DIR__ . '/../Views/workouts/edit.php';
        return ob_get_clean();
    }


    public function update(array $vars): void
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $workoutId = (int)($vars['id'] ?? 0);
        if ($workoutId <= 0) {
            http_response_code(400);
            echo "Workout ID ontbreekt.";
            return;
        }

        $workout = $this->workouts->findById($workoutId);
        if (!$workout) {
            http_response_code(404);
            echo "Workout niet gevonden.";
            return;
        }

        if ((int)$workout->userId !== (int)$_SESSION['user_id']) {
            http_response_code(403);
            echo "Geen toegang.";
            return;
        }

        $name = trim($_POST['name'] ?? '');
        $date = $_POST['date'] ?? '';

        if ($name === '' || strlen($name) > 100) {
            http_response_code(400);
            echo "Workout naam is verplicht (max 100 tekens).";
            return;
        }

        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            http_response_code(400);
            echo "Ongeldige datum.";
            return;
        }

        $this->workouts->update($workoutId, $name, $date);

        header("Location: /workouts/{$workoutId}");
        exit;
    }
}
