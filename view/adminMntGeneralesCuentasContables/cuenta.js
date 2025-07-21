
var usu_id = $('#usu_idx').val();
function initcuenta(){
    $("#cuenta_form").on("submit",function(e){
    e.preventDefault();
    const nombreInput = document.getElementById('cuenta_numero');
    const errorNombre = document.getElementById('errorNombre');
    let nombreValido = validarInput(nombreInput, errorNombre);
    if (nombreValido) {
       guardaryeditarcuenta(); 
        }
    });
    $('#cuenta_numero').on('input', function() {
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
function guardaryeditarcuenta() {
    const formData = new FormData($("#cuenta_form")[0]);

    $.ajax({
        url: "../../controller/cuenta.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            $('#cuenta_data').DataTable().ajax.reload();
            $('#modalCuenta').modal('hide');

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
                    const bar = document.createElement('div');
                    bar.id = 'top-progress-bar';
                    bar.style.cssText = `
                        position: absolute;
                        top: 0;
                        left: 0;
                        height: 6px;
                        width: 0%;
                        background-color: rgb(16, 141, 16);
                        transition: width 0.4s ease;
                    `;
                    Swal.getPopup().appendChild(bar);
                    setTimeout(() => {
                        bar.style.width = '100%';
                    }, 300);
                }
            });
        }
    });
}

function mostrarAlertaCarga() {
  document.getElementById('alerta-carga').style.display = 'block';
}
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

    $('#cuenta_data').on('preXhr.dt', function () {
        mostrarAlertaCarga();
        inicioCarga = new Date().getTime();
    });

    $('#cuenta_data').on('xhr.dt', function () {
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
    var table= $('#cuenta_data').DataTable({
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
           </svg> Exportar Datos`,
      buttons: [
      {
        extend: 'copyHtml5',
        text: `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clipboard" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 4h6a2 2 0 0 1 2 2v1h-10v-1a2 2 0 0 1 2 -2" /><path d="M9 4v1h6v-1" /><path d="M9 10h6" /><path d="M9 14h6" /><path d="M9 18h6" /><path d="M5 7v14h14v-14" /></svg> Copiar`,
        exportOptions: {
          columns: [ 1] 
        }
      },
      {
        extend: 'csvHtml5',
        text: `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-type-csv" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M10 13l1 2l1 -2l1 2l1 -2" /></svg> CSV`,
        exportOptions: {
          columns: [ 1] 
        }
      },
      {
        extend: 'excelHtml5',
        text: `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-spreadsheet" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M8 11h8v7h-8z" /><path d="M8 15h8" /><path d="M11 11v7" /></svg> Excel`,
        exportOptions: {
          columns: [ 1] 
        }
      },
      {
        extend: 'pdfHtml5',
        text: `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-type-pdf" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M10 12h1v4" /><path d="M14 12h1a1 1 0 0 1 0 2h-1v2" /><path d="M10 16h1" /></svg> PDF`,
        orientation: 'landscape',
        pageSize: 'A4',
        exportOptions: {
          columns: [ 1] 
        },
        customize: function (doc) {
          doc.defaultStyle.fontSize = 10;
        }
      },
      {
        extend: 'print',
        text: `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-printer" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9v-4a1 1 0 0 1 1 -1h10a1 1 0 0 1 1 1v4" /><path d="M6 18h12" /><path d="M6 14h12" /><path d="M9 18v3h6v-3" /><path d="M4 13v-2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v2" /></svg> Imprimir`,
        exportOptions: {
          columns: [ 1] 
        }
      }
       ]
  }
],
        "ajax":{
            url:"../../controller/cuenta.php?op=listar",
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
    $('#cuenta_id_all').on('change', function () {
        let isChecked = $(this).is(':checked');
        $('.cuenta-checkbox').prop('checked', isChecked);
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
  $('.cuenta-checkbox').prop('checked', false);
  $('#cuenta_id_all').prop('checked', false);
  actualizarContadorSeleccionados();
}
document.getElementById("cuenta_numero").addEventListener("input", function () {
  this.value = this.value.replace(/[^0-9.]/g, "");
});
  // Evento cuando se marca/desmarca cada checkbox
$(document).on('change', '.cuenta-checkbox', function () {
    const id = $(this).data('id');
    if ($(this).is(':checked')) {
        idsSeleccionados.add(id);
    } else {
        idsSeleccionados.delete(id);
    }
    actualizarContadorSeleccionados();
});
$('#cuenta_id_all').on('change', function () {
  const checked = $(this).is(':checked');
  $('.cuenta-checkbox').each(function () {
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

$('#cuenta_data').on('draw.dt', function () {
  $('.cuenta-checkbox').each(function () {
    const id = $(this).data('id');
    $(this).prop('checked', idsSeleccionados.has(id));
  });

  const allChecked = $('.cuenta-checkbox').length > 0 && $('.cuenta-checkbox').length === $('.cuenta-checkbox:checked').length;
  $('#cuenta_id_all').prop('checked', allChecked);

  actualizarContadorSeleccionados();
});

$('#eliminar_cuentas').on('click', function () {
    let seleccionados = [];
    $('.cuenta-checkbox:checked').each(function () {
        seleccionados.push($(this).val());
    });
    if (seleccionados.length === 0) {
        Swal.fire({
            title: '¡Atención!',
            text: 'Debes seleccionar al menos una cuenta contable para continuar.',
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
        text: 'Esto eliminará las cuentas contables seleccionados.',
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
                url: '../../controller/cuenta.php?op=eliminar_cuentas',
                type: 'POST',
                data: { ids: seleccionados },
                success: function (response) {
                    console.log("Respuesta del servidor:", response); 
                    $('#cuenta_data').DataTable().ajax.reload(function() {
                        idsSeleccionados.clear();
                        $('.cuenta-checkbox').prop('checked', false);
                        $('#cuenta_id_all').prop('checked', false);
                        actualizarContadorSeleccionados();
                    });
                    Swal.fire({
                        title: 'Eliminadas',
                        text: 'Las cuentas contables fueron eliminadas correctamente.',
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
            idsSeleccionados.clear();
            $('.cuenta-checkbox').prop('checked', false);
            $('#cuenta_id_all').prop('checked', false);
            actualizarContadorSeleccionados();
        }
    });
});
function editarcuenta(cuenta_id){
    $.post("../../controller/cuenta.php?op=mostrar",{cuenta_id : cuenta_id}, function (data) {
        idsSeleccionados.clear();
        $('.cuenta-checkbox').prop('checked', false);
        $('#cuenta_id_all').prop('checked', false);
        $('#cuenta_numero').removeClass('is-valid is-invalid');
        $('#errorNombre').removeClass('active');
        actualizarContadorSeleccionados();
        data = JSON.parse(data);
        $('#cuenta_id').val(data.cuenta_id);
        $('#cuenta_numero').val(data.cuenta_numero);
        $('#lbltitulo').html('<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-screen-share ms-3"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M21 12v3a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1v-10a1 1 0 0 1 1 -1h9" /><path d="M7 20l10 0" /><path d="M9 16l0 4" /><path d="M15 16l0 4" /><path d="M17 4h4v4" /><path d="M16 9l5 -5" /></svg> EDITAR CUENTA CONTABLE');
        $('#lblsubtitulo').html('MODIFICAR LA CUENTA CONTABLE SELECCIONADA');
        const ahora = dayjs(); // si usas dayjs
        mostrarUltimaAccion(`Editó la cuenta contable "${data.cuenta_numero}"`, ahora.toISOString());
    });  
    $('#modalCuenta').modal('show');
}
function eliminarcuenta(cuenta_id) {
    $.post("../../controller/cuenta.php?op=mostrar", { cuenta_id }, function (data) {
        data = JSON.parse(data);
        const cuenta_numero = data.cuenta_numero;

        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡Esta acción no se puede deshacer!",
            imageUrl: '../../static/gif/advertencia.gif',
            imageWidth: 100,
            imageHeight: 100,
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminarlo',
            confirmButtonColor: 'rgb(243, 18, 18)',
            cancelButtonColor: '#000',
            didOpen: () => {
                const bar = document.createElement('div');
                bar.id = 'top-progress-bar';
                bar.style.cssText = `position:absolute;top:0;left:0;height:5px;width:0%;background-color:rgb(243, 18, 18);transition:width 0.4s ease;`;
                Swal.getPopup().appendChild(bar);
                setTimeout(() => { bar.style.width = '40%'; }, 300);
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../../controller/cuenta.php?op=eliminar',
                    type: 'POST',
                    data: { cuenta_id },
                    success: function () {
                        $('#cuenta_data').DataTable().ajax.reload();
                        mostrarUltimaAccion(`Eliminó la cuenta contable "${cuenta_numero}"`, dayjs().toISOString());

                        Swal.fire({
                            title: '¡Eliminado!',
                            html: `<p>La cuenta contable <strong>${cuenta_numero}</strong> ha sido eliminada correctamente.</p>
                            <div id="top-progress-bar-final" style="position:absolute;top:0;left:0;height:5px;width:0%;background-color:rgb(243, 18, 18);transition:width 0.6s ease;"></div>`,
                            imageUrl: '../../static/gif/verified.gif',
                            imageWidth: 100,
                            imageHeight: 100,
                            confirmButtonColor: 'rgb(243, 18, 18)',
                            didOpen: () => {
                                const bar = document.getElementById('top-progress-bar-final');
                                setTimeout(() => { bar.style.width = '100%'; }, 100);
                            }
                        });
                    },
                    error: function () {
                        Swal.fire('Error', 'No se pudo eliminar la cuenta contable.', 'error');
                    }
                });
            }
        });
    });
}

$('#cuenta_form').on('reset', function () {
  setTimeout(function () {
    $('#cuenta_numero').removeClass('is-valid is-invalid');
    $('#errorNombre').removeClass('active');
  }, 0);
});
function nuevacuenta(){
  $('#cuenta_numero').val(''); 
  $('#cuenta_form')[0].reset();
  $('#cuenta_numero').removeClass('is-valid is-invalid');
  $('#errorNombre').removeClass('active');
  $('#lbltitulo').html('<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-screen-share ms-3"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M21 12v3a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1v-10a1 1 0 0 1 1 -1h9" /><path d="M7 20l10 0" /><path d="M9 16l0 4" /><path d="M15 16l0 4" /><path d="M17 4h4v4" /><path d="M16 9l5 -5" /></svg> REGISTRAR NUEVA CUENTA CONTABLE');
  $('#lblsubtitulo').html(' POR FAVOR, COMPLETE LOS DATOS DE LA CUENTA CONTABLE A REGISTRAR');
  $('#modalCuenta').modal('show');
  idsSeleccionados.clear();
  $('.cuenta-checkbox').prop('checked', false);
  $('#cuenta_id_all').prop('checked', false);
  actualizarContadorSeleccionados();
}
initcuenta();
