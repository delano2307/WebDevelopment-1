<?php

namespace App\Repositories;

use App\Database;
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
        return $stmt->fetchAll();
    }

    /**
     * Vind één set op id (nodig voor edit + ownership check).
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            "SELECT id, workout_id, exercise_id, reps, weight
            FROM sets
            WHERE id = :id"
        );
        $stmt->execute([':id' => $id]);
        $set = $stmt->fetch();

        return $set ?: null;
    }

    /**
     * Update een set.
     */
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

    /**
     * Delete een set.
     */
    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM sets WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }

}
