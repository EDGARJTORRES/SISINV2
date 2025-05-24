
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
   $("#combo_marca_obj").select2({
   dropdownParent: $("#modalModelo"),
   dropdownPosition: "below",
  });
   $.post("../../controller/marca.php?op=combo", function (data) {
    $("#combo_marca_obj").html(data);
  });
  var table =  $('#modelo_data').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        searching: true,
        buttons: [
        ],
        "ajax":{
            url:"../../controller/modelo.php?op=listar",
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

function editarmodelo(modelo_id){
    $.post("../../controller/modelo.php?op=mostrar",{modelo_id : modelo_id}, function (data) {
        data = JSON.parse(data);
        $('#marca_id').val(data.marca_id);
        $('#marca_nom').val(data.marca_nom);
        $('#modelo_id').val(data.modelo_id);
        $('#modelo_nom').val(data.modelo_nom);
        $('#lbltitulo').html('Editar marca');
    }); 
    $('#modalModelo').modal('show');
}
function eliminarmodelo(modelo_id){
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
              url: '../../controller/modelo.php?op=eliminar',
                type: 'POST',
               data: {modelo_id : modelo_id},
               success: function (response) {
                    $('#modelo_data').DataTable().ajax.reload(function(){
                        Swal.fire({
                            title: '¡Eliminado!',
                            html: `
                                <p>El Modelo ha sido eliminado correctamente.</p>
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
                    });
                },
                error: function () {
                    Swal.fire('Error', 'No se pudo eliminar el usuario.', 'error');
                }
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
