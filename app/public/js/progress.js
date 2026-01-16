const select = document.getElementById('exerciseSelect');
const tbody = document.getElementById('progressTbody');
const chartCanvas = document.getElementById('progressChart');

let chart = null;

select.addEventListener('change', () => {
  loadProgress(select.value);
});

async function loadProgress(exerciseId) {
  tbody.innerHTML = `<tr><td colspan="2">Laden...</td></tr>`;

  const res = await fetch(`/api/progress?exercise_id=${encodeURIComponent(exerciseId)}`);
  const data = await res.json();

  if (!res.ok) {
    tbody.innerHTML = `<tr><td colspan="2">${data.error ?? 'Error'}</td></tr>`;
    if (chart) chart.destroy();
    chart = null;
    return;
  }

  // Tabel vullen
  tbody.innerHTML = '';
  if (data.length === 0) {
    tbody.innerHTML = `<tr><td colspan="2">Nog geen data voor deze oefening.</td></tr>`;
  } else {
    for (const row of data) {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${row.date}</td>
        <td>${row.max_weight}</td>
      `;
      tbody.appendChild(tr);
    }
  }

  // Grafiek tekenen
  drawChart(data);
}

function drawChart(data) {
  const labels = data.map(r => r.date);
  const values = data.map(r => Number(r.max_weight));

  if (chart) chart.destroy();

  chart = new Chart(chartCanvas, {
    type: 'line',
    data: {
      labels,
      datasets: [{
        label: 'Max gewicht (kg)',
        data: values
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false
    }
  });
}

// initial load
loadProgress(select.value);
