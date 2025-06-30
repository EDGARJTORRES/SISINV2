
var usu_id = $('#usu_idx').val();
function initdocumento(){
    $("#documento_form").on("submit",function(e){
    e.preventDefault();
    guardaryeditar(); 
    });
}
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

function mostrarAlertaCarga() {
  document.getElementById('alerta-carga').style.display = 'block';
}

// Ocultar alerta
function ocultarAlertaCarga() {
  document.getElementById('alerta-carga').style.display = 'none';
}

$(document).ready(function () {
   setTimeout(() => {
       $('.buttons-collection')
      .removeClass('btn-secondary')
      .addClass('btn');
    }, 300);
    let inicioCarga;
    let tiempoMinimo = 3000; 

    $('#documento_data').on('preXhr.dt', function () {
        mostrarAlertaCarga();
        inicioCarga = new Date().getTime();
    });

    $('#documento_data').on('xhr.dt', function () {
        let finCarga = new Date().getTime();
        let duracion = finCarga - inicioCarga;
        let tiempoRestante = tiempoMinimo - duracion;

        if (tiempoRestante > 0) {
            setTimeout(function () {
                ocultarAlertaCarga();
            }, tiempoRestante);
        } else {
            ocultarAlertaCarga();
        }
    });
  var table = $('#documento_data').DataTable({
    "aProcessing": true,
    "aServerSide": true,
    dom: 'Bfrtip',
    searching: true,
     buttons: [],
    "ajax": {
      url: "../../controller/documento.php?op=get_documentos_firmados",
      type: "post"
    },
    "bDestroy": true,
    "responsive": true,
    "bInfo": true,
    "iDisplayLength":10,
    "order": [[4, "desc"]],
    "language": {
      "sProcessing": "Procesando...",
      "sLengthMenu": "Mostrar _MENU_ registros",
      "sZeroRecords": "No se encontraron resultados",
      "sEmptyTable": "Ningún dato disponible en esta tabla",
      "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
      "sSearch": "Buscar:",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
      },
      "oAria": {
        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
    }
  });
  $('#buscar_documento').on('input', function () {
    table.search(this.value).draw();
  });
});

function editarDocumento(doc_id) {
  $.post("../../controller/documento.php?op=mostrar", { doc_id: doc_id }, function (data) {
    data = JSON.parse(data);
    $('#doc_id').val(data.doc_id);
    $('#doc_tipo').val(data.doc_tipo);
    $('#depe_id').val(data.depe_id);
    $('#doc_desc').val(data.doc_desc);
    $('#doc_ruta').val(data.doc_ruta);
    $('#pers_id').val(data.pers_id);
     $.post("../../controller/dependencia.php?op=combo", function (html) {
      $("#area_asignacion_combo").html(html).val(data.depe_id).trigger('change');
    });

    // Cargar usuario y seleccionar
    $.post("../../controller/persona.php?op=combo", function (html) {
      $("#usuario_combo").html(html).val(data.pers_id).trigger('change');
    });

    $('#lbltitulo').html(`
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round" stroke-linejoin="round"
        class="icon icon-tabler icon-tabler-edit ms-3">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
        <path d="M16 5l3 3"/>
      </svg> EDITAR DOCUMENTO FIRMADO`);

    if (data.doc_ruta) {
      const nombre = data.doc_ruta.split('/').pop();
      $('#upload_content').html(`
        <span class="upload-area-title text-center w-100">
          <i class="fa-solid fa-file-pdf me-2"></i> ${nombre}
        </span>
      `);
    }
    $('#modalRegistrar').modal('show');
  });
}

function eliminarDocumento(doc_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡Esta acción no se puede deshacer!",
        imageUrl: '../../static/gif/advertencia.gif',
        imageWidth: 100,
        imageHeight: 100,
        showCancelButton: true,
        confirmButtonColor: 'rgb(243, 18, 18)', 
        cancelButtonColor: '#000', 
        confirmButtonText: 'Sí, eliminarlo',
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
                background-color: rgb(243, 18, 18);
                transition: width 0.4s ease;
            `;
            swalBox.appendChild(topBar);
            setTimeout(() => {
                topBar.style.width = '40%';
            }, 300);
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '../../controller/documento.php?op=eliminar',
                type: 'POST',
                data: { doc_id: doc_id },
                success: function (response) {
                    $('#documento_data').DataTable().ajax.reload();

                    Swal.fire({
                        title: '¡Eliminado!',
                        html: `
                            <p>El documento ha sido eliminado correctamente.</p>
                            <div id="top-progress-bar-final" style="
                                position: absolute;
                                top: 0;
                                left: 0;
                                height: 5px;
                                width: 0%;
                                background-color: rgb(243, 18, 18);
                                transition: width 0.6s ease;
                            "></div>
                        `,
                        imageUrl: '../../static/gif/verified.gif',
                        imageWidth: 100,
                        imageHeight: 100,
                        showConfirmButton: true,
                        confirmButtonColor: 'rgb(243, 18, 18)',
                        backdrop: true,
                        didOpen: () => {
                            const bar = document.getElementById('top-progress-bar-final');
                            setTimeout(() => {
                                bar.style.width = '100%';
                            }, 100);
                        }
                    });
                },
                error: function () {
                    Swal.fire('Error', 'No se pudo eliminar el documento.', 'error');
                }
            });
        }
    });
}


function guardaryeditar() {
  mostrarLoader();
  const form = document.getElementById('documento_form');
  const formData = new FormData(form);

  const archivo = document.getElementById('archivo_pdf').files[0];
  const doc_id = $('#doc_id').val();

  // Validación manual si es nuevo registro
  if (!archivo && !doc_id) {
    ocultarLoader();
      Swal.fire({
      imageUrl: '../../static/gif/pdf.gif',
      imageWidth: 100,
      imageHeight: 100, 
      title: 'Error',
      text: 'Debe adjuntar un archivo PDF.',
      confirmButtonText: 'Aceptar',
      confirmButtonColor: 'rgb(223, 6, 6)'
    });
    return;
  }

  $.ajax({
    url: "../../controller/documento.php?op=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function () {
      $('#documento_form')[0].reset();
      $('#modalRegistrar').modal('hide');
      $('#documento_data').DataTable().ajax.reload();
      ocultarLoader();
      Swal.fire({
        title: '¡Correcto!',
        text: 'Se registró correctamente.',
        imageUrl: '../../static/gif/verified.gif',
        imageWidth: 100,
        imageHeight: 100,
        confirmButtonText: 'Aceptar',
        confirmButtonColor: 'rgb(18, 129, 18)',
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
              background-color:rgb(16, 141, 16);
              transition: width 0.4s ease;
          `;
          swalBox.appendChild(topBar);

          setTimeout(() => {
            topBar.style.width = '100%';
          }, 300);
        }
      });
    },
    error: function () {
      ocultarLoader();
      Swal.fire('Error', 'No se pudo guardar el documento.', 'error');
    }
  });
}


function nuevoregistro() {
  const form = document.getElementById('documento_form');
  form.reset();
  $(form).find('select.select2').val(null).trigger('change');
  document.getElementById('upload_content').innerHTML = `
  <span class="upload-area-icon">
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="35" height="35" viewBox="0 0 340.531 419.116">
      <defs>
        <clipPath id="clip-files-new">
          <rect width="340.531" height="419.116" />
        </clipPath>
      </defs>
      <g id="files-new" clip-path="url(#clip-files-new)">
        <path id="Union_2" data-name="Union 2" d="M-2904.708-8.885A39.292,39.292,0,0,1-2944-48.177V-388.708A39.292,39.292,0,0,1-2904.708-428h209.558a13.1,13.1,0,0,1,9.3,3.8l78.584,78.584a13.1,13.1,0,0,1,3.8,9.3V-48.177a39.292,39.292,0,0,1-39.292,39.292Zm-13.1-379.823V-48.177a13.1,13.1,0,0,0,13.1,13.1h261.947a13.1,13.1,0,0,0,13.1-13.1V-323.221h-52.39a26.2,26.2,0,0,1-26.194-26.195v-52.39h-196.46A13.1,13.1,0,0,0-2917.805-388.708Zm146.5,241.621a14.269,14.269,0,0,1-7.883-12.758v-19.113h-68.841c-7.869,0-7.87-47.619,0-47.619h68.842v-18.8a14.271,14.271,0,0,1,7.882-12.758,14.239,14.239,0,0,1,14.925,1.354l57.019,42.764c.242.185.328.485.555.671a13.9,13.9,0,0,1,2.751,3.292,14.57,14.57,0,0,1,.984,1.454,14.114,14.114,0,0,1,1.411,5.987,14.006,14.006,0,0,1-1.411,5.973,14.653,14.653,0,0,1-.984,1.468,13.9,13.9,0,0,1-2.751,3.293c-.228.2-.313.485-.555.671l-57.019,42.764a14.26,14.26,0,0,1-8.558,2.847A14.326,14.326,0,0,1-2771.3-147.087Z" transform="translate(2944 428)" fill="var(--c-action-primary)"></path>
      </g>
    </svg>
  </span>
  <span class="upload-area-title">Arrastre el archivo aquí o haga clic</span>
  <span class="upload-area-description">
    Solo se permiten archivos PDF firmados.<br /><strong>Clic Aquí</strong>
  </span>
`;
  document.getElementById('archivo_pdf').value = "";
  $('#lbltitulo').html(`
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-screen-share ms-3">
      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
      <path d="M21 12v3a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1v-10a1 1 0 0 1 1 -1h9" />
      <path d="M7 20l10 0" /><path d="M9 16l0 4" /><path d="M15 16l0 4" /><path d="M17 4h4v4" /><path d="M16 9l5 -5" />
    </svg> SUBIR NUEVO DOCUMENTO FIRMADO
  `);

  // Mostrar modal
  $('#modalRegistrar').modal('show');
}

initdocumento();
