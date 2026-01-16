<!doctype html>
<html lang="nl">
<head>
  <meta charset="utf-8">
  <title>Oefeningen</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h3 mb-0">Oefeningen</h1>

  <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
    <a class="btn btn-primary" href="/exercises/create">+ Nieuwe oefening</a>
  <?php endif; ?>
</div>

<a class="btn btn-outline-secondary mb-3" href="/dashboard">← Dashboard</a>

<?php if (empty($exercises)): ?>
  <div class="alert alert-info">Nog geen oefeningen.</div>
<?php else: ?>
  <table class="table table-striped align-middle">
    <thead>
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
          <td><?= htmlspecialchars($e['name']) ?></td>
          <td><?= htmlspecialchars($e['muscle_group'] ?? '') ?></td>

          <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
            <td class="text-end">
              <a class="btn btn-sm btn-outline-primary"
                 href="/exercises/<?= (int)$e['id'] ?>/edit">Bewerk</a>

              <form method="post"
                    action="/exercises/<?= (int)$e['id'] ?>/delete"
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
<?php endif; ?>

</body>
</html>
