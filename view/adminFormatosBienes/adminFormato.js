var table;
var usu_id = $("#usu_idx").val();

$(document).ready(function () {
    table = $('#formatos_data').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        searching: true,
        buttons: [],
        "ajax": {
            url: "../../controller/formato.php?op=listar",
            type: "post"
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo": true,
        "iDisplayLength": 10,
        "ordering": true,
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

    $('#buscar_registros').on('input', function () {
        table.search(this.value).draw();
    });

    $('#filtro_anexo').on('change', function () {
        let value = $(this).val();

        if (value === "0") {
            table.column(2).search('').draw();
        } else if (value === "Asignacion") {
            table.column(2).search('ASIGNACIÓN', true, false).draw();
        } else if (value === "Desplazamiento") {
            table.column(2).search('DESPLAZAMIENTO', true, false).draw();
        }
    });

    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        const selectedDate = $('#fecha_inicio').val(); 
        if (!selectedDate) return true; 
        const div = document.createElement('div');
        div.innerHTML = data[1];
        const fechaStr = div.textContent.trim();  
        const [fechaParte] = fechaStr.split(' ');
        const [d, m, y] = fechaParte.split('/');
        const rowDate = `${y}-${m.padStart(2, '0')}-${d.padStart(2, '0')}`;
        return rowDate === selectedDate;
    });
    $('#fecha_inicio').on('change', function () {
        table.draw();
    });
    $('#form_id_all').on('click', function () {
        var checked = $(this).is(':checked');
        $('#formatos_data tbody input.formato_checkbox').prop('checked', checked);
    });

});

function limpiarFiltros() {
    $('#filtro_anexo').val('0').trigger('change');  
    $('#buscar_registros').val('');                
    $('#cantidad_registros').val(10).trigger('change'); 
    $('#fecha_inicio').val('');                    
    table.search('').columns().search('').draw();  
    $('#form_id_all').prop('checked', false);
    $('#formatos_data tbody input.formato_checkbox').prop('checked', false);
}
