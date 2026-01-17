<?php

namespace App\Repositories;

use App\Database;
use App\Models\Workout;
use PDO;

class WorkoutRepository
{
    private PDO $pdo;

    public function __construct()
    {
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
        $rows = $stmt->fetchAll();

        $out = [];
        foreach ($rows as $row) {
            $w = new Workout();
            $w->id = (int)$row['id'];
            $w->name = (string)$row['name'];
            $w->userId = (int)$row['user_id'];
            $w->date = (string)$row['date'];
            $w->createdAt = isset($row['created_at']) ? (string)$row['created_at'] : null;
            $out[] = $w;
        }
        return $out;
    }

    public function findById(int $id): ?Workout
    {
        $stmt = $this->pdo->prepare(
            "SELECT id, name, user_id, date, created_at
             FROM workouts
             WHERE id = :id"
        );
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();

        if (!$row) return null;

        $w = new Workout();
        $w->id = (int)$row['id'];
        $w->name = (string)$row['name'];
        $w->userId = (int)$row['user_id'];
        $w->date = (string)$row['date'];
        $w->createdAt = isset($row['created_at']) ? (string)$row['created_at'] : null;

        return $w;
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
        $rows = $stmt->fetchAll();

        $out = [];
        foreach ($rows as $row) {
            $w = new Workout();
            $w->id = (int)$row['id'];
            $w->name = (string)$row['name'];
            $w->userId = (int)$row['user_id'];
            $w->date = (string)$row['date'];
            $w->createdAt = isset($row['created_at']) ? (string)$row['created_at'] : null;
            $out[] = $w;
        }
        return $out;
    }

    public function deleteSetsByWorkoutId(int $workoutId): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM sets WHERE workout_id = :workout_id");
        $stmt->execute([':workout_id' => $workoutId]);
    }

    public function delete(int $workoutId): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM workouts WHERE id = :id");
        $stmt->execute([':id' => $workoutId]);
    }

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
