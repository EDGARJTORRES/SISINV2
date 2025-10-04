$(document).ready(function () {
  function cargarBienes() {
    $.ajax({
      url: "../../controller/dependencia.php?op=listar_historial_movimiento",
      method: "POST",
      dataType: "json",
      success: function (response) {
        let lista = $("#listaBienes");
        lista.empty();

        if (response && response.aaData && response.aaData.length > 0) {
          let agrupados = {};
          response.aaData.forEach(function (bien) {
            let codigo = bien[0];  
            let nombre = bien[1];
            if (!agrupados[nombre]) agrupados[nombre] = [];
            agrupados[nombre].push(codigo);
          });

          let index = 0;
          Object.keys(agrupados).forEach(function (nombre) {
            let codigos = agrupados[nombre];
            let collapseId = "collapse_" + index++;

            let card = `
              <li class="mb-3 item-bien">
                <div class="card border-0 shadow-sm">
                  <div class="card-header d-flex align-items-center cursor-pointer"
                      data-bs-toggle="collapse" data-bs-target="#${collapseId}">
                    <div class="me-3 d-flex align-items-center justify-content-center">
                      <span class="avatar avatar-lg bg-primary-lt text-primary">
                        <!-- icono -->
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
                    <div class="flex-grow-1">
                      <div class="fw-bold fs-5 mb-1 nombre-bien">${nombre}</div>
                      <span class="badge bg-primary-lt">${codigos.length} bienes</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                        fill="none" stroke="currentColor" stroke-width="2" 
                        stroke-linecap="round" stroke-linejoin="round" 
                        class="icon collapse-icon ms-2">
                      <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                  </div>

                  <div id="${collapseId}" class="collapse">
                    <div class="p-2 border-bottom">
                      <input type="text"
                             class="form-control buscador-codigos py-2"
                             placeholder="Buscar código de barras..."
                             data-target="#list_${collapseId}">
                    </div>
                    <ul id="list_${collapseId}" class="list-group list-group-flush">
                      ${codigos.map(cod => `
                        <li class="list-group-item item-codigo">
                          <span class="badge bg-green-lt">${cod}</span>
                          <button class="btn btn-link p-0 float-end text-primary d-flex align-items-center"
                                  onclick="verHistorial('${cod}', this)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                class="icon me-1">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                              <path d="M5 12h14"/>
                              <path d="M13 18l6-6"/>
                              <path d="M13 6l6 6"/>
                            </svg>
                            Ver Historial
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

          // Animación flecha
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

  // Buscador interno (por código)
  $(document).on("keyup", ".buscador-codigos", function () {
    let texto = $(this).val().toLowerCase();
    let target = $(this).attr("data-target");
    let encontrados = 0;

    $(target).find(".item-codigo").each(function () {
      let coincide = $(this).text().toLowerCase().includes(texto);
      $(this).toggle(coincide);
      if (coincide) encontrados++;
    });

    if (encontrados === 0) {
      if (!$(target).find(".sin-resultados").length) {
        $(target).append('<li class="list-group-item sin-resultados text-muted">No se encontraron resultados.</li>');
      }
    } else {
      $(target).find(".sin-resultados").remove();
    }
  });

  $("#buscadorBienes").on("keyup", function () {
    let texto = $(this).val().toLowerCase();
    let encontrados = 0;

    $("#listaBienes .item-bien").each(function () {
      let coincide = $(this).find(".nombre-bien").text().toLowerCase().includes(texto);
      $(this).toggle(coincide);
      if (coincide) encontrados++;
    });

    // quitar mensaje anterior si existe
    $("#listaBienes .sin-resultados-global").remove();

    // si no hay resultados, mostrar mensaje
    if (encontrados === 0) {
      $("#listaBienes").append(`
        <li class="sin-resultados-global list-group-item text-center mt-3 border-0 rounded-3 py-4">
          <img src="../../static/gif/red-en-la-nube.gif" alt="No se encontraron resultados"
               class="mb-3" style="width: 120px;">
          <div class="d-flex align-items-center justify-content-center fw-bold fs-5 text-dark">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon me-2 text-muted">
              <circle cx="12" cy="12" r="9" />
              <line x1="12" y1="8" x2="12" y2="12" />
              <line x1="12" y1="16" x2="12.01" y2="16" />
            </svg> 
            No se encontraron resultados
          </div>
          <div class="text-muted small">
            No se hallaron bienes patrimoniales con ese nombre. Prueba con otro
          </div>
        </li>
      `);
    }
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
