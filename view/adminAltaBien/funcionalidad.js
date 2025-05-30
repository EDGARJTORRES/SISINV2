function avanzarPaso(pasoActual) {
  const pasoForm = document.getElementById(`step-${pasoActual}`);
  const campos = pasoForm.querySelectorAll('.required');
  let esValido = true;

  campos.forEach(campo => {
    if (!campo.value || campo.value.trim() === "") {
      campo.classList.add("is-invalid");
      esValido = false;
    } else {
      campo.classList.remove("is-invalid");
    }
  });

  if (esValido) {
    // Ocultar paso actual
    pasoForm.classList.add("d-none");

    // Mostrar siguiente paso
    const siguiente = document.getElementById(`step-${pasoActual + 1}`);
    if (siguiente) siguiente.classList.remove("d-none");

    // Actualizar indicadores
    document.getElementById(`step-indicator-${pasoActual}`).classList.remove("active");
    document.getElementById(`step-indicator-${pasoActual + 1}`).classList.add("active");
  }
}

function retrocederPaso(pasoActual) {
  const pasoForm = document.getElementById(`step-${pasoActual}`);
  const anterior = document.getElementById(`step-${pasoActual - 1}`);

  if (pasoForm && anterior) {
    pasoForm.classList.add("d-none");
    anterior.classList.remove("d-none");

    document.getElementById(`step-indicator-${pasoActual}`).classList.remove("active");
    document.getElementById(`step-indicator-${pasoActual - 1}`).classList.add("active");
  }
}