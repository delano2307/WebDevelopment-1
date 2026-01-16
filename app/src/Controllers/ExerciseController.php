<?php

namespace App\Controllers;

use App\Repositories\ExerciseRepository;

class ExerciseController
{
    private ExerciseRepository $exercises;

    public function __construct()
    {
        $this->exercises = new ExerciseRepository();
    }

    private function requireAuth(): void
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }

    private function requireAdmin(): void
    {
        $this->requireAuth();

        if (($_SESSION['role'] ?? '') !== 'admin') {
            http_response_code(403);
            echo "Geen toegang (admin vereist).";
            exit;
        }
    }

    // ✅ Iedereen die ingelogd is: lijst bekijken
    public function index(): string
    {
        $this->requireAuth();

        $exercises = $this->exercises->findAll();

        ob_start();
        require __DIR__ . '/../Views/exercises/index.php';
        return ob_get_clean();
    }

    // 🔒 Admin-only: create
    public function create(): string
    {
        $this->requireAdmin();

        $error = null;
        $old = ['name' => '', 'muscle_group' => ''];

        ob_start();
        require __DIR__ . '/../Views/exercises/create.php';
        return ob_get_clean();
    }

    public function store(): string
    {
        $this->requireAdmin();

        $name = trim($_POST['name'] ?? '');
        $muscleGroup = trim($_POST['muscle_group'] ?? '');

        $error = $this->validate($name, $muscleGroup);

        if ($error !== null) {
            $old = ['name' => $name, 'muscle_group' => $muscleGroup];
            ob_start();
            require __DIR__ . '/../Views/exercises/create.php';
            return ob_get_clean();
        }

        $this->exercises->create($name, $muscleGroup);

        header('Location: /exercises');
        exit;
    }

    // 🔒 Admin-only: edit/update/delete
    public function edit(array $vars): string
    {
        $this->requireAdmin();

        $id = (int)($vars['id'] ?? 0);
        $exercise = $this->exercises->findById($id);

        if (!$exercise) {
            http_response_code(404);
            return "Oefening niet gevonden.";
        }

        $error = null;

        ob_start();
        require __DIR__ . '/../Views/exercises/edit.php';
        return ob_get_clean();
    }

    public function update(array $vars): string
    {
        $this->requireAdmin();

        $id = (int)($vars['id'] ?? 0);
        $exercise = $this->exercises->findById($id);

        if (!$exercise) {
            http_response_code(404);
            return "Oefening niet gevonden.";
        }

        $name = trim($_POST['name'] ?? '');
        $muscleGroup = trim($_POST['muscle_group'] ?? '');

        $error = $this->validate($name, $muscleGroup);

        if ($error !== null) {
            $exercise['name'] = $name;
            $exercise['muscle_group'] = $muscleGroup;

            ob_start();
            require __DIR__ . '/../Views/exercises/edit.php';
            return ob_get_clean();
        }

        $this->exercises->update($id, $name, $muscleGroup);

        header('Location: /exercises');
        exit;
    }

    public function delete(array $vars): void
    {
        $this->requireAdmin();

        $id = (int)($vars['id'] ?? 0);
        $exercise = $this->exercises->findById($id);

        if (!$exercise) {
            http_response_code(404);
            echo "Oefening niet gevonden.";
            return;
        }

        $this->exercises->delete($id);

        header('Location: /exercises');
        exit;
    }

    private function validate(string $name, string $muscleGroup): ?string
    {
        if ($name === '') return "Naam is verplicht.";
        if (mb_strlen($name) < 2) return "Naam moet minimaal 2 tekens zijn.";
        if (mb_strlen($name) > 80) return "Naam mag maximaal 80 tekens zijn.";

        if ($muscleGroup !== '' && mb_strlen($muscleGroup) > 40) {
            return "Spiergroep mag maximaal 40 tekens zijn.";
        }

        return null;
    }
}
