<?php

namespace App\Repositories;

use App\Database;
use App\Models\ProgressPoint;
use PDO;

class ProgressRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::pdo();
    }

    /** @return ProgressPoint[] */
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

        $rows = $stmt->fetchAll();

        $out = [];
        foreach ($rows as $row) {
            $p = new ProgressPoint();
            $p->date = (string)$row['date'];
            $p->max_weight = (float)$row['max_weight'];
            $out[] = $p;
        }

        return $out;
    }
}
