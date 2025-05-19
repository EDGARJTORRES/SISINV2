function initbienes() {
  $("#bien_form").on("submit", function (e) {
    guardaryeditarbienes(e);
  });
}

function guardaryeditarbienes(e) {
  e.preventDefault();

  var formData = new FormData($("#bien_form")[0]);
  var fecharegistro = $("#fecharegistro").val();
  formData.append("fecharegistro", fecharegistro);
  console.log(fecharegistro);
  var obj_id = $("#combo_obj_bien").val();
  formData.append("obj_id", obj_id);
  var modelo_id = $("#combo_modelo_obj").val(); // Corregido nombre de variable
  formData.append("modelo_id", modelo_id); // Corregido nombre de variable
  var bien_color = $("#combo_color_bien").val(); // Corregido nombre de variable
  formData.append("bien_color", bien_color); // Corregido nombre de variable
  var obj_dim = $("#obj_dim").val(); // Corregido nombre de variable
  formData.append("obj_dim", obj_dim); // Corregido nombre de variable
  formData.append("edit_obj_id", $("#obj_id").val());

  console.log(bien_color);
  $.ajax({
    url: "../../controller/objeto.php?op=guardaryeditarbien",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (data) {
      $("#bienes_data").DataTable().ajax.reload();
      $("#modalObjetoCate").modal("hide");

      Swal.fire({
        title: "Correcto!",
        text: "Se Registro Correctamente",
        icon: "success",
        confirmButtonText: "Aceptar",
      });
    },
    error: function (xhr, status, error) {
      // Manejar errores de AJAX
      console.error(xhr.responseText);
      alert("Error al guardar los datos");
    },
  });
}

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

  $("#combo_gg_bien_obj").change(function () {
    var gg_id = $(this).val();
    $("#combo_obj_bien").empty();
    if (gg_id !== "") {
      $.post(
        "../../controller/clase.php?op=combo",
        { gg_id: gg_id },
        function (data) {
          $("#combo_clase_bien_obj").html(data);
          $("#combo_obj_bien").val("");
          $("#combo_obj_bien").change();
        }
      );
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
    $("#combo_modelo_obj").empty();
    if (marca_id !== "") {
      $.post(
        "../../controller/objeto.php?op=combo_modelo",
        { marca_id: marca_id },
        function (data) {
          $("#combo_modelo_obj").html(data);
        }
      );
    }
  });
  $("#combo_clase_bien_obj").change(function () {
    var gc_id = $(this).val();
    $("#combo_obj_bien").empty();
    $("#codigo_barras_input").empty();
    $("#combo_obj_bien").empty();
    if (gc_id !== "") {
      $.post(
        "../../controller/objeto.php?op=combo_clase",
        { gc_id: gc_id },
        function (data) {
          $("#combo_obj_bien").html(data);
        }
      ).fail(function () {
        alert("Error al obtener las opciones de clase");
      });
    }
  });
  $("#combo_obj_bien").change(function () {
    var gc_id = $(this).val();
    $("#codigo_barras_input").empty();
    if (gc_id !== "") {
      var cod = $("#cod_interno").val();
      var codigo_cana = $("#combo_obj_bien option:selected").attr(
        "data-codigo-cana"
      );
      nuevo_cod = codigo_cana + "-" + cod;
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
function verGG(gg_id) {
  var gc_id = 0;
  $("#gg_id").val(gg_id);
  $("#combo_gg_tabla_obj").val("").trigger("change");
  $("#combo_clase_bien_obj_tabla").val("").trigger("change");
  $("#lbltituloDepe").html("Registros de la Dependencia: ");
  $("#modalobjgg").modal("show");
}
function nuevoBien() {
  $("#edit_block").hide();
  $("#combo_gg_bien_obj").val("");
  $("#combo_gg_bien_obj").change();
  $("#combo_color_bien").val("");
  $("#combo_color_bien").change();
  $("#combo_clase_bien_obj").empty();
  $("#combo_obj_bien").empty();
  $("#combo_marca_obj").val("");
  $("#obj_dim").val("");
  $("#combo_marca_obj").change();

  $("#obj_id").val("");

  $("#gg_text").html('Grupo Generico:  <span class="tx-danger">*</span>');
  $("#clase_text").html('Clase:  <span class="tx-danger">*</span>');
  $("#obj_text").html('Objeto: <span class="tx-danger">*</span>');

  $("#combo_gg_bien_obj").prop("disabled", false);
  $("#combo_clase_bien_obj").prop("disabled", false);
  $("#combo_obj_bien").prop("disabled", false);
  $("#combo_marca_obj").prop("disabled", false);
  $("#combo_modelo_obj").prop("disabled", false);
  // Cargar el combo de categorías

  $.post("../../controller/objeto.php?op=getcodinterno", function (data) {
    // Convierte el dato recibido a un número y le suma 1
    var cod = parseInt(data) + 1;

    // Formatea el código a una cadena de 4 dígitos, con ceros a la izquierda
    var formattedCod = cod.toString().padStart(4, "0");

    // Establece los valores de los campos de entrada
    $("#cod_interno").val(formattedCod);
    $("#codigo_barras_input").val(formattedCod);

    // Genera el código de barras con el código formateado
    generarCodigoBarras(formattedCod);
  }).fail(function () {
    // Maneja errores de la solicitud AJAX
    alert("Error al obtener el código interno");
  });

  $("#bien_id").val("");

  $("#bien_numserie").val("");
  $("#cod_interno").val("");
  $("#codigo_barras_input").val("");
  $("#fecharegistro").val("");

  $("#modalBackdrop").hide();
  $("#modalObjetoCate").modal("show");
}
function generarCodigoBarras(codigoBarras) {
  // Obtener el canvas y el contexto
  var canvas = document.getElementById("codigo_barras_canvas");
  var ctx = canvas.getContext("2d");

  // Limpiar el canvas
  ctx.clearRect(0, 0, canvas.width, canvas.height);

  // Generar el código de barras usando JsBarcode
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

function editarBien(bien_id) {
  $("#edit_block").show();
  var fecha = new Date();
  var opcionesFecha = {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
  };
  var fechaFormateada = fecha.toLocaleDateString("es-ES", opcionesFecha);

  $("#bien_id").val(bien_id);
  $("#modalBackdrop").hide();
  $("#modalObjetoCate").modal("show");
  $("#lbltituloObjcate").html("Editar Registro " + fechaFormateada);

  $.post(
    "../../controller/objeto.php?op=buscar_bien_id",
    { bien_id: bien_id },
    function (bienData) {
      bienData = JSON.parse(bienData);

      /*       $("#combo_gg_bien_obj").val(bienData.gg_id).trigger("change"); */
      $("#combo_marca_obj").val(bienData.marca_id).trigger("change");
      $("#combo_gg_bien_obj").prop("disabled", true);
      $("#combo_clase_bien_obj").prop("disabled", true);
      $("#combo_obj_bien").prop("disabled", true);
      $("#combo_marca_obj").prop("disabled", true);
      $("#combo_modelo_obj").prop("disabled", true);

      $("#obj_id").val(bienData.obj_id);

      //text
      $("#gg_text").html(
        "Grupo Generico: " +
          bienData.gg_nom +
          '<span class="tx-danger">*</span>'
      );
      $("#clase_text").html(
        "Clase: " + bienData.clase_nom + '<span class="tx-danger">*</span>'
      );
      $("#obj_text").html("Objeto: " + bienData.obj_nombre) +
        '<span class="tx-danger">*</span>';

      $.post(
        "../../controller/objeto.php?op=combo_modelo",
        { marca_id: bienData.marca_id },
        function (data) {
          $("#combo_modelo_obj").html(data);
          $("#combo_modelo_obj").val(bienData.modelo_id).change();
        }
      );

      var colorIndices = bienData.bien_color.replace(/[{}"]/g, "").split(",");
      $("#combo_color_bien").val(colorIndices).trigger("change");

      $("#bien_numserie").val(bienData.bien_numserie);
      $("#codigo_barras_input").val(bienData.bien_codbarras);
      $("#fecharegistro").val(bienData.fecharegistro);
      // Formatea el bien_id a una cadena de 4 dígitos, con ceros a la izquierda
      var formattedBienId = bienData.bien_id.toString().padStart(4, "0");

      // Establece el valor formateado en el campo de entrada
      $("#cod_interno").val(formattedBienId);
      $("#obj_dim").val(bienData.bien_dim);

      // Generar el código de barras usando JsBarcode
      var codigoBarras = bienData.bien_codbarras;
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
  );
}

function generarBarras() {
  obj_id = $("#combo_obj_bien").val();
  // Realizas la llamada AJAX para obtener los datos del servidor
  $.ajax({
    type: "POST",
    url: "../../controller/dependencia.php?op=generarBarras", // Ruta al archivo PHP que procesa la solicitud
    data: { obj_id: obj_id }, // Datos que envías al servidor (puedes ajustar según tus necesidades)
    dataType: "json", // Especifica el tipo de datos que esperas recibir del servidor
    success: function (response) {
      // Llenas el campo con los datos obtenidos
      $("#codigo_barras_input").val(response.codigo_cana);
    },
    error: function (xhr, status, error) {
      // Manejo de errores
      console.error(error);
    },
  });
}

function eliminarBien(bien_id) {
  swal
    .fire({
      title: "Eliminar!",
      text: "Desea Eliminar el Registro?",
      icon: "error",
      confirmButtonText: "Si",
      showCancelButton: true,
      cancelButtonText: "No",
    })
    .then((result) => {
      if (result.value) {
        $.post(
          "../../controller/objeto.php?op=eliminarBien",
          { bien_id: bien_id },
          function (data) {
            $("#bienes_data").DataTable().ajax.reload();

            Swal.fire({
              title: "Correcto!",
              text: "Se Elimino Correctamente",
              icon: "success",
              confirmButtonText: "Aceptar",
            });
          }
        );
      }
    });
}

function imprimirBien(bien_id) {
  redirect_by_post(
    "../../controller/stick.php?op=imprimir",
    { bien_id, bien_id },
    true
  );
}
function imprimirGrupo(depe_id) {
  redirect_by_post(
    "../../controller/stick.php?op=imprimirDependencia",
    { depe_id, depe_id },
    true
  );
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

initbienes();
