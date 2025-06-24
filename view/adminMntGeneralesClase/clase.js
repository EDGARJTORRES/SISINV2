
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
function mostrarAlertaCarga() {
  document.getElementById('alerta-carga').style.display = 'block';
}

// Ocultar alerta
function ocultarAlertaCarga() {
  document.getElementById('alerta-carga').style.display = 'none';
}

$(document).ready(function () {
    setTimeout(() => {
       $('.buttons-collection')
      .removeClass('btn-secondary')
      .addClass('btn');
    }, 300);
    let inicioCarga;
    let tiempoMinimo = 3000; // 2 segundos

    $('#clase_data').on('preXhr.dt', function () {
        mostrarAlertaCarga();
        inicioCarga = new Date().getTime();
    });

    $('#clase_data').on('xhr.dt', function () {
        let finCarga = new Date().getTime();
        let duracion = finCarga - inicioCarga;
        let tiempoRestante = tiempoMinimo - duracion;

        if (tiempoRestante > 0) {
            setTimeout(function () {
                ocultarAlertaCarga();
            }, tiempoRestante);
        } else {
            ocultarAlertaCarga();
        }
    });
    var table= $('#clase_data').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        searching: true,
         buttons: [
           {
            extend: 'collection',
            text: `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                    <path d="M7 11l5 5l5 -5" />
                    <path d="M12 4v12" />
                </svg> Exportar`,
            buttons: [
            {
                extend: 'copyHtml5',
                text: `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clipboard" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 4h6a2 2 0 0 1 2 2v1h-10v-1a2 2 0 0 1 2 -2" /><path d="M9 4v1h6v-1" /><path d="M9 10h6" /><path d="M9 14h6" /><path d="M9 18h6" /><path d="M5 7v14h14v-14" /></svg> Copiar`,
                exportOptions: {
                columns: [ 1, 2] 
                }
            },
            {
                extend: 'csvHtml5',
                text: `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-type-csv" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M10 13l1 2l1 -2l1 2l1 -2" /></svg> CSV`,
                exportOptions: {
                columns: [ 1, 2] 
                }
            },
            {
                extend: 'excelHtml5',
                text: `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-spreadsheet" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M8 11h8v7h-8z" /><path d="M8 15h8" /><path d="M11 11v7" /></svg> Excel`,
                exportOptions: {
                columns: [ 1, 2] 
                }
            },
            {
                extend: 'pdfHtml5',
                text: `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-type-pdf" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M10 12h1v4" /><path d="M14 12h1a1 1 0 0 1 0 2h-1v2" /><path d="M10 16h1" /></svg> PDF`,
                orientation: 'landscape',
                pageSize: 'A4',
                exportOptions: {
                columns: [ 1, 2] 
                },
                customize: function (doc) {
                doc.defaultStyle.fontSize = 10;
                }
            },
            {
                extend: 'print',
                text: `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-printer" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9v-4a1 1 0 0 1 1 -1h10a1 1 0 0 1 1 1v4" /><path d="M6 18h12" /><path d="M6 14h12" /><path d="M9 18v3h6v-3" /><path d="M4 13v-2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v2" /></svg> Imprimir`,
                 extend: 'print',
                text: `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-printer" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9v-4a1 1 0 0 1 1 -1h10a1 1 0 0 1 1 1v4" /><path d="M6 18h12" /><path d="M6 14h12" /><path d="M9 18v3h6v-3" /><path d="M4 13v-2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v2" /></svg> Imprimir`,
                exportOptions: {
                columns: [ 1, 2] 
                }
            }
            ]
        }
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
    table.buttons().container().appendTo('#contenedor-excel');
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
    const sliderElement = document.getElementById('slider_rango');
    noUiSlider.create(sliderElement, {
      start: [1, 100],
      connect: true,
      range: {
        'min': 1,
        'max': 100
      },
      tooltips: [false, false],
      format: {
        to: value => Math.round(value),
        from: value => Number(value)
      }
    }); 
    sliderElement.noUiSlider.on('update', function (values) {
      const min = parseInt(values[0]);
      const max = parseInt(values[1]);
      document.getElementById('min_valor').textContent = min;
      document.getElementById('max_valor').textContent = max;

      $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        const cantidad = parseInt(data[1]) || 0;
        return cantidad >= min && cantidad <= max;
      });

      table.draw();
      $.fn.dataTable.ext.search.pop();
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


function limpiarFiltros() {
  $('#buscar_dependencia').val('');
  $('#filtro_dependencia').val('');
  const slider = document.getElementById('slider_rango').noUiSlider;
  slider.set([1, 100]); 
  document.getElementById('min_valor').textContent = 1;
  document.getElementById('max_valor').textContent = 100;
  const table = $('#dependencias_objetos').DataTable();
  table.search('').draw(); 
  $.fn.dataTable.ext.search = []; 
  table.draw();
}



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
        const ahora = dayjs(); // si usas dayjs
        mostrarUltimaAccion(`Editó la clase "${data.clase_nom}"`, ahora.toISOString());
    });
   
    $('#modalClase').modal('show');
}

function eliminarclase(clase_id) {
  $.post("../../controller/clase.php?op=mostrar", { clase_id: clase_id }, function (data) {
    data = JSON.parse(data);
    const nombre_clase = data.clase_nom;

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
          data: { clase_id: clase_id },
          success: function (response) {
            $('#clase_data').DataTable().ajax.reload();

            const ahora = dayjs();
            mostrarUltimaAccion(`Eliminó la clase "${nombre_clase}"`, ahora.toISOString());

            Swal.fire({
              title: '¡Eliminado!',
              html: `
                <p>La clase <strong>${nombre_clase}</strong> ha sido eliminada correctamente.</p>
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
  });
}


$('#clase_form').on('reset', function () {
  setTimeout(function () {
    $('#clase_nom, #clase_cod').removeClass('is-valid is-invalid');
    $('#errorNombre, #errorCodigo').removeClass('active');
  }, 0);
});
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
