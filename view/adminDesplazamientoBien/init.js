function initbienes() {
  $("#bien_form").on("submit", function (e) {
    guardaryeditarbienes(e);
  });
}
function guardaryeditarbienes(e) {
  e.preventDefault();
}
$(document).ready(function () {
  $(".select2").select2();
  $.post("../../controller/dependencia.php?op=combo", function (data) {
    $("#area_destino_combo").html(data);
    $("#area_origen_combo").html(data);
  });
  $.post("../../controller/persona.php?op=combo", function (data) {
    $("#usuario_combo_origen").html(data);
    $("#usuario_combo_destino").html(data);
  });
});
$("#usuario_combo_origen").on("change", function () {
  let pers_id = $(this).val();
  if (pers_id) {
    listarBienesRepre(pers_id); 
  } else {
    $("#obj_formato").DataTable().clear().draw();
  }
});
function limpiarFiltros() { 
  $('#buscar_registros').val('');
  if ($.fn.dataTable.isDataTable('#obj_formato')) {
    const table = $('#obj_formato').DataTable();
    table.search('').columns().search('').draw();
    table.ajax.reload(null, false);
  } else {
    console.warn('La tabla #obj_formato no está inicializada como DataTable.');
  }
}
initbienes();
