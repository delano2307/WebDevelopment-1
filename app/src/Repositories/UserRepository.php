<?php

namespace App\Repositories;

use App\Database;
use PDO;

class UserRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::pdo();
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    public function create(string $name, string $email, string $passwordHash): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO users (name, email, password_hash, role) VALUES (:name, :email, :password_hash, :role)');

        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password_hash' => $passwordHash,
            'role' => 'user',
        ]);
        
        return (int)$this->pdo->lastInsertId();
    }
    
}
