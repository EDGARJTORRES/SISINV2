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