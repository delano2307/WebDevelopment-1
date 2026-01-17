<?php

namespace App\Models;

class Set
{
    public ?int $id = null;
    public int $workoutId;
    public int $exerciseId;
    public int $reps;
    public float $weight;
    public ?string $exerciseName = null;
}
