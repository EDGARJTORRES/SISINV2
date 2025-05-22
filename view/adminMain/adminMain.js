var usu_id = $("#usu_idx").val();
$(document).ready(function(){
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
    const colores = {
        'A': '#2196F3', 
        'N': '#9C27B0',   
        'M': '#F44336',  
        'R': '#FF9800',  
        'B': '#4CAF50',   
        'I': '#9E9E9E'    
    };

    let seriesData = [];

    data.forEach(function(item) {
        const estadoInicial = item.estado;
        const nombreEstado = mapaEstados[estadoInicial] || estadoInicial;
        const color = colores[estadoInicial] || '#999999';

        seriesData.push({
            name: nombreEstado,
            y: parseInt(item.cantidad),
            color: color
        });
    });

    Highcharts.chart('grafico_estados_bienes', {
        chart: {
            type: 'column',
            options3d: {
                enabled: true,
                alpha: 15,
                beta: 15,
                depth: 50,
                viewDistance: 25
            },
            spacingLeft: 0,
            spacingRight: 0,
            marginLeft: 0,
            marginRight: 0
        },
        title: {
            text: null,
        },
        xAxis: {
            categories: seriesData.map(e => e.name),
            title: {
                text: 'Estado'
            },
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Cantidad de Bienes',
            },
            allowDecimals: false
        },
        tooltip: {
            headerFormat: '<b>{point.key}</b><br>',
            pointFormat: '{series.name}: {point.y}'
        },
        plotOptions: {
            column: {
                depth: 25,
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Bienes',
            data: seriesData
        }]
    });
});

    $.post("../../controller/bien.php?op=ultimo", function(data){
        data = JSON.parse(data); 
        if (data) {
            $('#lblultimo').html(data.obj_nombre);
        } else {
            $('#lblultimo').html("No se encontró el último equipo.");
        }
    }); 


});