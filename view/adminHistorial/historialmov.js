$(document).ready(function() {

    function cargarBienes() {
        $.ajax({
            url: "../../controller/dependencia.php?op=listar_historial_movimiento",
            method: "POST",
            dataType: "json",
            success: function(response) {
                let lista = $("#listaBienes");
                lista.empty();

                if (response && response.aaData && response.aaData.length > 0) {
                    response.aaData.forEach(function(bien) {
                        console.log(bien);
                        let item = `
                        <li class="mb-2">
                          <div class="card border-0 p-3" 
                              style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                            <div class="row g-2 align-items-center">
                              
                              <!-- Ícono -->
                              <div class="col-12 col-md-2 d-flex justify-content-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" 
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                    class="icon-lg icon icon-tabler icons-tabler-outline icon-tabler-device-ipad-share text-primary">
                                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                  <path d="M12 21h-6a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v8" />
                                  <path d="M9 18h3.5" />
                                  <path d="M16 22l5 -5" />
                                  <path d="M21 21.5v-4.5h-4.5" />
                                </svg>
                              </div>
                              
                              <!-- Contenido -->
                              <div class="col-12 col-md-10">
                                <div class="fw-bold my-2">${bien[1]}</div>
                                <div class="d-flex flex-wrap justify-content-between align-items-center">
                                  <small class="badge bg-green-lt mb-2">${bien[0]}</small>
                                  <button class="btn btn-sm bg-dark text-light d-flex align-items-center gap-1" 
                                          onclick="verHistorial('${bien[0]}')">
                                    <span>Ir</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" 
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                      <path d="M5 12h14" />
                                      <path d="M13 18l6 -6" />
                                      <path d="M13 6l6 6" />
                                    </svg>
                                  </button>
                                </div>
                              </div>
                              
                            </div>
                          </div>
                        </li>`;
                        lista.append(item);

                    });

                    $(".hover-shadow").hover(
                        function() { $(this).css("transform", "translateY(-3px)"); },
                        function() { $(this).css("transform", "translateY(0)"); }
                    );

                } else {
                    lista.append('<li class="text-center text-muted">No se encontraron bienes.</li>');
                }
            },
            error: function(err) {
                console.error("Error al cargar bienes:", err);
            }
        });
    }

    cargarBienes();

    $("#buscadorBienes").on("keyup", function() {
        let texto = $(this).val().toLowerCase();
        $("#listaBienes li").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(texto) > -1);
        });
    });

});
function verHistorial(codigo) {
  $.ajax({
    url: "../../controller/dependencia.php?op=listar_historial_movimiento",
    type: "POST",
    data: { codigo_barras: codigo },
    dataType: "json",
    success: function(data) {
      let historialDiv = $("#historialBien");
      historialDiv.empty();
      if (data.length > 0) {
        data.forEach(function(row, index) {
          let stepClass = index === 0 ? "stepper-step stepper-completed" : "stepper-step stepper-active";
          let stepNumber = index + 1; 
          let stepCircle = index === 0 
            ? `<svg viewBox="0 0 16 16" class="bi bi-check-lg" fill="currentColor" height="16" width="16" xmlns="http://www.w3.org/2000/svg">
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
    error: function(err) {
      console.error("Error al cargar historial:", err);
    }
  });
}
