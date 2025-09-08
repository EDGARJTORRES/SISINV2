$(document).ready(function () {

  function cargarBienes() {
    $.ajax({
      url: "../../controller/dependencia.php?op=listar_historial_movimiento",
      method: "POST",
      dataType: "json",
      success: function (response) {
        console.log("Respuesta cargarBienes:", response); // 👈 Ver respuesta

        let lista = $("#listaBienes");
        lista.empty();

        if (response && response.aaData && response.aaData.length > 0) {
          let agrupados = {};
          response.aaData.forEach(function (bien) {
            let codigo = bien[0];
            let nombre = bien[1];
            if (!agrupados[nombre]) {
              agrupados[nombre] = [];
            }
            agrupados[nombre].push(codigo);
          });

          let index = 0;
          Object.keys(agrupados).forEach(function (nombre) {
            let codigos = agrupados[nombre];
            let collapseId = "collapse_" + index++;

            let card = `
              <li class="mb-3">
                <div class="card border-0 shadow-sm hover-shadow-md">
                  <div class="card-header d-flex align-items-center cursor-pointer"
                      data-bs-toggle="collapse" data-bs-target="#${collapseId}">

                    <!-- Icono -->
                    <div class="me-3 d-flex align-items-center justify-content-center">
                      <span class="avatar avatar-lg bg-primary-lt text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                            class="icon icon-tabler icon-tabler-box" 
                            width="32" height="32" viewBox="0 0 24 24" 
                            stroke-width="2" stroke="currentColor" fill="none" 
                            stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                          <path d="M12 3l8 4.5v9l-8 4.5l-8 -4.5v-9z" />
                          <path d="M12 12l8 -4.5" />
                          <path d="M12 12l-8 -4.5" />
                          <path d="M12 12v9" />
                        </svg>
                      </span>
                    </div>

                    <!-- Texto -->
                    <div class="flex-grow-1">
                      <div class="fw-bold fs-5 mb-1">${nombre}</div>
                      <span class="badge bg-primary-lt">${codigos.length} bienes</span>
                    </div>

                    <!-- Flecha -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                        fill="none" stroke="currentColor" stroke-width="2" 
                        stroke-linecap="round" stroke-linejoin="round" 
                        class="icon collapse-icon ms-2">
                      <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                  </div>

                  <!-- Contenido -->
                  <div id="${collapseId}" class="collapse">
                    <div class="p-2 border-bottom">
                      <input type="text" 
                             class="form-control buscador-codigos py-2" 
                             placeholder="Buscar código..." 
                             data-target="#list_${collapseId}">
                    </div>
                    <ul id="list_${collapseId}" class="list-group list-group-flush">
                      ${codigos.map(cod => `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                          <span class="badge bg-green-lt">${cod}</span>
                          <button class="btn btn-sm btn-dark d-flex align-items-center gap-1"
                                  onclick="verHistorial('${cod}', this)">
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                class="icon icon-tabler icon-tabler-arrow-right" 
                                width="16" height="16" viewBox="0 0 24 24" 
                                stroke-width="2" stroke="currentColor" fill="none" 
                                stroke-linecap="round" stroke-linejoin="round">
                              <line x1="5" y1="12" x2="19" y2="12" />
                              <line x1="13" y1="18" x2="19" y2="12" />
                              <line x1="13" y1="6" x2="19" y2="12" />
                            </svg>
                            Ir
                          </button>
                        </li>
                      `).join("")}
                    </ul>
                  </div>
                </div>
              </li>
            `;
            lista.append(card);
          });

          // Buscador interno
          $(document).off("keyup", ".buscador-codigos").on("keyup", ".buscador-codigos", function () {
            let texto = $(this).val().toLowerCase();
            let target = $(this).attr("data-target"); // 👈 corregido
            console.log("Buscando en:", target, "texto:", texto);
            $(target).find("li").each(function () {
              $(this).toggle($(this).text().toLowerCase().includes(texto));
            });
          });

          // Animación de flecha
          $("#listaBienes .collapse").on("show.bs.collapse", function () {
            $(this).prev(".card-header").find(".collapse-icon").css("transform", "rotate(180deg)");
          }).on("hide.bs.collapse", function () {
            $(this).prev(".card-header").find(".collapse-icon").css("transform", "rotate(0deg)");
          });

        } else {
          lista.append('<li class="text-center text-muted">No se encontraron bienes.</li>');
        }
      },
      error: function (err) {
        console.error("Error al cargar bienes:", err);
      }
    });
  }

  cargarBienes();

  // Buscador global
  $("#buscadorBienes").on("keyup", function () {
    let texto = $(this).val().toLowerCase();
    $("#listaBienes li").each(function () {
      $(this).toggle($(this).text().toLowerCase().includes(texto));
    });
  });

});

function verHistorial(codigo, btn) {
  $(".list-group-item-activo").removeClass("list-group-item-activo");
  if (btn) {
    $(btn).closest("li").addClass("list-group-item-activo");
  }
  $.ajax({
    url: "../../controller/dependencia.php?op=listar_historial_movimiento",
    type: "POST",
    data: { codigo_barras: codigo },
    dataType: "json",
    success: function (data) {
      console.log("Historial recibido:", data);
      let historialDiv = $("#historialBien");
      historialDiv.empty();
      if (Array.isArray(data) && data.length > 0) {
        data.forEach(function (row, index) {
          let stepClass = index === 0 ? "stepper-step stepper-completed" : "stepper-step stepper-active";
          let stepNumber = index + 1;
          let stepCircle = index === 0
            ? `<svg viewBox="0 0 16 16" class="bi bi-check-lg" fill="currentColor" 
                  height="16" width="16" xmlns="http://www.w3.org/2000/svg">
                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z"></path>
              </svg>`
            : stepNumber;
          let fecha = row.form_fechacrea ? row.form_fechacrea : "Fecha no disponible";
          historialDiv.append(`
            <div class="${stepClass}">
              <div class="stepper-circle">${stepCircle}</div>
              <div class="stepper-line"></div>
              <div class="stepper-content">
                <div class="stepper-title">${row.depe_denominacion || "Dependencia no disponible"}</div>
                <div class="stepper-status">${row.nombre_completo || "Persona no disponible"}</div>
                <div class="stepper-time">${fecha}</div>
              </div>
            </div>
          `);
        });
      } else {
        historialDiv.append('<p class="text-muted">No se encontraron movimientos para este bien.</p>');
      }
    },
    error: function (err) {
      console.error("Error al cargar historial:", err);
    }
  });
}
