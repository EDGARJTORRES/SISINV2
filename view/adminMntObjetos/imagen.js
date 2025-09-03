document.getElementById("obj_img").addEventListener("change", function (event) {
    const file = event.target.files[0];
    const previewImage = document.getElementById("previewImage");

    if (file) {
        if (file.size > 2 * 1024 * 1024) {
            alert("El archivo excede los 2MB permitidos.");
            event.target.value = ""; 
            previewImage.style.display = "none";
            return;
        }
        const validTypes = ["image/jpeg", "image/png", "image/gif"];
        if (!validTypes.includes(file.type)) {
            Swal.fire({
                title: 'Formato inválido',
                imageUrl: '../../static/gif/letra-x.gif',
                imageWidth: 100,
                imageHeight: 100,
                text: 'Solo se permiten archivos JPG y PNG.',
                confirmButtonColor: 'rgb(243, 18, 18)',
                confirmButtonText: 'Entendido'
            });
            event.target.value = ""; 
            previewImage.style.display = "none";
            return;
        }
        const reader = new FileReader();
        reader.onload = function (e) {
            previewImage.src = e.target.result;
            previewImage.style.display = "block";
        };
        reader.readAsDataURL(file);
    } else {
        previewImage.src = "";
        previewImage.style.display = "none";
    }
});
