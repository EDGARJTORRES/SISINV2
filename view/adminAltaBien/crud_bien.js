function guardaryeditarbienes(e) {
  e.preventDefault();
  mostrarLoader();

  const bien_id = $("#bien_id").val();
  const esNuevo = !bien_id;

  if (esNuevo) {
    let cantidad = parseInt($("#cantidad_bienes").val()) || 1;

    $.post("../../controller/objeto.php?op=getcodinterno", function (data) {
      let cod_inicial = parseInt(data) + 1;
      let codigo_obj = $("#combo_obj_bien option:selected").attr("data-codigo-cana") || "";
      let registros = [];

      for (let i = 1; i <= cantidad; i++) {
        let formData = new FormData();

        let cod_generado = (cod_inicial + (i - 1)).toString().padStart(4, "0");
        let cod_barra = `${codigo_obj}-${cod_generado}`;

        // Códigos
        formData.append("cod_interno", cod_generado);
        formData.append("codigo_barras_input", cod_barra);

        // Generales
        formData.append("obj_id", $("#combo_obj_bien").val());
        formData.append("gc_id", $("#combo_clase_bien_obj").val());
        formData.append("gg_id", $("#combo_gg_bien_obj").val());

        if (i === 1) {
          // Bien N°1 - campos sin sufijo
          formData.append("marca_id", $("#combo_marca_obj").val());
          formData.append("modelo_id", $("#combo_modelo_obj").val());
          formData.append("obj_dim", $("#obj_dim").val());
          formData.append("bien_numserie", $("#bien_numserie").val());
          formData.append("bien_obs", $("#bien_obs").val());
          formData.append("bien_color", $("#combo_color_bien").val());
          formData.append("procedencia", $("#procedencia").val());
          formData.append("fecharegistro", $("#fecharegistro").val());
          formData.append("val_adq", $("#val_adq").val());
          formData.append("doc_adq", $("#doc_adq").val());
        } else {
          // Bienes N°2 en adelante - campos dinámicos con sufijo
          formData.append("marca_id", $(`#marca_${i}`).val());
          formData.append("modelo_id", $(`#modelo_${i}`).val());
          formData.append("obj_dim", $(`input[name='obj_dim_${i}']`).val());
          formData.append("bien_numserie", $(`input[name='bien_numserie_${i}']`).val());
          formData.append("bien_obs", $(`textarea[name='bien_obs_${i}']`).val());
          formData.append("bien_color", $(`#color_${i}`).val());
          formData.append("procedencia", $(`select[name='procedencia_${i}']`).val());
          formData.append("fecharegistro", $(`input[name='fecharegistro_${i}']`).val());
          formData.append("val_adq", $(`input[name='val_adq_${i}']`).val());
          formData.append("doc_adq", $(`input[name='doc_adq_${i}']`).val());
        }

        registros.push(formData);
      }

      enviarRegistros(registros, cantidad);
    });
  } else {
    let formData = new FormData($("#bien_form")[0]);

    formData.set("bien_id", bien_id);
    formData.set("codigo_barras_input", $("#codigo_barras_input").val());
    formData.set("cod_interno", $("#cod_interno").val());

    formData.set("modelo_id", $("#combo_modelo_obj").val());
    formData.set("marca_id", $("#combo_marca_obj").val());
    formData.set("obj_id", $("#combo_obj_bien").val());
    formData.set("gc_id", $("#combo_clase_bien_obj").val());
    formData.set("gg_id", $("#combo_gg_bien_obj").val());
    formData.set("bien_color", $("#combo_color_bien").val());
    formData.set("procedencia", $("#procedencia").val());
    formData.set("bien_numserie", $("#bien_numserie").val());
    formData.set("obj_dim", $("#obj_dim").val());
    formData.set("val_adq", $("#val_adq").val());
    formData.set("doc_adq", $("#doc_adq").val());
    formData.set("fecharegistro", $("#fecharegistro").val());
    formData.set("bien_obs", $("#bien_obs").val());
    formData.set("cantidad_bienes", "1"); // fijo en edición

    let registros = [formData];
    enviarRegistros(registros, 1);
  }
}
function enviarRegistros(registros, cantidad) {
  let promesas = registros.map((formData) =>
    $.ajax({
      url: "../../controller/objeto.php?op=guardaryeditarbien",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
    })
  );

  Promise.all(promesas)
    .then(() => {
      $("#bienes_data").DataTable().ajax.reload();
      $("#modalObjetoCate").modal("hide");

      Swal.fire({
        title: "¡Correcto!",
        text: cantidad === 1 ? "Se actualizó correctamente." : `Se registraron ${cantidad} bienes correctamente.`,
        imageUrl: "../../static/gif/verified.gif",
        imageWidth: 100,
        imageHeight: 100,
        confirmButtonColor: "rgb(18, 129, 18)",
        confirmButtonText: "Aceptar",
        backdrop: true,
      });

      ocultarLoader();
    })
    .catch((error) => {
      console.error("Error en operación:", error);
      alert("Error al procesar los bienes.");
      ocultarLoader();
    });
}