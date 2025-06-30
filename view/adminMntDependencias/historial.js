function verBienesBaja(depe_id) {
    $('#modalHistorial').modal('show');
    $('#tblHistorial').DataTable({
        destroy: true,
        processing: true,
        serverSide: false,
        drawCallback: function () {
        },
        ajax: {
            url: "../../controller/dependencia.php?op=listarBienesBajaPorArea",
            type: "POST",
            data: { depe_id: depe_id }
        },
        columnDefs: [
            {
            targets: [0,1, 2, 3,4, 5, 6,7,8,9], 
            render: function (data, type, row) {
            if (data === '---') {
               return '<span class="valor-faltante">N/A</span>';
            }
            return data;
            }
            }
        ],
        bDestroy: true,
        responsive: true,
        bInfo: true,
        iDisplayLength: 10,
        ordering: true,
        searching: true,
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
}
