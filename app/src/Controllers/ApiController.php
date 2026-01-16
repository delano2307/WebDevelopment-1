<?php

namespace App\Controllers;

use App\Repositories\ProgressRepository;

class ApiController
{
    public function progress(): void
    {
        // Auth check (zelfde stijl als DashboardController)
        if (empty($_SESSION['user_id'])) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $userId = (int)$_SESSION['user_id'];

        $exerciseIdRaw = $_GET['exercise_id'] ?? '';
        if (!ctype_digit((string)$exerciseIdRaw)) {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'exercise_id missing/invalid']);
            return;
        }

        $exerciseId = (int)$exerciseIdRaw;

        $repo = new ProgressRepository();
        $data = $repo->getProgressByExercise($userId, $exerciseId);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }
}
