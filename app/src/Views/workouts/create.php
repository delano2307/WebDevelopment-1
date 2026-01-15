<!doctype html>
<html lang="nl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Nieuwe workout</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

  <h1 class="h3">Nieuwe workout</h1>
  <p class="text-muted">Kies een datum en start je workout. Daarna voeg je sets toe.</p>

  <form class="card p-3" method="post" action="/workouts">
    <div class="mb-3">
        <label class="form-label" for="name">Workout naam</label>
        <input
            class="form-control"
            type="text"
            id="name"
            name="name"
            maxlength="100"
            placeholder="Bijv. Push Day, Leg Day..."
            required
        >
    </div>

    <div class="mb-3">
      <label class="form-label" for="date">Datum</label>
      <input class="form-control" type="date" id="date" name="date" value="<?= htmlspecialchars($today) ?>" required>
    </div>

    <div class="d-flex gap-2">
      <button class="btn btn-primary" type="submit">Workout starten</button>
      <a class="btn btn-outline-secondary" href="/workouts">Annuleren</a>
    </div>
  </form>

</body>
</html>
