
var usu_id = $('#usu_idx').val();

function initobjeto(){
    $("#obj_form").on("submit",function(e){
        guardaryeditarobjeto(e);
    });
}

function guardaryeditarobjeto(e) {
    e.preventDefault();
   
    var formData = new FormData($("#obj_form")[0]);
    var gc_id = $("#combo_clase_gen").val();
    formData.append("gc_id", gc_id);
    $.ajax({
        url: "../../controller/objeto.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data){
            // Si la respuesta es un JSON
            var response = JSON.parse(data);
            if (response.success) {
                // Si la operación fue exitosa
                $('#clase_grupo_obj_id').DataTable().ajax.reload();
                $('#modalObjeto').modal('hide');

                Swal.fire({
                    title: 'Correcto!',
                    text: 'Se registró correctamente',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                });
            } else {
                // Si ocurrió un error
                Swal.fire({
                    title: 'Error!',
                    text: response.message, // Mostrar el mensaje de error recibido del servidor
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        },
        error: function(xhr, textStatus, errorThrown) {
            // Si ocurre un error en la solicitud AJAX
            Swal.fire({
                title: 'Error!',
                text: 'Hubo un error al procesar la solicitud.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    });
}


$(document).ready(function(){
   
    
  $("#combo_clase_gen").change(function () {
    var gc_id = $(this).val();
    cargarDataGrupoObj(gc_id);
    
  });
});
function cargarDataGrupoObj(gc_id){
   var table =$('#clase_grupo_obj_id').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        crollX: true,
        dom: 'Bfrtip',
        searching: true,
        buttons: [
        ],
        "ajax":{
            url:"../../controller/objeto.php?op=listar",
            type:"post",
            data: {gc_id:gc_id}
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo":true,
        "iDisplayLength": parseInt($('#cantidad_registros').val()),
        "order": [[0, 'desc']],
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
}

function editarObjeto(obj_id){
     $.post("../../controller/objeto.php?op=mostrar",{obj_id : obj_id}, function (data) {
        data = JSON.parse(data);
        console.log(data);
        $('#obj_id').val(data.obj_id);
        $('#obj_nombre').val(data.obj_nombre);
        $('#combo_cate').val(data.cate_id);
        $('#combo_cate').change();
        $('#lbltituloObj').html('Editar Objeto');
    });
    $('#modalObjeto').modal('show');
}
function eliminarObjeto(obj_id){
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
              url: '../../controller/objeto.php?op=eliminar',
                type: 'POST',
               data: {obj_id : obj_id},
                success: function (response) {
                    $('#clase_grupo_obj_id').DataTable().ajax.reload();
                    Swal.fire({
                        title: '¡Eliminado!',
                        html: `
                            <p>El Objeto ha sido eliminado correctamente.</p>
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

function nuevoObjeto(){
    var gc_id = $("#combo_clase_gen").val();
    if(gc_id == ''){
        Swal.fire({
            title: 'Error!',
            text: 'Debe Ingresar la Clase',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        })
    }else {
        $('#obj_id').val('');
        $('#obj_nom').val('');
        $('#codigo_cana').val('');
        $('#lbltituloObj').html('Registrar Nuevo Objeto');
        $('#obj_form')[0].reset();
        $('#modalObjeto').modal('show');
    }
 
}

function rotarObjetoDepe(obj_id){
    /* $.post("../../controller/objeto.php?op=mostrar",{obj_id : obj_id}, function (data) {
        data = JSON.parse(data);
        console.log(data);
        $('#obj_id').val(data.obj_id);
        $('#obj_nombre').val(data.obj_nombre);
        $('#combo_cate').val(data.cate_id);
        $('#combo_cate').change();
        $('#lbltituloObj').html('Editar Objeto');
    }); */
   
    $('#modalObjetoRotar').modal('show');
}

  initobjeto();
