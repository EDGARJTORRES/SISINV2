$(document).ready(function () {
  $("#spinner").hide();
  $("#fecharegistro").mask("9999/99/99");

  $(".select2").select2();

  $("#combo_modelo_obj").select2({
    dropdownParent: $("#modalObjetoCate"),
    dropdownPosition: "below",
  });
  $("#combo_gg_bien_obj").select2({
    dropdownParent: $("#modalObjetoCate"),
    dropdownPosition: "below",
  });
  $("#combo_color_bien").select2({
    dropdownParent: $("#modalObjetoCate"),
    dropdownPosition: "below",
  });
  $("#combo_clase_bien_obj").select2({
    dropdownParent: $("#modalObjetoCate"),
    dropdownPosition: "below",
  });
  $("#combo_obj_bien").select2({
    dropdownParent: $("#modalObjetoCate"),
    dropdownPosition: "below",
  });
  $("#combo_gg_tabla_obj").select2({
    dropdownParent: $("#modalobjgg"),
    dropdownPosition: "below",
  });
  $("#combo_clase_bien_obj_tabla").select2({
    dropdownParent: $("#modalobjgg"),
    dropdownPosition: "below",
  });
  $("#combo_marca_obj").select2({
    dropdownParent: $("#modalObjetoCate"),
    dropdownPosition: "below",
  });
  $("#combo_color_bien").select2({
    dropdownParent: $("#modalObjetoCate"),
    dropdownPosition: "below",
  });
   $("#procedencia").select2({
    dropdownParent: $("#modalObjetoCate"),
    dropdownPosition: "below",
  });

  $("#combo_gg_bien_obj").change(function () {
    if (modoEdicion) return; // ⚠️ evitar recarga automática en edición

    const gg_id = $(this).val();
    if (gg_id !== "") {
      $.post("../../controller/clase.php?op=combo", { gg_id: gg_id }, function (data) {
        $("#combo_clase_bien_obj").html(data);
        $("#combo_obj_bien").html(""); // limpia objeto
      });
    }
  });
  $.post("../../controller/grupogenerico.php?op=combo", function (data) {
    $("#combo_gg_bien_obj").html(data);
  });
  $.post("../../controller/objeto.php?op=combo_color", function (data) {
    $("#combo_color_bien").html(data);
  });
  $.post("../../controller/marca.php?op=combo", function (data) {
    $("#combo_marca_obj").html(data);
  });
  $("#combo_marca_obj").change(function () {
  var marca_id = $(this).val();

    if (!modoEdicion) {
      $("#combo_modelo_obj").empty();
    }
    if (marca_id !== "") {
      $.post(
        "../../controller/objeto.php?op=combo_modelo",
        { marca_id: marca_id },
        function (data) {
          $("#combo_modelo_obj").html(data);

          if (modoEdicion) {
            // Reinicia el valor del modelo en edición
            $("#combo_modelo_obj").val($("#modelo_id").val()).trigger("change");
          }
        }
      );
    }
  });

  $("#combo_clase_bien_obj").change(function () {
    if (modoEdicion) return;

    const gc_id = $(this).val();
    if (gc_id !== "") {
      $.post("../../controller/objeto.php?op=combo_clase", { gc_id: gc_id }, function (data) {
        $("#combo_obj_bien").html(data);
      });
    }
  });

  $("#combo_obj_bien").change(function () {
    if (modoEdicion) {
      return;
    }
    var obj_id = $(this).val();
    if (obj_id !== "") {
      var cod = $("#cod_interno").val();
      var codigo_cana = $("#combo_obj_bien option:selected").attr("data-codigo-cana");
      var nuevo_cod = `${codigo_cana}-${cod}`;
      $("#codigo_barras_input").val(nuevo_cod);
      generarCodigoBarras(nuevo_cod);
    }
  });
  $("#combo_gg_bien_obj").change(function () {
    var gg_id = $(this).val();
    if (gg_id !== "") {
      $.post(
        "../../controller/clase.php?op=combo",
        { gg_id: gg_id },
        function (data) {
          $("#combo_clase_bien_obj").html(data);
        }
      );
    }
  });
  
});