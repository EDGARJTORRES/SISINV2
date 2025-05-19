
var usu_id = $('#usu_idx').val();

function initclase(){
    $("#clase_form").on("submit",function(e){
        guardaryeditarclase(e);
    });
}

function guardaryeditarclase(e){
    e.preventDefault();
    var formData = new FormData($("#clase_form")[0]);
    $.ajax({
        url: "../../controller/clase.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data){

            $('#clase_data').DataTable().ajax.reload();
            $('#modalClase').modal('hide');

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


    $('#clase_data').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        searching: true,
        buttons: [
        ],
        "ajax":{
            url:"../../controller/clase.php?op=listar",
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

function editarclase(clase_id){
    $.post("../../controller/clase.php?op=mostrar",{clase_id : clase_id}, function (data) {
        data = JSON.parse(data);
        $('#clase_id').val(data.clase_id);
        $('#clase_nom').val(data.clase_nom);
        $('#clase_cod').val(data.clase_cod);
        $('#lbltituloclase').html('Editar clase');
    });
   
    $('#modalClase').modal('show');
}

function eliminarclase(clase_id){
    swal.fire({
        title: "Eliminar!",
        text: "Desea Eliminar el Registro?",
        icon: "error",
        confirmButtonText: "Si",
        showCancelButton: true,
        cancelButtonText: "No",
    }).then((result) => {
        if (result.value) {
            $.post("../../controller/clase.php?op=eliminar",{clase_id : clase_id}, function (data) {
                $('#clase_data').DataTable().ajax.reload();

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

function nuevaclase(){
    $('#clase_id').val('');
    $('#lbltitulo').html('Registrar Nueva clase');
    $('#clase_form')[0].reset();
    $('#modalClase').modal('show');
}


initclase();
