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
$(document).on('change', '.clase-checkbox', function () {
    const id = $(this).data('id');
    if ($(this).is(':checked')) {
        idsSeleccionados.add(id);
    } else {
        idsSeleccionados.delete(id);
    }
    actualizarContadorSeleccionados();
});
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
            idsSeleccionados.clear();
            $('.clase-checkbox').prop('checked', false);
            $('#clase_id_all').prop('checked', false);
            actualizarContadorSeleccionados();
        }
    });
});
