var usu_id = $('#usu_idx').val();

$(document).ready(function () {
    $.post("../../controller/persona.php?op=obtener_datos_generales", function (data) {
       data = JSON.parse(data);
        const nombretitulo = `${data.pers_nombre} ${data.pers_apelpat}`;
        $("#nombre_usuario").text(nombretitulo);
        // Asignar datos al encabezado
        const nombreCompleto = `${data.pers_nombre} ${data.pers_apelpat} ${data.pers_apelmat}`;
        $("#nombre_usuario2").text(nombreCompleto);
        $("#correo_usuario").text(data.pers_emailp || data.pers_emailm);
        $("#correo_usuario2").text(data.pers_emailp || data.pers_emailm);

        // Asignar datos a los inputs
        $("#usu_nom").val(data.pers_nombre);
        $("#usu_apep").val(data.pers_apelpat);
        $("#usu_apem").val(data.pers_apelmat);
        $("#usu_corr").val(data.pers_emailp || data.pers_emailm);
        $("#usu_pass").val(data.pers_clave);
        $("#telefono").val(data.pers_celu01 || data.pers_telefijo);
        $("#tipo_rol").val(data.pers_grupo);
        $("#usu_sex").val(data.pers_sexo);
        if (data.pers_foto) {
            $('#foto_perfil_actual').attr('src', data.pers_foto);
        }
    });
});
