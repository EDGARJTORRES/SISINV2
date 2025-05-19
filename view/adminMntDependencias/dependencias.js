function initdependencia() {
  $("#obj_depe_form").on("submit", function (e) {
    guardaryeditardependencia(e);
  });
}
function guardaryeditardependencia(e) {
  e.preventDefault();

  var formData = new FormData($("#obj_depe_form")[0]);
  var depe_id = $("#depe_id").val();
  formData.append("depe_id", depe_id);
  var obj_id = $("#combo_obj_depe").val();
  formData.append("obj_id", obj_id);
  var marca_id = $("#combo_marca_obj").val();
  formData.append("marca_id", marca_id);
  var fecharegistro = $("#fecharegistro").val();
  formData.append("fecharegistro", fecharegistro);
  $.ajax({
    url: "../../controller/dependencia.php?op=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (data) {
      $("#obj_depedata").DataTable().ajax.reload();
      $("#modalObjetoCate").modal("hide");

      Swal.fire({
        title: "Correcto!",
        text: "Se Registro Correctamente",
        icon: "success",
        confirmButtonText: "Aceptar",
      });
    },
  });
}
$(document).ready(function () {

  $("#fecharegistro").mask("9999/99/99");
  $('#showPaletteOnly').spectrum({
    showPaletteOnly: true,
    showPalette:true,
    color: '#DC3545',
    palette: [
        ['#1D2939', '#fff', '#0866C6','#23BF08', '#F49917'],
        ['#DC3545', '#17A2B8', '#6610F2', '#fa1e81', '#72e7a6']
    ]
});



  $(".select2").select2();
  $("#combo_gg_depe_obj").select2({
    dropdownParent: $("#modalObjetoCate"),
    dropdownPosition: "below",
  });
  $("#combo_clase_depe_obj").select2({
    dropdownParent: $("#modalObjetoCate"),
    dropdownPosition: "below",
  });
  $("#combo_obj_depe").select2({
    dropdownParent: $("#modalObjetoCate"),
    dropdownPosition: "below",
  });
  $("#combo_gg_tabla_obj").select2({
    dropdownParent: $("#modalDependencias"),
    dropdownPosition: "below",
  });
  $("#combo_clase_depe_obj_tabla").select2({
    dropdownParent: $("#modalDependencias"),
    dropdownPosition: "below",
  });
  $("#combo_marca_obj").select2({
    dropdownParent: $("#modalObjetoCate"),
    dropdownPosition: "below",
  });
  $("#combo_cate_depe").select2({
    dropdownParent: $("#modalDependencias"),
    dropdownPosition: "below",
  });
  $("#combo_cate_depe").change(function () {
    if (cate_id !== "") {
      loadDataDependencias($("#depe_id").val());
    }
  });

  $("#combo_gg_depe_obj").change(function () {
    var gg_id = $(this).val(); // Obtener el valor seleccionado de la categoría
    if (gg_id !== "") {
      // Realizar una solicitud AJAX para obtener el combo de objetos asociados a esa categoría
      $.post("../../controller/clase.php?op=combo",{ gg_id: gg_id }, function (data) {
        $("#combo_clase_depe_obj").html(data);
      });
    }
  });
  $("#combo_clase_depe_obj").change(function () {
    var gc_id = $(this).val(); // Obtener el valor seleccionado de la categoría
    if (gc_id !== "") {
      // Realizar una solicitud AJAX para obtener el combo de objetos asociados a esa categoría
      $.post(
        "../../controller/objeto.php?op=combo_clase",
        { gc_id: gc_id },
        function (data) {
          $("#combo_obj_depe").html(data);
        }
      );
    }
  });

 
});
function verDependencia(dep_id) {
  var gc_id = 0;
  $("#depe_id").val(dep_id);
  $("#combo_gg_tabla_obj").val("").trigger("change");
  $("#combo_clase_depe_obj_tabla").val("").trigger("change");
  $("#lbltituloDepe").html("Registros de la Dependencia: ");
  $("#modalDependencias").modal("show");

  loadDataDependencias($("#depe_id").val(),gc_id);
  $.post("../../controller/grupogenerico.php?op=combo", function (data) {
    $("#combo_gg_tabla_obj").html(data);
  });
  $("#combo_gg_tabla_obj").change(function () {
    var gg_id = $(this).val(); // Obtener el valor seleccionado de la categoría
    if (gg_id !== "") {
      // Realizar una solicitud AJAX para obtener el combo de objetos asociados a esa categoría
      $.post("../../controller/clase.php?op=combo",{ gg_id: gg_id }, function (data) {
        $("#combo_clase_depe_obj_tabla").html(data);
      });
    }
  });
  $("#combo_clase_depe_obj_tabla").change(function () {
    gc_id = $("#combo_clase_depe_obj_tabla").val();
    if(gc_id !== 0 && $("#combo_gg_tabla_obj").val() != '' ){
      loadDataDependencias($("#depe_id").val(),gc_id);
    }
   
    console.log(gc_id);
  });
}
function nuevoRegistroObjetoCate() {
   // Cargar el combo de categorías
   $.post("../../controller/grupogenerico.php?op=combo", function (data) {
    $("#combo_gg_depe_obj").html(data);
  });

  $.post("../../controller/marca.php?op=combo", function (data) {
    $("#combo_marca_obj").html(data);
  });
  $("#objdepe_id").val("");
  $("#combo_gg_depe_obj").val("").trigger("change");
  $("#combo_clase_depe_obj").val("").trigger("change");
  $("#combo_obj_depe").val("").trigger("change");
  $("#combo_marca_obj").val("").trigger("change");
  $("#objdepe_numserie").val("");
  $("#cod_interno").val("");
  $("#codigo_barras_input").val("");
  $("#fecharegistro").val("");

  $("#modalBackdrop").hide();
  $("#modalObjetoCate").modal("show");
}
function loadDataDependencias(depe_id, gc_id) {
  console.log(depe_id , gc_id);
  $("#obj_depedata").DataTable({
    aProcessing: true,
    aServerSide: true,
    dom: "Bfrtip",
    searching: true,
    buttons: [],
    ajax: {
      url: "../../controller/dependencia.php?op=listarObjetos",
      type: "post",
      data: { depe_id: depe_id, gc_id:gc_id},
    },
    bDestroy: true,
    responsive: false,
    bInfo: false,
    iDisplayLength: 5,
    order: [[0, "desc"]],
    ordering: true,
    language: {
      sProcessing: "Procesando...",
      sLengthMenu: "Mostrar _MENU_ registros",
      sZeroRecords: "No se encontraron resultados",
      sEmptyTable: "Ningún dato disponible en esta tabla",
      sInfo:
        "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
      sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
      sInfoPostFix: "",
      sSearch: "Buscar:",
      sUrl: "",
      sInfoThousands: ",",
      sLoadingRecords: "Cargando...",
      oPaginate: {
        sFirst: "Primero",
        sLast: "Último",
        sNext: "Siguiente",
        sPrevious: "Anterior",
      },
      oAria: {
        sSortAscending:
          ": Activar para ordenar la columna de manera ascendente",
        sSortDescending:
          ": Activar para ordenar la columna de manera descendente",
      },
    },
  });
}

function editarObjDepe(objdepe_id) {
  var fecha = new Date();
  var opcionesFecha = {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
  };
  var fechaFormateada = fecha.toLocaleDateString("es-ES", opcionesFecha);
  $("#objdepe_id").val(objdepe_id);
  $("#modalBackdrop").hide();
  $("#modalObjetoCate").modal("show");
  $("#lbltituloObjcate").html("Editar Registro " + fechaFormateada);

  $.post("../../controller/marca.php?op=combo", function (data) {
    $("#combo_marca_obj").html(data);
  });


  $.post(
    "../../controller/dependencia.php?op=mostrarObjCate",
    { objdepe_id: objdepe_id },
    function (data) {
      data = JSON.parse(data);
      console.log(data);
      // Actualizar los valores de los campos con los datos obtenidos
      $("#combo_cate_depe_obj").val(data.cate_id).trigger("change");
      var cate_id = $("#combo_cate_depe_obj").val();
      $.post(
        "../../controller/objeto.php?op=combo_cate",
        { cate_id: cate_id },
        function (datacombo) {
          $("#combo_obj_depe").html(datacombo);
          $("#combo_obj_depe").val(data.obj_id).trigger("change");
        }
      );
      
      $("#combo_marca_obj").val(data.marca_id).trigger("change");
      $("#objdepe_numserie").val(data.objdepe_numserie);
      $("#codigo_barras_input").val(data.objdepe_codbarras);
      $("#fecharegistro").val(data.fecharegistro);

      // Obtener el nuevo valor del input de código de barras
      var codigoBarras = $("#codigo_barras_input").val();

      // Limpiar el canvas
      var canvas = document.getElementById("codigo_barras_canvas");
      var ctx = canvas.getContext("2d");
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
  );
}
function generarBarras() {
  obj_id=$('#combo_obj_depe').val();
  // Realizas la llamada AJAX para obtener los datos del servidor
  $.ajax({
      type: "POST",
      url: "../../controller/dependencia.php?op=generarBarras", // Ruta al archivo PHP que procesa la solicitud
      data: { obj_id: obj_id }, // Datos que envías al servidor (puedes ajustar según tus necesidades)
      dataType: "json", // Especifica el tipo de datos que esperas recibir del servidor
      success: function(response) {
          // Llenas el campo con los datos obtenidos
          $("#codigo_barras_input").val(response.codigo_cana);
      },
      error: function(xhr, status, error) {
          // Manejo de errores
          console.error(error);
      }
  });
}

function eliminarObjetoDepe(objdepe_id) {
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
          "../../controller/dependencia.php?op=eliminar",
          { objdepe_id: objdepe_id },
          function (data) {
            $("#categoria_data").DataTable().ajax.reload();

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

function ImprimirObjDepe(objdepe_id) {
  redirect_by_post(
    "../../controller/stick.php?op=imprimir",
    { objdepe_id, objdepe_id },
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

initdependencia();
