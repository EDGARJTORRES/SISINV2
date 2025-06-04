function initbienes() {
  $("#bien_form").on("submit", function (e) {
    guardaryeditarbienes(e);
  });
}
function buscarDNIOrigen() {
   var pers_dni_id = $("#pers_origen_dni").val(); // Obtener el ID del DNI seleccionado
    console.log("ID del DNI seleccionado:", pers_dni_id); // Verifica el ID
    $.post("../../controller/persona.php?op=buscarDNI", { pers_dni: pers_dni_id }, function(response) {
        try {
            var data = JSON.parse(response);
            console.log("Respuesta del servidor:", data); // Verifica la respuesta
            if (data && data.nombre_completo) {
                $("#pers_origen_nom").val(data.nombre_completo); // Llenar el campo de nombre
                $("#pers_id").val(data.pers_id); // Llenar el campo de ID si es necesario
            } else {
                console.error("No se encontró el campo 'nombre_completo' en la respuesta");
                $("#pers_origen_nom").val(''); // Limpiar el campo si no se encuentra el nombre
            }
        } catch (e) {
            console.error("Error al procesar la respuesta JSON:", e);
            $("#pers_origen_nom").val(''); // Limpiar el campo en caso de error
            $("#pers_id").val(''); // Limpiar el campo de ID si es necesario
        }
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
        $("#pers_origen_nom").val(''); // Limpiar el campo en caso de error
        $("#pers_id").val(''); // Limpiar el campo de ID si es necesario
    });
}
function buscarDNIDestino() {
  var pers_dni_id = $("#pers_destino_dni").val(); // Obtener el ID del DNI seleccionado
    console.log("ID del DNI seleccionado:", pers_dni_id); // Verifica el ID
    $.post("../../controller/persona.php?op=buscarDNI", { pers_dni: pers_dni_id }, function(response) {
        try {
            var data = JSON.parse(response);
            console.log("Respuesta del servidor:", data); // Verifica la respuesta
            if (data && data.nombre_completo) {
                $("#pers_destino_nom").val(data.nombre_completo); // Llenar el campo de nombre
                $("#pers_id").val(data.pers_id); // Llenar el campo de ID si es necesario
            } else {
                console.error("No se encontró el campo 'nombre_completo' en la respuesta");
                $("#pers_destino_nom").val(''); // Limpiar el campo si no se encuentra el nombre
            }
        } catch (e) {
            console.error("Error al procesar la respuesta JSON:", e);
            $("#pers_destino_nom").val(''); // Limpiar el campo en caso de error
            $("#pers_id").val(''); // Limpiar el campo de ID si es necesario
        }
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
        $("#pers_destino_nom").val(''); // Limpiar el campo en caso de error
        $("#pers_id").val(''); // Limpiar el campo de ID si es necesario
    });
}

function guardaryeditarbienes(e) {
  e.preventDefault();
}

$(document).ready(function () {

  $(".select2").select2();
  $.post("../../controller/persona.php?op=combo", function (data) {
      $("#pers_origen_dni").html(data);
      $("#pers_destino_dni").html(data);
  });

  $("#pers_origen_dni").change(function() {
      buscarDNIOrigen();
  });
   $("#pers_destino_dni").change(function() {
      buscarDNIDestino();
  });

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
  console.log(cod_bar);
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
                title: "Datos del Objeto",
                html:
                  "Denominacion: " +
                  data.obj_nombre +
                  "<br>" +
                  "Fecha de Registro: " +
                  data.fecharegistro +
                  "<br>" +
                  "Número de Serie: " +
                  data.bien_numserie +
                  "<br>" +
                  "Estado del Bien: " +
                  data.bien_est +
                  "<br>" +
                  "Dimensiones: " +
                  data.bien_dim +
                  "<br>" +
                  "Color: " +
                  nombresColores.join(", ") +
                  "<br>" +
                  "Dependencia Origen: " +
                  (data.depe_denominacion ? data.depe_denominacion : "N/A"),
                icon: "info",
                showCancelButton: false, // No mostrar el botón de cancelar
                confirmButtonText: "Aceptar",
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
      icon: "error",
      confirmButtonText: "Aceptar",
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
      icon: "error",
      confirmButtonText: "Aceptar",
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
    title: "¿Confirmar?",
    text: "¿Está seguro de que desea enviar los datos?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Enviar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      // Si el usuario confirma, enviar datos al servidor
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
        title: "Éxito",
        text: "Se agregaron los bienes correctamente.",
        icon: "success",
        confirmButtonText: "Aceptar",
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

// Función para validar el número de checkboxes seleccionados// Inicializar el contador global de checkboxes seleccionados
let contadorSeleccionados = 0;

// Función para validar la selección de checkboxes
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
