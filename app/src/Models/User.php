<?php

namespace App\Models;

class User
{
    public ?int $id = null;
    public string $name;
    public string $email;
    public ?string $passwordHash = null;
    public string $role = 'user';
    public ?string $createdAt = null;
}
