
var usu_id = $('#usu_idx').val();

function initmodelo() {
  $("#modelo_form").on("submit", function (e) {
    e.preventDefault();

    const nombreInput = document.getElementById('modelo_nom');
    const comboInput = document.getElementById('combo_marca_obj');
    const errorNombre = document.getElementById('errorNombre');
    const errorCombo = document.getElementById('errorCombo');

    const nombreValido = validarInput(nombreInput, errorNombre);
    const comboValido = validarSelect(comboInput, errorCombo);

    if (nombreValido && comboValido) {
      guardaryeditarmodelo();
    }
  });

  $('#modelo_nom').on('input', function () {
    validarInput(this, document.getElementById('errorNombre'));
  });

  $('#combo_marca_obj').on('change', function () {
    validarSelect(this, document.getElementById('errorCombo'));
  });
}

function validarInput(input, errorDiv) {
  const valor = input.value.trim();
  const patternAttr = input.getAttribute("pattern");

  let esValido = true;

  if (patternAttr) {
    const pattern = new RegExp(patternAttr);
    esValido = pattern.test(valor);
  }

  if (!valor || !esValido) {
    input.classList.remove('is-valid');
    input.classList.add('is-invalid');
    errorDiv.classList.remove('d-none');
    return false;
  } else {
    input.classList.remove('is-invalid');
    input.classList.add('is-valid');
    errorDiv.classList.add('d-none');
    return true;
  }
}

function validarSelect(select, errorDiv) {
  if (!select.value || select.value === "") {
    select.classList.remove('is-valid');
    select.classList.add('is-invalid');
    errorDiv.classList.remove('d-none');
    return false;
  } else {
    select.classList.remove('is-invalid');
    select.classList.add('is-valid');
    errorDiv.classList.add('d-none');
    return true;
  }
}

function guardaryeditarmodelo() {

  const formData = new FormData($("#modelo_form")[0]);
  $.ajax({
    url: "../../controller/modelo.php?op=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (data) {
      $('#modelo_data').DataTable().ajax.reload();
      $('#modalModelo').modal('hide');
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
    $("#combo_marca_obj").select2({
    dropdownParent: $("#modalModelo"),
    dropdownPosition: "below",
    });
    $.post("../../controller/marca.php?op=combo", function (data) {
        $("#combo_marca_obj").html(data);
    });
    var table= $('#modelo_data').DataTable({
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
    $('#modelo_id_all').on('change', function () {
        let isChecked = $(this).is(':checked');
        $('.modelo-checkbox').prop('checked', isChecked);
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
  $('.modelo-checkbox').prop('checked', false);
  $('#modelo_id_all').prop('checked', false);
  actualizarContadorSeleccionados();
}

$(document).on('change', '.modelo-checkbox', function () {
    const id = $(this).data('id');
    if ($(this).is(':checked')) {
        idsSeleccionados.add(id);
    } else {
        idsSeleccionados.delete(id);
    }
    actualizarContadorSeleccionados();
});

$('#modelo_id_all').on('change', function () {
  const checked = $(this).is(':checked');
  $('.modelo-checkbox').each(function () {
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

$('#modelo_data').on('draw.dt', function () {
  $('.modelo-checkbox').each(function () {
    const id = $(this).data('id');
    $(this).prop('checked', idsSeleccionados.has(id));
  });

  const allChecked = $('.modelo-checkbox').length > 0 && $('.modelo-checkbox').length === $('.modelo-checkbox:checked').length;
  $('#modelo_id_all').prop('checked', allChecked);

  actualizarContadorSeleccionados();
});
  
$('#eliminar_modelos').on('click', function () {
    let seleccionados = [];
    $('.modelo-checkbox:checked').each(function () {
        seleccionados.push($(this).val());
    });
    if (seleccionados.length === 0) {
        Swal.fire({
            title: '¡Atención!',
            text: 'Debes seleccionar al menos un modelo para continuar.',
            imageUrl: '../../static/gif/tarjeta.gif',
            imageWidth: 100,
            imageHeight: 100,
            confirmButtonText: 'Entendido',
            confirmButtonColor: 'rgb(243, 18, 18)', 
        });
        return;
    }
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esto eliminará los modelos seleccionados.',
        imageUrl: '../../static/gif/advertencia.gif',
        imageWidth: 100,
        imageHeight: 100,
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        confirmButtonColor: 'rgb(243, 18, 18)', 
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
                url: '../../controller/modelo.php?op=eliminar_modelos',
                type: 'POST',
                data: { ids: seleccionados },
                success: function (response) {
                    console.log("Respuesta del servidor:", response); 
                    $('#modelo_data').DataTable().ajax.reload(function() {
                        idsSeleccionados.clear();
                        $('.modelo-checkbox').prop('checked', false);
                        $('#modelo_id_all').prop('checked', false);
                        actualizarContadorSeleccionados();
                    });
                    Swal.fire({
                        title: 'Eliminadas',
                        text: 'Las modelos fueron eliminadas correctamente.',
                        imageUrl: '../../static/gif/verified.gif',
                        imageWidth: 100,
                        imageHeight: 100,
                        confirmButtonText: 'Entendido',
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
                    Swal.fire('Error', 'No se pudieron eliminar.', 'error');
                }
            });
        } else {
            // Lógica para reiniciar todo al cancelar
            idsSeleccionados.clear();
            $('.modelo-checkbox').prop('checked', false);
            $('#modelo_id_all').prop('checked', false);
            actualizarContadorSeleccionados();
        }
    });
});

function editarmodelo(modelo_id_input){
    $.post("../../controller/modelo.php?op=mostrar",{modelo_id_input :modelo_id_input}, function (data) {
        idsSeleccionados.clear();
        $('.modelo-checkbox').prop('checked', false);
        $('#modelo_id_all').prop('checked', false);
        $('#modelo_nom, #combo_marca_obj').removeClass('is-valid is-invalid');
        $('#errorNombre, #errorCombo').removeClass('active');
        actualizarContadorSeleccionados();
        data = JSON.parse(data);
         $('#modelo_id').val(data.modelo_id);
         $('#modelo_nom').val(data.modelo_nom);
         $('#combo_marca_obj').val(data.marca_id).trigger('change');
         $('#lbltitulo').html('<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-mood-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20.955 11.104a9 9 0 1 0 -9.895 9.847" /><path d="M9 10h.01" /><path d="M15 10h.01" /><path d="M9.5 15c.658 .672 1.56 1 2.5 1c.126 0 .251 -.006 .376 -.018" /><path d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39z" /></svg> EDITAR MARCA REGISTRADO');
    });
     $('#modalModelo').modal('show');
}
function eliminarmodelo(modelo_id) {
   $('.modelo-checkbox').prop('checked', false);
   $('#modelo_id_all').prop('checked', false);
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
                   $('#modelo_data').DataTable().ajax.reload();
                    Swal.fire({
                        title: '¡Eliminado!',
                        html: `
                            <p>El modelo ha sido eliminado correctamente.</p>
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
$('#btnCancelar').on('click', function() {
  resetearFormularioModelo();
});
function resetearFormularioModelo() {
  $('#modelo_form')[0].reset(); 
  $('#combo_marca_obj').val('').trigger('change');
  $('#modelo_nom').val(''); 
  $('#modelo_nom, #combo_marca_obj').removeClass('is-valid is-invalid');
  idsSeleccionados.clear();
  actualizarContadorSeleccionados();
}

function nuevomodelo(){
  $('#modelo_nom').val(''); 
  $('#combo_marca_obj').val('').trigger('change'); 
  $('#modelo_form')[0].reset();
  $('.modelo-checkbox').prop('checked', false);
  $('#modelo_id_all').prop('checked', false);
  $('#modelo_nom, #combo_marca_obj').removeClass('is-valid is-invalid');
  $('#errorNombre, #errorCombo').removeClass('active');
  $('#lbltitulo').html('<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-screen-share ms-3"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M21 12v3a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1v-10a1 1 0 0 1 1 -1h9" /><path d="M7 20l10 0" /><path d="M9 16l0 4" /><path d="M15 16l0 4" /><path d="M17 4h4v4" /><path d="M16 9l5 -5" /></svg> REGISTRAR NUEVO MODELO');
  $('#modalModelo').modal('show');
  idsSeleccionados.clear();
  $('.modelo-checkbox').prop('checked', false);
  $('#modelo_id_all').prop('checked', false);
  actualizarContadorSeleccionados();
}
initmodelo();
