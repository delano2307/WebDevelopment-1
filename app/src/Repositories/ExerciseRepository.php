<?php

namespace App\Repositories;

use App\Database;
use PDO;

class ExerciseRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::pdo();
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query(
            "SELECT id, name, muscle_group
             FROM exercises
             ORDER BY name ASC"
        );

        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            "SELECT id, name, muscle_group FROM exercises WHERE id = :id"
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch() ?: null;
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
        $stmt = $this->pdo->prepare(
            "DELETE FROM exercises WHERE id = :id"
        );
        $stmt->execute([':id' => $id]);
    }

}
