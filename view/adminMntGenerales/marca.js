
var usu_id = $('#usu_idx').val();

function initMarca(){
    $("#marca_form").on("submit",function(e){
        guardaryeditarmarca(e);
    });
}

function guardaryeditarmarca(e){
    e.preventDefault();
    var formData = new FormData($("#marca_form")[0]);
    $.ajax({
        url: "../../controller/marca.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data){

            $('#marca_data').DataTable().ajax.reload();
            $('#modalMarca').modal('hide');

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


    $('#marca_data').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        searching: true,
        buttons: [
        ],
        "ajax":{
            url:"../../controller/marca.php?op=listar",
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

function editarmarca(marca_id){
    $.post("../../controller/marca.php?op=mostrar",{marca_id : marca_id}, function (data) {
        data = JSON.parse(data);
        console.log(data);
        $('#marca_id').val(data.marca_id);
        $('#marca_nom').val(data.marca_nom);
        $('#lbltitulo').html('Editar marca');
    });
   
    $('#modalMarca').modal('show');
}

function eliminarmarca(marca_id){
    swal.fire({
        title: "Eliminar!",
        text: "Desea Eliminar el Registro?",
        icon: "error",
        confirmButtonText: "Si",
        showCancelButton: true,
        cancelButtonText: "No",
    }).then((result) => {
        if (result.value) {
            $.post("../../controller/marca.php?op=eliminar",{marca_id : marca_id}, function (data) {
                $('#marca_data').DataTable().ajax.reload();

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

function nuevamarca(){
    $('#marca_id').val('');
    $('#marca_nom').val('');
    $('#lbltitulo').html('Registrar Nueva marca');
    $('#marca_form')[0].reset();
    $('#modalMarca').modal('show');
}


initMarca();
