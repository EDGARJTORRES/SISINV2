
var usu_id = $('#usu_idx').val();

function initdocumento(){
    $("#documento_form").on("submit",function(e){
    e.preventDefault();
    });
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
    "order": [[0, "desc"]],
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

function nuevoregistro(){
  $('#lbltitulo').html('<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-screen-share ms-3"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M21 12v3a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1v-10a1 1 0 0 1 1 -1h9" /><path d="M7 20l10 0" /><path d="M9 16l0 4" /><path d="M15 16l0 4" /><path d="M17 4h4v4" /><path d="M16 9l5 -5" /></svg> SUBIR NUEVO DOCUMENTO FIRMADO');
  $('#modalRegistrar').modal('show');
}

initdocumento();
