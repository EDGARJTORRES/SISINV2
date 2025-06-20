function mostrarLoader() {
  const loader = document.getElementById('page');
  loader.style.visibility = 'visible';
  loader.style.opacity = '1';
  loader.style.pointerEvents = 'auto';
}

function ocultarLoader() {
  const loader = document.getElementById('page');
  loader.style.visibility = 'hidden';
  loader.style.opacity = '0';
  loader.style.pointerEvents = 'none';
}

function initbienes() {
  $("#bien_form").on("submit", function (e) {
    guardaryeditarbienes(e);
  });
}
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

function guardaryeditarbienes(e) {
  e.preventDefault();
}

$(document).ready(function () {

  $(".select2").select2();
  

  $.post("../../controller/dependencia.php?op=combo", function (data) {
    $("#area_destino_combo").html(data);
    $("#area_origen_combo").html(data);
  });
});

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
function nuevoFormato() {
  var table = $("#obj_formato").DataTable(); // Asegúrate de que es la tabla correcta
  var filasConCheckboxActivo = [];

  // Recorre todas las filas de la tabla
  table.rows().every(function (rowIdx, tableLoop, rowLoop) {
    // Obtener la celda con el checkbox
    var cell1 = table.cell({ row: rowIdx, column: 6 }).node(); // Ajusta el índice de la columna si es necesario

    // Comprobar si el checkbox está marcado
    if ($("input[type='checkbox']", cell1).prop("checked") == true) {
      // Añadir la fila al array de filas con checkboxes activados
      filasConCheckboxActivo.push(this.data());
    }
  });

  // Comprobar si hay filas activadas
  if (filasConCheckboxActivo.length === 0) {
    Swal.fire({
       title: "Error",
       text: "No hay filas registradas en la tabla.",
       imageUrl: '../../static/gif/letra-x.gif',
       imageWidth: 100,
       imageHeight: 100,
       confirmButtonText: 'Aceptar',
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

  // Obtener los valores de los selectores de áreas
  var depeReceptor = $("#area_destino_combo").val();
  var depeEmisor = $("#area_origen_combo").val();

  // Validar que se haya seleccionado un área de asignación
  if (!depeReceptor) {
    Swal.fire({
      title: "Error",
      text: "Debes seleccionar un área de asignación.",
      imageUrl: '../../static/gif/asignar.gif',
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

  // Objeto para almacenar los datos asociados a cada fila
  var dataDict = {};
  table
    .rows()
    .nodes()
    .each(function (row) {
      // Encontrar el checkbox dentro de la fila
      var checkbox = $(row).find("input[type='checkbox']");

      // Verificar si el checkbox está marcado
      if (checkbox.is(":checked")) {
        // Extraer el estado del select de la fila
        var codigoBarra = $(row).find("td").eq(0).text().trim();
        var estado = $(row).find("select").val();
        var comentario = $(row).find("input").val();
        dataDict[codigoBarra] = {
          estado: estado,
          comentario: comentario,
        };
      }
    });

  // Mostrar confirmación
  Swal.fire({
    title: "Advertencia",
    text: "¿Está seguro de que desea enviar los datos?",
    showCancelButton: true,
    confirmButtonText: "Enviar",
    cancelButtonText: "Cancelar",
    imageUrl: '../../static/gif/advertencia.gif',
    imageWidth: 100,
    imageHeight: 100,
    confirmButtonColor: 'rgb(255, 102, 0)',
    cancelButtonColor: '#000',
    backdrop: true,
    didOpen: () => {
      const swalBox = Swal.getPopup();
      const topBar = document.createElement('div');
      topBar.id = 'top-progress-bar';
      topBar.style.cssText = `
          position: absolute;
          top: 0;
          left: 0;
          height: 5px;
          width: 0%;
          background-color:rgb(255, 102, 0);
          transition: width 0.4s ease;
      `;
      swalBox.appendChild(topBar);
      setTimeout(() => {
        topBar.style.width = '40%';
      }, 300);
    }
  }).then((result) => {
    if (result.isConfirmed) {
      console.table(depeReceptor);
      console.table(depeEmisor);
      enviarDatosAlServidor(dataDict, depeReceptor, depeEmisor);
    }
  });
}

function enviarDatosAlServidor(dataDict, depeReceptor, depeEmisor) {
  // Obtener los IDs de origen y destino
  var persOrigenId = $("#pers_origen_id").val();
  var persDestinoId = $("#pers_destino_id").val();

  console.table(persOrigenId);
  console.table(persDestinoId);
  // Enviar los datos al servidor
  mostrarLoader();
  $.post(
    "../../controller/formato.php?op=desplazar",
    {
      dataDict: JSON.stringify(dataDict),
      depe_receptor: depeReceptor,
      depe_emisor: depeEmisor,
      pers_origen_id: persOrigenId,
      pers_destino_id: persDestinoId,
    },
    function (response) {
      // Manejar la respuesta del servidor
      Swal.fire({
         title: "Correcto",
         html: `
          <p>Se agregaron los bienes correctamente.</p>
          <div id="top-progress-bar-final" style="
            position: absolute;
            top: 0;
            left: 0;
            height: 5px;
            width: 0%;
            background-color:rgb(16, 141, 16);
            transition: width 0.6s ease;">
          </div>
        `,
        imageUrl: '../../static/gif/verified.gif',
        imageWidth: 100,
        imageHeight: 100,
        confirmButtonText: "Aceptar",
        confirmButtonColor: 'rgb(16, 141, 16)',
        backdrop: true,
        didOpen: () => {
          const bar = document.getElementById('top-progress-bar-final');
          setTimeout(() => {
            bar.style.width = '100%';
          }, 100);
        }
      }).then(() => {
        // Limpiar la tabla después de que el usuario haga clic en "Aceptar"
         $("#obj_formato tbody").empty();
        window.location.href = "../../view/adminFormatosBienes/index.php";
      });
    }
  ).always(function () {
    // Restaurar el botón de envío
    var botonEnviar = Swal.getConfirmButton();
    botonEnviar.disabled = false;
    botonEnviar.innerHTML = "Enviar";
    ocultarLoader();
  });
}

function verFormatoDatos() {
  $("#modalFormato").modal("show");
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

function imprimir(bien_codbarras) {
  console.log(bien_codbarras);
  redirect_by_post(
    "../../controller/stick.php?op=imprimir_barras",
    { bien_codbarras, bien_codbarras },
    true
  );
}
function imprimirGrupo(depe_id) {
  redirect_by_post(
    "../../controller/stick.php?op=imprimirDependencia",
    { depe_id, depe_id },
    true
  );
}

function eliminarformato(form_id) {
  console.log(form_id);
  swal
    .fire({
      title: "Eliminar!",
      text: "Desea Eliminar el Registro?",
      icon: "error",
      confirmButtonText: "Si",
      showCancelButton: true,
      cancelButtonText: "No",
    })
    .then((result) => {
      if (result.value) {
        $.post(
          "../../controller/formato.php?op=eliminar_formato",
          { form_id: form_id },
          function (data) {
            $("#formatos_data").DataTable().ajax.reload();

            Swal.fire({
              title: "Correcto!",
              text: "Se Elimino Correctamente",
              icon: "success",
              confirmButtonText: "Aceptar",
            });
          }
        );
      }
    });
}

function redirect_by_post(purl, pparameters, in_new_tab) {
  pparameters = typeof pparameters == "undefined" ? {} : pparameters;
  in_new_tab = typeof in_new_tab == "undefined" ? true : in_new_tab;

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
  $.each(pparameters, function (key) {
    $(form).append(
      '<input type="text" name="' + key + '" value="' + this + '" />'
    );
  });
  document.body.appendChild(form);
  form.submit();
  document.body.removeChild(form);

  return false;
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

initbienes();
