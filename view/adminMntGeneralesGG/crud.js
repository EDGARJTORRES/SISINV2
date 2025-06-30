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
function editarGG(gg_id){
    $.post("../../controller/grupogenerico.php?op=mostrar",{gg_id : gg_id}, function (data) {
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
        const ahora = dayjs();
        mostrarUltimaAccion(`Editó el Grupo Generico "${data.gg_nom}"`, ahora.toISOString());
    });
    $('#modalGG').modal('show');
   
}
function eliminarGG(gg_id) {
    $.post("../../controller/grupogenerico.php?op=mostrar", { gg_id: gg_id }, function (data) {
        data = JSON.parse(data);
        const nombreGrupo = data.gg_nom;

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
                        const ahora = dayjs();
                        mostrarUltimaAccion(`Eliminó el Grupo Genérico "${nombreGrupo}"`, ahora.toISOString());

                        $('#GG_data').DataTable().ajax.reload(limpiarSeleccion);

                        Swal.fire({
                            title: '¡Eliminado!',
                            html: `
                                <p>El Grupo Genérico <strong>${nombreGrupo}</strong> ha sido eliminado correctamente.</p>
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
                        Swal.fire('Error', 'No se pudo eliminar el Grupo Generico.', 'error');
                    }
                });
            }
        });
    });
}
$('#modalGG').on('reset', function () {
  setTimeout(function () {
    $('#ggnomgene, #ggcodgene').removeClass('is-valid is-invalid');
    $('#errorNombre, #errorCodigo').removeClass('active');
  }, 0); 
});