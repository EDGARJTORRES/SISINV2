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
