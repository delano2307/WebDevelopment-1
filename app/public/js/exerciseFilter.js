// public/js/exerciseFilter.js

function initExerciseFilter({
  muscleSelectId,
  exerciseSelectId,
  optionMuscleAttr = "muscle",
  allValue = "all"
}) {
  const muscleFilter = document.getElementById(muscleSelectId);
  const exerciseSelect = document.getElementById(exerciseSelectId);
  if (!muscleFilter || !exerciseSelect) return;

  function applyFilter() {
    const selectedGroup = muscleFilter.value;

    for (const opt of exerciseSelect.options) {
      if (opt.value === "") continue; // placeholder
      const optGroup = opt.dataset[optionMuscleAttr] || "Overig";
      const show = (selectedGroup === allValue || optGroup === selectedGroup);

      opt.hidden = !show;
      opt.disabled = !show;
    }

    // Als huidige selectie weg gefilterd is: reset
    const current = exerciseSelect.selectedOptions[0];
    if (current && current.value !== "" && (current.hidden || current.disabled)) {
      exerciseSelect.value = "";
    }
  }

  muscleFilter.addEventListener("change", applyFilter);
  applyFilter();
}

function initExerciseListFilter({
  muscleSelectId,
  rowSelector,
  allValue = "all"
}) {
  const muscleFilter = document.getElementById(muscleSelectId);
  const rows = document.querySelectorAll(rowSelector);
  if (!muscleFilter || !rows.length) return;

  function apply() {
    const selected = muscleFilter.value;

    rows.forEach((r) => {
      const g = r.dataset.muscle || "Overig";
      const show = (selected === allValue || g === selected);
      r.style.display = show ? "" : "none";
    });
  }

  muscleFilter.addEventListener("change", apply);
  apply();
}

// Expose naar je HTML
window.initExerciseFilter = initExerciseFilter;
window.initExerciseListFilter = initExerciseListFilter;
