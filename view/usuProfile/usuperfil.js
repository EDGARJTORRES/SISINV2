var usu_id = $('#usu_idx').val();

$(document).ready(function () {
    $.post("../../controller/persona.php?op=obtener_datos_generales", function (data) {
        try {
            data = JSON.parse(data);
            const nombretitulo = `${data.pers_nombre || ''} ${data.pers_apelpat || ''}`;
            $("#nombre_usuario").text(nombretitulo.trim());
            const sexo = data.pers_sexo === 'M' ? 'MASCULINO' :
                         data.pers_sexo === 'F' ? 'FEMENINO' : 'NO ESPECIFICADO';
            const tipoRol = data.pers_grupo
                ? data.pers_grupo.charAt(0).toUpperCase() + data.pers_grupo.slice(1).toLowerCase()
                : 'No definido';
            const tipoRol2 = data.pers_grupo
                ? data.pers_grupo.charAt(0).toUpperCase() + data.pers_grupo.slice(1).toLowerCase()
                : 'No definido';
            const nombreCompleto = `${data.pers_nombre || ''} ${data.pers_apelpat || ''} ${data.pers_apelmat || ''}`;
            $("#nombre_usuario2").text(nombreCompleto.trim());
            $("#correo_usuario").text(data.pers_emailp || data.pers_emailm || 'No registrado');
            $("#correo_usuario2").text(data.pers_emailp || data.pers_emailm || 'No registrado');
            $("#telefono").text(data.pers_celu01 || data.pers_telefijo || 'No registrado');
            $("#tipo_rol").text(tipoRol);
            $("#tipoRol2").text(tipoRol2);
            $("#usu_sex").text(sexo);
            $("#dni").text(data.pers_dni || 'No registrado');
            if (data.pers_foto) {
                $('#foto_perfil_actual').attr('src', data.pers_foto);
                $('#foto_avatar').css('background-image', `url(${data.pers_foto})`);
            }
        } catch (e) {
            console.error("Error procesando datos de persona:", e, data);
        }
    });
});
