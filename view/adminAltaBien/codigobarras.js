function generarCodigoBarras(codigoBarras) {
  var canvas = document.getElementById("codigo_barras_canvas");
  var ctx = canvas.getContext("2d");
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  JsBarcode(canvas, codigoBarras, {
    format: "CODE128",
    displayValue: true,
    fontOptions: "bold",
    textAlign: "center",
    textMargin: 10,
    fontSize: 14,
    width: 2,
    height: 30,
  });
}
function generarBarras() {
  obj_id = $("#combo_obj_bien").val();
  $.ajax({
    type: "POST",
    url: "../../controller/dependencia.php?op=generarBarras",
    data: { obj_id: obj_id }, 
    dataType: "json",
    success: function (response) {
      $("#codigo_barras_input").val(response.codigo_cana);
    },
    error: function (xhr, status, error) {
      console.error(error);
    },
  });
}