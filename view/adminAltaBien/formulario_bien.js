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
    .off("keydown mousewheel"); // quita bloqueo si se activó antes

  $("#combo_gg_bien_obj").val("").trigger("change").prop("disabled", false);
  $("#combo_clase_bien_obj").empty().prop("disabled", false);
  $("#combo_obj_bien").empty().prop("disabled", false);
  $("#combo_marca_obj").val("").trigger("change").prop("disabled", false);
  $("#combo_modelo_obj").prop("disabled", false);
  $("#procedencia").val("").trigger("change").prop("disabled", false);
  $("#combo_color_bien").val("").trigger("change");

  $("#edit_block").hide();

  // Obtener el nuevo código
  $.post("../../controller/objeto.php?op=getcodinterno", function (data) {
    const cod = parseInt(data) + 1;
    const formattedCod = cod.toString().padStart(4, "0");
    $("#cod_interno").val(formattedCod);
    $("#codigo_barras_input").val(formattedCod);
    generarCodigoBarras(formattedCod);
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
        confirmButtonText: 'Sí, eliminarlo',
        backdrop: true,
        didOpen: () => {
            const swalBox = Swal.getPopup();
            const topBar = document.createElement('div');
            topBar.id = 'top-progress-bar';
            topBar.style.cssText = `
                position: absolute;
                top: 0;
                left: 0;
                height: 5px;
                width: 0%;
                background-color:rgb(243, 18, 18);
                transition: width 0.4s ease;
            `;
            swalBox.appendChild(topBar);

            setTimeout(() => {
                topBar.style.width = '40%';
            }, 300);
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
              url: '../../controller/objeto.php?op=eliminarBien',
              type: 'POST',
               data: { bien_id: bien_id },
                success: function (response) {
                   $("#bienes_data").DataTable().ajax.reload();
                    Swal.fire({
                        title: '¡Eliminado!',
                        html: `
                            <p>El Bien ha sido eliminado correctamente.</p>
                            <div id="top-progress-bar-final" style="
                                position: absolute;
                                top: 0;
                                left: 0;
                                height: 5px;
                                width: 0%;
                                background-color:rgb(243, 18, 18);
                                transition: width 0.6s ease;
                            "></div>
                        `,
                        imageUrl: '../../static/gif/verified.gif',
                        imageWidth: 100,
                        imageHeight: 100,
                        showConfirmButton: true,
                        confirmButtonColor: 'rgb(243, 18, 18)',
                        backdrop: true,
                        didOpen: () => {
                            const bar = document.getElementById('top-progress-bar-final');
                            setTimeout(() => {
                                bar.style.width = '100%';
                            }, 100);
                        }
                    });
                },
                error: function () {
                    Swal.fire('Error', 'No se pudo eliminar el usuario.', 'error');
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