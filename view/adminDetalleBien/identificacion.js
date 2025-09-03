$(document).on("submit", "#formIdentificacion", function(e) {
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
        "#ruta",
        "#vin",
        "#categoria",
        "#anio_fabricacion",
        "#carroceria",
        "#version"
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
        url: "../../controller/detallebien.php?op=editar_identificacion",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            Swal.fire({
                title: 'Correcto!',
                text: 'Datos de identificación actualizados correctamente',
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

function mostrarIdentificacion() {
    let bien_id = $("#combo_vehiculo").val();
    if (!bien_id) return;

    $.post("../../controller/detallebien.php?op=mostrar_identificacion", { bien_id: bien_id }, function(datos) {
        $("#ruta").val(datos.ruta || '');
        $("#vin").val(datos.vin || '');
        $("#categoria").val(datos.categoria || '');
        $("#anio_fabricacion").val(datos.anio_fabricacion || '');
        $("#carroceria").val(datos.carroceria || '');
        $("#version").val(datos.version || '');
        cargarTipoServicio(datos.tipo_servicio_id);


        // Cargar combustibles
        let seleccionados = [];
        if (datos.combustibles) {
            seleccionados = datos.combustibles
                .replace(/^{|}$/g, '')
                .replace(/"/g, '')
                .split(',')
                .map(s => s.trim());
        }

        $.post("../../controller/combustible.php?op=combo_detalle_combustible", {}, function(allCombustibles) {
            let html = '';
            allCombustibles.forEach(c => {
                let checked = seleccionados.includes(c.nombre) ? 'checked' : '';
                html += `
                    <label class="form-selectgroup-item flex-fill">
                        <input type="checkbox" name="combustibles[]" value="${c.id}" class="form-selectgroup-input" ${checked}>
                        <div class="form-selectgroup-label d-flex align-items-center p-3">
                            <div class="me-3">
                                <span class="form-selectgroup-check"></span>
                            </div>
                            <div class="form-selectgroup-label-content d-flex align-items-center">
                                <div>
                                    <div class="font-weight-medium">${c.nombre}</div>
                                </div>
                            </div>
                        </div>
                    </label>
                `;
            });
            $("#combustibles_container").html(html);
        }, "json");

    }, "json");
}


$("#btnCancelar").on("click", function () {
    $("input[name='combustibles[]']").each(function () {
        $(this).prop("checked", false);
    });
});
