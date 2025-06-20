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