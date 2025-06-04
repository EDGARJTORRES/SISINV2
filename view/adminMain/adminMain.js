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

      let seriesData = [];

      data.forEach(function(item) {
          const nombreEstado = mapaEstados[item.estado] || item.estado;
          seriesData.push({
              name: nombreEstado,
              y: parseInt(item.cantidad)
          });
      });

      // Generar colores monocromáticos a partir de un solo color base
      const baseColor = '#00695C';  
      const colors = [];

      for (let i = 0; i < seriesData.length; i++) {
          // El primer valor es el más oscuro, los siguientes más claros
          colors.push(Highcharts.color(baseColor).brighten(i * 0.1 - 0.2).get());
      }

      // Asignar colores generados a los datos
      for (let i = 0; i < seriesData.length; i++) {
          seriesData[i].color = colors[i];
      }

      Highcharts.chart('grafico_estados_bienes', {
          chart: {
              type: 'pie',
              options3d: {
                  enabled: true,
                  alpha: 45,
                  beta: 0
              }
          },
          title: {
              text: null,
          },
          tooltip: {
              pointFormat: '{series.name}: <b>{point.y}</b>'
          },
          plotOptions: {
              pie: {
                  allowPointSelect: true,
                  cursor: 'pointer',
                  depth: 35,
                  dataLabels: {
                      enabled: true,
                      format: '{point.name}: {point.y}'
                  }
              }
          },
          series: [{
              name: 'Bienes',
              data: seriesData
          }]
      });
  });
  function cargarGrafico() {
  fetch('../../controller/dependencia.php?op=contador_objetos_por_dependencia')
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