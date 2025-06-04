function limitarADigitosDNI(input) {
    let valor = input.value.toString().replace(/\D/g, '');
    if (valor.length > 8) {
        valor = valor.slice(0, 8);
        $("#pers_origen_nom").val('');
    } else if (valor.length == 8) {
        buscarDNIOrigen();
    } else if (valor.length < 8) {
        $("#pers_origen_nom").val('');
    }
    input.value = valor;
}

function limitarADigitosDNIdestino(input) {
    let valor = input.value.toString().replace(/\D/g, '');
    if (valor.length > 8) {
        valor = valor.slice(0, 8);
        $("#pers_destino_nom").val('');
    } else if (valor.length == 8) {
        buscarDNIDestino();
    } else if (valor.length < 8) {
        $("#pers_destino_nom").val('');
    }
    input.value = valor;
}
