
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
