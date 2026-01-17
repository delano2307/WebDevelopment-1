<?php

namespace App\Repositories;

use App\Database;
use App\Models\Exercise;
use PDO;

class ExerciseRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::pdo();
    }

    /** @return Exercise[] */
    public function findAll(): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT id, name, muscle_group, created_at
             FROM exercises
             ORDER BY name ASC"
        );
        $stmt->execute();
        $rows = $stmt->fetchAll();

        $out = [];
        foreach ($rows as $row) {
            $e = new Exercise();
            $e->id = (int)$row['id'];
            $e->name = (string)$row['name'];
            $e->muscleGroup = isset($row['muscle_group']) ? (string)$row['muscle_group'] : null;
            $e->createdAt = isset($row['created_at']) ? (string)$row['created_at'] : null;
            $out[] = $e;
        }
        return $out;
    }

    public function findById(int $id): ?Exercise
    {
        $stmt = $this->pdo->prepare(
            "SELECT id, name, muscle_group, created_at
             FROM exercises
             WHERE id = :id"
        );
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();

        if (!$row) return null;

        $e = new Exercise();
        $e->id = (int)$row['id'];
        $e->name = (string)$row['name'];
        $e->muscleGroup = isset($row['muscle_group']) ? (string)$row['muscle_group'] : null;
        $e->createdAt = isset($row['created_at']) ? (string)$row['created_at'] : null;

        return $e;
    }

    public function create(string $name, string $muscleGroup): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO exercises (name, muscle_group)
             VALUES (:name, :muscle_group)"
        );
        $stmt->execute([
            ':name' => $name,
            ':muscle_group' => $muscleGroup === '' ? null : $muscleGroup
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    public function update(int $id, string $name, string $muscleGroup): void
    {
        $stmt = $this->pdo->prepare(
            "UPDATE exercises
             SET name = :name, muscle_group = :muscle_group
             WHERE id = :id"
        );
        $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':muscle_group' => $muscleGroup === '' ? null : $muscleGroup
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM exercises WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}
