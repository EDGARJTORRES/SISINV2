$(document).ready(function () {
    setTimeout(() => {
      $('.buttons-collection')
        .removeClass('btn-secondary')
        .addClass('btn');
    }, 300);

    let inicioCarga;
    let tiempoMinimo = 1000; // 2 segundos

    $('#GG_data').on('preXhr.dt', function () {
        mostrarAlertaCarga();
        inicioCarga = new Date().getTime();
    });

    $('#GG_data').on('xhr.dt', function () {
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
   var table= $('#GG_data').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        searching: true,  
        buttons: [
        {
          extend: 'collection',
          text: `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                  <path d="M7 11l5 5l5 -5" />
                  <path d="M12 4v12" />
                </svg> Exportar Datos`,
            buttons: [
            {
              extend: 'copyHtml5',
              text: `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clipboard" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 4h6a2 2 0 0 1 2 2v1h-10v-1a2 2 0 0 1 2 -2" /><path d="M9 4v1h6v-1" /><path d="M9 10h6" /><path d="M9 14h6" /><path d="M9 18h6" /><path d="M5 7v14h14v-14" /></svg> Copiar`,
              exportOptions: {
                columns: [ 1, 2] 
              },
            },
            {
              extend: 'csvHtml5',
              text: `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-type-csv" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M10 13l1 2l1 -2l1 2l1 -2" /></svg> CSV`,
              className: 'btn btn-outline-info',
              exportOptions: {
                columns: [ 1, 2] 
              },
            },
            {
              extend: 'excelHtml5',
              text: `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-spreadsheet" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M8 11h8v7h-8z" /><path d="M8 15h8" /><path d="M11 11v7" /></svg> Excel`,
              exportOptions: {
                columns: [ 1, 2] 
              },
            },
            {
              extend: 'pdfHtml5',
              text: `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-type-pdf" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M10 12h1v4" /><path d="M14 12h1a1 1 0 0 1 0 2h-1v2" /><path d="M10 16h1" /></svg> PDF`,
              orientation: 'landscape',
              pageSize: 'A4',
              exportOptions: {
                columns: [ 1, 2] 
              },
              customize: function (doc) {
                doc.defaultStyle.fontSize = 10;
              }
            },
            {
              extend: 'print',
              text: `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-printer" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9v-4a1 1 0 0 1 1 -1h10a1 1 0 0 1 1 1v4" /><path d="M6 18h12" /><path d="M6 14h12" /><path d="M9 18v3h6v-3" /><path d="M4 13v-2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v2" /></svg> Imprimir`,
              exportOptions: {
                columns: [ 1, 2] 
                }
            }
          ]
        }
      ],
        "ajax":{
            url:"../../controller/grupogenerico.php?op=listar",
            type:"post"
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo":true,
        "iDisplayLength": parseInt($('#cantidad_registros').val()),
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
    table.buttons().container().appendTo('#contenedor-excel');
    $('#cantidad_registros').on('input change', function () {
        let val = parseInt($(this).val());
        if (isNaN(val) || val < 1) {
            val = 1;
        } else if (val > 25) {
            val = 25;
        }
        $(this).val(val);
        table.page.len(val).draw();
    });

    $('#buscar_registros').on('input', function () {
        table.search(this.value).draw();
    }); 
     $('#gg_id_all').on('change', function () {
        let isChecked = $(this).is(':checked');
        $('.gg-checkbox').prop('checked', isChecked);
    });
    const sliderElement = document.getElementById('slider_rango');
    noUiSlider.create(sliderElement, {
      start: [1, 150],
      connect: true,
      range: {
        'min': 1,
        'max': 150
      },
      tooltips: [false, false],
      format: {
        to: value => Math.round(value),
        from: value => Number(value)
      }
    });

    sliderElement.noUiSlider.on('update', function (values) {
      const min = parseInt(values[0]);
      const max = parseInt(values[1]);
      document.getElementById('min_valor').textContent = min;
      document.getElementById('max_valor').textContent = max;

      $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        const cantidad = parseInt(data[1]) || 0;
        return cantidad >= min && cantidad <= max;
      });

      table.draw();
      $.fn.dataTable.ext.search.pop();
    });   
});
function limpiarFiltros() {
  $('#buscar_dependencia').val('');
  $('#filtro_dependencia').val('');
  $('#buscar_registros').val('');
  const slider = document.getElementById('slider_rango').noUiSlider;
  slider.set([1, 150]); 
  document.getElementById('min_valor').textContent = 1;
  document.getElementById('max_valor').textContent = 150;
  $.fn.dataTable.ext.search = [];
  const tableDependencias = $('#dependencias_objetos').DataTable();
  tableDependencias.search('').draw();
  const tableGG = $('#GG_data').DataTable();
  tableGG.search('').clear().draw();  
  tableGG.ajax.reload();              
}
