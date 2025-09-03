$(document).on("submit", "#formCaracteristicas", function(e) {
    e.preventDefault();

    if ($("#combo_vehiculo").val() === null || $("#combo_vehiculo").val() === "") {
        Swal.fire({
            title: 'Atención',
            text: 'Debe seleccionar un vehículo antes de guardar los datos.',
            icon: 'warning',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
        });
        return false;
    }
    let campos = [
        "#nro_motor",
        "#ruedas",
        "#cilindros",
        "#cilindrada",
        "#potencia",
        "#form_rodaje"
    ];
    let incompleto = campos.some(function(selector) {
        return $(selector).val() === null || $(selector).val().trim() === "";
    });

    if (incompleto) {
        Swal.fire({
            title: 'Campos incompletos',
            text: 'Debe completar todos los campos antes de guardar.',
            icon: 'warning',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
        });
        return false;
    }

    let formData = new FormData(this);
    formData.append("bien_id", $("#combo_vehiculo").val());

    $.ajax({
        url: "../../controller/detallebien.php?op=editar_caracteristicas",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            Swal.fire({
                title: 'Correcto!',
                text: 'Datos de características actualizados correctamente',
                imageUrl: '../../static/gif/verified.gif',
                imageWidth: 100,
                imageHeight: 100,
                confirmButtonText: 'Aceptar',
                confirmButtonColor: 'rgb(18, 129, 18)',
                backdrop: true
            });
        }
    });
});

function mostrarCaracteristicas() {
    let bien_id = $("#combo_vehiculo").val();
    if (!bien_id) return;

    $.post("../../controller/detallebien.php?op=mostrar_caracteristicas", { bien_id: bien_id }, function(datos) {
        $("#nro_motor").val(datos.nro_motor || '');
        $("#ruedas").val(datos.ruedas || '');
        $("#cilindros").val(datos.cilindros || '');
        $("#cilindrada").val(datos.cilindrada || '');
        $("#potencia").val(datos.potencia || '');
        $("#form_rodaje").val(datos.form_rodaje || '');
        if (datos.ejes !== undefined && datos.ejes !== null) {
            $("input[name='ejes'][value='" + datos.ejes + "']").prop("checked", true);
        } else {
            $("input[name='ejes']").prop("checked", false);
        }

    }, "json");
}

