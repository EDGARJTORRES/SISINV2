$(function () {
  $.post("../../controller/bien.php?op=combo_detalle_bien", function (data) {
    $("#combo_vehiculo").html(data).select2({ width: '100%' });
  });
  $.post("../../controller/combustible.php?op=combo_detalle_combustible", function (data) {
    $("#comb_nombre").html(data).select2({ width: '100%' });
  });
  $("#combo_vehiculo").on("change", function () {
    const bien_id = $(this).val();
    if (bien_id) {
      mostrarDetalleBien(bien_id);
    } else {
      limpiarFormulario();
    }
  });
});

function mostrarDetalleBien(bien_id) {
  $.ajax({
    url: "../../controller/detallebien.php?op=mostrar_detalle_bien_id",
    type: "POST",
    data: { bien_id: bien_id },
    dataType: "json",
    success: function (data) {
      if (data && Object.keys(data).length) {
        $("#placa").val(data.placa || "");
        $("#ruta").val(data.ruta || "");
        $("#tipo_movilidad").val(data.tipo_movilidad || "");
        $("#categoria").val(data.categoria || "");
        $("#anio_fabricacion").val(data.anio_fabricacion || "");
        $("#peso_neto").val(data.peso_neto || "");
        $("#carga_util").val(data.carga_util || "");
        $("#peso_bruto").val(data.peso_bruto || "");
        $("#ruedas").val(data.ruedas || "");
        $("#cilindros").val(data.cilindros || "");
        $("#ejes").val(data.ejes || "");
        $("#nro_motor").val(data.nro_motor || "");
        $("#pasajeros").val(data.pasajeros || "");
        $("#asientos").val(data.asientos || "");
        $("#carroceria").val(data.carroceria || "");
        $("#comb_nombre").val(data.comb_id || "").trigger("change");
      } else {
        limpiarFormulario();
        Swal.fire({
          icon: 'warning',
          title: 'No se encontraron datos',
          text: 'No hay información disponible para el vehículo seleccionado.'
        });
      }
    },
    error: function (xhr) {
      console.error("Error al obtener el detalle del bien:", xhr.responseText || xhr.statusText);
    }
  });
}

function limpiarFormulario() {
  const $form = $("#detalleBienForm");
  if ($form.length) $form[0].reset();
  $("#comb_nombre").val(null).trigger("change");
}
function nullIfEmpty(value) {
  return value === "" ? null : value;
}

function actualizarDetalle() {
  let vacios = false;
  $("#detalleBienForm").find("input, select").each(function () {
    if (!$(this).val() || $(this).val().trim() === "") {
      vacios = true;
    }
  });

  if (vacios) {
    Swal.fire({
      title: "Campos incompletos",
      text: "Debe llenar todos los campos antes de continuar.",
      imageUrl: '../../static/gif/letra-x.gif',
      imageWidth: 100,
      imageHeight: 100,
      confirmButtonText: "Aceptar",
      confirmButtonColor: 'rgb(243, 18, 18)',
      backdrop: true,
      didOpen: () => {
        const swalBox = Swal.getPopup();
        const topBar = document.createElement('div');
        topBar.id = 'top-progress-bar';
        topBar.style.cssText = `
            position: absolute;
            top: 0;
            left: 0;
            height: 6px;
            width: 0%;
            background-color:rgb(243, 18, 18);
            transition: width 0.4s ease;
        `;
        swalBox.appendChild(topBar);
        setTimeout(() => {
          topBar.style.width = '100%';
        }, 300);
      }
    });
    return;
  }
  const formData = {
    bien_id: $("#combo_vehiculo").val(),
    placa: $("#placa").val(),
    ruta: $("#ruta").val(),
    tipo_movilidad: $("#tipo_movilidad").val(),
    categoria: $("#categoria").val(),
    anio_fabricacion: nullIfEmpty($("#anio_fabricacion").val()),
    peso_neto: nullIfEmpty($("#peso_neto").val()),
    carga_util: nullIfEmpty($("#carga_util").val()),
    peso_bruto: nullIfEmpty($("#peso_bruto").val()),
    ruedas: nullIfEmpty($("#ruedas").val()),
    cilindros: nullIfEmpty($("#cilindros").val()),
    ejes: nullIfEmpty($("#ejes").val()),
    nro_motor: $("#nro_motor").val(),
    pasajeros: nullIfEmpty($("#pasajeros").val()),
    asientos: nullIfEmpty($("#asientos").val()),
    carroceria: $("#carroceria").val(),
    comb_id: nullIfEmpty($("#comb_nombre").val())
  };

  $.ajax({
    url: "../../controller/detallebien.php?op=actualizar_detalle_bien",
    type: "POST",
    data: formData,
    success: function (resp) {
      if (resp.trim() === "ok") {
        Swal.fire({
          icon: 'success',
          title: '¡Actualizado!',
          text: 'El detalle del vehículo se actualizó correctamente.',
          timer: 2000,
          showConfirmButton: false
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Ocurrió un problema: ' + resp
        });
      }
    },
    error: function (xhr) {
      Swal.fire({
        icon: 'error',
        title: 'Error de servidor',
        text: xhr.responseText || xhr.statusText
      });
    }
  });
}
