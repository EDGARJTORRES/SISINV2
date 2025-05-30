
var usu_id = $('#usu_idx').val();

function initmarca(){
    $("#marca_form").on("submit",function(e){
    e.preventDefault();
    const nombreInput = document.getElementById('marca_nom');
    const errorNombre = document.getElementById('errorNombre');
    let nombreValido = validarInput(nombreInput, errorNombre);
    if (nombreValido) {
       guardaryeditarmarca(); 
        }
    });
    $('#marca_nom').on('input', function() {
        validarInput(this, document.getElementById('errorNombre'));
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

function guardaryeditarmarca(){
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
                title: '¡Correcto!',
                text: 'Se registró correctamente.',
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
                        background-color:rgb(16, 141, 16);
                        transition: width 0.4s ease;
                    `;
                    swalBox.appendChild(topBar);

                    setTimeout(() => {
                        topBar.style.width = '100%';
                    }, 300);
                } 
            });
        }
    });
}

$(document).ready(function(){
    var table= $('#marca_data').DataTable({
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
        "responsive": true,
        "bInfo":true,
        "iDisplayLength": parseInt($('#cantidad_registros').val()),
	    "order": [[0, "desc"]],
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
    $('#cantidad_registros').on('input change', function () {
        let val = parseInt($(this).val());
        if (isNaN(val) || val < 1) {
            val = 1;
        } else if (val > 25) {
            val = 25;
        }
        $(this).val(val);
        table.page.len(val).draw();
    });

    $('#buscar_registros').on('input', function () {
        table.search(this.value).draw();
    }); 
    $('#marca_id_all').on('change', function () {
        let isChecked = $(this).is(':checked');
        $('.marca-checkbox').prop('checked', isChecked);
    });  
});

let idsSeleccionados = new Set();

function actualizarContadorSeleccionados() {
  const total = idsSeleccionados.size;
  $('#contador_valor').text(total);
  const antes = total === 1 ? 'Se encontró ' : 'Se encontraron ';
  const despues = total === 1 ? ' elemento' : ' elementos';
  $('#contador_seleccionados').contents().filter(n => n.nodeType === 3).each((i, el) => {
    if (i === 0) el.nodeValue = antes;
    if (i === 1) el.nodeValue = despues;
  });
}

 function limpiarSeleccion() {
  idsSeleccionados.clear();
  $('.marca-checkbox').prop('checked', false);
  $('#marca_id_all').prop('checked', false);
  actualizarContadorSeleccionados();
}
  // Evento cuando se marca/desmarca cada checkbox
$(document).on('change', '.marca-checkbox', function () {
    const id = $(this).data('id');
    if ($(this).is(':checked')) {
        idsSeleccionados.add(id);
    } else {
        idsSeleccionados.delete(id);
    }
    actualizarContadorSeleccionados();
});

  // Checkbox general (seleccionar todos en la página actual)
  $('#marca_id_all').on('change', function () {
    const checked = $(this).is(':checked');
    $('.marca-checkbox').each(function () {
      const id = $(this).data('id');
      $(this).prop('checked', checked);
      if (checked) {
        idsSeleccionados.add(id);
      } else {
        idsSeleccionados.delete(id);
      }
    });
    actualizarContadorSeleccionados();
  });

  $('#marca_data').on('draw.dt', function () {
    $('.marca-checkbox').each(function () {
      const id = $(this).data('id');
      $(this).prop('checked', idsSeleccionados.has(id));
    });

    const allChecked = $('.marca-checkbox').length > 0 && $('.marca-checkbox').length === $('.marca-checkbox:checked').length;
    $('#marca_id_all').prop('checked', allChecked);

    actualizarContadorSeleccionados();
  });
  
  $('#eliminar_marcas').on('click', function () {
      let seleccionados = [];
      $('.marca-checkbox:checked').each(function () {
          seleccionados.push($(this).val());
      });
      console.log("IDs seleccionados para eliminar:", seleccionados);

      if (seleccionados.length === 0) {
          Swal.fire({
              title: '¡Atención!',
              text: 'Debes seleccionar al menos una marca para continuar.',
              imageUrl: '../../static/gif/tarjeta.gif',
              imageWidth: 100,
              imageHeight: 100,
              confirmButtonText: 'Entendido',
              confirmButtonColor: 'rgb(90, 4, 69)', 
          });
          return;
      }
      Swal.fire({
          title: '¿Estás seguro?',
          text: 'Esto eliminará las marcas seleccionados.',
          imageUrl: '../../static/gif/advertencia.gif',
          imageWidth: 100,
          imageHeight: 100,
          showCancelButton: true,
          confirmButtonText: 'Sí, eliminar',
          confirmButtonColor: 'rgb(90, 4, 69)', 
          cancelButtonText: 'Cancelar',
          cancelButtonColor: '#000',
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
                  background-color:rgb(90, 4, 69);
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
                  url: '../../controller/marca.php?op=eliminar_marcas',
                  type: 'POST',
                 data: { ids: seleccionados },
                  success: function (response) {
                      console.log("Respuesta del servidor:", response); 
                      $('#marca_data').DataTable().ajax.reload(function() {
                          idsSeleccionados.clear();
                          $('.marca-checkbox').prop('checked', false);
                          $('#marca_id_all').prop('checked', false);
                          actualizarContadorSeleccionados();
                      });
                      Swal.fire({
                          title: 'Eliminadas',
                          text: 'Las marcas fueron eliminadas correctamente.',
                          imageUrl: '../../static/gif/verified.gif',
                          imageWidth: 100,
                          imageHeight: 100,
                          confirmButtonText: 'Entendido',
                          confirmButtonColor: 'rgb(90, 4, 69)',
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
                      Swal.fire('Error', 'No se pudieron eliminar.', 'error');
                  }
              });
          } else {
              // Lógica para reiniciar todo al cancelar
              idsSeleccionados.clear();
              $('.marca-checkbox').prop('checked', false);
              $('#marca_id_all').prop('checked', false);
              actualizarContadorSeleccionados();
          }
      });
  });



function editarmarca(marca_id){
    $.post("../../controller/marca.php?op=mostrar",{marca_id : marca_id}, function (data) {
        idsSeleccionados.clear();
        $('.marca-checkbox').prop('checked', false);
        $('#marca_id_all').prop('checked', false);
        $('#marca_nom').removeClass('is-valid is-invalid');
        $('#errorNombre').removeClass('active');
        actualizarContadorSeleccionados();
        data = JSON.parse(data);
        $('#clase_id').val(data.marca_id);
        $('#marca_nom').val(data.marca_nom);
        $('#lbltitulo').html('<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-screen-share ms-3"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M21 12v3a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1v-10a1 1 0 0 1 1 -1h9" /><path d="M7 20l10 0" /><path d="M9 16l0 4" /><path d="M15 16l0 4" /><path d="M17 4h4v4" /><path d="M16 9l5 -5" /></svg> EDITAR MARCA');
    });
   
    $('#modalMarca').modal('show');
}

function eliminarmarca(marca_id) {
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
              url: '../../controller/marca.php?op=eliminar',
                type: 'POST',
               data: {marca_id : marca_id},
                success: function (response) {
                   $('#marca_data').DataTable().ajax.reload();
                    Swal.fire({
                        title: '¡Eliminado!',
                        html: `
                            <p>La marca ha sido eliminado correctamente.</p>
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
                    Swal.fire('Error', 'No se pudo eliminar la marca.', 'error');
                }
            });
        }
    });
}

function nuevamarca(){
  $('#marca_nom').val(''); 
  $('#marca_form')[0].reset();
  $('#marca_nom').removeClass('is-valid is-invalid');
  $('#errorNombre').removeClass('active');
  $('#lbltitulo').html('<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-screen-share ms-3"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M21 12v3a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1v-10a1 1 0 0 1 1 -1h9" /><path d="M7 20l10 0" /><path d="M9 16l0 4" /><path d="M15 16l0 4" /><path d="M17 4h4v4" /><path d="M16 9l5 -5" /></svg> REGISTRAR NUEVA MARCA');
  $('#modalMarca').modal('show');
  idsSeleccionados.clear();
  $('.marca-checkbox').prop('checked', false);
  $('#marca_id_all').prop('checked', false);
  actualizarContadorSeleccionados();
}
initmarca();
