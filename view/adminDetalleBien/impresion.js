function imprimirFormatoBaja() {
    const ahora = new Date();
    const fecha = ahora.toLocaleDateString('es-PE');
    const hora = ahora.toLocaleTimeString('es-PE', { hour: '2-digit', minute: '2-digit' });

    // Actualiza DOM visible
    document.getElementById('fecha-impresion').textContent = fecha;
    document.getElementById('hora-impresion').textContent = hora;

    const contenidoOriginal = document.getElementById('formato-baja').cloneNode(true);

    contenidoOriginal.querySelector('#fecha-impresion').textContent = fecha;
    contenidoOriginal.querySelector('#hora-impresion').textContent = hora;

    const ventana = window.open('', '_blank', `width=${screen.width},height=${screen.height},left=0,top=0`);
    ventana.moveTo(0, 0);
    ventana.resizeTo(screen.width, screen.height);

    ventana.document.write(`
        <html>
        <head>
            <title>&#8203;</title> 
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css">
            <link href="../../public/css/sinasignacion.css" rel="stylesheet"/>
            <style>
            @page { size: A4 landscape; margin: 1cm; }
            body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
            .encabezado {
                display: flex;
                justify-content: space-between; /* separa las dos columnas */
                align-items: center;            /* centra verticalmente */
                font-size: 12px;
            }

            /* Columna izquierda */
            .encabezado .columna1 {
                flex: 1;              /* ocupa la mitad del espacio */
                display: flex;
                align-items: center;
                gap: 10px;            /* espacio entre elementos internos */
            }

            /* Columna derecha */
            .encabezado .columna2 {
                flex: 1;              /* ocupa la otra mitad */
                text-align: right;    /* alinea el texto a la derecha */
                font-size: 12px;
            }

            h2 { text-align: center; text-transform: uppercase; font-size: 14px; margin-bottom: 0px !important; }
            .value { display: inline-block; width: calc(100% - 190px);}
            .section-title { background: #f0f0f0; font-weight: bold; border: 1px solid #ccc; }
            .double-column { display: flex; gap: 0; font-size: 12px; }
            .double-column .col {
                width: 60% !important;
            }
            .double-column table { width: 100%; border-collapse: collapse; }
            .double-column td { padding: 5px; vertical-align: top; font-size: 12px; }
            .double-column strong { font-size: 12px; font-weight: bold; }
            .respuesta-sm { font-size: 12px; }
            .styled-table { 
            width: 100% !important; 
            border-collapse: collapse !important; 
            font-family: Arial, sans-serif !important; 
            margin-top: 0px !important; 
            }

            .styled-table th, 
            .styled-table td { 
            border: 1px solid #cccccc; 
            padding: 7px 4px;!important; 
            vertical-align: top !important; 
            font-size: 11px !important; 
            }

            .styled-table thead th {  
            background-color: #a6c8ebff !important; 
            font-weight: bold !important; 
            text-align: center !important; 
            }

            .styled-table tr:nth-child(even) { 
            background-color: #fafafa !important; 
            }

            .styled-table tr:hover { 
            background-color: #f1f1f1 !important; 
            }

            .styled-table td[colspan="2"], 
            .styled-table td[colspan="3"] { 
            font-weight: normal !important; 
            background-color: #f9f9f9 !important; 
            }

            </style>
        </head>
        <body onload="window.print(); setTimeout(() => window.close(), 100);">
            ${contenidoOriginal.innerHTML}
        </body>
        </html>
    `);

    ventana.document.close();
}

function descargarPDFFormatoBaja() {
    const elemento = document.getElementById("formato-baja");
    elemento.style.marginTop = "0px";
    elemento.style.paddingTop = "0px";
    const ahora = new Date();
    const fecha = ahora.toLocaleDateString('es-PE').replace(/\//g, '-');
    const hora = ahora.toLocaleTimeString('es-PE', { hour: '2-digit', minute: '2-digit' });
    document.getElementById('fecha-impresion').textContent = ahora.toLocaleDateString('es-PE');
    document.getElementById('hora-impresion').textContent = hora;
    const opciones = {
        filename:     `ficha_asignacion_vehiculo_${fecha}.pdf`,
        margin:       [0, 0, 0, 0],
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2, useCORS: true, scrollY: 0 },
        jsPDF:        { unit: 'in', format: 'a4', orientation: 'landscape' }
    };

    html2pdf().set(opciones).from(elemento).save().then(() => {
        elemento.style.marginTop = "";
        elemento.style.paddingTop = "";
    });
}
