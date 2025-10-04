let dependenciaSeleccionadaId = null;
function mostrarAlertaCarga() {
  document.getElementById('alerta-carga').style.display = 'block';
}

function ocultarAlertaCarga() {
  document.getElementById('alerta-carga').style.display = 'none';
}

document.addEventListener("DOMContentLoaded", function () {
  function obtenerIconoPorDependencia(nombre) {
    const n = nombre.toUpperCase();
    if (n.includes("TURISMO") || n.includes("CULTURA")) return "fa-map-marked-alt";
    if (n.includes("TESORERIA") || n.includes("EGRESO")) return "fa-cash-register";
    if (n.includes("TRANSPORTE") || n.includes("VEHICULO")) return "fa-car";
    if (n.includes("TRÁNSITO") || n.includes("TRANSITO")) return "fa-traffic-light";
    if (n.includes("INFORMACION") || n.includes("TECNOLOGIA")) return "fa-network-wired";
    if (n.includes("REGISTRO CIVIL")) return "fa-id-card";
    if (n.includes("RIESGO") || n.includes("DEFENSA CIVIL")) return "fa-fire-extinguisher";
    if (n.includes("LOGISTICA") || n.includes("ALMACEN") || n.includes("ALMACÉN")) return "fa-boxes";
    if (n.includes("TERMINAL")) return "fa-bus";
    if (n.includes("RECURSOS HUMANOS") || n.includes("ASISTENCIA SOCIAL")) return "fa-users";
    if (n.includes("ESTADISTICA") || n.includes("PRESUPUESTO") || n.includes("GESTIÓN")) return "fa-chart-pie";
    if (n.includes("MANTENIMIENTO") || n.includes("SERVICIOS")) return "fa-tools";
    if (n.includes("OBRA") || n.includes("INFRAESTRUCTURA")) return "fa-hard-hat";
    if (n.includes("EDUCACION") || n.includes("CAPACIDADES")) return "fa-graduation-cap";
    if (n.includes("SEGURIDAD") || n.includes("SERENAZGO") || n.includes("POLICIA")) return "fa-shield-alt";
    if (n.includes("ARCHIVO") || n.includes("DOCUMENTO")) return "fa-archive";
    if (n.includes("FISCALIZACION") || n.includes("CONTROL")) return "fa-search";
    if (n.includes("VIAL") || n.includes("SEÑALIZACION")) return "fa-road";
    if (n.includes("ATENCION") || n.includes("GESTION DOCUMENTARIA")) return "fa-headset";
    if (n.includes("MEDIO AMBIENTE") || n.includes("PARQUE") || n.includes("RESIDUO")) return "fa-leaf";
    if (n.includes("CONTRATACION")) return "fa-file-contract";
    if (n.includes("DEFENSORIA") || n.includes("DISCAPACIDAD") || n.includes("CIAM")) return "fa-hands-helping";
    if (n.includes("TRIBUTACION") || n.includes("RENTAS")) return "fa-receipt";
    return "fa-building";
  }

  fetch("../../controller/dependencia.php?op=listar_cantidad_bienes_por_dependencia")
    .then(response => response.json())
    .then(data => {
      const lista = document.getElementById("lista-items");
      const detalle = document.getElementById("detalle-contenido");
      const mensajeInicial = document.getElementById("mensaje-inicial");
      const subtituloInicial = document.getElementById("subtitulo-inicial");
      let html = "";

      data.forEach(dep => {
        const icono = obtenerIconoPorDependencia(dep.depe_denominacion);
        html += `
          <div class="list-group-item d-flex align-items-start" data-id="${dep.depe_id}">
            <div class="me-3 pt-1">
              <i class="fa-solid ${icono} fa-lg text-primary"></i>
            </div>
            <div class="flex-grow-1">
              <a href="#" class="text-reset d-block fw-semibold text-decoration-none">${dep.depe_denominacion}</a>
              <div class="text-secondary mt-1 small">
                ${dep.cantidad_bienes} bienes registrados
              </div>
            </div>
          </div>`;
      });

      lista.innerHTML = html;

      // Delegar eventos DataTable (como aún no existe)
      let inicioCarga;
      let tiempoMinimo = 1000;

      $(document).on('preXhr.dt', '#dependencia_data', function () {
        mostrarAlertaCarga();
        inicioCarga = new Date().getTime();
      });

      $(document).on('xhr.dt', '#dependencia_data', function () {
        let finCarga = new Date().getTime();
        let duracion = finCarga - inicioCarga;
        let tiempoRestante = tiempoMinimo - duracion;

        if (tiempoRestante > 0) {
          setTimeout(ocultarAlertaCarga, tiempoRestante);
        } else {
          ocultarAlertaCarga();
        }
      });

      const items = document.querySelectorAll('#lista-items .list-group-item');
      items.forEach(item => {
        item.addEventListener('click', function (e) {
          dependenciaSeleccionadaId = item.dataset.id; // 💾 guarda el ID
          e.preventDefault();
          items.forEach(i => i.classList.remove('active'));
          item.classList.add('active');

          if (mensajeInicial) mensajeInicial.style.display = "none";
          if (subtituloInicial) subtituloInicial.style.display = "none";

          const depeId = item.dataset.id;
          const nombre = item.querySelector('a').innerText;
          mostrarAlertaCarga(); 

          // Tabla inicial
          detalle.innerHTML = `
            <h5 class="mb-3">${nombre}</h5>
            <div class="mb-2 w-100">
              <div class="d-flex gap-2">
                <!-- Botón Imprimir -->
                <button class="btn btn-6 btn-outline-secundary" onclick="imprimirBienesSeleccionados()" >
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-brand-codesandbox"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 7.5v9l-4 2.25l-4 2.25l-4 -2.25l-4 -2.25v-9l4 -2.25l4 -2.25l4 2.25z" /><path d="M12 12l4 -2.25l4 -2.25" /><path d="M12 12l0 9" /><path d="M12 12l-4 -2.25l-4 -2.25" /><path d="M20 12l-4 2v4.75" /><path d="M4 12l4 2l0 4.75" /><path d="M8 5.25l4 2.25l4 -2.25" /></svg>
                    Imprimir Codigos   
                </button>
                <button class="btn btn-6 btn-outline-secundary" onclick="limpiarFiltros()">
                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eraser mx-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 20h-10.5l-4.21 -4.3a1 1 0 0 1 0 -1.41l10 -10a1 1 0 0 1 1.41 0l5 5a1 1 0 0 1 0 1.41l-9.2 9.3" /><path d="M18 13.3l-6.3 -6.3" /></svg> Limpiar 
                </button>
                <!-- Input con ícono -->
                <div class="input-icon w-100">
                  <span class="input-icon-addon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                      class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                      <path d="M21 21l-6 -6" />
                    </svg>
                  </span>
                  <input type="text" id="buscar_registros" placeholder="Buscar registro..." class="form-control w-100">
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table id="dependencia_data" class="table card-table table-vcenter text-nowrap datatable" >
                <thead >
                  <tr>
                    <th><input type="checkbox" id="gb_id_all"> </th>
                    <th>Código Barras</th>
                    <th>Representante</th>
                    <th>Denominacion</th>
                    <th>Valor Adq.</th>
                    <th>Doc. Adq.</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody id="tbody-bienes"></tbody>
              </table>
            </div>`;
          $.ajax({
            url: "../../controller/dependencia.php?op=listar_bienes_por_dependencia",
            type: "POST",
            data: { depe_id: depeId },
            dataType: "json",
            success: function (bienes) {
              let rows = "";
              if (bienes.length > 0) {
                $.each(bienes, function (index, b) {
                  rows += `
                    <tr>
                      <td>
                        <label class="checkbox-wrapper-46">
                          <input type="checkbox" class="inp-cbx gb-checkbox" data-id="${b.bien_id}" value="${b.bien_id}" />
                          <span class="cbx">
                            <span>
                              <svg viewBox="0 0 12 10" height="10px" width="12px">
                                <!-- Aquí dentro va el contenido SVG si tienes alguno -->
                              </svg>
                            </span>
                            <span></span>
                          </span>
                        </label>
                      </td>
                      <td><span class="badge bg-cyan text-cyan-fg selectable">${b.bien_codbarras || '-'}</span></td>
                      <td>${b.nombre_completo || 'N/A'}</td>
                      <td>${b.obj_nombre || 'N/A'}</td>
                      <td>${b.val_adq || 'N/A'}</td>
                      <td>${b.doc_adq || 'N/A'}</td>
                      <td>
                        <button
                          class="btn btn-icon btn-github"
                          onclick="imprimirBien(${b.bien_id})"
                          title="Imprimir código de barras"
                        >
                          <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-code"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 8l-4 4l4 4" /><path d="M17 8l4 4l-4 4" /><path d="M14 4l-4 16" /></svg>
                        </button>
                      </td>
                    </tr>`;
                });
              } else {
                rows = `<tr><td colspan="7" class="text-center text-muted">No hay bienes registrados.</td></tr>`;
              }

              $("#tbody-bienes").html(rows);

              // Inicializa o reinicia DataTable
              if ($.fn.DataTable.isDataTable("#dependencia_data")) {
                $("#dependencia_data").DataTable().destroy();
              }
              const table =  $("#dependencia_data").DataTable({
                pageLength: 9,
                lengthChange: false,
                ordering: false,
                searching: true, 
                language: {
                  "sProcessing":     "Procesando...",
                  "sLengthMenu":     "Mostrar _MENU_ registros",
                  "sZeroRecords":    "No se encontraron resultados",
                  "sEmptyTable":     "Ningún dato disponible en esta tabla",
                  "sInfo":           "Mostrando un total de _TOTAL_ registros",
                  "sInfoEmpty":      "Mostrando un total de 0 registros",
                  "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                  "sInfoPostFix":    "",
                  "sSearch":         "Buscar:",
                  "sUrl":            "",
                  "sInfoThousands":  ",",
                  "sLoadingRecords": "Cargando...",
                  "oPaginate": {
                      "sFirst":    "Primero",
                      "sLast":     "Último",
                      "sNext":     "Siguiente",
                      "sPrevious": "Anterior"
                  },
                  "oAria": {
                      "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                      "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                  }
              },
              });
              $('#buscar_registros').on('input', function () {
                  table.search(this.value).draw();
              }); 
              setTimeout(ocultarAlertaCarga, 1000);
            },
            error: function () {
              $("#tbody-bienes").html(`<tr><td colspan="7" class="text-danger">Error al obtener los datos.</td></tr>`);
            }
          });
        });
      });
    })
    .catch(error => console.error("Error al cargar dependencias:", error));
});
function imprimirBien(bien_id) {
  redirect_by_post(
    "../../controller/stick.php?op=imprimir",
    { bien_id, bien_id },
    true
  );
}
function imprimirBienesSeleccionados() {
  const checkboxes = document.querySelectorAll('.gb-checkbox:checked');
  const bien_ids = Array.from(checkboxes).map(cb => cb.value);
  if (bien_ids.length === 0) {
    Swal.fire({
      title: '¡Atención!',
      text: 'Seleccione al menos un bien para imprimir.',
      imageUrl: '../../static/gif/tarjeta.gif',
      imageWidth: 100,
      imageHeight: 100,
      confirmButtonText: 'Entendido',
      confirmButtonColor: 'rgb(243, 18, 18)', 
    });
    return;
  }
  redirect_by_post(
    "../../controller/stick.php?op=imprimir_multiple", 
    { bien_id: bien_ids },
    true
  );
}
function redirect_by_post(purl, pparameters, in_new_tab) {
  pparameters = typeof pparameters === "undefined" ? {} : pparameters;
  in_new_tab = typeof in_new_tab === "undefined" ? true : in_new_tab;

  var form = document.createElement("form");
  $(form)
    .attr("id", "reg-form")
    .attr("name", "reg-form")
    .attr("action", purl)
    .attr("method", "post")
    .attr("enctype", "multipart/form-data");

  if (in_new_tab) {
    $(form).attr("target", "_blank");
  }

  // Manejar parámetros
  $.each(pparameters, function (key, value) {
    if (Array.isArray(value)) {
      value.forEach(function (v) {
        $(form).append(
          '<input type="hidden" name="' + key + '[]" value="' + v + '" />'
        );
      });
    } else {
      $(form).append(
        '<input type="hidden" name="' + key + '" value="' + value + '" />'
      );
    }
  });

  document.body.appendChild(form);
  form.submit();
  document.body.removeChild(form);

  return false;
}
function limpiarFiltros() {
  // Limpiar el input de búsqueda
  const input = document.getElementById('buscar_registros');
  if (input) input.value = '';

  // Limpiar la búsqueda del DataTable si existe
  const table = $('#dependencia_data').DataTable();
  table.search('').draw();
  table.page('first').draw('page');

  // Recargar tabla si hay una dependencia activa
  if (!dependenciaSeleccionadaId) return;

  // Simula el clic REAL sobre el elemento activo
  const item = document.querySelector(`.list-group-item[data-id="${dependenciaSeleccionadaId}"]`);
  if (item) item.click();
}
