<!doctype html>
<html lang="nl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Set bewerken</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <h1 class="h3 mb-0">Set bewerken</h1>
      <div class="text-muted">Workout #<?= (int)$set['workout_id'] ?></div>
    </div>
    <a class="btn btn-outline-secondary" href="/workouts/<?= (int)$set['workout_id'] ?>">← Terug</a>
  </div>

  <form class="card p-3" method="post" action="/sets/<?= (int)$set['id'] ?>/update">
    <div class="mb-3">
      <label class="form-label">Oefening</label>
      <select class="form-select" name="exercise_id" required>
        <?php foreach ($exercises as $ex): ?>
          <option value="<?= (int)$ex['id'] ?>" <?= ((int)$ex['id'] === (int)$set['exercise_id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($ex['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="row g-2">
      <div class="col-6">
        <label class="form-label">Reps</label>
        <input class="form-control" type="number" name="reps" min="1" max="200"
               value="<?= (int)$set['reps'] ?>" required>
      </div>

      <div class="col-6">
        <label class="form-label">Gewicht (kg)</label>
        <input class="form-control" type="number" step="0.5" name="weight" min="0" max="999.99"
               value="<?= htmlspecialchars((string)$set['weight']) ?>" required>
      </div>
    </div>

    <div class="mt-3 d-flex gap-2">
      <button class="btn btn-primary" type="submit">Opslaan</button>
      <a class="btn btn-outline-secondary" href="/workouts/<?= (int)$set['workout_id'] ?>">Annuleren</a>
    </div>
  </form>

</body>
</html>
