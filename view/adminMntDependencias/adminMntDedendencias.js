var usu_id = $("#usu_idx").val();

$(document).ready(function(){


  var table =  $('#dependencias_objetos').DataTable({
      "aProcessing": true,
      "aServerSide": true,
      dom: 'Bfrtip',
      searching: true,
      buttons: [
      ],
      "ajax":{
          url:"../../controller/dependencia.php?op=listarBienesBaja",
          type:"post"
      },
      "bDestroy": true,
      "responsive": true,
      "bInfo":true,
      "iDisplayLength":5,
      "order": [[0, "desc"]], 
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
    $('#buscar_dependencia').on('input', function () {
        table.search(this.value).draw();
    });
    $('#filtro_bienes').on('input', function () {
        const valorMaximo = parseInt($(this).val(), 10);
        $('#valor_bienes').text(valorMaximo); 

        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        const totalBienes = parseInt(data[2]) || 0; 
        return totalBienes <= valorMaximo;
        });

        table.draw();
        $.fn.dataTable.ext.search.pop();
    });


});