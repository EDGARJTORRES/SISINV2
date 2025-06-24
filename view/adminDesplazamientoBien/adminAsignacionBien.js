function buscarDNIOrigen() {
  pers_dni = $("#pers_origen_dni").val();

  $.post(
    "../../controller/persona.php?op=buscarDNI",
    { pers_dni: pers_dni },
    function (response) {
      try {
        var data = JSON.parse(response);

        // Depurar el objeto data
        console.log(data);

        // Verifica que data contiene el campo "nombre_completo"
        if (data && data.nombre_completo) {
          $("#pers_origen_nom").val(data.nombre_completo);
          $("#pers_origen_id").val(data.pers_id);
          listarBienesRepre(data.pers_id);
        } else {
          console.error(
            "No se encontró el campo 'nombre_completo' en la respuesta"
          );
          $("#pers_origen_nom").val("");
        }
      } catch (e) {
        console.error("Error al procesar la respuesta JSON:", e);
        $("#pers_origen_nom").val("");
        $("#pers_origen_dni").val("");
      }
    }
  ).fail(function (jqXHR, textStatus, errorThrown) {
    console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
    $("#pers_origen_nom").val("");
    $("#pers_origen_id").val("");
  });
}
function buscarDNIDestino() {
  pers_dni = $("#pers_destino_dni").val();

  $.post(
    "../../controller/persona.php?op=buscarDNI",
    { pers_dni: pers_dni },
    function (response) {
      try {
        var data = JSON.parse(response);

        // Depurar el objeto data
        console.log(data);

        // Verifica que data contiene el campo "nombre_completo"
        if (data && data.nombre_completo) {
          $("#pers_destino_nom").val(data.nombre_completo);
          $("#pers_destino_id").val(data.pers_id);
        } else {
          console.error(
            "No se encontró el campo 'nombre_completo' en la respuesta"
          );
          $("#pers_destino_nom").val("");
        }
      } catch (e) {
        console.error("Error al procesar la respuesta JSON:", e);
        $("#pers_destino_nom").val("");
        $("#pers_destino_dni").val("");
      }
    }
  ).fail(function (jqXHR, textStatus, errorThrown) {
    console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
    $("#pers_destino_nom").val("");
    $("#pers_destino_id").val("");
  });
}
function listarBienesRepre(pers_id) {
  $("#obj_formato").DataTable({
    aProcessing: true,
    aServerSide: true,
    dom: "Bfrtip",
    searching: true,
    buttons: [],
    ajax: {
      url: "../../controller/objeto.php?op=listarBienRepre",
      type: "post",
      data: { pers_id, pers_id },
    },
    bDestroy: true,
    responsive: false,
    bInfo: false,
    iDisplayLength: 10,
    ordering: false,
    language: {
      sProcessing: "Procesando...",
      sLengthMenu: "Mostrar _MENU_ registros",
      sZeroRecords: "No se encontraron resultados",
      sEmptyTable: "Ningún dato disponible en esta tabla",
      sInfo:
        "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
      sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
      sInfoPostFix: "",
      sSearch: "Buscar:",
      sUrl: "",
      sInfoThousands: ",",
      sLoadingRecords: "Cargando...",
      oPaginate: {
        sFirst: "Primero",
        sLast: "Último",
        sNext: "Siguiente",
        sPrevious: "Anterior",
      },
      oAria: {
        sSortAscending:
          ": Activar para ordenar la columna de manera ascendente",
        sSortDescending:
          ": Activar para ordenar la columna de manera descendente",
      },
    },
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
      // Si se reciben datos del servidor
      console.log(response);

      try {
        // Intentar analizar la respuesta como JSON
        var data = JSON.parse(response);
        console.table(data);

        // Si no se reciben datos del servidor
        if (!data || !data.bien_id) {
          // Mostrar un mensaje de error
          Swal.fire({
            title: "No se encontraron datos",
            icon: "error",
            confirmButtonText: "Aceptar",
          });
          return;
        }
        // Convertir la cadena de colores en un array
        var colores = data.bien_color.replace(/[{}]/g, "").split(",");
        const estadoBienLegible = estadosBien[data.bien_est] || 'Desconocido';

        // Obtener los nombres de los colores
        var nombresColores = [];
        var completedRequests = 0;
        colores.forEach(function (color_id) {
          get_color_string(color_id.trim(), function (color_nom) {
            nombresColores.push(color_nom);
            completedRequests++;

            // Si se han obtenido todos los nombres de colores
            if (completedRequests === colores.length) {
              // Mostrar los datos del objeto en un SweetAlert
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
    // Si hay un error en la solicitud POST
    Swal.fire({
      title: "Error",
      text: "Hubo un problema al buscar el objeto.",
      icon: "error",
      confirmButtonText: "Aceptar",
    });
  });
}
let contadorSeleccionados = 0;
function validarCheckbox(checkbox) {
  // Si el checkbox está marcado, aumentar el contador
  if (checkbox.checked) {
    contadorSeleccionados++;
  } else {
    // Si el checkbox está desmarcado, disminuir el contador
    contadorSeleccionados--;
  }
  // Verificar si se ha superado el límite de 10 checkboxes seleccionados
  if (contadorSeleccionados > 10) {
    // Mostrar un mensaje de advertencia al usuario
    Swal.fire({
      title: "Error",
      text: "Solo se pueden seleccionar 10 bienes por formato.",
      icon: "error",
      confirmButtonText: "Aceptar",
    });

    // Desmarcar el checkbox que causó que se supere el límite
    checkbox.checked = false;

    // Disminuir el contador porque se desmarcó el checkbox
    contadorSeleccionados--;
  }
}