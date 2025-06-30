function buscarBien() {
  var botonBuscar = $("#buscaObjeto");
  var cod_bar = $("#cod_bar").val(); 
  botonBuscar.attr("disabled", true);
  botonBuscar.html(`
  <svg class="tabler-loader" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-rotate-clockwise-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 4.55a8 8 0 0 1 6 14.9m0 -4.45v5h5" /><path d="M5.63 7.16l0 .01" /><path d="M4.06 11l0 .01" /><path d="M4.63 15.1l0 .01" /><path d="M7.16 18.37l0 .01" /><path d="M11 19.94l0 .01" /></svg>
  `);
  $("#obj_formato tbody").empty();
  $.post(
    "../../controller/objeto.php?op=buscar_obj_barras_consultas",
    { cod_bar: cod_bar },
    function (response) {
    botonBuscar.attr("disabled", false);
     botonBuscar.html(`
       <span class="d-flex align-items-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
          <path d="M14 3v4a1 1 0 0 0 1 1h4" />
          <path d="M12 21h-5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v4.5" />
          <path d="M16.5 17.5m-2.5 0a2.5 2.5 0 1 0 5 0a2.5 2.5 0 1 0 -5 0" />
          <path d="M18.5 19.5l2.5 2.5" />
        </svg>
        <span>Buscar</span>
      </span>
      `);

      try {
        var data = JSON.parse(response);
        if (!data || !data.bien_id) {
          Swal.fire({
            title: "No se encontraron datos",
            imageUrl: '../../static/gif/letra-x.gif',
            imageWidth: 100,
            imageHeight: 100,
            confirmButtonText: "Aceptar",
            confirmButtonColor: 'rgb(243, 18, 18)',
          });
          return;
        }
        var colores = data.bien_color.replace(/[{}]/g, "").split(",");

        // Obtener los nombres de los colores
        var nombresColores = [];
        var completedRequests = 0;
        colores.forEach(function (color_id) {
          get_color_string(color_id.trim(), function (color_nom) {
            nombresColores.push(color_nom);
            completedRequests++;

            // Si se han obtenido todos los nombres de colores
            if (completedRequests === colores.length) {
              // Mostrar los datos del objeto en un SweetAlert con dos botones
              mostrarDatosObjeto(data, nombresColores);
              $("#cod_bar").val("");
            }
          });
        });
      } catch (error) {
        console.error("Error al analizar la respuesta JSON:", error);
      }
    }
  ).fail(function () {
    botonBuscar.attr("disabled", false);
    botonBuscar.html('<i class="fa fa-search"></i>');
    Swal.fire({
      title: "Error",
      text: "Hubo un problema al buscar el objeto.",
      icon: "error",
      confirmButtonText: "Aceptar",
    });
  });

  $("#cod_bar").val("");
}

function mostrarDatosObjeto(data, nombresColores) {
const contenedor = document.querySelector(".respuesta");

const mainContainer = document.createElement("div");
mainContainer.className = "row g-3";

const colEstado = document.createElement("div");
colEstado.className = "col-lg-3 d-flex align-items-center justify-content-center"; 

const innerWrapper = document.createElement("div");
innerWrapper.className = "d-flex flex-column align-items-center"; 
innerWrapper.innerHTML = `
  <div class="text-title mb-0"><h3>Estado del Bien</h3></div>
  <div class="card text-white w-100" style="background-color: ${obtenerColorPorEstado(data.bien_est)}; max-width: 220px; font-size: 13px;">
    <div class="card-body py-2 px-3 text-center">
      <div class="text-uppercase fw-semibold d-flex align-items-center justify-content-center" style="gap: 6px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-shareplay">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
          <path d="M18 18a3 3 0 0 0 3 -3v-8a3 3 0 0 0 -3 -3h-12a3 3 0 0 0 -3 3v8a3 3 0 0 0 3 3" />
          <path d="M9 20h6l-3 -5z" />
        </svg>
        ${data.bien_est}
      </div>
    </div>
  </div>
  <div class="mt-2 w-100 d-flex justify-content-center">
    <img src="../../static/illustrations/2020202.jpg" alt="Estado del bien" class="img-fluid" style="max-width: 220px;">
  </div>
`;

  colEstado.appendChild(innerWrapper);
  mainContainer.appendChild(colEstado);

  // Crear contenedor de las filas de datos
  const colDatos = document.createElement("div");
  colDatos.className = "col-lg-9";

  // Fila: Datos del Bien
  const rowBien = document.createElement("div");
  rowBien.className = "row mb-3";
  rowBien.innerHTML = `
   <div class="col-12">
   <div class="card" style="
   background: white;
  transition: box-shadow 0.3s ease;">
        <div class="card-status-start bg-primary"></div>
        <div class="card-body d-flex">
          <div class="w-100">
            <h4 style="background-color: #f0f4f8; color:rgb(10, 78, 173);  padding: 8px 8px; border-radius: 8px; text-transform: uppercase; font-weight: 600; font-size: 18px; display: flex; align-items: center; gap: 8px;">
              <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="#3b82f6" class="icon icon-tabler icon-tabler-archive">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M2 3m0 2a2 2 0 0 1 2 -2h16a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-16a2 2 0 0 1 -2 -2z" />
                <path d="M19 9c.513 0 .936 .463 .993 1.06l.007 .14v7.2c0 1.917 -1.249 3.484 -2.824 3.594l-.176 .006h-10c-1.598 0 -2.904 -1.499 -2.995 -3.388l-.005 -.212v-7.2c0 -.663 .448 -1.2 1 -1.2h14zm-5 2h-4a1 1 0 0 0 0 2h4a1 1 0 0 0 0 -2z" />
              </svg>
              Datos del Bien
            </h4>
            <div class="text-muted">
              <div class="row mb-3">
                <div class="col-lg-3">
                  <strong>Código de barras:</strong><br>
                  ${data.bien_codbarras ? data.bien_codbarras.toUpperCase() : 'NO ASIGNADO'}
                </div>
                <div class="col-lg-3">
                  <strong>Denominación:</strong><br>
                  ${data.obj_nombre ? data.obj_nombre.toUpperCase() : 'SIN DENOMINACIÓN'}
                </div>
                <div class="col-lg-3">
                  <strong>Fecha Adquisición:</strong><br>
                  ${data.fecharegistro ? data.fecharegistro.toUpperCase() : 'NO REGISTRADA'}
                </div>
                <div class="col-lg-3">
                  <strong>Valor Adquisición:</strong><br>
                  ${data.val_adq ? data.val_adq.toString().toUpperCase() : 'SIN VALOR ASIGNADO'}
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-lg-3">
                  <strong>Doc. Adquisición:</strong><br>
                  ${data.doc_adq ? data.doc_adq.toUpperCase() : 'NO ASIGNADO'}
                </div>
                <div class="col-lg-3">
                  <strong>Observación:</strong><br>
                  ${data.bien_obs ? data.bien_obs.toUpperCase() : 'SIN OBSERVACIONES'}
                </div>
                <div class="col-lg-3">
                  <strong>Marca:</strong><br>
                  ${data.marca_nom ? data.marca_nom.toUpperCase() : 'SIN MARCA ASIGNADA'}
                </div>
                <div class="col-lg-3">
                  <strong>Modelo:</strong><br>
                  ${data.modelo_nom ? data.modelo_nom.toUpperCase() : 'SIN MODELO ASIGNADO'}
                </div>
              </div>
              <div class="row">
                <div class="col-lg-3">
                  <strong>Número de Serie:</strong><br>
                  ${data.bien_numserie ? data.bien_numserie.toUpperCase() : 'NO TIENE NÚMERO DE SERIE'}
                </div>
                <div class="col-lg-3">
                  <strong>Dimensiones:</strong><br>
                  ${data.bien_dim ? data.bien_dim.toUpperCase() : 'NO ESPECIFICADAS'}
                </div>
                <div class="col-lg-3">
                  <strong>Procedencia:</strong><br>
                  ${data.procedencia ? data.procedencia.toUpperCase() : 'NO REGISTRADA'}
                </div>
                <div class="col-lg-3">
                  <strong>Color:</strong><br>
                  ${(nombresColores && nombresColores.length > 0) ? nombresColores.map(c => c.toUpperCase()).join(", ") : 'SIN COLOR ASIGNADO'}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  `;

const rowDependencia = document.createElement("div");
rowDependencia.className = "row mb-3 d-flex align-items-stretch";
rowDependencia.innerHTML = `
  <div class="col-lg-6 d-flex">
    <div class="card h-100 w-100" style="
      background: white;
      transition: box-shadow 0.3s ease;">
      <div class="card-status-start bg-orange"></div>
      <div class="card-body d-flex flex-column">
        <div class="w-100">
          <h4 style="background-color:rgb(243, 209, 159); padding: 8px 8px; color:rgb(255, 115, 0); border-radius: 8px; text-transform: uppercase; font-weight: 600; font-size: 18px; display: flex; align-items: center; gap: 8px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="6" height="8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-buildings">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 21v-15c0 -1 1 -2 2 -2h5c1 0 2 1 2 2v15" /><path d="M16 8h2c1 0 2 1 2 2v11" /><path d="M3 21h18" /><path d="M10 12v0" /><path d="M10 16v0" /><path d="M10 8v0" /><path d="M7 12v0" /><path d="M7 16v0" /><path d="M7 8v0" /><path d="M17 12v0" /><path d="M17 16v0" />
            </svg>
            Datos de la Dependencia
          </h4>
          <div class="text-muted">
            <strong>Dependencia Origen:</strong><br>
            ${data.depe_denominacion ? data.depe_denominacion : 'No tiene Área asignada'}
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-6 d-flex">
    <div class="card h-100 w-100" style="
      background: white;
      transition: box-shadow 0.3s ease;">
      <div class="card-status-start bg-green"></div>
      <div class="card-body d-flex flex-column">
        <div class="w-100">
          <h4 style="background-color:rgb(138, 240, 155);padding: 8px 8px; color:rgb(30, 117, 4); border-radius: 8px; text-transform: uppercase; font-weight: 600; font-size: 18px; display: flex; align-items: center; gap: 8px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="6" height="6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-scan">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 9a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M4 8v-2a2 2 0 0 1 2 -2h2" /><path d="M4 16v2a2 2 0 0 0 2 2h2" /><path d="M16 4h2a2 2 0 0 1 2 2v2" /><path d="M16 20h2a2 2 0 0 0 2 -2v-2" /><path d="M8 16a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2" />
            </svg>
            Datos del Representante
          </h4>
          <div class="text-muted">
            <div class="row">
              <div class="col-lg-6">
                <strong>Representante:</strong><br>
                ${data.nombre_completo ? data.nombre_completo.toUpperCase() : 'NO REGISTRADO'}
              </div>
              <div class="col-lg-6">
                <strong>DNI:</strong><br>
                ${data.pers_dni ? data.pers_dni.toUpperCase() : 'NO ESPECIFICADO'}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
`;


  // Añadir las filas al contenedor derecho
  colDatos.appendChild(rowBien);
  colDatos.appendChild(rowDependencia);

  // Añadir al contenedor principal
  mainContainer.appendChild(colDatos);
  contenedor.appendChild(mainContainer);
}

function obtenerColorPorEstado(estado) {
  switch (estado) {
    case "Nuevo":
      return "#228be6"; // Tabler blue
    case "Bueno":
      return "#82c91e"; // Tabler lime
    case "Regular":
      return "#f76707"; // Tabler orange
    default:
      return "#fa5252"; // Tabler red
  }
}

function obtenerColor2PorEstado(estado) {
  switch (estado) {
    case "Nuevo":
      return "#d0ebff"; // Light blue
    case "Bueno":
      return "#e9fac8"; // Light lime
    case "Regular":
      return "#ffe8cc"; 
    default:
      return "#ffe3e3"; 
  }
}


function get_color_string(color_id, callback) {
  console.log(color_id);
  $.post(
    "../../controller/objeto.php?op=get_color",
    { color_id: color_id },
    function (data) {
      var jsonData = JSON.parse(data);
      callback(jsonData.color_nom);
    }
  );
}