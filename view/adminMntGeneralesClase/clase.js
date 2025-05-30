
var usu_id = $('#usu_idx').val();

function initclase(){
    $("#clase_form").on("submit",function(e){
    e.preventDefault();
    const nombreInput = document.getElementById('clase_nom');
    const codigoInput = document.getElementById('clase_cod');
    const errorNombre = document.getElementById('errorNombre');
    const errorCodigo = document.getElementById('errorCodigo');
    let nombreValido = validarInput(nombreInput, errorNombre);
    let codigoValido = validarInput(codigoInput, errorCodigo);
    if (nombreValido && codigoValido) {
       guardaryeditarclase(); 
        }
    });
    // Validación en tiempo real
    $('#clase_nom').on('input', function() {
        validarInput(this, document.getElementById('errorNombre'));
    });

    $('#clase_cod').on('input', function() {
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

function guardaryeditarclase(){
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
    var table= $('#clase_data').DataTable({
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
    $('#clase_id_all').on('change', function () {
        let isChecked = $(this).is(':checked');
        $('.clase-checkbox').prop('checked', isChecked);
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
  console.log(idsSeleccionados);
  $('.clase-checkbox').prop('checked', false);
  $('#clase_id_all').prop('checked', false);
  actualizarContadorSeleccionados();
}
  // Evento cuando se marca/desmarca cada checkbox
$(document).on('change', '.clase-checkbox', function () {
    const id = $(this).data('id');
    if ($(this).is(':checked')) {
        idsSeleccionados.add(id);
    } else {
        idsSeleccionados.delete(id);
    }
    actualizarContadorSeleccionados();
});

  // Checkbox general (seleccionar todos en la página actual)
  $('#clase_id_all').on('change', function () {
    const checked = $(this).is(':checked');
    $('.clase-checkbox').each(function () {
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

  // Al cambiar de página en DataTables, volver a marcar los checkboxes seleccionados
  $('#clase_data').on('draw.dt', function () {
    $('.clase-checkbox').each(function () {
      const id = $(this).data('id');
      $(this).prop('checked', idsSeleccionados.has(id));
    });

    // Si todos están seleccionados en la página actual, marcar también el "gg_id_all"
    const allChecked = $('.clase-checkbox').length > 0 && $('.clase-checkbox').length === $('.clase-checkbox:checked').length;
    $('#clase_id_all').prop('checked', allChecked);

    actualizarContadorSeleccionados();
  });
  
  $('#eliminar_gc').on('click', function () {
      let seleccionados = [];
      $('.clase-checkbox:checked').each(function () {
          seleccionados.push($(this).val());
      });
      console.log("IDs seleccionados para eliminar:", seleccionados);

      if (seleccionados.length === 0) {
          Swal.fire({
              title: '¡Atención!',
              text: 'Debes seleccionar al menos una Clase para continuar.',
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
          text: 'Esto eliminará las Clases seleccionados.',
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
                  background-color:rgb(138, 17, 107);
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
                  url: '../../controller/clase.php?op=eliminar_gc',
                  type: 'POST',
                 data: { ids: seleccionados },
                  success: function (response) {
                      console.log("Respuesta del servidor:", response); 
                      $('#clase_data').DataTable().ajax.reload(function() {
                          idsSeleccionados.clear();
                          $('.clase-checkbox').prop('checked', false);
                          $('#clase_id_all').prop('checked', false);
                          actualizarContadorSeleccionados();
                      });
                      Swal.fire({
                          title: 'Eliminadas',
                          text: 'Las Clases fueron eliminadas correctamente.',
                          imageUrl: '../../static/gif/verified.gif',
                          imageWidth: 100,
                          imageHeight: 100,
                          confirmButtonText: 'Entendido',
                          confirmButtonColor: 'rgb(155, 13, 119)',
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
              $('.clase-checkbox').prop('checked', false);
              $('#clase_id_all').prop('checked', false);
              actualizarContadorSeleccionados();
          }
      });
  });



function editarclase(clase_id){
    $.post("../../controller/clase.php?op=mostrar",{clase_id : clase_id}, function (data) {
        idsSeleccionados.clear();
        $('.clase-checkbox').prop('checked', false);
        $('#clase_id_all').prop('checked', false);
        $('#clase_nom, #clase_cod').removeClass('is-valid is-invalid');
        $('#errorNombre, #errorCodigo').removeClass('active');
        actualizarContadorSeleccionados();
        data = JSON.parse(data);
        $('#clase_id').val(data.clase_id);
        $('#clase_nom').val(data.clase_nom);
        $('#clase_cod').val(data.clase_cod);
        $('#lbltitulo').html('<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-mood-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20.955 11.104a9 9 0 1 0 -9.895 9.847" /><path d="M9 10h.01" /><path d="M15 10h.01" /><path d="M9.5 15c.658 .672 1.56 1 2.5 1c.126 0 .251 -.006 .376 -.018" /><path d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39z" /></svg> EDITAR CLASE REGISTRADA');
    });
   
    $('#modalClase').modal('show');
}

function eliminarclase(clase_id) {
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
              url: '../../controller/clase.php?op=eliminar',
                type: 'POST',
               data: {clase_id : clase_id},
                success: function (response) {
                   $('#clase_data').DataTable().ajax.reload();
                    Swal.fire({
                        title: '¡Eliminado!',
                        html: `
                            <p>La clase ha sido eliminado correctamente.</p>
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

function nuevaclase(){
  $('#clase_nom').val(''); 
  $('#clase_cod').val('');
  $('#clase_form')[0].reset();
  $('#clase_nom, #clase_cod').removeClass('is-valid is-invalid');
  $('#errorNombre, #errorCodigo').removeClass('active');
  $('#lbltitulo').html('<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-screen-share ms-3"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M21 12v3a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1v-10a1 1 0 0 1 1 -1h9" /><path d="M7 20l10 0" /><path d="M9 16l0 4" /><path d="M15 16l0 4" /><path d="M17 4h4v4" /><path d="M16 9l5 -5" /></svg> REGISTRAR NUEVA CLASE');
  $('#modalClase').modal('show');
  idsSeleccionados.clear();
  $('.clase-checkbox').prop('checked', false);
  $('#clase_id_all').prop('checked', false);
  actualizarContadorSeleccionados();
}
initclase();
