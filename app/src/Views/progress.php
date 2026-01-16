<!doctype html>
<html lang="nl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Progressie</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Chart.js (CDN) -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    .chart-wrap{
        position: relative;
        height: 320px;      /* kies wat je mooi vindt: 250-400 */
        width: 100%;
    }
    .chart-wrap canvas{
        width: 100% !important;
        height: 100% !important;
        display: block;
    }
  </style>

</head>

<body class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Mijn progressie</h1>
    <a class="btn btn-outline-primary" href="/dashboard">Terug</a>
  </div>

  <div class="card mb-3">
    <div class="card-body">
      <label class="form-label" for="exerciseSelect">Kies oefening</label>
      <select id="exerciseSelect" class="form-select">
        <?php foreach ($exercises as $e): ?>
          <option value="<?= (int)$e['id'] ?>">
            <?= htmlspecialchars($e['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
      <div class="form-text">Wij werken met max gewicht per datum.</div>
    </div>
  </div>

  <div class="row g-3">
    <div class="col-12 col-lg-6">
      <div class="card">
        <div class="card-body">
          <h2 class="h5">Tabel</h2>
          <div class="table-responsive">
            <table class="table table-striped align-middle mb-0">
              <thead>
                <tr>
                  <th>Datum</th>
                  <th>Max gewicht (kg)</th>
                </tr>
              </thead>
              <tbody id="progressTbody"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-6">
      <div class="card">
        <div class="card-body">
          <h2 class="h5">Grafiek</h2>
            <div class="chart-wrap">
                <canvas id="progressChart"></canvas>
            </div>
        </div>
      </div>
    </div>
  </div>

  <script src="/js/progress.js"></script>
</body>
</html>
