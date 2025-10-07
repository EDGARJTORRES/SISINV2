let modoEdicion = false;
function initbienes() {
  $("#bien_form").on("submit", function (e) {
    guardaryeditarbienes(e);
  });
}
function mostrarLoader() {
  const loader = document.getElementById('page');
  loader.style.visibility = 'visible';
  loader.style.opacity = '1';
  loader.style.pointerEvents = 'auto';
}
function ocultarLoader() {
  const loader = document.getElementById('page');
  loader.style.visibility = 'hidden';
  loader.style.opacity = '0';
  loader.style.pointerEvents = 'none';
}

function redirect_by_post(purl, pparameters, in_new_tab) {
  pparameters = typeof pparameters === "undefined" ? {} : pparameters;
  in_new_tab = typeof in_new_tab === "undefined" ? true : in_new_tab;

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

  // Manejar parámetros
  $.each(pparameters, function (key, value) {
    if (Array.isArray(value)) {
      value.forEach(function (v) {
        $(form).append(
          '<input type="hidden" name="' + key + '[]" value="' + v + '" />'
        );
      });
    } else {
      $(form).append(
        '<input type="hidden" name="' + key + '" value="' + value + '" />'
      );
    }
  });

  document.body.appendChild(form);
  form.submit();
  document.body.removeChild(form);

  return false;
}
$("#cod_interno").on("input", function () {
  let codigo_cana = $("#combo_obj_bien option:selected").attr("data-codigo-cana") || "";
  let cod_interno = $(this).val();
  let cod_barra = `${codigo_cana}-${cod_interno}`;
  $("#codigo_barras_input").val(cod_barra);
  generarCodigoBarras(cod_barra);
});

initbienes();
