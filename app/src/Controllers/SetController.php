<?php

namespace App\Controllers;

use App\Repositories\SetRepository;
use App\Repositories\WorkoutRepository;
use App\Repositories\ExerciseRepository;

class SetController
{
    private SetRepository $sets;
    private WorkoutRepository $workouts;
    private ExerciseRepository $exercises;

    public function __construct()
    {
        $this->sets = new SetRepository();
        $this->workouts = new WorkoutRepository();
        $this->exercises = new ExerciseRepository();
    }

    /**
     * POST /sets
     * Voeg één of meerdere sets toe (met ownership check).
     */
    public function store(): void
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $workoutId  = (int)($_POST['workout_id'] ?? 0);
        $exerciseId = (int)($_POST['exercise_id'] ?? 0);

        // Kan single zijn (string) of multi (array)
        $repsInput   = $_POST['reps'] ?? [];
        $weightInput = $_POST['weight'] ?? [];

        // Maak er altijd arrays van (werkt ook als je nog single inputs hebt)
        $repsArr   = is_array($repsInput) ? $repsInput : [$repsInput];
        $weightArr = is_array($weightInput) ? $weightInput : [$weightInput];

        if ($workoutId <= 0 || $exerciseId <= 0) {
            http_response_code(400);
            echo "Workout of oefening ontbreekt.";
            return;
        }

        // Ownership check: workout moet van user zijn
        $workout = $this->workouts->findById($workoutId);
        if (!$workout) {
            http_response_code(404);
            echo "Workout niet gevonden.";
            return;
        }

        if ((int)$workout->userId !== (int)$_SESSION['user_id']) {
            http_response_code(403);
            echo "Geen toegang.";
            return;
        }

        $createdCount = 0;

        // Loop over alle rijen
        $max = max(count($repsArr), count($weightArr));
        for ($i = 0; $i < $max; $i++) {

            $repsRaw = trim((string)($repsArr[$i] ?? ''));
            $wRaw    = trim((string)($weightArr[$i] ?? ''));

            // Lege rij? skip (handig als user extra rij toevoegt en leeg laat)
            if ($repsRaw === '' || $wRaw === '') {
                continue;
            }

            // Reps validatie
            if (!ctype_digit($repsRaw)) {
                http_response_code(400);
                echo "Reps moeten een heel getal zijn.";
                return;
            }

            $reps = (int)$repsRaw;
            if ($reps <= 0 || $reps > 200) {
                http_response_code(400);
                echo "Reps moeten tussen 1 en 200 zijn.";
                return;
            }

            // Gewicht validatie (komma -> punt voor NL invoer)
            $wRaw = str_replace(',', '.', $wRaw);

            if (!is_numeric($wRaw)) {
                http_response_code(400);
                echo "Gewicht is ongeldig.";
                return;
            }

            $weight = (float)$wRaw;
            if ($weight < 0 || $weight > 999.99) {
                http_response_code(400);
                echo "Gewicht buiten bereik.";
                return;
            }

            // Opslaan
            $this->sets->create($workoutId, $exerciseId, $reps, $weight);
            $createdCount++;
        }

        if ($createdCount === 0) {
            http_response_code(400);
            echo "Geen geldige sets om op te slaan.";
            return;
        }

        header("Location: /workouts/{$workoutId}");
        exit;
    }


    /**
     * GET /sets/{id}/edit
     * Toon edit-form voor één set.
     */
    public function edit(array $vars): string
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $setId = (int)($vars['id'] ?? 0);
        if ($setId <= 0) {
            http_response_code(400);
            echo "Set ID ontbreekt.";
            exit;
        }

        $set = $this->sets->findById($setId);
        if (!$set) {
            http_response_code(404);
            echo "Set niet gevonden.";
            exit;
        }

        // Ownership check via workout
        $workout = $this->workouts->findById((int)$set->workoutId);
        if (!$workout || (int)$workout->userId !== (int)$_SESSION['user_id']) {
            http_response_code(403);
            echo "Geen toegang.";
            exit;
        }

        $exercises = $this->exercises->findAll();

        ob_start();
        require __DIR__ . '/../Views/sets/edit.php';
        return ob_get_clean();
    }

    /**
     * POST /sets/{id}/update
     * Verwerk edit-form.
     */
    public function update(array $vars): void
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $setId = (int)($vars['id'] ?? 0);
        if ($setId <= 0) {
            http_response_code(400);
            echo "Set ID ontbreekt.";
            return;
        }

        $set = $this->sets->findById($setId);
        if (!$set) {
            http_response_code(404);
            echo "Set niet gevonden.";
            return;
        }

        // Ownership check via workout
        $workout = $this->workouts->findById((int)$set->workoutId);
        if (!$workout || (int)$workout->userId !== (int)$_SESSION['user_id']) {
            http_response_code(403);
            echo "Geen toegang.";
            return;
        }

        $exerciseId = (int)($_POST['exercise_id'] ?? 0);
        $reps       = (int)($_POST['reps'] ?? 0);
        $weightRaw  = $_POST['weight'] ?? null;

        if ($exerciseId <= 0) {
            http_response_code(400);
            echo "Oefening ontbreekt.";
            return;
        }
        if ($reps <= 0 || $reps > 200) {
            http_response_code(400);
            echo "Reps moeten tussen 1 en 200 zijn.";
            return;
        }
        if ($weightRaw === null || !is_numeric($weightRaw)) {
            http_response_code(400);
            echo "Gewicht is ongeldig.";
            return;
        }

        $weight = (float)$weightRaw;
        if ($weight < 0 || $weight > 999.99) {
            http_response_code(400);
            echo "Gewicht buiten bereik.";
            return;
        }

        $this->sets->update($setId, $exerciseId, $reps, $weight);

        header("Location: /workouts/" . (int)$set->workoutId);
        exit;
    }

    /**
     * POST /sets/{id}/delete
     * Verwijder set (met ownership check).
     */
    public function delete(array $vars): void
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $setId = (int)($vars['id'] ?? 0);
        if ($setId <= 0) {
            http_response_code(400);
            echo "Set ID ontbreekt.";
            return;
        }

        $set = $this->sets->findById($setId);
        if (!$set) {
            http_response_code(404);
            echo "Set niet gevonden.";
            return;
        }

        $workout = $this->workouts->findById((int)$set->workoutId);
        if (!$workout || (int)$workout->userId !== (int)$_SESSION['user_id']) {
            http_response_code(403);
            echo "Geen toegang.";
            return;
        }

        $workoutId = (int)$set->workoutId;

        $this->sets->delete($setId);

        header("Location: /workouts/{$workoutId}");
        exit;
    }
}
