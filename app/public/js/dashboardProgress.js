
//Haalt progressie op voor de laatst gelogde oefening voor in de grafiek op het dashboard

async function loadDashboardProgress() {
  const canvas = document.getElementById('dashboardProgressChart');
  if (!canvas) return;

  const exerciseId = Number(canvas.dataset.lastExerciseId || 0);
  const emptyEl = document.getElementById('dashboardProgressEmpty');

  if (!exerciseId) {
    if (emptyEl) emptyEl.classList.remove('d-none');
    return;
  }

  try {
    const res = await fetch(`/api/progress?exercise_id=${encodeURIComponent(exerciseId)}`);
    const data = await res.json();

    if (!res.ok) {
      if (emptyEl) {
        emptyEl.textContent = data.error ?? 'Kon progressie niet laden.';
        emptyEl.classList.remove('d-none');
      }
      return;
    }

    if (!Array.isArray(data) || data.length === 0) {
      if (emptyEl) {
        emptyEl.textContent = 'Nog geen progressiedata voor je laatste oefening.';
        emptyEl.classList.remove('d-none');
      }
      return;
    }

    const labels = data.map(r => r.date);
    const values = data.map(r => Number(r.max_weight));

    new Chart(canvas, {
      type: 'line',
      data: {
        labels,
        datasets: [{
          label: 'Max gewicht (kg)',
          data: values,
          tension: 0.25
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false
      }
    });
  } catch (e) {
    console.error(e);
    if (emptyEl) {
      emptyEl.textContent = 'Kon progressie niet laden.';
      emptyEl.classList.remove('d-none');
    }
  }
}

loadDashboardProgress();
