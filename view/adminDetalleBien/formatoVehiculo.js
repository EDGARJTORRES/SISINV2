function generarFormato() {
    const selectedOption = $("#combo_vehiculo").find("option:selected");
    const bien_id = selectedOption.val();

    if (!bien_id) {
         Swal.fire({
            title: "Atención",
            text: "Debe seleccionar un vehículo antes de continuar.",
            imageUrl: '../../static/gif/advertencia.gif',
            imageWidth: 100,
            imageHeight: 100,
            confirmButtonText: "Entendido",
            confirmButtonColor: "rgb(243, 18, 18)",
            timer: 3000,
            timerProgressBar: true,
            didOpen: () => {
                const bar = Swal.getPopup().querySelector('.swal2-timer-progress-bar');
                if (bar) {
                    bar.style.transform = "rotate(0deg)";
                }
            }
        });
        return;
    }

    // Redirigir a la ruta con el bien_id
    window.location.href = `http://localhost/sisPatrimonio/view/adminDetalleBien/vistaDetalleBien.php?bien_id=${bien_id}`;
}
