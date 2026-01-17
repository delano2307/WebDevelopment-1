<!doctype html>
<html lang="nl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .dashboard-fixed-card {
        height: 520px; 
      }

      .exercise-scroll {
        height: 360px;         
        overflow-y: auto;
        overflow-x: hidden;
      }

      .chart-wrap {
        height: 360px;
      }
    </style>
  </head>

  <body class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h1 class="h3 mb-0">Dashboard</h1>
        <div class="text-muted">
          Welkom<?= isset($user->name) ? ', ' . htmlspecialchars($user->name) : '' ?>!
        </div>
      </div>

      <div class="d-flex gap-2">
        <form method="post" action="/logout">
          <button class="btn btn-outline-danger" type="submit">Uitloggen</button>
        </form>
      </div>
    </div>

    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <h2 class="h5 mb-0">Mijn workouts</h2>
        </div>

        <?php if (empty($workouts)): ?>
          <div class="alert alert-info mb-0">
            Je hebt nog geen workouts. Klik op <strong>“Nieuwe workout”</strong> om te starten.
          </div>
          <a class="btn btn-primary w-100 mt-3" href="/workouts/create">
              Nieuwe workout
            </a>
        <?php else: ?>
          <div class="list-group list-group-flush">
            <?php foreach ($workouts as $w): ?>
              <a class="list-group-item list-group-item-action px-0"
                href="/workouts/<?= (int)$w->id ?>">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <div class="fw-semibold"><?= htmlspecialchars($w->name) ?></div>
                    <div class="text-muted small">
                      Aangemaakt: <?= htmlspecialchars($w->createdAt) ?>
                    </div>
                  </div>
                  <div class="fw-semibold"><?= htmlspecialchars($w->date) ?></div>
                </div>
              </a>
            <?php endforeach; ?>
          </div>

          <div class="mt-3 d-flex gap-2">
            <a class="btn btn-outline-primary w-100" href="/workouts">
              Bekijk alle workouts
            </a>
            <a class="btn btn-primary w-100" href="/workouts/create">
              Nieuwe workout
            </a>
          </div>

        <?php endif; ?>
      </div>
    </div>

    <div class="row g-4">

      <div class="col-12 col-lg-6">
        <div class="card dashboard-fixed-card">
          <div class="card-body d-flex flex-column">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h2 class="h5 mb-0">Oefeningen</h2>
            </div>

            <?php if (empty($exercises)): ?>
              <div class="alert alert-info mb-0">Nog geen oefeningen.</div>
            <?php else: ?>

              <div class="exercise-scroll border rounded">
                <table class="table table-sm table-striped align-middle mb-0">
                  <thead class="table-light" style="position: sticky; top: 0; z-index: 1;">
                    <tr>
                      <th>Naam</th>
                      <th>Spiergroep</th>
                      <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
                        <th class="text-end">Acties</th>
                      <?php endif; ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($exercises as $e): ?>
                      <tr>
                        <td><?= htmlspecialchars($e->name) ?></td>
                        <td><?= htmlspecialchars($e->muscleGroup ?? '') ?></td>

                        <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
                          <td class="text-end">
                            <a class="btn btn-sm btn-outline-primary"
                              href="/exercises/<?= (int)$e->id ?>/edit">Bewerk</a>

                            <form method="post"
                                  action="/exercises/<?= (int)$e->id ?>/delete"
                                  class="d-inline"
                                  onsubmit="return confirm('Weet je zeker dat je deze oefening wilt verwijderen?');">
                              <button class="btn btn-sm btn-outline-danger" type="submit">Verwijder</button>
                            </form>
                          </td>
                        <?php endif; ?>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>

              <div class="mt-3">
                <a class="btn btn-outline-primary w-100" href="/exercises">Bekijk alle oefeningen</a>
              </div>

            <?php endif; ?>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-6">
        <div class="card dashboard-fixed-card">
          <div class="card-body d-flex flex-column">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h2 class="h5 mb-0">Progressie</h2>
              <span class="text-muted small">Snelle blik</span>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-2">
              <div class="text-muted small">
                Laatste oefening:
                <strong>
                  <?= $lastExercise ? htmlspecialchars($lastExercise->name) : '-' ?>
                </strong>
                <?php if ($lastExercise && !empty($lastExercise->muscleGroup)): ?>
                  <span class="text-muted"> (<?= htmlspecialchars($lastExercise->muscleGroup) ?>)</span>
                <?php endif; ?>
              </div>
            </div>

            <div class="chart-wrap position-relative border rounded p-2">
              <div id="dashboardProgressEmpty" class="text-muted small d-none text-center py-4">
                Nog geen progressie beschikbaar. Log eerst een set.
              </div>

              <canvas
                id="dashboardProgressChart"
                data-last-exercise-id="<?= (int)($lastExerciseId ?? 0) ?>"
                style="width: 100%; height: 100%;">
              </canvas>
            </div>

            <div class="mt-3">
              <a class="btn btn-outline-secondary w-100" href="/progress">
                Ga naar progressie →
              </a>
            </div>
          </div>
        </div>
      </div>

    </div>

    <hr class="my-4">

    

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/js/dashboardProgress.js"></script>

  </body>
</html>
