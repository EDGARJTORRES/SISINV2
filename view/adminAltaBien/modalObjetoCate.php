<style>
    #lock {
        display: none;
    }

    .lock-label {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgb(80, 80, 80);
        border-radius: 15px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .lock-wrapper {
        width: fit-content;
        height: fit-content;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transform: rotate(-10deg);
    }

    .shackle {
        background-color: transparent;
        height: 9px;
        width: 14px;
        border-top-right-radius: 10px;
        border-top-left-radius: 10px;
        border-top: 3px solid white;
        border-left: 3px solid white;
        border-right: 3px solid white;
        transition: all 0.3s;
    }

    .lock-body {
        width: 15px;
    }

    #lock:checked+.lock-label .lock-wrapper .shackle {
        transform: rotateY(150deg) translateX(3px);
        transform-origin: right;
    }

    #lock:checked+.lock-label {
        background-color: rgb(167, 71, 245);
    }

    .lock-label:active {
        transform: scale(0.9);
    }
</style>


<div class="modal modal-blur fade" id="modalObjetoCate" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 80%; margin: auto;">
        <div class="modal-content">
            <div class="modal-header">
                <h5  id="lbltituloObjcate" class="modal-title" style="color: #004085; display: flex; align-items: center; gap: 10px; background-color: rgb(247, 249, 250); padding: 8px 8px; border-left: 5px solid #17a2b8; border-radius: 6px; width:100%;">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-screen-share ms-3"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M21 12v3a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1v-10a1 1 0 0 1 1 -1h9" /><path d="M7 20l10 0" /><path d="M9 16l0 4" /><path d="M15 16l0 4" /><path d="M17 4h4v4" /><path d="M16 9l5 -5" /></svg>
                      Nuevo Registro
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post"  id="bien_form">
                <div class="modal-body">
                    <input type="hidden" name="bien_id" id="bien_id" />
                    <input type="hidden" name="obj_id" id="obj_id" />
                    <div class="container">
                        <div class="card mb-3 p-3">
                            <div class="row">
                                <h3 class="card-title">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-category-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4h6v6h-6zm10 0h6v6h-6zm-10 10h6v6h-6zm10 3h6m-3 -3v6" /></svg>
                                        Clasificación del Bien
                                </h3>
                            </div>                             
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label" id="gg_text">Grupo Generico:<span style="color:red"> *</span></label>
                                        <select class="form-select select2" id="combo_gg_bien_obj" name="combo_gg_bien_obj" data-placeholder="Seleccione Grupo" style="width: 100%;">
                                            <option value="" disabled selected>Seleccione</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label"  id="clase_text" >Clase:<span  style="color:red"> *</span></label>
                                        <select class="form-select select2" id="combo_clase_bien_obj" name="combo_clase_bien_obj" data-placeholder="Seleccione Clase" style="width: 100%;">
                                            <option value="" disabled selected>Seleccione</option>
                                        
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label" id="obj_text">Objeto:<span  style="color:red"> *</span></label>
                                        <select class="form-select select2" id="combo_obj_bien" name="combo_obj_bien" data-placeholder="Seleccione objeto" style="width: 100%;">
                                            <option value="" disabled selected>Seleccione</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3 p-3">
                            <div class="row">
                                <h3 class="card-title">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-object-scan"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 8v-2a2 2 0 0 1 2 -2h2" /><path d="M4 16v2a2 2 0 0 0 2 2h2" /><path d="M16 4h2a2 2 0 0 1 2 2v2" /><path d="M16 20h2a2 2 0 0 0 2 -2v-2" /><path d="M8 8m0 2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-4a2 2 0 0 1 -2 -2z" /></svg>
                                    Identificación Técnica
                                </h3>
                            </div> 
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label">Marca:<span  style="color:red"> *</span></label>
                                        <select class="form-select select2" id="combo_marca_obj" name="combo_marca_obj"  data-placeholder="Seleccione Marca" style="width: 100%;">
                                            <option value="" disabled selected>Seleccione</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label">Modelo:<span  style="color:red"> *</span></label>
                                        <select class="form-select select2" id="combo_modelo_obj" name="combo_modelo_obj" data-placeholder="Seleccione Modelo" style="width: 100%;">
                                            <option value="" disabled selected>Seleccione</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label">Dimensiones:<span  style="color:red"> *</span></label>
                                        <input type="text" class="form-control" id="obj_dim" name="obj_dim">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label">N° Serie:<span  style="color:red"> *</span></label>
                                        <input type="text" class="form-control" id="bien_numserie" name="bien_numserie">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3 p-3">
                            <div class="row">
                                <h3 class="card-title">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                    Características Visuales
                                </h3>
                            </div> 
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="mb-3">
                                        <label class="form-label">Fecha de Registro:<span  style="color:red"> *</span></label>
                                        <input type="date" class="form-control" id="fecha_registro" name="fecha_registro" value="<?php echo date('Y-m-d'); ?>" required>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label">Color:<span style="color:red"> *</span></label>
                                        <div class="form-group">
                                            <select class="form-control select2" style="width: 100%" data-placeholder="Color" id="combo_color_bien" name="combo_color_bien" multiple required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Codigo Interno:<span  style="color:red"> *</span></label>
                                        <input type="text" class="form-control" disabled="" id="cod_interno" name="cod_interno" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3 p-3">
                            <div class="row">
                                <h3 class="card-title">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-library"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 3m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" /><path d="M4.012 7.26a2.005 2.005 0 0 0 -1.012 1.737v10c0 1.1 .9 2 2 2h10c.75 0 1.158 -.385 1.5 -1" /><path d="M11 7h5" /><path d="M11 10h6" /><path d="M11 13h3" /></svg>
                                    Información de Registro	
                                </h3>
                            </div> 
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Muestra de barra:<span  style="color:red"> *</span></label>
                                        <div>
                                            <canvas id="codigo_barras_canvas" style="border: 1px solid #ccc;"></canvas>
                                        </div>  
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Codigo Generado:<span  style="color:red"> *</span></label>
                                        <input type="text" class="form-control" id="codigo_barras_input"  name="codigo_barras_input" disabled="" >
                                    </div>
                                </div>
                            </div> 
                        </div>         
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="action" value="add" class="btn btn-primary ">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-checks"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12l5 5l10 -10" /><path d="M2 12l5 5m5 -5l5 -5" /></svg>
                        Guardar
                    </button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                        Cancelar
                   </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
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
</script>
