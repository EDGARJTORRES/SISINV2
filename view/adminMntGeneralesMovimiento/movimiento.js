
var usu_id = $('#usu_idx').val();

function initmovimiento(){
    $("#mov_form").on("submit",function(e){
        guardaryeditarmovimiento(e);
    });
}

function guardaryeditarmovimiento(e){
    e.preventDefault();
    var formData = new FormData($("#mov_form")[0]);
    $.ajax({
        url: "../../controller/movimiento.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data){

            $('#mov_data').DataTable().ajax.reload();
            $('#modalMovimiento').modal('hide');

            Swal.fire({
                title: 'Correcto!',
                text: 'Se Registro Correctamente',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            })
        }
    });
}

$(document).ready(function(){
    $('#mov_data').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        searching: true,
        buttons: [
        ],
        "ajax":{
            url:"../../controller/movimiento.php?op=listar",
            type:"post"
        },
        "bDestroy": true,
        "responsive": false,
        "bInfo":false,
        "iDisplayLength": 5,
        "ordering": false, 
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
});

function editarmovimiento(mov_id){
    $.post("../../controller/movimiento.php?op=mostrar",{mov_id : mov_id}, function (data) {
        data = JSON.parse(data);
        $('#mov_id').val(data.mov_id);
        $('#mov_nom').val(data.mov_nom);
        $('#lbltitulo').html('Editar clase');
    });
   
    $('#modalMovimiento').modal('show');
}

function eliminarmovimiento(mov_id){
    swal.fire({
        title: "Eliminar!",
        text: "Desea Eliminar el Registro?",
        icon: "error",
        confirmButtonText: "Si",
        showCancelButton: true,
        cancelButtonText: "No",
    }).then((result) => {
        if (result.value) {
            $.post("../../controller/movimiento.php?op=eliminar",{mov_id : mov_id}, function (data) {
                $('#mov_data').DataTable().ajax.reload();

                Swal.fire({
                    title: 'Correcto!',
                    text: 'Se Elimino Correctamente',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                })
            });
        }
    });
}

function nuevoMov(){
    $('#mov_id').val('');
    $('#lbltitulomov').html('Registrar Nuevo movimiento');
    $('#mov_form')[0].reset();
    $('#modalMovimiento').modal('show');
}


initmovimiento();
