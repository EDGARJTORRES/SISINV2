
var usu_id = $('#usu_idx').val();

function initobjeto(){
    $("#obj_form").on("submit",function(e){
    e.preventDefault(); 
    const nombreInput = document.getElementById('obj_nombre');
    const codigoInput = document.getElementById('codigo_cana');
    const errorNombre = document.getElementById('errorNombre');
    const errorCodigo = document.getElementById('errorCodigo');

    let nombreValido = validarInput(nombreInput, errorNombre);
    let codigoValido = validarInput(codigoInput, errorCodigo);

    if (nombreValido && codigoValido) {
      guardaryeditarobjeto(e);
    }
  });

  $('#obj_nombre').on('input', function() {
    validarInput(this, document.getElementById('errorNombre'));
  });

  $('#codigo_cana').on('input', function() {
    validarInput(this, document.getElementById('errorCodigo'));
  });
}
function validarInput(input, errorDiv) {
  const pattern = new RegExp(input.getAttribute("pattern"));
  if (input.value.trim() === '' || !pattern.test(input.value.trim())) {
    input.classList.remove('is-valid');
    input.classList.add('is-invalid');
    errorDiv.classList.add('active');
    return false;
  } else {
    input.classList.remove('is-invalid');
    input.classList.add('is-valid');
    errorDiv.classList.remove('active');
    return true;
  }
}
function guardaryeditarobjeto(e) {
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
            $('#clase_grupo_obj_id').DataTable().ajax.reload();
            $('#modalObjeto').modal('hide');
               Swal.fire({
                title: 'Correcto!',
                text: 'Se registró correctamente',
                imageUrl: '../../static/gif/verified.gif',
                imageWidth: 100,
                imageHeight: 100,
                confirmButtonText: 'Aceptar',
                confirmButtonColor: 'rgb(18, 129, 18)',
                backdrop: true,
                didOpen: () => {
                    const swalBox = Swal.getPopup();
                    const topBar = document.createElement('div');
                    topBar.id = 'top-progress-bar';
                    topBar.style.cssText = `
                        position: absolute;
                        top: 0;
                        left: 0;
                        height: 6px;
                        width: 0%;
                        background-color: rgb(16, 141, 16);
                        transition: width 0.4s ease;
                    `;
                    swalBox.appendChild(topBar);

                    setTimeout(() => {
                        topBar.style.width = '100%';
                    }, 300);
                } 
            }).then(() => {
                $('#modalObjeto').modal('hide');
                if ( $.fn.DataTable.isDataTable('#clase_grupo_obj_id') ) {
                    $('#clase_grupo_obj_id').DataTable().ajax.reload(null, false);
                }
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
$(document).ready(function () {
  $('button[type="reset"]').on('click', function () {
    // Limpiar clases de validación
    $('#obj_nombre, #codigo_cana')
      .removeClass('is-valid is-invalid');

    // Ocultar mensajes de error
    $('#errorNombre, #errorCodigo').removeClass('active');
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
function editarObjeto(obj_id) {
    $.post("../../controller/objeto.php?op=mostrar", { obj_id: obj_id }, function (data) {
        data = JSON.parse(data);
        $('#obj_nombre, #codigo_cana').removeClass('is-valid is-invalid');
        $('#errorNombre, #errorCodigo').removeClass('active');
        $('#obj_id').val(data.obj_id);
        $('#obj_nombre').val(data.obj_nombre);
        $('#codigo_cana').val(data.codigo_cana);
        if (data.cate_id) {
            $('#combo_cate').val(data.cate_id).trigger('change');
        }
        if (data.gc_id) {
            $('#combo_clase_gen').val(data.gc_id).trigger('change');
        }
        if (data.obj_img) {
            $('#previewImage')
                .attr("src", "../../" + data.obj_img) // ✅ ahora apunta bien
                .show();
        } else {
            $('#previewImage').hide();
        }
        $('#lbltituloObj').html(`
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                class="icon icon-tabler icons-tabler-outline icon-tabler-screen-share ms-3">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M21 12v3a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1v-10a1 1 0 0 1 1 -1h9"/>
                <path d="M7 20l10 0" />
                <path d="M9 16l0 4" />
                <path d="M15 16l0 4" />
                <path d="M17 4h4v4" />
                <path d="M16 9l5 -5" />
            </svg> EDITAR REGISTRO DE OBJETO
        `);

        $('#modalObjeto').modal('show');
    });
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
    var gg_id = $("#combo_grupo_gen").val();
    var gc_id = $("#combo_clase_gen").val();
    if (gg_id == '') {
        Swal.fire({
            title: '¡Error!',
            imageUrl: '../../static/gif/letra-x.gif',
            imageWidth: 100,
            imageHeight: 100,
            text: 'Debe seleccionar el Grupo Genérico',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: 'rgb(243, 18, 18)',
        });
    } else if (gc_id == '') {
        Swal.fire({
            title: 'Error!',
            imageUrl: '../../static/gif/letra-x.gif',
            imageWidth: 100,
            imageHeight: 100,
            text: 'Debe Ingresar la Clase',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: 'rgb(243, 18, 18)',
        })
    }else {
        $('#obj_id').val('');
        $('#obj_nom').val('');
        $('#codigo_cana').val('');
        $('#obj_img').val('');
        $('#previewImage').attr("src", "").hide();
        $('#obj_nombre, #codigo_cana').removeClass('is-valid is-invalid');
        $('#errorNombre, #errorCodigo').removeClass('active');
        $('#lbltituloObj').html('<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-screen-share ms-3"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M21 12v3a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1v-10a1 1 0 0 1 1 -1h9" /><path d="M7 20l10 0" /><path d="M9 16l0 4" /><path d="M15 16l0 4" /><path d="M17 4h4v4" /><path d="M16 9l5 -5" /></svg> REGISTRAR NUEVO OBJETO');
        $('#obj_form')[0].reset();
        $('#modalObjeto').modal('show');
    }
 
}
function verImagen(imgPath) {
    Swal.fire({
        title: 'Imagen del Objeto',
        html: `<img src="${imgPath}" alt="Objeto" style="width: 100%; max-width: 500px; height: auto;">`,
        showCloseButton: true,
        showConfirmButton: false,
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
                background-color: rgba(241, 56, 0, 1);
                transition: width 0.4s ease;
            `;
            swalBox.appendChild(topBar);

            setTimeout(() => {
                topBar.style.width = '100%';
            }, 300);
        }
    });
}
initobjeto();
