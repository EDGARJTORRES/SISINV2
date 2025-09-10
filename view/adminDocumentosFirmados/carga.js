 document.getElementById('archivo_pdf').addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
      const nombreArchivo = file.name;
      document.getElementById('upload_content').innerHTML = `
        <span class="upload-area-title text-center w-100">
          <i class="fa-solid fa-file-pdf me-2"></i> ${nombreArchivo}
        </span>
      `;
    }
  });
  document.getElementById('btnCancelar').addEventListener('click', function () {
  const form = document.getElementById('documento_form');
  form.reset();
  $(form).find('select.select2').val(null).trigger('change');
  document.getElementById('upload_content').innerHTML = `
    <span class="upload-area-icon">
      <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 340.531 419.116">
        <g id="files-new" clip-path="url(#clip-files-new)">
          <path id="Union_2" data-name="Union 2" d="M-2904.708-8.885A39.292,39.292..." transform="translate(2944 428)" fill="var(--c-action-primary)"></path>
        </g>
      </svg>
    </span>
    <span class="upload-area-title">Arrastre el archivo aquí o haga clic</span>
    <span class="upload-area-description">
      Solo se permiten archivos PDF firmados.<br /><strong>Clic Aqui</strong>
    </span>
  `;
  const fileInput = document.getElementById('archivo_pdf');
  fileInput.value = "";
});

$(document).ready(function () {
  $.post("../../controller/dependencia.php?op=combo", function (data) {
    $("#area_asignacion_combo").html(data).select2({
      dropdownParent: $("#modalRegistrar"),
      dropdownPosition: "below",
      width: '100%'
    });
  });
  $.post("../../controller/persona.php?op=combo", function (data) {
    $("#usuario_combo").html(data).select2({
      dropdownParent: $("#modalRegistrar"),
      dropdownPosition: "below",
      width: '100%'
    });
  });
});
function verDocumento(rutaRelativa) {
  const baseUrl = window.location.origin + '/sisPatrimonio/';
  const url = baseUrl + rutaRelativa.replace(/^doc\//, 'doc/');
  document.getElementById("documento-preview").innerHTML = `
      <iframe src="${url}" width="100%" height="600px" frameborder="0"></iframe>
  `;
  const modal = new bootstrap.Modal(document.getElementById('modalVerDocumento'));
  modal.show();
}