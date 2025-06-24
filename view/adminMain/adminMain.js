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
        'N': 'NUEVO',
        'M': 'MALO',
        'R': 'REGULAR',
        'B': 'BUENO'
    };

    let total = 0;
    let htmlDetalle = '<div class="detalle-hover"><ul class="mb-0 ps-3" STYLE="list-style-type: none;">';

    data.forEach(function(item) {
        const nombreEstado = mapaEstados[item.estado] || item.estado;
        const cantidad = parseInt(item.cantidad);
        total += cantidad;
        htmlDetalle += `<li>${nombreEstado}: ${cantidad}</li>`;
    });

    htmlDetalle += '</ul></div>';

    $('#lbltotabien').html(`
        <div class="resumen-total-hover">
            <span style="font-size: 24px; font-weight: bold;">${total}</span>
            ${htmlDetalle}
        </div>
    `);
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
            text: 'Cantidad de Bienes por Estado',
            align: 'center',
            style: {
              fontSize: '16px',
              fontWeight: 'bold'
            }
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
  $.get("../../controller/bien.php?op=grafico_valor_bienes", function (data) {
  const valores = JSON.parse(data);
  const adquisicion = parseFloat(valores.total_adquisicion || 0);
  const baja = parseFloat(valores.total_baja || 0);

  Highcharts.chart('grafico_valor_bienes', {
    chart: {
      type: 'pie',
      height: 320
    },
    title: {
      text: 'Valor Total de Bienes Adquiridos vs Dados de Baja',
      align: 'center',
      style: {
        fontSize: '16px',
        fontWeight: 'bold'
      }
    },
    tooltip: {
      pointFormat: '<b>S/ {point.y:,.2f}</b> ({point.percentage:.1f}%)'
    },
    accessibility: {
      point: {
        valueSuffix: '%'
      }
    },
    plotOptions: {
      pie: {
        allowPointSelect: true,
        cursor: 'pointer',
        dataLabels: {
          enabled: true,
          format: '<b>{point.name}</b>: S/ {point.y:,.2f}'
        }
      }
    },
    series: [{
      name: 'Valor',
      colorByPoint: true,
      data: [{
        name: 'Total Adquisición',
        y: adquisicion,
        color: '#6c757d'
      }, {
        name: 'Total Baja',
        y: baja,
        color: '#dc3545'
      }]
    }]
  });

    }).fail(function (err) {
      console.error("Error al cargar gráfico valor bienes:", err);
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
          text: 'Cantidad de Bienes por Dependencia',
          align: 'center',
          style: {
            fontSize: '16px',
            fontWeight: 'bold'
          }
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