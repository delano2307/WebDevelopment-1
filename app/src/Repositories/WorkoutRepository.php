<?php

namespace App\Repositories;

use App\Database;
use PDO;

class WorkoutRepository
{
    private PDO $pdo;

    public function __construct()
    {
        //connectie met database
        $this->pdo = Database::pdo();
    }

    
    public function create(int $userId, string $name, string $date): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO workouts (user_id, name, date)
            VALUES (:user_id, :name, :date)"
        );

        $stmt->execute([
            ':user_id' => $userId,
            ':name'    => $name,
            ':date'    => $date,
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    public function findAllByUserId(int $userId): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT id, name, user_id, date, created_at
             FROM workouts
             WHERE user_id = :user_id
             ORDER BY date DESC, id DESC"
        );

        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            "SELECT id, name, user_id, date, created_at
             FROM workouts
             WHERE id = :id"
        );

        $stmt->execute([':id' => $id]);
        $workout = $stmt->fetch();

        return $workout ?: null;
    }

    public function findLastFiveByUserId(int $userId): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT id, name, user_id, date, created_at
            FROM workouts
            WHERE user_id = :user_id
            ORDER BY date DESC, id DESC
            LIMIT 5"
        );

        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll();
    }

    /**
     * Verwijder alle sets van een workout (handig als je geen FK ON DELETE CASCADE hebt).
     */
    public function deleteSetsByWorkoutId(int $workoutId): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM sets WHERE workout_id = :workout_id");
        $stmt->execute([':workout_id' => $workoutId]);
    }

    /**
     * Verwijder een workout.
     */
    public function delete(int $workoutId): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM workouts WHERE id = :id");
        $stmt->execute([':id' => $workoutId]);
    }

    /**
     * Update workout naam en datum.
     */
    public function update(int $id, string $name, string $date): void
    {
        $stmt = $this->pdo->prepare(
            "UPDATE workouts
            SET name = :name, date = :date
            WHERE id = :id"
        );

        $stmt->execute([
            ':id'   => $id,
            ':name' => $name,
            ':date' => $date,
        ]);
    }


}