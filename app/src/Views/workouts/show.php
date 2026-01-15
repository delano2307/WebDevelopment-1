<!doctype html>
<html lang="nl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Workout detail</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <!-- LINKS: titel + metadata onder elkaar -->
        <div>
            <h1 class="h3 mb-1"><?= htmlspecialchars($workout['name']) ?></h1>
            <div class="text-muted">Datum: <?= htmlspecialchars($workout['date']) ?></div>
            <small class="text-muted">Workout #<?= (int)$workout['id'] ?></small>
        </div>

        <!-- RECHTS: knoppen naast elkaar -->
        <div class="d-flex align-items-center gap-2">
            <a class="btn btn-outline-primary"
                href="/workouts/<?= (int)$workout['id'] ?>/edit">
                Workout bewerken
            </a>

            <form method="post"
                action="/workouts/<?= (int)$workout['id'] ?>/delete"
                onsubmit="return confirm('Weet je zeker dat je deze workout wilt verwijderen? Alle sets worden ook verwijderd.');">
                <button class="btn btn-outline-danger" type="submit">
                    Workout verwijderen
                </button>
            </form>

            <a class="btn btn-outline-secondary" href="/workouts">
                ← Terug
            </a>
        </div>

    </div>



  <!-- Sets overzicht -->
  <div class="card p-3 mb-4">
    <h2 class="h5">Sets</h2>

    <?php if (empty($sets)): ?>
      <div class="alert alert-info mb-0">Nog geen sets toegevoegd.</div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table table-sm align-middle mb-0">
          <thead>
            <tr>
              <th>Oefening</th>
              <th class="text-end">Reps</th>
              <th class="text-end">Gewicht (kg)</th>
              <th class="text-end">Acties</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($sets as $s): ?>
              <tr>
                <td><?= htmlspecialchars($s['exercise_name']) ?></td>
                <td class="text-end"><?= (int)$s['reps'] ?></td>
                <td class="text-end"><?= htmlspecialchars((string)$s['weight']) ?></td>
                <td class="text-end">
                    <a class="btn btn-sm btn-outline-primary" href="/sets/<?= (int)$s['id'] ?>/edit">Bewerk</a>

                    <form class="d-inline"
                            method="post"
                            action="/sets/<?= (int)$s['id'] ?>/delete"
                            onsubmit="return confirm('Set verwijderen?');">
                        <button class="btn btn-sm btn-outline-danger" type="submit">Verwijder</button>
                    </form>
                </td>

              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>

  <!-- Set toevoegen -->
  <div class="card p-3">
    <h2 class="h5">Set toevoegen</h2>

    <?php if (empty($exercises)): ?>
      <div class="alert alert-warning mb-0">
        Er zijn nog geen oefeningen in de database. Voeg eerst oefeningen toe aan de tabel <code>exercises</code>.
      </div>
    <?php else: ?>
      <form class="row g-2" method="post" action="/sets">
        <!-- Verplicht: set koppelen aan juiste workout -->
        <input type="hidden" name="workout_id" value="<?= (int)$workout['id'] ?>">

        <div class="col-12 col-md-6">
          <label class="form-label">Oefening</label>
          <select class="form-select" name="exercise_id" required>
            <option value="">Kies oefening...</option>
            <?php foreach ($exercises as $ex): ?>
              <option value="<?= (int)$ex['id'] ?>"><?= htmlspecialchars($ex['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-6 col-md-3">
          <label class="form-label">Reps</label>
          <input class="form-control" type="number" name="reps" min="1" max="200" required>
        </div>

        <div class="col-6 col-md-3">
          <label class="form-label">Gewicht (kg)</label>
          <input class="form-control" type="number" step="0.5" name="weight" min="0" max="999.99" required>
        </div>

        <div class="col-12">
          <button class="btn btn-primary" type="submit">Toevoegen</button>
        </div>
      </form>
    <?php endif; ?>
  </div>

</body>
</html>
