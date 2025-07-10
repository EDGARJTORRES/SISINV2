function nuevoBien() {
  modoEdicion = false;
  $("#bien_form")[0].reset();
  $("#cod_interno").closest(".form-group").show();
  $("#cod_interno").prop("readonly", true);
  $("#contenedor_ident_tecnica .extra-campo").remove();
  $("#contenedor_caracteristicas .extra-campo").remove();
  $("#contenedor_adquisicion .extra-campo").remove();
  $("#cantidad_bienes")
    .val(1)
    .prop("readonly", false)
    .removeAttr("disabled") 
    .off("keydown mousewheel");
  $("#combo_marca_obj").val("").trigger("change").prop("disabled", false);
  $("#combo_modelo_obj").prop("disabled", false);
  $("#procedencia").val("").trigger("change").prop("disabled", false);
  $("#combo_color_bien").val("").trigger("change");
  $("#edit_block").hide();
  $.post("../../controller/objeto.php?op=getcodinterno", function (data) {
    const cod = parseInt(data) + 1;
    const formattedCod = cod.toString().padStart(4, "0");
    $("#cod_interno").val(formattedCod);
    $("#codigo_barras_input").val(formattedCod);
    generarCodigoBarras(formattedCod);
  });
  $.post("../../controller/objeto.php?op=combo_objetos_todos", function (objetos) {
    $("#combo_obj_bien").html(objetos);
  });

  $("#bien_id").val("");
  $("#modalObjetoCate").modal("show");
}
function editarBien(bien_id) {
  modoEdicion = true;
  $("#modalObjetoCate").modal("show");
  $("#contenedor_ident_tecnica .extra-campo").remove();
  $("#contenedor_caracteristicas .extra-campo").remove();
  $("#contenedor_adquisicion .extra-campo").remove();
  $("#cod_interno").prop("readonly", true);

  $("#cantidad_bienes")
    .val(1)
    .prop("readonly", false)
    .attr("disabled", true);

  $.post("../../controller/objeto.php?op=mostrar_bien_id", { bien_id }, function (data) {
    let bienData;
    try {
      bienData = (typeof data === "string") ? JSON.parse(data) : data;
    } catch (e) {
      Swal.fire("Error", "Respuesta inválida del servidor.", "error");
      return;
    }

    if (!bienData || !bienData.bien_id) {
      Swal.fire("Error", "No se encontró el bien.", "error");
      return;
    }

    // Rellenar formulario
    $("#bien_id").val(bienData.bien_id);
    $("#obj_id").val(bienData.obj_id);
    $("#fecharegistro").val(bienData.fecharegistro);
    $("#modelo_id").val(bienData.modelo_id);
    $("#codigo_barras_input").val(bienData.bien_codbarras);
    $("#bien_numserie").val(bienData.bien_numserie);
    $("#obj_dim").val(bienData.bien_dim);
    $("#val_adq").val(bienData.val_adq);
    $("#doc_adq").val(bienData.doc_adq);
    $("#bien_obs").val(bienData.bien_obs);
    $("#procedencia").val(bienData.procedencia).trigger("change");
    $("#bien_cuenta").val(bienData.bien_cuenta);
    generarCodigoBarras(bienData.bien_codbarras);

    const colorArray = bienData.bien_color ? bienData.bien_color.replace(/[{}"]/g, "").split(",") : [];
    $("#combo_color_bien").val(colorArray).trigger("change");

    // Carga de combos anidados
    $("#combo_gg_bien_obj").val(bienData.gg_id).trigger("change");
    $.post("../../controller/clase.php?op=combo", { gg_id: bienData.gg_id }, function (clases) {
      $("#combo_clase_bien_obj").html(clases);
      $("#combo_clase_bien_obj").val(bienData.gc_id).trigger("change");

      $.post("../../controller/objeto.php?op=combo_clase", { gc_id: bienData.gc_id }, function (objetos) {
        $("#combo_obj_bien").html(objetos);
        $("#combo_obj_bien").val(bienData.obj_id).trigger("change");
      });
    });

    $("#combo_marca_obj").val(bienData.marca_id).trigger("change");
    $.post("../../controller/objeto.php?op=combo_modelo", { marca_id: bienData.marca_id }, function (modelos) {
      $("#combo_modelo_obj").html(modelos);
      $("#combo_modelo_obj").val(bienData.modelo_id).trigger("change");
    });
  });
}
function eliminarBien(bien_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡Esta acción no se puede deshacer!",
        imageUrl: '../../static/gif/advertencia.gif',
        imageWidth: 100,
        imageHeight: 100,
        showCancelButton: true,
        confirmButtonColor: 'rgb(243, 18, 18)',
        cancelButtonColor: '#000',
        confirmButtonText: 'Sí, eliminarlo'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '../../controller/objeto.php?op=eliminarBien',
                type: 'POST',
                data: { bien_id: bien_id },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        $("#bienes_data").DataTable().ajax.reload();
                        Swal.fire({
                            title: '¡Eliminado!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonColor: 'rgb(243, 18, 18)'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'No se puede eliminar',
                            text: response.message || 'Este bien tiene historial o dependencias asignadas.',
                            confirmButtonColor: '#d33'
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Respuesta inválida del servidor.'
                    });
                }
            });
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