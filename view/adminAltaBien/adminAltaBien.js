var usu_id = $("#usu_idx").val();

$(document).ready(function () {
  var table = $('#bienes_data').DataTable({
    "aProcessing": true,
    "aServerSide": true,
    dom: 'Bfrtip',
    searching: false,
    buttons: [],
    "ajax": {
      url: "../../controller/grupogenerico.php?op=listar_gg_bienes",
      type: "post"
    },
    "bDestroy": true,
    "responsive": true,
    "bInfo": true,
    "iDisplayLength": parseInt($('#cantidad_registros').val()),
    "order": [[0, 'desc']],
    "language": {
      "sProcessing": "Procesando...",
      "sLengthMenu": "Mostrar _MENU_ registros",
      "sZeroRecords": "No se encontraron resultados",
      "sEmptyTable": "Ningún dato disponible en esta tabla",
      "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
      "sSearch": "Buscar:",
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
    },
  });

    $('#filtro_estado').on('change', function () {
        table.column(6).search(this.value).draw();
    });
    $('#cantidad_registros').on('input change', function() {
        var val = parseInt($(this).val());
        if (val > 0) {
            table.page.len(val).draw();
        }
    });
});
