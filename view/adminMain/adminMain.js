var usu_id = $("#usu_idx").val();
$(document).ready(function(){
  $.post("../../controller/bien.php?op=ultimo", function(data){
    data = JSON.parse(data); 
    if (data) {
        $('#lblultimo').html(data.obj_nombre);
    } else {
        $('#lblultimo').html("No se encontró el último equipo.");
    }
  });
  $.post("../../controller/bien.php?op=total_adquision", function(data) {
      data = JSON.parse(data);
      if (data.length > 0 && data[0].total_valor_adquisicion !== null) {
          $('#lbltotal_adq').html(data[0].total_valor_adquisicion);
      } else {
          $('#lbltotal_adq').html("No se encontró el total.");
      }
  });
  $.post("../../controller/bien.php?op=total_bienes", function(data) {
      data = JSON.parse(data);
      if (data.length > 0 && data[0].total_bienes !== null) {
          $('#lbltotabien').html(data[0].total_bienes);
      } else {
          $('#lbltotabien').html("No se encontró el total.");
      }
  });
  $.post("../../controller/dependencia.php?op=obtener_ultimo_bien_baja", function(data) {
      data = JSON.parse(data); 
      if (data) {
          $('#lblultimabaja').html(data.obj_nombre);
      } else {
          $('#lblultimabaja').html("No se encontró el último equipo dado de baja.");
      }
  });

 $.post("../../controller/bien.php?op=contador_bien_estado", function(data) {
    data = JSON.parse(data);

    const mapaEstados = {
        'A': 'Activo',
        'N': 'Nuevo',
        'M': 'Malo',
        'R': 'Regular',
        'B': 'Bueno',
        'I': 'Inactivo'
    };

    let categorias = [];
    let valores = [];

    data.forEach(function(item) {
        const nombreEstado = mapaEstados[item.estado] || item.estado;
        categorias.push(nombreEstado);
        valores.push(parseInt(item.cantidad));
    });

    Highcharts.chart('grafico_estados_bienes', {
        chart: {
            type: 'line'  // <<< CAMBIO: tipo lineal
        },
        title: {
            text: 'Cantidad de Bienes por Estado'
        },
        xAxis: {
            categories: categorias,
            title: {
                text: 'Estado'
            }
        },
        yAxis: {
            title: {
                text: 'Cantidad'
            },
            allowDecimals: false
        },
        tooltip: {
            pointFormat: '<b>{point.y}</b> bienes'
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: true
            }
        },
        series: [{
            name: 'Bienes',
            data: valores,
            color: '#00695C'
        }]
    });
});

  function cargarGrafico() {
  fetch('../../controller/dependencia.php?op=contador_bienes_por_dependencia')
    .then(response => response.json())
    .then(data => {
      const categorias = data.map(item => item.depe_denominacion);
      const cantidades = data.map(item => parseInt(item.cantidad));

      Highcharts.chart('grafico_objetos_dependencia', {
        chart: {
          type: 'bar'
        },
        title: {
          text: null,
        },
        xAxis: {
          categories: categorias,
          title: {
            text: 'Dependencias'
          }
        },
        yAxis: {
          min: 0,
          title: {
            text: 'Cantidad de Objetos',
            align: 'high'
          },
          labels: {
            overflow: 'justify'
          }
        },
        plotOptions: {
          bar: {
            dataLabels: {
              enabled: true
            }
          }
        },
        series: [{
          name: 'Objetos',
          data: cantidades
        }],
        credits: {
          enabled: false
        }
      });
    })
    .catch(error => console.error('Error al cargar datos:', error));
    }
    cargarGrafico();


});