<?php

namespace App\Repositories;

use App\Database;
use PDO;

class ProgressRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::pdo();
    }

    /**
     * Progressie = per workout-datum het maximum gewicht (kg) voor een exercise.
     * Alleen data van de ingelogde user.
     */
    public function getProgressByExercise(int $userId, int $exerciseId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT w.date AS date, MAX(s.weight) AS max_weight
            FROM workouts w
            JOIN sets s ON s.workout_id = w.id
            WHERE w.user_id = :user_id
              AND s.exercise_id = :exercise_id
            GROUP BY w.date
            ORDER BY w.date ASC
        ");

        $stmt->execute([
            ':user_id' => $userId,
            ':exercise_id' => $exerciseId,
        ]);

        return $stmt->fetchAll();
    }
}
