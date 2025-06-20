function imprimirFormato(form_id){
  redirect_by_post(
    "../../controller/formato.php?op=imprimir_formato",
    { form_id: form_id },
    true
  );
}
function eliminarFormato(form_id) {
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
              url: '../../controller/formato.php?op=eliminar_formato',
              type: 'POST',
               data: {form_id :form_id},
                success: function (response) {
                   $('#formatos_data').DataTable().ajax.reload();
                    Swal.fire({
                        title: '¡Eliminado!',
                        html: `
                            <p>El formato ha sido eliminado correctamente.</p>
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
                    Swal.fire('Error', 'No se pudo eliminar el formato.', 'error');
                }
            });
        }
    });
}
function redirect_by_post(purl, pparameters, in_new_tab) {
  pparameters = typeof pparameters == "undefined" ? {} : pparameters;
  in_new_tab = typeof in_new_tab == "undefined" ? true : in_new_tab;

  var form = document.createElement("form");
  $(form)
    .attr("id", "reg-form")
    .attr("name", "reg-form")
    .attr("action", purl)
    .attr("method", "post")
    .attr("enctype", "multipart/form-data");
  if (in_new_tab) {
    $(form).attr("target", "_blank");
  }
  $.each(pparameters, function (key) {
    $(form).append(
      '<input type="text" name="' + key + '" value="' + this + '" />'
    );
  });
  document.body.appendChild(form);
  form.submit();
  document.body.removeChild(form);

  return false;
}