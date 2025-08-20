function mostrarAlertaCarga() {
  document.getElementById('alerta-carga').style.display = 'block';
}
function ocultarAlertaCarga() {
  document.getElementById('alerta-carga').style.display = 'none';
}
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
function nuevobaja() {
  $('#modalBaja').modal('show');
  cargarListadoBienesEnModal();
}
function cargarListadoBienesEnModal() {
  fetch("../../controller/dependencia.php?op=listar_cantidad_bienes_por_dependencia")
    .then(response => response.json())
    .then(data => {
      let html = `
        <div class="row">
          <div class="col-md-4">
            <div id="lista-items" class="list-group"></div>
          </div>
          <div class="col-md-8">
            <div id="detalle-contenido">
              <p id="mensaje-inicial">Seleccione una dependencia para ver sus bienes.</p>
              <h6 id="subtitulo-inicial" class="text-muted">Detalle de bienes aparecerá aquí.</h6>
            </div>
          </div>
        </div>`;
      const lista = document.getElementById("lista-items");
      const detalle = document.getElementById("detalle-contenido");
      const mensajeInicial = document.getElementById("mensaje-inicial");
      const subtituloInicial = document.getElementById("subtitulo-inicial");

      let listaHTML = "";
      data.forEach(dep => {
        const icono = obtenerIconoPorDependencia(dep.depe_denominacion);
        listaHTML += `
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

      lista.innerHTML = listaHTML;

      // Delegar eventos de tabla
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
          e.preventDefault();
          items.forEach(i => i.classList.remove('active'));
          item.classList.add('active');

          if (mensajeInicial) mensajeInicial.style.display = "none";
          if (subtituloInicial) subtituloInicial.style.display = "none";

          const depeId = item.dataset.id;
          const nombre = item.querySelector('a').innerText;
          mostrarAlertaCarga();

          detalle.innerHTML = `
            <h5 class="mb-3">${nombre}</h5>
            <div class="mb-2 w-100">
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
            <div class="table-responsive">
              <table id="dependencia_data" class="table card-table table-vcenter text-nowrap datatable" style="width: 95%;">
                <thead>
                  <tr>
                    <th>Código</th>
                    <th>Denominación</th>
                    <th>Dimensión</th>
                    <th>Valor Adq.</th>
                    <th>Doc. Adq.</th>
                    <th>Obs. Bien</th>
                    <th>Acción</th>
                  </tr>
                </thead>
                <tbody id="tbody-bienes"></tbody>
              </table>
            </div>`;

          $.ajax({
            url: "../../controller/dependencia.php?op=listar_bienes_por_dependencia2",
            type: "POST",
            data: { depe_id: depeId },
            dataType: "json",
            success: function (bienes) {
              let rows = "";
              if (bienes.length > 0) {
                $.each(bienes, function (index, b) {
                  rows += `
                      <tr>
                        <td><span class="badge bg-cyan text-cyan-fg selectable">${b.bien_codbarras || '-'}</span></td>
                        <td>${b.obj_nombre || '-'}</td>
                        <td>${b.bien_dim || '-'}</td>
                        <td>${b.val_adq || '-'}</td>
                        <td>${b.doc_adq || '-'}</td>
                        <td>
                          <span class="${
                            b.bien_est === 'B' ? 'bg-success text-white px-3 py-1 rounded' :
                            b.bien_est === 'N' ? 'bg-purple text-white px-3 py-1 rounded' :
                            b.bien_est === 'R' ? 'bg-warning text-white px-3 py-1 rounded' :
                            b.bien_est === 'M' ? 'bg-danger text-white px-3 py-1 rounded' :
                            'bg-secondary text-white px-2 py-1 rounded'
                          }">
                            ${
                              b.bien_est === 'B' ? 'Bueno' :
                              b.bien_est === 'M' ? 'Malo' :
                              b.bien_est === 'R' ? 'Regular' :
                              b.bien_est === 'N' ? 'Nuevo' :
                              '-'
                            }
                          </span>
                        </td>
                        <td>
                          <button class="btn btn-outline-dark" onclick="darDeBaja(${b.bien_id})">
                            <i class="fa fa-trash"></i>
                          </button>
                        </td>
                      </tr>`;
                });
              } else {
                rows = `<tr><td colspan="7" class="text-center text-muted">No hay bienes registrados.</td></tr>`;
              }
              $("#tbody-bienes").html(rows);
              if ($.fn.DataTable.isDataTable("#dependencia_data")) {
                $("#dependencia_data").DataTable().destroy();
              }

              var table = $("#dependencia_data").DataTable({
                pageLength: 5,
                lengthChange: false,
                order: [[0, "desc"]],
                searching: true,
                language: {
                  sProcessing: "Procesando...",
                  sLengthMenu: "Mostrar _MENU_ registros",
                  sZeroRecords: "No se encontraron resultados",
                  sEmptyTable: "Ningún dato disponible en esta tabla",
                  sInfo: "Mostrando un total de _TOTAL_ registros",
                  sInfoEmpty: "Mostrando un total de 0 registros",
                  sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
                  sSearch: "Buscar:",
                  oPaginate: {
                    sFirst: "Primero",
                    sLast: "Último",
                    sNext: "Siguiente",
                    sPrevious: "Anterior"
                  }
                }
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
}
function darDeBaja(bien_id) {
  $('#modalBaja').modal('hide');
  $('.modal-backdrop').remove();
  Swal.fire({
    title: '¿Estás seguro?',
    text: "¡Esta acción no se puede deshacer!",
    imageUrl: '../../static/gif/advertencia.gif',
    imageWidth: 100,
    imageHeight: 100,
    showCancelButton: true,
    confirmButtonColor: 'rgb(243, 18, 18)',
    cancelButtonColor: '#000',
    confirmButtonText: 'Sí, continuar',
    didOpen: () => agregarBarraProgreso(40)
  }).then((confirmResult) => {
    if (confirmResult.isConfirmed) {
      Swal.fire({
        title: 'motivo de Baja',
        input: 'textarea',
        inputPlaceholder: 'Ingrese la motivo de Baja...',
        inputAttributes: { 'aria-label': 'motivo de baja' },
        showCancelButton: true,
        confirmButtonText: 'Confirmar',
        confirmButtonColor: 'rgb(243, 18, 18)',
        cancelButtonColor: '#000',
        inputValidator: (value) => {
          if (!value.trim()) return 'Debes ingresar la motivo de baja valida.';
        },
        didOpen: () => agregarBarraProgreso(70)
      }).then((motivoResult) => {
        if (motivoResult.isConfirmed) {
          const motivoBaja = motivoResult.value.trim();
          $.ajax({
            url: '../../controller/dependencia.php?op=baja_de_bien',
            type: 'POST',
            data: { bien_id: bien_id, motivo_baja: motivoBaja },
            success: function () {
              const depeId = document.querySelector(".list-group-item.active")?.dataset?.id;
              if (depeId) {
                $.ajax({
                  url: "../../controller/dependencia.php?op=listar_bienes_por_dependencia2",
                  type: "POST",
                  data: { depe_id: depeId },
                  dataType: "json",
                  success: function (bienes) {
                    if (bienes.length === 0) {
                      Swal.fire({
                        imageUrl: '../../static/gif/sin-datos.gif',
                        imageWidth: 100,
                        imageHeight: 100,
                        title: 'Sin bienes restantes',
                        text: 'Ya no hay bienes en esta dependencia.',
                        confirmButtonColor: 'rgb(15, 4, 77)',
                        confirmButtonText: 'Ok',
                      }).then(() => {
                        window.location.href = "/SISINV2/view/adminMntDependencias/vistabajaDocumento.php?bien_id=" + bien_id;

                      });
                      return;
                    }
                    let rows = "";
                    $.each(bienes, function (index, b) {
                      rows += `
                        <tr>
                          <td>${b.bien_codbarras || '-'}</td>
                          <td>${b.obj_nombre || '-'}</td>
                          <td>${b.bien_dim || '-'}</td>
                          <td>${b.val_adq || '-'}</td>
                          <td>${b.doc_adq || '-'}</td>
                          <td>${b.bien_obs || '-'}</td>
                          <td>
                            <button class="btn btn-outline-dark" onclick="darDeBaja(${b.bien_id})">
                              <i class="fa fa-trash"></i>
                            </button>
                          </td>
                        </tr>`;
                    });
                    $('#dependencia_data').DataTable().destroy();
                    $('#tbody-bienes').html(rows);
                    $('#dependencia_data').DataTable({
                      pageLength: 5,
                      lengthChange: false,
                      ordering: false,
                      searching: true,
                      language: {
                        sProcessing: "Procesando...",
                        sLengthMenu: "Mostrar _MENU_ registros",
                        sZeroRecords: "No se encontraron resultados",
                        sEmptyTable: "Ningún dato disponible en esta tabla",
                        sInfo: "Mostrando un total de _TOTAL_ registros",
                        sInfoEmpty: "Mostrando un total de 0 registros",
                        sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
                        sSearch: "Buscar:",
                        oPaginate: {
                          sFirst: "Primero",
                          sLast: "Último",
                          sNext: "Siguiente",
                          sPrevious: "Anterior"
                        }
                      }
                    });
                    Swal.fire({
                      title: '¡Dado de baja!',
                      html: `<p>El bien ha sido dado de baja correctamente.</p>
                            <div id="top-progress-bar-final" style="
                                position: absolute;
                                top: 0;
                                left: 0;
                                height: 5px;
                                width: 0%;
                                background-color:rgb(243, 18, 18);
                                transition: width 0.6s ease;">
                            </div>`,
                      imageUrl: '../../static/gif/verified.gif',
                      imageWidth: 100,
                      imageHeight: 100,
                      showConfirmButton: false,
                      timer: 1800, // espera 1.8 segundos y luego redirige
                      didOpen: () => {
                        setTimeout(() => {
                          document.getElementById('top-progress-bar-final').style.width = '100%';
                        }, 100);
                      },
                      willClose: () => {
                        window.location.href = "/SISINV2/view/adminMntDependencias/vistabajaDocumento.php?bien_id=" + bien_id;
                      }
                    });
                    if ($.fn.DataTable.isDataTable('#dependencias_objetos')) {
                      $('#dependencias_objetos').DataTable().ajax.reload(null, false);
                    }
                    fetch("../../controller/dependencia.php?op=listar_cantidad_bienes_por_dependencia")
                      .then(response => response.json())
                      .then(data => {
                        const lista = document.getElementById("lista-items");
                        let listaHTML = "";
                        data.forEach(dep => {
                          const icono = obtenerIconoPorDependencia(dep.depe_denominacion);
                          const isActive = dep.depe_id == depeId ? "active" : "";
                          listaHTML += `
                            <div class="list-group-item d-flex align-items-start ${isActive}" data-id="${dep.depe_id}">
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
                        lista.innerHTML = listaHTML;
                      });
                  },
                  error: function () {
                    Swal.fire({
                      title: 'Error',
                      text: 'No se pudo actualizar la lista de bienes.',
                      icon: 'error'
                    });
                  }
                });
              }
            },
            error: function () {
              Swal.fire({
                title: 'Error',
                text: 'No se pudo dar de baja.',
                icon: 'error'
              });
            }
          });
        }
      });
    }
  });
}
function agregarBarraProgreso(porcentaje = 40) {
  const swalBox = Swal.getPopup();
  const topBar = document.createElement('div');
  topBar.id = 'top-progress-bar';
  topBar.style.cssText = `
    position: absolute;
    top: 0;
    left: 0;
    height: 5px;
    width: 0%;
    background-color: rgb(243, 18, 18);
    transition: width 0.4s ease;
  `;
  swalBox.appendChild(topBar);
  setTimeout(() => {
    topBar.style.width = porcentaje + '%';
  }, 300);
}
