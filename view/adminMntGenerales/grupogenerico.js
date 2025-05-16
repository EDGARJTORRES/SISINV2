
var usu_id = $('#usu_idx').val();

function initGG(){
    $("#GG_form").on("submit",function(e){
        guardaryeditarGG(e);
    });
}

function guardaryeditarGG(e){
    e.preventDefault();
    var formData = new FormData($("#GG_form")[0]);
    $.ajax({
        url: "../../controller/grupogenerico.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data){

            $('#GG_data').DataTable().ajax.reload();
            $('#modalGG').modal('hide');

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

    $('#GG_data').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        searching: true,  // <-- aquí cambias a true
        buttons: [
        ],
        "ajax":{
            url:"../../controller/grupogenerico.php?op=listar",
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


function editarGG(gg_id_input){
  
    $.post("../../controller/grupogenerico.php?op=mostrar",{gg_id_input : gg_id_input}, function (data) {
        data = JSON.parse(data);
      
        $('#ggidgene').val(data.gg_id);
        console.log(data.gg_id);
        console.log(data.gg_nom);
        console.log(data.gg_cod);

        $('#ggnomgene').val(data.gg_nom);
        $('#ggcodgene').val(data.gg_cod);
        $('#lbltituloGG').html('Editar Grupo Generico');
    });
    $('#modalGG').modal('show');
   
}

function eliminarGG(gg_id){
    swal.fire({
        title: "Eliminar!",
        text: "Desea Eliminar el Registro?",
        icon: "error",
        confirmButtonText: "Si",
        showCancelButton: true,
        cancelButtonText: "No",
    }).then((result) => {
        if (result.value) {
            $.post("../../controller/grupogenerico.php?op=eliminar",{gg_id : gg_id}, function (data) {
                $('#GG_data').DataTable().ajax.reload();

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

function nuevaGG(){
    $('#gg_id_gene').val('');
    $('#gg_nom_gene').val('');
    $('#lbltituloGG').html('Registrar Nuevo Grupo generico');
    $('#GG_form')[0].reset();
    $('#modalGG').modal('show');
}


initGG();
