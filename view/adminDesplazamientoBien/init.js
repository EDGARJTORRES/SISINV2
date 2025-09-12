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
});

initbienes();
