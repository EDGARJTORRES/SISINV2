function initbienes() {
  $("#bien_form").on("submit", function (e) {
    guardaryeditarbienes(e);
  });
}
function buscarDNI() {
  pers_dni = $("#pers_dni").val();

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

function guardaryeditarbienes(e) {
  e.preventDefault();
}

$(document).ready(function () {
  $(".select2").select2();

  $.post("../../controller/dependencia.php?op=combo", function (data) {
    $("#area_asignacion_combo").html(data);
  });
});
function nuevoFormato() {
  // Obtener todas las filas de la tabla
  var rows = $("#obj_formato tbody tr");
  // Validar que haya al menos una fila registrada
  if (rows.length === 0) {
    Swal.fire({
      title: "Error",
      text: "No hay filas registradas en la tabla.",
      icon: "error",
      confirmButtonText: "Aceptar",
    });
    return;
  }
  var depe_receptor = $("#area_asignacion_combo").val();
  if (!depe_receptor) {
    Swal.fire({
      title: "Error",
      text: "Debes seleccionar un área de asignación.",
      icon: "error",
      confirmButtonText: "Aceptar",
    });
    return;
  }

  // Objeto para almacenar los datos asociados a cada código de barras
  var dataDict = {};

  // Iterar sobre cada fila de la tabla
  rows.each(function () {
    // Obtener el código de barras de la primera celda de la fila
    var codigoBarra = $(this).find("td:first").text().trim();

    // Obtener el color de la tercera celda de la fila
    var color = $(this).find("td").eq(2).text().trim();

    // Obtener el estado de la cuarta celda de la fila
    var estado = $(this).find("td").eq(3).find("select").val();
    // Obtener el comentario de la quinta celda de la fila (input)
    var comentario = $(this).find("td").eq(4).find("input").val().trim();

    // Si el código de barras no está vacío, almacenarlo en el diccionario
    if (codigoBarra !== "") {
      dataDict[codigoBarra] = {
        color: color,
        estado: estado,
        comentario: comentario,
      };
    }
  });

  // Mostrar un cuadro de diálogo para pedir un comentario
  Swal.fire({
    title: "Confirmar?",
    text: "¿Está seguro de que desea enviar los datos?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Enviar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      // Si el usuario confirma, se obtiene el comentario ingresado
       // Obtener el botón de envío
       var botonEnviar = Swal.getConfirmButton();

       // Cambiar el ícono del botón a un spinner y bloquear el botón
       botonEnviar.disabled = true;
       botonEnviar.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Enviando...';
        var depe_receptor = $("#area_asignacion_combo").val();
        var pers_id = $("#pers_id").val();

      // Enviar los datos al servidor utilizando una solicitud POST
      $.post(
        "../../controller/formato.php?op=asignar",
        {
          dataDict: JSON.stringify(dataDict),
          depe_receptor: depe_receptor,
          pers_id: pers_id,
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
      ).always(function() {
        // Habilitar el botón de envío nuevamente y restaurar su texto
        botonEnviar.disabled = false;
        botonEnviar.innerHTML = 'Enviar';
    });

      // Mostrar la lista de datos en la consola
      console.log("Datos enviados al servidor:", dataDict);
    }
  });
}

function verFormatoDatos() {
  $("#modalFormato").modal("show");
}
function buscarCodigoRepetido(cod_bar) {
  var codigoRepetido = false;

  // Buscar el código de barras en las filas existentes de la tabla
  $("#obj_formato tbody td:first-child").each(function () {
    if ($(this).text() === cod_bar) {
      codigoRepetido = true;
      return false; // Salir del bucle each() si se encuentra el código repetido
    }
  });

  return codigoRepetido;
}

function buscarBien() {
  var botonBuscar = $("#buscaObjeto");
  var cod_bar = $("#cod_bar").val(); // Obtener el valor del código de barras

  // Verificar si el código de barras ya está en la tabla
  if (buscarCodigoRepetido(cod_bar)) {
    // Mostrar un mensaje de error si el código de barras está repetido
    Swal.fire({
      title: "Error",
      text: "El Objeto ya esta registrado.",
      icon: "error",
      confirmButtonText: "Aceptar",
    });
    return;
  }
  // Cambiar el ícono del botón a un spinner y bloquear el botón
  botonBuscar.attr("disabled", true);
  botonBuscar.html('<i class="fa fa-spinner fa-spin"></i>');

  // Realizar la solicitud POST al servidor para buscar el objeto
  $.post(
    "../../controller/objeto.php?op=buscar_obj_barras",
    { cod_bar: cod_bar },
    function (response) {
      botonBuscar.attr("disabled", false);
      botonBuscar.html('<i class="fa fa-search"></i>');
      try {
        // Intentar analizar la respuesta como JSON
        var data = JSON.parse(response);

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
              // Mostrar los datos del objeto en un SweetAlert con dos botones
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
      nombresColores.join(", ") + // Mostrar los nombres de colores separados por coma
      "<br>" +
      "Dependencia Origen: " +
      data.depe_denominacion,
    icon: "info",
    showCancelButton: true, // Mostrar el botón de cancelar
    confirmButtonText: "Aceptar",
    cancelButtonText: "Cancelar",
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
          icon: "error",
          confirmButtonText: "Aceptar",
        });
        return;
      }

      // Agregar la fila a la tabla solo si no hay dependencia asignada
      var newRow =
        "<tr>" +
        "<td>" +
        data.bien_codbarras +
        "</td>" +
        "<td>" +
        data.obj_nombre +
        "</td>" +
        "<td>" +
        nombresColores.join(", ") +
        "</td>" +
        "<td>" +
        "<style>table tr td select {  width: 100%; padding: 0.5rem;  border-radius: 0.25rem;" +
        "border: 1px solid #ced4da; font-size: 1rem; " +
        "   background-color: white;     color: #8e8ba1;  outline: none;   }</style>" +
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
        '<td><button class="btn btn-info" onclick="verDatosbien(\'' +
        data.bien_codbarras +
        '\')"><i class="fa fa-eye"></i></button></td>' +
        '<td><button class="btn btn-success" onclick="imprimir(\'' +
        data.bien_codbarras +
        '\')"><i class="fa fa-print"></i></button></td>' +
        '<td><button type="button" class="btn btn-danger" onclick="quitarbien(\'' +
        data.bien_codbarras +
        '\')"><i class="fa fa-trash"></i></button></td>' +
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

function quitarbien(cod_bar) {
  // Buscar la fila correspondiente al bien_id
  var rowToRemove = $("#obj_formato tbody")
    .find("td")
    .filter(function () {
      return $(this).text() == cod_bar;
    })
    .closest("tr");

  // Eliminar la fila
  rowToRemove.remove();
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

initbienes();
