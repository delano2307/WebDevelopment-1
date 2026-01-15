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
            "SELECT id, name
             FROM exercises
             ORDER BY name ASC"
        );

        return $stmt->fetchAll();
    }
}
