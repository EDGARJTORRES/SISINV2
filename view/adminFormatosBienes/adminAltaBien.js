var usu_id = $("#usu_idx").val();

$(document).ready(function(){
   var table = $('#formatos_data').DataTable({
      "aProcessing": true,
      "aServerSide": true,
      dom: 'Bfrtip',
      searching: true,
      buttons: [
      ],
      "ajax":{
          url:"../../controller/formato.php?op=listar",
          type:"post"
      },
      "bDestroy": true,
      "responsive": true,
      "bInfo":true,
      "iDisplayLength": parseInt($('#cantidad_registros').val()),
      "ordering": true, 
      "order": [[0, 'desc']],
      "language": {
          "sProcessing":     "Procesando...",
          "sLengthMenu":     "Mostrar _MENU_ registros",
          "sZeroRecords":    "No se encontraron resultados",
          "sEmptyTable":     "Ningún dato disponible en esta tabla",
          "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
          "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
          "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
          "sInfoPostFix":    "",
          "sSearch":         "Buscar:",
          "sUrl":            "",
          "sInfoThousands":  ",",
          "sLoadingRecords": "Cargando...",
          "oPaginate": {
              "sFirst":    "Primero",
              "sLast":     "Último",
              "sNext":     "Siguiente",
              "sPrevious": "Anterior"
          },
          "oAria": {
              "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
              "sSortDescending": ": Activar para ordenar la columna de manera descendente"
          }
      },
  });
    $('#cantidad_registros').on('input change', function() {
    var val = parseInt($(this).val());
        if (val > 0) {
            table.page.len(val).draw();
        }
    });
    $('#buscar_registros').on('input', function () {
        table.search(this.value).draw();
    });
    $('#filtro_anexo').on('change', function () {
        let value = $(this).val();

        if (value === "0") {
            // Mostrar todos
            table.column(1).search('').draw();
        } else if (value === "Asignacion") {
            table.column(1).search('ASIGNACIÓN', true, false).draw();
        } else if (value === "Desplazamiento") {
            table.column(1).search('DESPLAZAMIENTO', true, false).draw();
        }
    });

});