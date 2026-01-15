<!doctype html>
<html lang="nl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
  <h1>Dashboard</h1>
  <p>Welkom, <?= htmlspecialchars($user['name']) ?>!</p>
  <p><strong>Role:</strong> <?= htmlspecialchars($user['role']) ?></p>

  <form method="post" action="/logout">
    <button class="btn btn-outline-danger" type="submit">Uitloggen</button>
  </form>
</body>
</html>
