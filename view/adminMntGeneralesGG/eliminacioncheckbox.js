  let idsSeleccionados = new Set();
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