<!doctype html>
<html lang="nl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <h1 class="h3 mb-0">Dashboard</h1>
      <div class="text-muted">
        Welkom<?= isset($user['name']) ? ', ' . htmlspecialchars($user['name']) : '' ?>!
      </div>
    </div>

    <a class="btn btn-primary" href="/workouts/create">+ Nieuwe workout</a>
  </div>

  <!-- Workouts overzicht -->
  <h2 class="h5 mt-4">Mijn workouts</h2>

  <?php if (empty($workouts)): ?>
    <div class="alert alert-info">
      Je hebt nog geen workouts. Klik op <strong>“Nieuwe workout”</strong> om te starten.
    </div>
  <?php else: ?>
    <div class="list-group">
      <?php foreach ($workouts as $w): ?>
        <a class="list-group-item list-group-item-action"
           href="/workouts/<?= (int)$w['id'] ?>">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <div class="fw-semibold">
                <?= htmlspecialchars($w['name']) ?>
              </div>
              <div class="text-muted small">
                Aangemaakt: <?= htmlspecialchars($w['created_at']) ?>
              </div>
            </div>

            <div class="text-end">
              <div class="fw-semibold">
                <?= htmlspecialchars($w['date']) ?>
              </div>
              <div class="text-muted small">
                #<?= (int)$w['id'] ?>
              </div>
            </div>

          </div>
        </a>
      <?php endforeach; ?>
      
      <?php if (!empty($workouts)): ?>
          <div class="mt-3">
            <a class="btn btn-outline-primary w-100" href="/workouts">
              Bekijk alle workouts
            </a>
          </div>
        <?php endif; ?>
    </div>
  <?php endif; ?>

  <hr class="my-4">

  <!-- Logout -->
  <form method="post" action="/logout">
    <button class="btn btn-outline-danger" type="submit">Uitloggen</button>
  </form>

</body>
</html>
