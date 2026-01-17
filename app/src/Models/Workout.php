<?php

namespace App\Models;

class Workout
{
    public ?int $id = null;
    public int $userId;
    public string $name;
    public string $date;
    public ?string $createdAt = null;
}
