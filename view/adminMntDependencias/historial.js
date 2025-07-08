function verBienesBaja(depe_id) {
  $('#modalHistorial').modal('show');

  // Esperar a que el DOM y el modal estén listos
  setTimeout(() => {
    var table = $('#tblHistorial').DataTable({
      destroy: true,
      aProcessing: true,
      aServerSide: true,
      dom: 'Bfrtip',
      searching: true,
      lengthChange: false,
      buttons: [
        {
            extend: 'collection',
            text: `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                    <path d="M7 11l5 5l5 -5" />
                    <path d="M12 4v12" />
                </svg> Exportar`,
            buttons: [
            {
                extend: 'copyHtml5',
                text: `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clipboard" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 4h6a2 2 0 0 1 2 2v1h-10v-1a2 2 0 0 1 2 -2" /><path d="M9 4v1h6v-1" /><path d="M9 10h6" /><path d="M9 14h6" /><path d="M9 18h6" /><path d="M5 7v14h14v-14" /></svg> Copiar`,
                exportOptions: {
                columns: [ 0,1,2,3,4,5,6,7,8] 
                },
            },
            {
                extend: 'csvHtml5',
                text: `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-type-csv" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M10 13l1 2l1 -2l1 2l1 -2" /></svg> CSV`,
                exportOptions: {
                columns: [ 0,1,2,3,4,5,6,7,8] 
                },
            },
            {
                extend: 'excelHtml5',
                text: `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-spreadsheet" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M8 11h8v7h-8z" /><path d="M8 15h8" /><path d="M11 11v7" /></svg> Excel`,
                exportOptions: {
                columns: [ 0,1,2,3,4,5,6,7,8] 
                },
            },
            {
                extend: 'pdfHtml5',
                text: `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-type-pdf" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M10 12h1v4" /><path d="M14 12h1a1 1 0 0 1 0 2h-1v2" /><path d="M10 16h1" /></svg> PDF`,
                orientation: 'landscape',
                pageSize: 'A4',
                exportOptions: {
                columns: [ 0,1,2,3,4,5,6,7,8] 
                },
                customize: function (doc) {
                doc.defaultStyle.fontSize = 10;
                }
            },
            {
                extend: 'print',
                text: `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-printer" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9v-4a1 1 0 0 1 1 -1h10a1 1 0 0 1 1 1v4" /><path d="M6 18h12" /><path d="M6 14h12" /><path d="M9 18v3h6v-3" /><path d="M4 13v-2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v2" /></svg> Imprimir`,
                exportOptions: {
                columns: [ 0,1,2,3,4,5,6,7,8] 
                }
            }
            ]
        }
        ],
      ajax: {
        url: "../../controller/dependencia.php?op=listarBienesBajaPorArea",
        type: "POST",
        data: { depe_id: depe_id }
      },
      responsive: true,
      bInfo: true,
      iDisplayLength: 10,
      ordering: true,
      language: {
        sProcessing: "Procesando...",
        sLengthMenu: "Mostrar _MENU_ registros",
        sZeroRecords: "No se encontraron resultados",
        sEmptyTable: "Ningún dato disponible en esta tabla",
        sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
        sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
        sSearch: "Buscar:",
        sLoadingRecords: "Cargando...",
        oPaginate: {
          sFirst: "Primero",
          sLast: "Último",
          sNext: "Siguiente",
          sPrevious: "Anterior"
        },
        oAria: {
          sSortAscending: ": Activar para ordenar la columna de manera ascendente",
          sSortDescending: ": Activar para ordenar la columna de manera descendente"
        }
      }
    });

    // Mueve el contenedor de botones exportar después de inicializar
    setTimeout(() => {
      table.buttons().container().appendTo('#contenedor-excel');
    }, 300);

    // Buscador personalizado
    $('#buscar_bajas').on('input', function () {
      table.search(this.value).draw();
    });

    // Limpiar estilo por defecto
    setTimeout(() => {
      $('.buttons-collection').removeClass('btn-secondary').addClass('btn');
    }, 500);
  }, 100); // espera que modal se haya mostrado completamente
}
function restaurarBien(bien_id) {
    alert('Restaurar bien con ID: ' + bien_id);
}

function verFormato(bien_id) {
  window.location.href = "../adminMntDependencias/vistabajaDocumento.php?bien_id=" + bien_id;
}