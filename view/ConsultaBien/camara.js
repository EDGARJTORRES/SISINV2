document.addEventListener('DOMContentLoaded', function() {
      var input = document.getElementById('cod_bar');
      input.focus();
      });
      function limpiarDatos() {
          var respuesta = document.querySelector('.respuesta');
          respuesta.innerHTML = '';
      }

      function limitarADigitos(input) {
        let valor = input.value.toString();
          if (valor.length < 13) {
            limpiarDatos();
          }
          if (valor.length > 13) {
            valor = valor.slice(0, 8);
          }
          if (valor.length == 13) {
            limpiarDatos();
            buscarBien();
          }
          input.value = valor;
      }
  function activarCamara(){
      const video = document.getElementById('interactive');
      const codigoBarrasInput = document.getElementById('cod_bar');
      Quagga.init({
          inputStream: {
              name: 'Live',
              target: video,
              constraints: {
                  width: { min: 640 },
                  height: { min: 480 },
                  aspectRatio: { min: 1, max: 100 },
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
          console.log('QuaggaJS iniciado correctamente');
          Quagga.start();
      });
      Quagga.onDetected(function(result) {
          const code = result.codeResult.code;
          codigoBarrasInput.value = code;
      });
      }   
