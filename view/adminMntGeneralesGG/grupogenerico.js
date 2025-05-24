
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

   var table= $('#GG_data').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        searching: true,  
        buttons: [
        ],
        "ajax":{
            url:"../../controller/grupogenerico.php?op=listar",
            type:"post"
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo":true,
        "iDisplayLength": parseInt($('#cantidad_registros').val()),
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
    $('#cantidad_registros').on('input change', function() {
        var val = parseInt($(this).val());
        if (val > 0) {
            table.page.len(val).draw();
    }
    });
   $('#buscar_registros').on('input', function () {
    table.search(this.value).draw();
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
function eliminarGG(gg_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡Esta acción no se puede deshacer!",
        imageUrl: '../../static/gif/advertencia.gif',
        imageWidth: 100,
        imageHeight: 100,
        showCancelButton: true,
         confirmButtonColor: 'rgb(243, 18, 18)', 
        cancelButtonColor: '#000', 
        confirmButtonText: 'Sí, eliminarlo',
        backdrop: true,
        didOpen: () => {
            const swalBox = Swal.getPopup();
            const topBar = document.createElement('div');
            topBar.id = 'top-progress-bar';
            topBar.style.cssText = `
                position: absolute;
                top: 0;
                left: 0;
                height: 5px;
                width: 0%;
                background-color:rgb(243, 18, 18);
                transition: width 0.4s ease;
            `;
            swalBox.appendChild(topBar);

            setTimeout(() => {
                topBar.style.width = '40%';
            }, 300);
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
              url: '../../controller/grupogenerico.php?op=eliminar',
                type: 'POST',
               data: {gg_id : gg_id},
                success: function (response) {
                  $('#GG_data').DataTable().ajax.reload();
                    Swal.fire({
                        title: '¡Eliminado!',
                        html: `
                            <p>El Grupo Generico ha sido eliminado correctamente.</p>
                            <div id="top-progress-bar-final" style="
                                position: absolute;
                                top: 0;
                                left: 0;
                                height: 5px;
                                width: 0%;
                                background-color:rgb(243, 18, 18);
                                transition: width 0.6s ease;
                            "></div>
                        `,
                        imageUrl: '../../static/gif/verified.gif',
                        imageWidth: 100,
                        imageHeight: 100,
                        showConfirmButton: true,
                        confirmButtonColor: 'rgb(243, 18, 18)',
                        backdrop: true,
                        didOpen: () => {
                            const bar = document.getElementById('top-progress-bar-final');
                            setTimeout(() => {
                                bar.style.width = '100%';
                            }, 100);
                        }
                    });
                },
                error: function () {
                    Swal.fire('Error', 'No se pudo eliminar el usuario.', 'error');
                }
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
