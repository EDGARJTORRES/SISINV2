var usu_id = $("#usu_idx").val();
function cargarTotalBienes() {
  $.post("../../controller/bien.php?op=contador_bien_estado", function(data) {
    data = JSON.parse(data);

    const mapaEstados = {
        'N': 'NUEVO',
        'M': 'MALO',
        'R': 'REGULAR',
        'B': 'BUENO'
    };

    let total = 0;
    let htmlDetalle = '<div class="detalle-hover"><ul class="mb-0 ps-3" style="list-style-type: none;">';

    data.forEach(function(item) {
        const nombreEstado = mapaEstados[item.estado] || item.estado;
        const cantidad = parseInt(item.cantidad);
        total += cantidad;
        htmlDetalle += `<li>${nombreEstado}: ${cantidad}</li>`;
    });

    htmlDetalle += '</ul></div>';

    // ✅ REEMPLAZA TODO EL CONTENIDO DEL CONTENEDOR DEL PLACEHOLDER
    $('#placeholder-totales').removeClass('placeholder-glow').html(`
      <h3 class="card-title text-yellow">TOTAL DE BIENES</h3>
      <div class="row text-center">
        <div class="col-lg-4">
          <img style="height:60px;" src="../../static/gif/computadora.gif" alt="Cargando..." />
        </div>
        <div class="col-lg-8" style="align-content: center;">
          <h2 id="lbltotabien">
            <div class="resumen-total-hover">
              <span style="font-size: 18px;">${total}</span>
              ${htmlDetalle}
            </div>
          </h2>
        </div>
      </div>
    `);
  });
}
function cargarValorAdquisicion() {
  $.post("../../controller/bien.php?op=total_adquision", function(data) {
    data = JSON.parse(data);
    let contenidoFinal = "";

    if (data.length > 0 && data[0].total_valor_adquisicion !== null) {
      contenidoFinal = `
        <h3 class="card-title text-success">TOTAL VALOR ADQUISICIÓN</h3>
        <div class="row text-center">
          <div class="col-lg-4">
            <img style="height:60px;" src="../../static/gif/ordenador-portatil.gif" alt="Cargando..." />
          </div>
          <div class="col-lg-8" style="align-content: center;">
            <h4 id="lbltotal_adq">${data[0].total_valor_adquisicion}</h4>
          </div>
        </div>
      `;
    } else {
      contenidoFinal = `
        <h3 class="card-title text-success">TOTAL VALOR ADQUISICIÓN</h3>
        <div class="row text-center">
          <div class="col-lg-4">
            <img style="height:60px;" src="../../static/gif/ordenador-portatil.gif" alt="Cargando..." />
          </div>
          <div class="col-lg-8" style="align-content: center;">
            <h4 id="lbltotal_adq">No se encontró el total.</h4>
          </div>
        </div>
      `;
    }

    // Reemplazar contenido y quitar clase de placeholder
    $('#placeholder-adquisicion').removeClass('placeholder-glow').html(contenidoFinal);
  });
}
function cargarUltimoBien() {
  $.post("../../controller/bien.php?op=ultimo", function(data) {
    data = JSON.parse(data);

    const contenidoFinal = `
      <h3 class="card-title text-danger">ÚLTIMO BIEN REGISTRADO</h3>
      <div class="row text-center">
        <div class="col-lg-4">
          <img style="height:60px;" src="../../static/gif/vlogger.gif" alt="Cargando..." />
        </div>
        <div class="col-lg-8" style="align-content: center;">
          <h6 id="lblultimo">${data ? data.obj_nombre : 'No se encontró el último equipo.'}</h6>
        </div>
      </div>
    `;

    $('#placeholder-ultimo-bien').removeClass('placeholder-glow').html(contenidoFinal);
  });
}
function cargarUltimaBaja() {
  $.post("../../controller/dependencia.php?op=obtener_ultimo_bien_baja", function(data) {
    data = JSON.parse(data);

    const contenidoFinal = `
      <h3 class="card-title text-blue">ÚLTIMA BAJA DE BIEN</h3>
      <div class="row text-center">
        <div class="col-lg-4">
          <img style="height:60px;" src="../../static/gif/presentacion.gif" alt="Cargando..." />
        </div>
        <div class="col-lg-8" style="align-content: center;">
          <h6 id="lblultimabaja">${data ? data.obj_nombre : 'No se encontró el último equipo dado de baja.'}</h6>
        </div>
      </div>
    `;

    $('#placeholder-ultima-baja').removeClass('placeholder-glow').html(contenidoFinal);
  });
}
function cargarGraficoEstadoBienes() {
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

    // Reemplazar el contenido del placeholder por el definitivo
    const contenido = `
      <h3 class="card-title text-purple">BIENES REGISTRADOS <span class="text-secondary">(EVALUANDO SU ESTADO)</span></h3>
      <div class="row text-center">
        <div id="grafico_estados_bienes" style="height: 250px;"></div>
      </div>
    `;

    $("#placeholder-estado-bienes").removeClass("placeholder-glow").html(contenido);

    // Cargar gráfico después de reemplazar el contenedor
    Highcharts.chart('grafico_estados_bienes', {
      chart: {
        type: 'line'
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
        color: '#6c757d'
      }]
    });
  });
}
function cargarGrafico() {
  fetch('../../controller/dependencia.php?op=contador_bienes_por_dependencia')
    .then(response => response.json())
    .then(data => {
      const categorias = data.map(item => item.depe_denominacion);
      const cantidades = data.map(item => parseInt(item.cantidad));

      // Reemplazar el placeholder con el contenido real
      const contenido = `
        <h3 class="card-title text-purple">BIENES REGISTRADOS<span class="text-secondary"> (EVALUANDO SU DEPENDENCIA)</span></h3>
        <div class="row text-center">
          <div id="grafico_objetos_dependencia" style="height: 666px;"></div>
        </div>
      `;

      document.getElementById("placeholder-dependencia-bienes").classList.remove("placeholder-glow");
      document.getElementById("placeholder-dependencia-bienes").innerHTML = contenido;

      // Renderizar el gráfico
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
function cargarGraficoValorBienes() {
  $.get("../../controller/bien.php?op=grafico_valor_bienes", function (data) {
    const valores = JSON.parse(data);
    const adquisicion = parseFloat(valores.total_adquisicion || 0);
    const baja = parseFloat(valores.total_baja || 0);

    // Reemplazar el placeholder con contenido real
    const contenido = `
      <h3 class="card-title text-pink">BALANCE PATRIMONIAL:<span class="text-secondary"> (ADQUISICIÓN VS BAJA)</span></h3>
      <div id="grafico_valor_bienes" style="height: 320px;"></div>
    `;

    const placeholder = document.getElementById("placeholder-balance-patrimonial");
    placeholder.classList.remove("placeholder-glow");
    placeholder.innerHTML = contenido;

    // Generar gráfico
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
        data: [
          {
            name: 'Total Adquisición',
            y: adquisicion,
            color: '#6c757d'
          },
          {
            name: 'Total Baja',
            y: baja,
            color: '#dc3545'
          }
        ]
      }]
    });

  }).fail(function (err) {
    console.error("Error al cargar gráfico valor bienes:", err);
  });
}
cargarTotalBienes();
cargarValorAdquisicion();
cargarUltimoBien();
cargarUltimaBaja();
cargarGraficoEstadoBienes();
cargarGrafico();
cargarGraficoValorBienes();