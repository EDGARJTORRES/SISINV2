var usu_id = $('#usu_idx').val();

$(document).ready(function(){
    $.post("../../controller/usuario.php?op=mostrar",{usu_id : usu_id}, function(data){
        data = JSON.parse(data);
        $('#usu_nom').val(data.usu_nom);
        $('#usu_apep').val(data.usu_apep);
        $('#usu_apem').val(data.usu_apem);
        $('#usu_corr').val(data.usu_corr);
        $('#usu_pass').val(data.usu_pass);
        $('#telefono').val(data.telefono);
        $('#usu_sex').val(data.usu_sex);
        $('#tipo_rol').val(data.tipo_rol);
    });
});
$(document).on("click","#btnactualizar",function(){
    $.post("../../controller/usuario.php?op=update_perfil", {
        usu_id : usu_id,
        usu_nom : $('#usu_nom').val(),
        usu_apep : $('#usu_apep').val(),
        usu_apem : $('#usu_apem').val(),
        usu_pass : $('#usu_pass').val(),
        usu_sex : $('#usu_sex').val(),
        telefono : $('#telefono').val()
    }, function(data){
    });
    Swal.fire({
        title: '¡Correcto!',
        text: 'Se actualizó correctamente',
        icon: 'success',
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#3085d6',
        showClass: {
          popup: `
            animate__animated
            animate__fadeInUp
            animate__faster
          `
        },
        hideClass: {
          popup: `
            animate__animated
            animate__fadeOutDown
            animate__faster
          `
        }
      });
      
    });
    
