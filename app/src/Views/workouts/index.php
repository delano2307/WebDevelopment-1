<!doctype html>
<html lang="nl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mijn workouts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  
  <body class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
      <h1 class="h3 mb-0">Mijn workouts</h1>
      <a class="btn btn-primary" href="/workouts/create">+ Nieuwe workout</a>
    </div>

    <div class="mb-3">
      <a class="btn btn-outline-secondary btn-sm" href="/dashboard">← Dashboard</a>
    </div>

    <?php if (empty($workouts)): ?>
      <div class="alert alert-info">Nog geen workouts. Maak je eerste workout aan.</div>
    <?php else: ?>
      <div class="list-group">
        <?php foreach ($workouts as $w): ?>
          <a class="list-group-item list-group-item-action"
            href="/workouts/<?= (int)$w->id ?>">
            <div class="d-flex justify-content-between">
              <strong><?= htmlspecialchars($w->name) ?></strong>
              <div class="text-muted"><?= htmlspecialchars($w->date) ?></div>
            </div>
            <small class="text-muted">Aangemaakt: <?= htmlspecialchars($w->createdAt) ?></small>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <hr class="my-4">

    <form method="post" action="/logout">
      <button class="btn btn-outline-danger" type="submit">Uitloggen</button>
    </form>

  </body>
</html>
