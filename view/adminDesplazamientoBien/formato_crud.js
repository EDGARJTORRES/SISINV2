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

  // Obtener el valor del documento que autoriza el traslado
  var docTraslado = $("#doc_traslado").val();

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
      doc_traslado: docTraslado // <-- Agrega aquí el campo
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
function verFormatoDatos() {
  $("#modalFormato").modal("show");
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