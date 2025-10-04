
function limitarADigitosDNI(input) {
        let valor = input.value.toString().replace(/\D/g, '');
        if (valor.length > 8) {
            valor = valor.slice(0, 8);
            $("#pers_nom").val('');
        } else if (valor.length == 8) {
            buscarDNI();
        } else if(valor.length < 8){
            $("#pers_nom").val('');
        }
        input.value = valor;
    }
    const video = document.getElementById('interactive');
        const codigoBarrasInput = document.getElementById('cod_bar');
        Quagga.init({
        inputStream: {
            name: 'Live',
            target: video,
            constraints: {
            width: {
                min: 640
            },
            height: {
                min: 480
            },
            aspectRatio: {
                min: 1,
                max: 100
            },
            facingMode: 'environment'
            }
        },
        decoder: {
            readers: ['code_128_reader']
        }
        }, function(err) {
        if (err) {
            console.error('Error al inicializar Quagga:', err);
            return;
        }
        Quagga.start();
        });
        Quagga.onDetected(function(result) {
        const code = result.codeResult.code;
        codigoBarrasInput.value = code;
});