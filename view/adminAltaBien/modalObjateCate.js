 const monthSelect = document.getElementById('monthSelect');
  const daySelect = document.getElementById('daySelect');
  const yearSelect = document.getElementById('yearSelect');

  // Generar años desde 2000 hasta 2100
  const startYear = 2000;
  const endYear = 2100;
  for(let year = startYear; year <= endYear; year++){
    const option = document.createElement('option');
    option.value = year;
    option.textContent = year;
    yearSelect.appendChild(option);
  }

  // Función para calcular días del mes (considera años bisiestos)
  function daysInMonth(year, month) {
    return new Date(year, month, 0).getDate();
  }

  // Actualizar días según mes y año
  function updateDays() {
    const year = parseInt(yearSelect.value);
    const month = parseInt(monthSelect.value);

    if (!month || !year) {
      // Si no hay año o mes, poner días del mes 31 por defecto
      fillDays(31);
      return;
    }

    const days = daysInMonth(year, month);
    fillDays(days);
  }

  // Llena el select de días
  function fillDays(days) {
    const selectedDay = parseInt(daySelect.value);
    daySelect.innerHTML = '<option value="">Dia</option>'; // reset

    for(let i = 1; i <= days; i++) {
      const option = document.createElement('option');
      option.value = i;
      option.textContent = i;
      if(i === selectedDay) option.selected = true;
      daySelect.appendChild(option);
    }
  }

  // Eventos para actualizar días cuando cambie mes o año
  monthSelect.addEventListener('change', updateDays);
  yearSelect.addEventListener('change', updateDays);

  // Inicializar días al cargar la página
  // Si hay mes y año seleccionados, tomarlos, sino día 31 por defecto
  window.onload = () => {
    if(!yearSelect.value) yearSelect.value = 2024; // ejemplo valor por defecto
    updateDays();
  }

    // Obtener la fecha actual
    var fecha = new Date();
    var opcionesFecha = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    };
    var fechaFormateada = fecha.toLocaleDateString('es-ES', opcionesFecha);

    // Actualizar el contenido del elemento con el id "fecha"
    document.getElementById('lbltituloObjcate').innerHTML += fechaFormateada;
    