var usu_id = $("#usu_idx").val();

$(document).ready(function () {
  const table = $('#dependencias_objetos').DataTable({
    "aProcessing": true,
    "aServerSide": true,
    dom: 'Bfrtip',
    searching: true,
    buttons: [],
    "ajax": {
      url: "../../controller/dependencia.php?op=listarBienesBaja",
      type: "post"
    },
    "columnDefs": [
      {
        targets: 1,
        render: function (data) {
          if (!data || data.trim() === "" || data.trim() === ".") {
            return "N/A";
          }
          return data;
        }
      }
    ],
    "bDestroy": true,
    "responsive": true,
    "bInfo": true,
    "iDisplayLength": 6,
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

  $('#buscar_dependencia').on('input', function () {
    table.search(this.value).draw();
  });

  fetch("../../controller/dependencia.php?op=select_areas")
    .then(response => response.json())
    .then(data => {
      const select = document.getElementById("filtro_dependencia");
      data.forEach(area => {
        const option = document.createElement("option");
        option.value = area.depe_denominacion; 
        option.textContent = area.depe_denominacion;
        select.appendChild(option);
    });
  });

  $('#filtro_dependencia').on('change', function () {
    const selected = this.value;
    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
      const area = data[0];
      return selected === "" || area === selected;
    });
    table.draw();
    $.fn.dataTable.ext.search.pop();
  });

  const sliderElement = document.getElementById('slider_rango');
  noUiSlider.create(sliderElement, {
    start: [1, 100],
    connect: true,
    range: {
      'min': 1,
      'max': 100
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
      const cantidad = parseInt(data[2]) || 0;
      return cantidad >= min && cantidad <= max;
    });

    table.draw();
    $.fn.dataTable.ext.search.pop();
  });
});
function limpiarFiltros() {
  $('#buscar_dependencia').val('');
  $('#filtro_dependencia').val('');
  const slider = document.getElementById('slider_rango').noUiSlider;
  slider.set([1, 100]); 
  document.getElementById('min_valor').textContent = 1;
  document.getElementById('max_valor').textContent = 100;
  const table = $('#dependencias_objetos').DataTable();
  table.search('').draw(); 
  $.fn.dataTable.ext.search = []; 
  table.draw();
}

