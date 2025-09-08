$(document).on("submit", "#formIdentificacion", function(e) {
    e.preventDefault();
    const vehiculo = $("#combo_vehiculo").val();
    if (!vehiculo) {
        Swal.fire({
            title: 'Atención',
            text: 'Debe seleccionar un vehículo antes de guardar los datos.',
            icon: 'warning',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
        });
        return;
    }
    const campos = ["#ruta", "#vin", "#categoria", "#anio_fabricacion", "#version"];
    const incompleto = campos.some(sel => {
        const valor = $(sel).val();
        return !valor || valor.trim() === "";
    });
    if (incompleto) {
        Swal.fire({
            title: 'Campos incompletos',
            text: 'Debe completar todos los campos antes de guardar.',
            icon: 'warning',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
        });
        return;
    }
    const formData = new FormData(this);
    formData.append("bien_id", vehiculo);
    $.ajax({
        url: "../../controller/detallebien.php?op=editar_identificacion",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function () {
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
    const bien_id = $("#combo_vehiculo").val();
    if (!bien_id) return;
    $.post("../../controller/detallebien.php?op=mostrar_identificacion", { bien_id }, function(datos) {
        $("#ruta").val(datos.ruta || '');
        $("#vin").val(datos.vin || '');
        $("#anio_fabricacion").val(datos.anio_fabricacion || '');
        $("#version").val(datos.version || '');
        cargarClaseVehiculo(datos.clase_vehiculo_id);
        cargarTipoCarroceria(datos.tipo_carroceria_id, datos.categoria);
        const seleccionados = datos.combustibles
            ? datos.combustibles.replace(/[{}"]/g, '').split(',').map(s => s.trim()).filter(Boolean)
            : [];
        cargarCombustibles(seleccionados);

    }, "json");
}



$("#btnCancelar").on("click", function () {
    $("#formIdentificacion")[0].reset();
    mostrarIdentificacion();
});
