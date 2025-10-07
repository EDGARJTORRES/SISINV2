function copyTextFallback(text) {
    const input = document.createElement('input');
    input.value = text;
    document.body.appendChild(input);
    input.select();
    const result = document.execCommand('copy');
    document.body.removeChild(input);
    console.log('Resultado execCommand copy:', result);
    return result;
}

function mostrarToast(codigo, mensaje = '') {
    Swal.fire({
        position: "top-end",
        icon: "success",
        title: mensaje ? mensaje : "Código copiado: " + codigo,
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        width: '350px',
        customClass: { popup: 'swal2-toast' }
    });
}

var table;

$(document).ready(function () {
    table = $('#bienes_data').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        searching: true,
        buttons: [],
        "ajax": {
            url: "../../controller/bien.php?op=listar_bienes_sin_asignacion",
            type: "post",
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo": true,
        "iDisplayLength": 5,
        "order": [[3, 'desc']],
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
            }
        }
    });

    $('#modalsinasignacion').on('click', '.copiar-codbarras', function () {
        const codigo = $(this).data('codigo');
        console.log("Intentando copiar código:", codigo);

        // Copiar al portapapeles
        if (navigator.clipboard && window.isSecureContext) {
            console.log("navigator.clipboard disponible:", true);
            navigator.clipboard.writeText(codigo)
                .then(() => {
                    console.log("Código copiado con clipboard:", codigo);
                    mostrarToast(codigo); // Muestra solo el código
                    $('#modalsinasignacion').modal('hide');
                })
                .catch(err => {
                    console.error('Error clipboard, usando fallback:', err);
                    copyTextFallback(codigo);
                    mostrarToast(codigo); // Ahora también solo muestra el código
                    $('#modalsinasignacion').modal('hide');
                });
        } else {
            console.log("Usando fallback porque no hay clipboard o contexto inseguro");
            copyTextFallback(codigo);
            mostrarToast(codigo); // Muestra solo el código
            $('#modalsinasignacion').modal('hide');
        }

        // Pegar automáticamente en el input #cod_bar
        $('#cod_bar').val(codigo).focus();
    });

    // Búsqueda en tiempo real dentro del modal
    $('#buscar_registros').on('input', function () {
        table.search(this.value).draw();
    });

});

// Función para limpiar filtros y búsqueda
function limpiarFiltros() {
    $('#buscar_registros').val('');
    table.search('').columns().search('').draw();
}
