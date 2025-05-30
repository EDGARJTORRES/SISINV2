
var usu_id = $('#usu_idx').val();

function initGG() {
  $("#GG_form").on("submit", function(e) {
    e.preventDefault(); 

    const nombreInput = document.getElementById('ggnomgene');
    const codigoInput = document.getElementById('ggcodgene');
    const errorNombre = document.getElementById('errorNombre');
    const errorCodigo = document.getElementById('errorCodigo');

    let nombreValido = validarInput(nombreInput, errorNombre);
    let codigoValido = validarInput(codigoInput, errorCodigo);

    if (nombreValido && codigoValido) {
      guardaryeditarGG(); 
    }
  });

  $('#ggnomgene').on('input', function() {
    validarInput(this, document.getElementById('errorNombre'));
  });

  $('#ggcodgene').on('input', function() {
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

function guardaryeditarGG() {
  var formData = new FormData($("#GG_form")[0]);
  $.ajax({
    url: "../../controller/grupogenerico.php?op=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function(data) {
      $('#GG_data').DataTable().ajax.reload();
      $('#modalGG').modal('hide');
      Swal.fire({
        title: '¡Correcto!',
        text: 'Se registró correctamente el Grupo Generico.',
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
     $('#gg_id_all').on('change', function () {
        let isChecked = $(this).is(':checked');
        $('.gg-checkbox').prop('checked', isChecked);
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
  $('.gg-checkbox').prop('checked', false);
  $('#gg_id_all').prop('checked', false);
  actualizarContadorSeleccionados();
}

  // Evento cuando se marca/desmarca cada checkbox
  $(document).on('change', '.gg-checkbox', function () {
    const id = $(this).data('id');
    if ($(this).is(':checked')) {
      idsSeleccionados.add(id);
    } else {
      idsSeleccionados.delete(id);
    }
    actualizarContadorSeleccionados();
  });
  $('#gg_id_all').on('change', function () {
    const checked = $(this).is(':checked');
    $('.gg-checkbox').each(function () {
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

  $('#GG_data').on('draw.dt', function () {
    $('.gg-checkbox').each(function () {
      const id = $(this).data('id');
      $(this).prop('checked', idsSeleccionados.has(id));
    });

    const allChecked = $('.gg-checkbox').length > 0 && $('.gg-checkbox').length === $('.gg-checkbox:checked').length;
    $('#gg_id_all').prop('checked', allChecked);

    actualizarContadorSeleccionados();
  });
  
  $('#eliminar_gg').on('click', function () {
      let seleccionados = [];
      $('.gg-checkbox:checked').each(function () {
          seleccionados.push($(this).val());
      });
      if (seleccionados.length === 0) {
          Swal.fire({
              title: '¡Atención!',
              text: 'Debes seleccionar al menos un Grupo Generico para continuar.',
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
          text: 'Esto eliminará los Grupos genericos seleccionados.',
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
                  url: '../../controller/grupogenerico.php?op=eliminar_gg',
                  type: 'POST',
                  data: { ids: seleccionados },
                  success: function (response) {
                      $('#GG_data').DataTable().ajax.reload(function() {
                          idsSeleccionados.clear();
                          $('.gg-checkbox').prop('checked', false);
                          $('#gg_id_all').prop('checked', false);
                          // Reiniciar el contador
                          actualizarContadorSeleccionados();
                      });
                      Swal.fire({
                          title: 'Eliminadas',
                          text: 'Las Grupos Genericos fueron eliminadas correctamente.',
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
              idsSeleccionados.clear();
              $('.gg-checkbox').prop('checked', false);
              $('#gg_id_all').prop('checked', false);
              actualizarContadorSeleccionados();
          }
      });
  });


function editarGG(gg_id_input){
  
    $.post("../../controller/grupogenerico.php?op=mostrar",{gg_id_input : gg_id_input}, function (data) {
        idsSeleccionados.clear();
        $('.gg-checkbox').prop('checked', false);
        $('#gg_id_all').prop('checked', false);
        $('#ggnomgene, #ggcodgene').removeClass('is-valid is-invalid');
        $('#errorNombre, #errorCodigo').removeClass('active');
        actualizarContadorSeleccionados();
        data = JSON.parse(data);
        $('#ggidgene').val(data.gg_id);
        $('#ggnomgene').val(data.gg_nom);
        $('#ggcodgene').val(data.gg_cod);
        $('#lbltitulo').html('<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-mood-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20.955 11.104a9 9 0 1 0 -9.895 9.847" /><path d="M9 10h.01" /><path d="M15 10h.01" /><path d="M9.5 15c.658 .672 1.56 1 2.5 1c.126 0 .251 -.006 .376 -.018" /><path d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39z" /></svg> EDITAR GRUPO GENERICO REGISTRADO');
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
                data: { gg_id: gg_id },
                success: function (response) {
                    const table = $('#GG_data').DataTable();
                    table.ajax.reload(limpiarSeleccion);
                    Swal.fire({
                        title: '¡Eliminado!',
                        html: `
                            <p>El Grupo Genérico ha sido eliminado correctamente.</p>
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
                            setTimeout(() => bar.style.width = '100%', 100);
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
  $('#ggnomgene').val(''); 
  $('#ggcodgene').val('');
  $('#GG_form')[0].reset();
  $('#ggnomgene, #ggcodgene').removeClass('is-valid is-invalid');
  $('#errorNombre, #errorCodigo').removeClass('active');
  $('#lbltitulo').html('<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-screen-share ms-3"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M21 12v3a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1v-10a1 1 0 0 1 1 -1h9" /><path d="M7 20l10 0" /><path d="M9 16l0 4" /><path d="M15 16l0 4" /><path d="M17 4h4v4" /><path d="M16 9l5 -5" /></svg> REGISTRAR NUEVO GRUPO GENERICO');
  $('#modalGG').modal('show');
  idsSeleccionados.clear();
  $('.gg-checkbox').prop('checked', false);
  $('#gg_id_all').prop('checked', false);
  actualizarContadorSeleccionados();
}
initGG();
