document.addEventListener("DOMContentLoaded", function () {
  $("#cantidad_bienes").on("input", function () {
    const cantidad = parseInt($(this).val()) || 1;

    // Limpiar los campos anteriores (desde 2 en adelante)
    $("#contenedor_ident_tecnica .extra-campo").remove();
    $("#contenedor_caracteristicas .extra-campo").remove();
    $("#contenedor_adquisicion .extra-campo").remove();

    for (let i = 2; i <= cantidad; i++) {
      $("#contenedor_ident_tecnica").append(generarCamposIdentificacion(i));
      $("#contenedor_caracteristicas").append(generarCamposCaracteristicas(i));
      $("#contenedor_adquisicion").append(generarCamposAdquisicion(i));

      // Aplicar select2
      $(`#marca_${i}, #modelo_${i}, #color_${i}, #bien_cuenta_${i}`).select2({
        dropdownParent: $("#modalObjetoCate"),
        dropdownPosition: "below",
      });

      // Llenar combos dinámicos (marca, modelo, color)
      $.post("../../controller/marca.php?op=combo", function (data) {
        $(`#marca_${i}`).html(data);
        $(`#marca_${i}`).val($("#combo_marca_obj").val()).trigger("change");

        // Cargar modelos correspondientes a esa marca
        let marca_id = $("#combo_marca_obj").val();
        $.post("../../controller/objeto.php?op=combo_modelo", { marca_id }, function (modeloData) {
          $(`#modelo_${i}`).html(modeloData);
          $(`#modelo_${i}`).val($("#combo_modelo_obj").val()).trigger("change");
        });
      });

      $.post("../../controller/objeto.php?op=combo_color", function (data) {
        $(`#color_${i}`).html(data);
        $(`#color_${i}`).val($("#combo_color_bien").val()).trigger("change");
      });
      $.post("../../controller/cuenta.php?op=combo", function (data) {
        $(`#bien_cuenta_${i}`).html(data);
        $(`#bien_cuenta_${i}`).val($("#bien_cuenta").val()).trigger("change");
      });
    }
  });
});

function generarCamposIdentificacion(i) {
  return `
    <div class="col-12 extra-campo">
      <div class="d-flex justify-content-between align-items-center">
        <span class="fw-bold text-primary">BIEN PATRIMONIAL N°${i}</span>
        <button type="button" class="btn btn-6 btn-outline-primary" onclick="autocompletar(${i})">
          Autocompletar
        </button>
      </div>
    </div>
    <div class="col-lg-3 extra-campo">
      <label class="form-label">Marca <span class="text-danger">*</span></label>
      <select  data-placeholder="Seleccione la marca" class="form-select select2 required" name="marca_id_${i}" id="marca_${i}">
        <option></option>
      </select>
    </div>
    <div class="col-lg-3 extra-campo">
      <label class="form-label">Modelo <span class="text-danger">*</span></label>
      <select  data-placeholder="Seleccione el modelo" class="form-select select2 required" name="modelo_id_${i}" id="modelo_${i}">
        <option></option>
      </select>
    </div>
    <div class="col-lg-3 extra-campo">
      <label class="form-label">Dimensiones <span class="text-danger">*</span></label>
      <input type="text" placeholder="Ej: 40x30x20 cm" class="form-control required" name="obj_dim_${i}" />
    </div>
    <div class="col-lg-3 extra-campo">
      <label class="form-label">N° Serie <span class="text-danger">*</span></label>
      <input  placeholder="Ingrese el N° de serie" type="text" class="form-control required" name="bien_numserie_${i}" />
    </div>`;
}

function generarCamposCaracteristicas(i) {
  return `
    <div class="col-12 extra-campo">
      <div class="d-flex justify-content-between align-items-center">
        <span class="fw-bold text-primary">BIEN PATRIMONIAL N°${i}</span>
        <button type="button" class="btn btn-6 btn-outline-primary" onclick="autocompletar(${i})">
          Autocompletar
        </button>
      </div>
    </div>
    <div class="col-lg-3 extra-campo">
      <label class="form-label">Características <span class="text-danger">*</span></label>
      <textarea placeholder="Describa las características..." name="bien_obs_${i}" class="form-control" rows="1" style="resize: none;"></textarea>
    </div>
    <div class="col-lg-3 extra-campo">
      <label class="form-label">N° Cuenta Contable <span class="text-danger">*</span></label>
      <select  data-placeholder="Seleccione la cuenta contable" class="form-select select2 required" name="bien_cuenta_${i}" id="bien_cuenta_${i}">
        <option></option>
      </select>
    </div>
    <div class="col-lg-3 extra-campo">
      <label class="form-label">Color <span class="text-danger">*</span></label>
      <select  data-placeholder="Seleccione uno o más colores" class="form-select select2 required" name="bien_color_${i}" id="color_${i}" multiple></select>
    </div>
    <div class="col-lg-3 extra-campo">
      <label class="form-label">Procedencia <span class="text-danger">*</span></label>
      <select  data-placeholder="Seleccione la procedencia" class="form-select" name="procedencia_${i}">
        <option value="NACIONAL">Nacional</option>
        <option value="DONADO">Donado</option>
      </select>
    </div>`;
}

function generarCamposAdquisicion(i) {
  return `
    <div class="col-12 extra-campo">
      <div class="d-flex justify-content-between align-items-center">
        <span class="fw-bold text-primary">BIEN PATRIMONIAL N°${i}</span>
        <button type="button" class="btn btn-6 btn-outline-primary" onclick="autocompletar(${i})">
          Autocompletar
        </button>
      </div>
    </div>
    <div class="col-lg-4 extra-campo">
      <label class="form-label">Fecha de Adquisición <span class="text-danger">*</span></label>
      <input type="text" placeholder="Año/Mes/Dia" class="form-control required" name="fecharegistro_${i}" />
    </div>
    <div class="col-lg-4 extra-campo">
      <label class="form-label">Valor de Adquisición <span class="text-danger">*</span></label>
      <input type="text" placeholder="Ej: S/ 1,200.00" class="form-control required" name="val_adq_${i}" />
    </div>
    <div class="col-lg-4 extra-campo">
      <label class="form-label">N° Doc. Adquision <span class="text-danger">*</span></label>
      <input type="text" placeholder="Ej: NEA 2001, O/C 716" class="form-control required" name="doc_adq_${i}" />
    </div>`;
}

function autocompletar(i) {
  $(`#marca_${i}`).val($("#combo_marca_obj").val()).trigger("change");
  $(`#modelo_${i}`).val($("#combo_modelo_obj").val());
  $(`#cuenta_contable_${i}`).val($("#cuent_contable").val()).trigger("change");
  $(`input[name='obj_dim_${i}']`).val($("#obj_dim").val());
  $(`input[name='bien_numserie_${i}']`).val($("#bien_numserie").val());
  $(`textarea[name='bien_obs_${i}']`).val($("#bien_obs").val());
  $(`#color_${i}`).val($("#combo_color_bien").val()).trigger("change");
  $(`select[name='procedencia_${i}']`).val($("#procedencia").val());
  $(`input[name='fecharegistro_${i}']`).val($("#fecharegistro").val());
  $(`input[name='val_adq_${i}']`).val($("#val_adq").val());
  $(`input[name='doc_adq_${i}']`).val($("#doc_adq").val());
}