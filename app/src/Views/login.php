<!doctype html>
<html lang="nl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  
  <body class="container py-4">
    <h1 class="mb-3">Login</h1>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="/login" class="d-grid gap-2" style="max-width: 420px;">
      <div>
        <label class="form-label" for="email">E-mail</label>
        <input class="form-control" id="email" name="email" type="email" required>
      </div>
      <div>
        <label class="form-label" for="password">Wachtwoord</label>
        <input class="form-control" id="password" name="password" type="password" required>
      </div>
      <button class="btn btn-primary" type="submit">Inloggen</button>
    </form>

    <p class="mt-3">Nog geen account? <a href="/register">Registreren</a></p>
  </body>
</html>
 