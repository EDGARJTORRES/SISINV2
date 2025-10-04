
$(document).ready(function () {
    
});

function verTip(){
    document.getElementById("modaldata").style.display = "block";
    $('#modaldata').html(
        '<div class="alert alert-info" role="alert" style="margin-top:-20px;margin-bottom:-5px;">'+
            '<div class="d-flex">'+
                '<div>'+
                    '<svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon alert-icon icon-2"><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path><path d="M12 8v4"></path><path d="M12 16h.01"></path></svg>'+
                '</div>'+
                '<div>'+
                    '<h4 class="alert-title">Información</h4>'+
                    '<div class="text-secondary">Solicita al correo <b>gtie@munichiclayo.gob.pe</b> con el asunto: Reseteo de clave de correo Zimbra, en el contenido del correo indica tus apellidos y nombres, número de DNI, área donde labora actualmente, número de telefono celular y correo electrónico personal. Todos estos datos serán validados, y de ser confirmados se te atenderá en máximo 24 horas, de lo contrario se te indicará que no se pudo completar tu solicitud por haber brindado datos incorrectos.</div>'+
                '</div>'+
            '</div>'+
        '</div>');
}