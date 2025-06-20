function verFormatoDatos() {
  $("#modalFormato").modal("show");
}
function buscarBien() {
  var botonBuscar = $("#buscaObjeto");
  var cod_bar = $("#cod_bar").val(); 
  if (buscarCodigoRepetido(cod_bar)) {
    Swal.fire({
        title: "Error",
        text: "El Objeto ya esta registrado.",
        imageUrl: '../../static/gif/no.gif',
        imageWidth: 100,
        imageHeight: 100,
        confirmButtonColor: 'rgb(243, 18, 18)',
        confirmButtonText: "Aceptar",
        backdrop: true,
        didOpen: () => {
            const swalBox = Swal.getPopup();
            const topBar = document.createElement('div');
            topBar.id = 'top-progress-bar';
            topBar.style.cssText = `
                position: absolute;
                top: 0;
                left: 0;
                height: 6px;
                width: 0%;
                background-color:rgb(243, 18, 18);
                transition: width 0.4s ease;
            `;
            swalBox.appendChild(topBar);
            setTimeout(() => {
                topBar.style.width = '100%';
            }, 300);
        } 
    });
    return;
  }
  botonBuscar.attr("disabled", true);
  botonBuscar.html('<svg class="tabler-loader" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-rotate-clockwise-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 4.55a8 8 0 0 1 6 14.9m0 -4.45v5h5" /><path d="M5.63 7.16l0 .01" /><path d="M4.06 11l0 .01" /><path d="M4.63 15.1l0 .01" /><path d="M7.16 18.37l0 .01" /><path d="M11 19.94l0 .01" /></svg>Buscar');
  $.post(
    "../../controller/objeto.php?op=buscar_obj_barras",
    { cod_bar: cod_bar },
    function (response) {
      botonBuscar.attr("disabled", false);
      botonBuscar.html('<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M12 21h-5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v4.5" /><path d="M16.5 17.5m-2.5 0a2.5 2.5 0 1 0 5 0a2.5 2.5 0 1 0 -5 0" /><path d="M18.5 19.5l2.5 2.5" /></svg>');
      try {
        var data = JSON.parse(response);
        if (!data || !data.bien_id) {
          Swal.fire({
            title:"¡Error!",
            text: "No se encontraron datos",
            imageUrl: '../../static/gif/letra-x.gif',
            imageWidth: 100,
            imageHeight: 100,
            confirmButtonText: "Aceptar",
            confirmButtonColor: 'rgb(243, 18, 18)',
            backdrop: true,
             didOpen: () => {
              const swalBox = Swal.getPopup();
              const topBar = document.createElement('div');
              topBar.id = 'top-progress-bar';
              topBar.style.cssText = `
                  position: absolute;
                  top: 0;
                  left: 0;
                  height: 6px;
                  width: 0%;
                  background-color:rgb(243, 18, 18);
                  transition: width 0.4s ease;
              `;
              swalBox.appendChild(topBar);
              setTimeout(() => {
                  topBar.style.width = '100%';
              }, 300);
          } 
          });
          return;
        }
        var colores = data.bien_color.replace(/[{}]/g, "").split(",");
        var nombresColores = [];
        var completedRequests = 0;
        colores.forEach(function (color_id) {
          get_color_string(color_id.trim(), function (color_nom) {
            nombresColores.push(color_nom);
            completedRequests++;
            if (completedRequests === colores.length) {
              mostrarDatosObjeto(data, nombresColores);
            }
          });
        });
      } catch (error) {
        console.error("Error al analizar la respuesta JSON:", error);
      }
    }
  ).fail(function () {
    botonBuscar.attr("disabled", false);
    botonBuscar.html(`
    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round" stroke-linejoin="round">
      <circle cx="11" cy="11" r="8" />
      <line x1="21" y1="21" x2="16.65" y2="16.65" />
    </svg>
    `);
    Swal.fire({
      title: "Error",
      text: "Hubo un problema al buscar el objeto.",
      icon: "error",
      confirmButtonText: "Aceptar",
    });
  });

  $("#cod_bar").val("");
}