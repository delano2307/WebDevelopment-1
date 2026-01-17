<!doctype html>
<html lang="nl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Workout bewerken</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Workout bewerken</h1>
    <a class="btn btn-outline-secondary" href="/workouts/<?= (int)$workout->id ?>">← Terug</a>
  </div>

  <form class="card p-3"
        method="post"
        action="/workouts/<?= (int)$workout->id ?>/update">

    <div class="mb-3">
      <label class="form-label">Workout naam</label>
      <input class="form-control"
             type="text"
             name="name"
             maxlength="100"
             value="<?= htmlspecialchars($workout->name) ?>"
             required>
    </div>

    <div class="mb-3">
      <label class="form-label">Datum</label>
      <input class="form-control"
             type="date"
             name="date"
             value="<?= htmlspecialchars($workout->date) ?>"
             required>
    </div>

    <div class="d-flex gap-2">
      <button class="btn btn-primary" type="submit">Opslaan</button>
      <a class="btn btn-outline-secondary" href="/workouts/<?= (int)$workout->id ?>">Annuleren</a>
    </div>
  </form>

</body>
</html>
