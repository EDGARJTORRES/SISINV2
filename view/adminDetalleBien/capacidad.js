$(document).on("submit", "#formCapacidades", function(e) {
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
    let formData = new FormData(this);
    formData.append("bien_id", $("#combo_vehiculo").val());

    $.ajax({
        url: "../../controller/detallebien.php?op=editar_capacidades",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            Swal.fire({
                title: 'Correcto!',
                text: 'Datos de capacidades actualizados correctamente',
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

function mostrarCapacidades() {
    let bien_id = $("#combo_vehiculo").val();
    if (!bien_id) return;
    $.post("../../controller/detallebien.php?op=mostrar_capacidades", { bien_id: bien_id }, function(datos) {
        $("#pasajero").val(datos.pasajero || '');
        $("#asiento").val(datos.asiento || '');
        $("#peso_neto").val(datos.peso_neto || '');
        $("#carga_util").val(datos.carga_util || '');
        $("#peso_bruto").val(datos.peso_bruto || '');
    }, "json");
}
