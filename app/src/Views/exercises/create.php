<!doctype html>
<html lang="nl">
  <head>
    <meta charset="utf-8">
    <title>Nieuwe oefening</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  
  <body class="container py-4">

    <h1 class="h3 mb-3">Nieuwe oefening</h1>

    <a class="btn btn-outline-secondary mb-3" href="/exercises">← Terug</a>

    <?php if ($error): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="/exercises" class="card card-body">
      <div class="mb-3">
        <label class="form-label">Naam</label>
        <input class="form-control" name="name" required
              value="<?= htmlspecialchars($old['name']) ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Spiergroep</label>
        <input class="form-control" name="muscle_group"
              value="<?= htmlspecialchars($old['muscle_group']) ?>">
      </div>

      <button class="btn btn-primary">Opslaan</button>
    </form>

  </body>
</html>
