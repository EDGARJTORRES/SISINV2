function guardaryeditarbienes(e) {
  e.preventDefault();
}
function buscarDNI() {
   var pers_dni = $("#pers_dni").val();

  $.post("../../controller/persona.php?op=buscarDNI", {pers_dni: pers_dni}, function (response) {
      try {
          var data = JSON.parse(response);
          
          // Depurar el objeto data
          console.log(data);
          
          // Verifica que data contiene el campo "nombre_completo"
          if (data && data.nombre_completo) {
              $("#pers_nom").val(data.nombre_completo);
              $("#pers_id").val(data.pers_id);
          } else {
              console.error("No se encontró el campo 'nombre_completo' en la respuesta");
              $("#pers_nom").val('');
          }
      } catch (e) {
          console.error("Error al procesar la respuesta JSON:", e);
          $("#pers_nom").val('');
          $("#pers_id").val('');
      }
  }).fail(function (jqXHR, textStatus, errorThrown) {
      console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
      $("#pers_nom").val('');
      $("#pers_id").val('');
  });
}
function verDatosbien(cod_bar) {
  const estadosBien = {
    'N': 'Nuevo',
    'B': 'Bueno',
    'R': 'Regular',
    'M': 'Malo'
  };
  $.post(
    "../../controller/objeto.php?op=buscar_obj_barras",
    { cod_bar: cod_bar },
    function (response) {
      console.log(response);

      try {
        var data = JSON.parse(response);
        console.table(data);

        if (!data || !data.bien_id) {
          Swal.fire({
            title: "No se encontraron datos",
            icon: "error",
            confirmButtonText: "Aceptar",
          });
          return;
        }

        // ✅ Mover aquí la conversión del estado
        const estadoBienLegible = estadosBien[data.bien_est] || 'Desconocido';

        var colores = data.bien_color.replace(/[{}]/g, "").split(",");
        var nombresColores = [];
        var completedRequests = 0;

        colores.forEach(function (color_id) {
          get_color_string(color_id.trim(), function (color_nom) {
            nombresColores.push(color_nom);
            completedRequests++;

            if (completedRequests === colores.length) {
              Swal.fire({
                title: '<span style="color: black;">Datos del Objeto</span>',
                html: `
                <table style="width:100%; text-align:left; border-collapse: collapse; border-spacing: 0; font-size: 13px; line-height: 1.2;">
                  <tr>
                    <td style="width:40%; padding: 4px; color:black"><strong>DENOMINACIÓN:</strong></td>
                    <td style="width:60%; padding: 4px; text-align:right;">${data.obj_nombre}</td>
                  </tr>
                  <tr>
                    <td style="width:40%; padding: 4px;  color:black"><strong>FECHA REGISTRO:</strong></td>
                    <td style="width:60%; padding: 4px; text-align:right;">${data.fecharegistro}</td>
                  </tr>
                  <tr>
                    <td style="width:40%; padding: 4px;  color:black"><strong>NÚMERO DE SERIE:</strong></td>
                    <td style="width:60%; padding: 4px; text-align:right;">${data.bien_numserie}</td>
                  </tr>
                  <tr>
                    <td style="width:40%; padding: 4px;  color:black"><strong>ESTADO DEL BIEN:</strong></td>
                    <td style="width:60%; padding: 4px; text-align:right;">${estadoBienLegible}</td>
                  </tr>
                  <tr>
                    <td style="width:40%; padding: 4px;  color:black"><strong>PROCEDENCIA:</strong></td>
                    <td style="width:60%; padding: 4px; text-align:right;">${data.procedencia}</td>
                  </tr>
                  <tr>
                    <td style="width:40%; padding: 4px;  color:black"><strong>DIMENSIONES:</strong></td>
                    <td style="width:60%; padding: 4px; text-align:right;">${data.bien_dim}</td>
                  </tr>
                  <tr>
                    <td style="width:40%; padding: 4px;  color:black"><strong>COLOR:</strong></td>
                    <td style="width:60%; padding: 4px; text-align:right;">${nombresColores.join(", ")}</td>
                  </tr>
                  <tr>
                    <td style="width:40%; padding: 4px;  color:black"><strong>DEPENDENCIA DEL ORIGEN:</strong></td>
                    <td style="width:60%; padding: 4px; text-align:right;">
                      ${data.depe_denominacion ? data.depe_denominacion : 'Sin dependencia asignada'}
                    </td>
                  </tr>
                </table>
                `,
                imageUrl: '../../static/gif/informacion.gif',
                imageWidth: 100,
                imageHeight: 100,
                showCancelButton: false,  
                confirmButtonColor: 'rgb(18, 129, 18)',
                confirmButtonText: 'Aceptar',
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
                      width: 100%;
                      background-color:rgb(18, 129, 18);
                  `;
                  swalBox.appendChild(topBar);
                }
              });
            }
          });
        });
      } catch (error) {
        console.error("Error al analizar la respuesta JSON:", error);
      }
    }
  ).fail(function () {
    Swal.fire({
      title: "Error",
      text: "Hubo un problema al buscar el objeto.",
      icon: "error",
      confirmButtonText: "Aceptar",
    });
  });
}
function quitarbien(cod_bar) {
  var rowToRemove = $("#obj_formato tbody")
    .find("td")
    .filter(function () {
      return $(this).text() == cod_bar;
    })
    .closest("tr");
  rowToRemove.remove();
}
function mostrarDatosObjeto(data, nombresColores) {
  const estadosBien = {
  'N': 'Nuevo',
  'B': 'Bueno',
  'R': 'Regular',
  'M': 'Malo'
  };
  const estadoBienLegible = estadosBien[data.bien_est] || 'Desconocido';
  // Contar la cantidad de filas existentes en la tabla
  var rowCount = $("#obj_formato tbody tr").length;

  // Verificar si la cantidad de filas es menor de 12
  if (rowCount >= 10) {
    // Mostrar un mensaje de error si ya hay 12 filas o más
    Swal.fire({
      title: "Límite alcanzado",
      text: "Ya tienes 12 inserciones, no se pueden agregar más.",
      icon: "error",
      confirmButtonText: "Aceptar",
    });
    return;
  }
  // Mostrar los datos del objeto en un SweetAlert con dos botones
  Swal.fire({
  title: "DATOS DEL OBJETO",
  html: `
  <table style="width:100%; text-align:left; border-collapse: collapse; border-spacing: 0; font-size: 13px; line-height: 1.2;">
    <tr>
      <td style="width:40%; padding:4px;"><strong>DENOMINACIÓN:</strong></td>
      <td style="width:60%; padding:4px; text-align:right;">${data.obj_nombre}</td>
    </tr>
    <tr>
      <td style="width:40%; padding:4px;"><strong>FECHA REGISTRO:</strong></td>
      <td style="width:60%; padding:4px; text-align:right;">${data.fecharegistro}</td>
    </tr>
    <tr>
      <td style="width:40%; padding:4px;"><strong>NÚMERO DE SERIE:</strong></td>
      <td style="width:60%; padding:4px; text-align:right;">${data.bien_numserie}</td>
    </tr>
    <tr>
      <td style="width:40%; padding:4px;"><strong>ESTADO DEL BIEN:</strong></td>
      <td style="width:60%; padding:4px; text-align:right;">${estadoBienLegible}</td>
    </tr>
    <tr>
      <td style="width:40%; padding:4px;"><strong>PROCEDENCIA:</strong></td>
      <td style="width:60%; padding:4px; text-align:right;">${data.procedencia}</td>
    </tr>
    <tr>
      <td style="width:40%; padding:4px;"><strong>DIMENSIONES:</strong></td>
      <td style="width:60%; padding:4px; text-align:right;">${data.bien_dim}</td>
    </tr>
    <tr>
      <td style="width:40%; padding:4px;"><strong>COLOR:</strong></td>
      <td style="width:60%; padding:4px; text-align:right;">${nombresColores.join(", ")}</td>
    </tr>
    <tr>
      <td style="width:40%; padding:4px;"><strong>DEPENDENCIA DEL ORIGEN:</strong></td>
      <td style="width:60%; padding:4px; text-align:right;">
        ${data.depe_denominacion ? data.depe_denominacion : 'Sin dependencia asignada'}
      </td>
    </tr>
  </table>
  `,
  imageUrl: '../../static/gif/informacion.gif',
  imageWidth: 100,
  imageHeight: 100,
  showCancelButton: true,
  confirmButtonColor: 'rgb(18, 129, 18)',
  cancelButtonColor: '#000',
  confirmButtonText: 'Aceptar',
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
        width: 100%;
        background-color:rgb(18, 129, 18);
    `;
    swalBox.appendChild(topBar);
  }

}).then((result) => {
    // Si se hace clic en el botón de aceptar
    if (result.isConfirmed) {
      // Verificar si hay una dependencia asignada
      if (
        data.depe_denominacion !== null &&
        data.depe_denominacion.trim() !== ""
      ) {
        Swal.fire({
          title: "Error",
          text: "Solo se pueden agregar objetos sin dependencias asignadas.",
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

      // Agregar la fila a la tabla solo si no hay dependencia asignada
      var newRow =
        "<tr>" +
        "<td>" + data.bien_codbarras +"</td>" +
        "<td>" + data.obj_nombre +"</td>" +
        "<td>" + nombresColores.join(", ") +  "</td>" +
        "<td>" +
        "<style>" +
        "table { width: 100%; font-size: 1rem; border-collapse: collapse; }" +
        "table tr td { padding: 0.75rem; }" +
        "table tr td select { " +
        "  width: 100%; padding: 0.5rem; border-radius: 0.375rem;" +
        "  border: 1px solid #ced4da; font-size: 1rem;" +
        "  background-color: white; color: #333; outline: none;" +
        "}" +
        "</style>" +
        "<select class='form-select' onchange='actualizarEstado(this, \"" +
        data.bien_codbarras +
        "\")'>" +
        "<option value='N'" +
        (data.bien_est === "N" ? " selected" : "") +
        ">N - Nuevo</option>" +
        "<option value='B'" +
        (data.bien_est === "B" ? " selected" : "") +
        ">B - Bueno</option>" +
        "<option value='R'" +
        (data.bien_est === "R" ? " selected" : "") +
        ">R - Regular</option>" +
        "<option value='M'" +
        (data.bien_est === "M" ? " selected" : "") +
        ">M - Malo</option>" +
        "</select>" +
        "</td>" +
        "<td>" +
        // Agregar una nueva celda con un input de texto para comentarios
        "<input type='text' class='form-control' placeholder='Comentario' onchange='actualizarComentario(this, \"" +
        data.bien_codbarras +
        "\")'>" +
        "</td>" +
       '<td>' +
          '<div class="dropdown">' +
            '<button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">' +
              'Opciones' +
            '</button>' +
            '<ul class="dropdown-menu">' +
              '<li><a class="dropdown-item" href="#" onclick="verDatosbien(\'' + data.bien_codbarras + '\')"><i class="fa fa-eye mx-2"></i> Ver</a></li>' +
              '<li><a class="dropdown-item" href="#" onclick="imprimir(\'' + data.bien_codbarras + '\')"><i class="fa fa-print  mx-2"></i> Imprimir</a></li>' +
              '<li><a class="dropdown-item text-danger" href="#" onclick="quitarbien(\'' + data.bien_codbarras + '\')"><i class="fa fa-trash  mx-2"></i> Eliminar</a></li>' +
            '</ul>' +
          '</div>' +
        '</td>' +
        "</tr>";

      $("#obj_formato tbody").append(newRow);
    } else {
      // Si se hace clic en el botón de cancelar
      console.log("Objeto cancelado");
    }
  });
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