function initbienes() {
  $("#bien_form").on("submit", function (e) {
    guardaryeditarbienes(e);
  });
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
function guardaryeditarbienes(e) {
  e.preventDefault();
}
$(document).ready(function () {
  $(".select2").select2();

  $.post("../../controller/dependencia.php?op=combo", function (data) {
    $("#area_asignacion_combo").html(data);
  });
  $("#cod_bar").on("input", function () {
    let valor = $(this).val();
    $(this).val(valor.replace(/'/g, "-"));
  });
});

function nuevoFormato() {
  var rows = $("#obj_formato tbody tr");
  if (rows.length === 0) {
    Swal.fire({
      title: "Error",
      text: "No hay filas registradas en la tabla.",
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

  // Validación: área de asignación no seleccionada
  var depe_receptor = $("#area_asignacion_combo").val();
  if (!depe_receptor) {
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

  // Recolección de datos
  var dataDict = {};
  rows.each(function () {
    var codigoBarra = $(this).find("td:first").text().trim();
    var color = $(this).find("td").eq(2).text().trim();
    var estado = $(this).find("td").eq(3).find("select").val();
    var comentario = $(this).find("td").eq(4).find("input").val().trim();

    if (codigoBarra !== "") {
      dataDict[codigoBarra] = {
        color: color,
        estado: estado,
        comentario: comentario,
      };
    }
  });

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
      var botonEnviar = Swal.getConfirmButton();
      botonEnviar.disabled = true;
      botonEnviar.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" class="tabler-loader" viewBox="0 0 24 24" fill="none" stroke="currentColor">
          <path d="M12 4v4" />
          <path d="M12 16v4" />
          <path d="M4 12h4" />
          <path d="M16 12h4" />
          <circle cx="12" cy="12" r="7"/>
        </svg> Enviando...
      `;
       mostrarLoader();
      var depe_receptor = $("#area_asignacion_combo").val();
      var pers_id = $("#pers_id").val();
      $.post(
        "../../controller/formato.php?op=asignar",
        {
          dataDict: JSON.stringify(dataDict),
          depe_receptor: depe_receptor,
          pers_id: pers_id,
        },
        function (response) {
          // Éxito
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
            $("#obj_formato tbody").empty();
            window.location.href = "../../view/adminFormatosBienes/index.php";
          });
        }
      ).always(function () {
        botonEnviar.disabled = false;
        botonEnviar.innerHTML = 'Enviar';
        ocultarLoader();
      });
    }
  });
}
function verFormatoDatos() {
  $("#modalFormato").modal("show");
}
function resetCampos() {
  const campos = document.querySelectorAll('input, select, textarea');
  campos.forEach(campo => {
    const tag = campo.tagName.toUpperCase();
    if (tag === 'INPUT') {
      switch (campo.type) {
        case 'text':
        case 'password':
        case 'email':
        case 'number':
        case 'search':
        case 'tel':
        case 'url':
        case 'date':
        case 'datetime-local':
        case 'time':
        case 'month':
        case 'week':
          campo.value = '';
          break;
        case 'checkbox':
        case 'radio':
          campo.checked = false;
          break;
      }

    } else if (tag === 'SELECT') {
      if (campo.classList.contains('select2-hidden-accessible')) {
        $(campo).val(null).trigger('change');
      } else {
        campo.selectedIndex = 0;
      }

    } else if (tag === 'TEXTAREA') {
      campo.value = '';
    }
  });
}
function buscarCodigoRepetido(cod_bar) {
  var codigoRepetido = false;
  $("#obj_formato tbody td:first-child").each(function () {
    if ($(this).text() === cod_bar) {
      codigoRepetido = true;
      return false;
    }
  });

  return codigoRepetido;
}
function buscarBien() {
  var botonBuscar = $("#buscaObjeto");
  var cod_bar = $("#cod_bar").val().replace(/'/g, "-");
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
            '<button class="btn btn-btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">' +
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