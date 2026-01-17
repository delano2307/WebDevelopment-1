<?php

namespace App\Repositories;

use App\Database;
use App\Models\Set;
use PDO;

class SetRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::pdo();
    }

    public function create(int $workoutId, int $exerciseId, int $reps, float $weight): void
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO sets (workout_id, exercise_id, reps, weight)
             VALUES (:workout_id, :exercise_id, :reps, :weight)"
        );

        $stmt->execute([
            ':workout_id'  => $workoutId,
            ':exercise_id' => $exerciseId,
            ':reps'        => $reps,
            ':weight'      => $weight,
        ]);
    }

    public function findAllByWorkoutId(int $workoutId): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT s.id, s.workout_id, s.exercise_id, s.reps, s.weight,
                    e.name AS exercise_name
             FROM sets s
             JOIN exercises e ON e.id = s.exercise_id
             WHERE s.workout_id = :workout_id
             ORDER BY s.id ASC"
        );

        $stmt->execute([':workout_id' => $workoutId]);
        $rows = $stmt->fetchAll();

        $out = [];
        foreach ($rows as $row) {
            $s = new Set();
            $s->id = (int)$row['id'];
            $s->workoutId = (int)$row['workout_id'];
            $s->exerciseId = (int)$row['exercise_id'];
            $s->reps = (int)$row['reps'];
            $s->weight = (float)$row['weight'];
            $s->exerciseName = isset($row['exercise_name']) ? (string)$row['exercise_name'] : null;
            $out[] = $s;
        }
        return $out;
    }

    public function findById(int $id): ?Set
    {
        $stmt = $this->pdo->prepare(
            "SELECT id, workout_id, exercise_id, reps, weight
             FROM sets
             WHERE id = :id"
        );
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();

        if (!$row) return null;

        $s = new Set();
        $s->id = (int)$row['id'];
        $s->workoutId = (int)$row['workout_id'];
        $s->exerciseId = (int)$row['exercise_id'];
        $s->reps = (int)$row['reps'];
        $s->weight = (float)$row['weight'];

        return $s;
    }

    public function update(int $id, int $exerciseId, int $reps, float $weight): void
    {
        $stmt = $this->pdo->prepare(
            "UPDATE sets
             SET exercise_id = :exercise_id, reps = :reps, weight = :weight
             WHERE id = :id"
        );

        $stmt->execute([
            ':id' => $id,
            ':exercise_id' => $exerciseId,
            ':reps' => $reps,
            ':weight' => $weight,
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM sets WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }

    public function findLastLoggedExerciseIdByUserId(int $userId): ?int
    {
        $stmt = $this->pdo->prepare(
            "SELECT s.exercise_id
             FROM sets s
             JOIN workouts w ON w.id = s.workout_id
             WHERE w.user_id = :user_id
             ORDER BY w.date DESC, s.id DESC
             LIMIT 1"
        );

        $stmt->execute([':user_id' => $userId]);
        $val = $stmt->fetchColumn();

        return $val !== false ? (int)$val : null;
    }
}
