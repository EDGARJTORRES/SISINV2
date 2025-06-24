function initbienes() {
  $("#bien_form").on("submit", function (e) {
    guardaryeditarbienes(e);
  });
}
$(document).ready(function () {
  $(".select2").select2();

  $.post("../../controller/dependencia.php?op=combo", function (data) {
    $("#area_asignacion_combo").html(data);
  });
});
initbienes();