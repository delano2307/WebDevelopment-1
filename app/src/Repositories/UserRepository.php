<?php

namespace App\Repositories;

use App\Database;
use App\Models\User;
use PDO;

class UserRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::pdo();
    }

    public function findByEmail(string $email): ?User
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();

        if (!$row) return null;

        $u = new User();
        $u->id = (int)$row['id'];
        $u->name = (string)$row['name'];
        $u->email = (string)$row['email'];
        $u->passwordHash = isset($row['password_hash']) ? (string)$row['password_hash'] : null;
        $u->role = (string)$row['role'];
        $u->createdAt = isset($row['created_at']) ? (string)$row['created_at'] : null;

        return $u;
    }

    public function findById(int $id): ?User
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        if (!$row) return null;

        $u = new User();
        $u->id = (int)$row['id'];
        $u->name = (string)$row['name'];
        $u->email = (string)$row['email'];
        $u->passwordHash = isset($row['password_hash']) ? (string)$row['password_hash'] : null;
        $u->role = (string)$row['role'];
        $u->createdAt = isset($row['created_at']) ? (string)$row['created_at'] : null;

        return $u;
    }

    public function create(string $name, string $email, string $passwordHash): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO users (name, email, password_hash, role) VALUES (:name, :email, :password_hash, :role)'
        );

        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password_hash' => $passwordHash,
            'role' => 'user',
        ]);

        return (int)$this->pdo->lastInsertId();
    }
}
