<!doctype html>
<html lang="nl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Workout detail</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="/js/exerciseFilter.js"></script>
  </head>

  <body class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">

      <div>
        <h1 class="h3 mb-1"><?= htmlspecialchars($workout->name) ?></h1>
        <div class="text-muted">Datum: <?= htmlspecialchars($workout->date) ?></div>
      </div>

      <div class="d-flex align-items-center gap-2">
        <a class="btn btn-outline-primary"
          href="/workouts/<?= (int)$workout->id ?>/edit">
          Workout bewerken
        </a>

        <form method="post"
              action="/workouts/<?= (int)$workout->id ?>/delete"
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


    <div class="card p-3">
      <h2 class="h5">Set toevoegen</h2>

      <?php if (empty($exercises)): ?>
        <div class="alert alert-warning mb-0">
          Er zijn nog geen oefeningen in de database.
          Voeg eerst oefeningen toe aan de tabel <code>exercises</code>.
        </div>
      <?php else: ?>

        <?php
          $muscleGroups = [];
          foreach ($exercises as $ex) {
              $g = trim((string)($ex->muscle_group ?? $ex->muscleGroup ?? ''));
              if ($g === '') $g = 'Overig';
              $muscleGroups[$g] = true;
          }
          $muscleGroups = array_keys($muscleGroups);
          sort($muscleGroups);
        ?>

        <form class="row g-2" method="post" action="/sets">

          <input type="hidden" name="workout_id" value="<?= (int)$workout->id ?>">

          <div class="col-12 col-md-6">
            <label class="form-label" for="muscleGroupFilter">Spiergroep</label>
            <select id="muscleGroupFilter" class="form-select">
              <option value="all">Alle spiergroepen</option>
              <?php foreach ($muscleGroups as $g): ?>
                <option value="<?= htmlspecialchars($g) ?>"><?= htmlspecialchars($g) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label" for="exerciseSelect">Oefening</label>
            <select id="exerciseSelect" class="form-select" name="exercise_id" required>
              <option value="">Kies oefening...</option>
              <?php foreach ($exercises as $ex): ?>
                <?php $g = trim((string)($ex->muscle_group ?? $ex->muscleGroup ?? '')) ?: 'Overig'; ?>
                <option value="<?= (int)$ex->id ?>" data-muscle="<?= htmlspecialchars($g) ?>">
                  <?= htmlspecialchars($ex->name) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-12">
            <label class="form-label mb-2">Sets</label>

            <div class="table-responsive">
              <table class="table table-sm align-middle mb-2" id="setsTable">
                <thead class="table-light">
                  <tr>
                    <th style="width: 35%;">Reps</th>
                    <th style="width: 35%;">Gewicht (kg)</th>
                    <th class="text-end" style="width: 30%;">Actie</th>
                  </tr>
                </thead>
                <tbody id="setsBody">
                  <tr>
                    <td>
                      <input class="form-control" type="number" name="reps[]" min="1" max="200" required>
                    </td>
                    <td>
                      <input class="form-control" type="number" name="weight[]" step="0.5" min="0" max="999.99" required>
                    </td>
                    <td class="text-end">
                      <button type="button" class="btn btn-outline-danger btn-sm remove-row" disabled>Verwijder</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="d-flex gap-2">
              <button type="button" class="btn btn-outline-secondary" id="addSetRow">+ Set toevoegen</button>
              <button class="btn btn-primary" type="submit">Alles opslaan</button>
            </div>
          </div>

        </form>

        <script>
          initExerciseFilter({
            muscleSelectId: "muscleGroupFilter",
            exerciseSelectId: "exerciseSelect",
            optionMuscleAttr: "muscle",
            allValue: "all"
          });

          const setsBody = document.getElementById('setsBody');
          const addBtn = document.getElementById('addSetRow');

          function updateRemoveButtons() {
            const buttons = setsBody.querySelectorAll('.remove-row');
            buttons.forEach((btn, idx) => {
              btn.disabled = (buttons.length === 1); 
            });
          }

          addBtn.addEventListener('click', () => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
              <td><input class="form-control" type="number" name="reps[]" min="1" max="200" required></td>
              <td><input class="form-control" type="number" name="weight[]" step="0.5" min="0" max="999.99" required></td>
              <td class="text-end"><button type="button" class="btn btn-outline-danger btn-sm remove-row">Verwijder</button></td>
            `;
            setsBody.appendChild(tr);
            updateRemoveButtons();
          });

          setsBody.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-row')) {
              e.target.closest('tr').remove();
              updateRemoveButtons();
            }
          });

          updateRemoveButtons();
        </script>


      <?php endif; ?>
    </div>

    <div class="card p-3 mt-4">
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
                  <td><?= htmlspecialchars($s->exerciseName ?? '') ?></td>
                  <td class="text-end"><?= (int)$s->reps ?></td>
                  <td class="text-end"><?= htmlspecialchars((string)$s->weight) ?></td>
                  <td class="text-end">
                    <a class="btn btn-sm btn-outline-primary"
                      href="/sets/<?= (int)$s->id ?>/edit">
                      Bewerk
                    </a>

                    <form class="d-inline"
                          method="post"
                          action="/sets/<?= (int)$s->id ?>/delete"
                          onsubmit="return confirm('Set verwijderen?');">
                      <button class="btn btn-sm btn-outline-danger" type="submit">
                        Verwijder
                      </button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>

  </body>
</html>
