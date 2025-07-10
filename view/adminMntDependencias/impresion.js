function imprimirFormatoBaja() {
    const ahora = new Date();
    const fecha = ahora.toLocaleDateString('es-PE');
    const hora = ahora.toLocaleTimeString('es-PE', { hour: '2-digit', minute: '2-digit' });

    // ✅ Actualiza el DOM visible también
    document.getElementById('fecha-impresion').textContent = fecha;
    document.getElementById('hora-impresion').textContent = hora;

    const contenidoOriginal = document.getElementById('formato-baja').cloneNode(true);

    // ✅ Actualiza el contenido clonado
    contenidoOriginal.querySelector('#fecha-impresion').textContent = fecha;
    contenidoOriginal.querySelector('#hora-impresion').textContent = hora;

    const ventana = window.open('', '_blank', 'width=900,height=1000');

    ventana.document.write(`
        <html>
        <head>
            <title>Impresión de Baja</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css">
            <link href="../../public/css/sinasignacion.css" rel="stylesheet"/>
            <style>
            @page { size: A4 portrait; margin: 1cm; }
            body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
            h2 { text-align: center; text-transform: uppercase; font-size: 14px; margin-bottom: 20px; }
            .encabezado { display: flex; justify-content: space-between; }
            .encabezado div { width: 32%; }
            .value { display: inline-block; width: calc(100% - 190px);}
            .section-title { background: #f0f0f0; font-weight: bold border: 1px solid #ccc; }
            .double-column {
                display: flex;
                gap: 0;
                font-size: 11px;
            }

            .double-column table {
                width: 100%;
                border-collapse: collapse;
            }

            .double-column td {
                padding: 2px;
                vertical-align: top;
                font-size: 12px; /* Aplica también a <td> directamente */
            }

            .double-column strong {
                font-size: 11px;
                font-weight: bold;
            }

            .respuesta-sm {
                font-size: 11px;
            }
            .observaciones { min-height: 60px; border: 1px solid #000; padding: 6px; margin-top: 20px; }
            
    .styled-table {
        width: 100%;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
        font-size: 12px;
        margin-top: 10px;
    }

    .styled-table th, .styled-table td {
        border: 1px solid #cccccc;
        padding: 7px 10PX;
        vertical-align: top;
        text-align: left;
    }

    .styled-table thead th {
        background-color: #f2f2f2;
        font-weight: bold;
        text-align: center;
    }

    .styled-table tr:nth-child(even) {
        background-color: #fafafa;
    }

    .styled-table tr:hover {
        background-color: #f1f1f1;
    }

    .styled-table td[colspan="2"], .styled-table td[colspan="3"] {
        font-weight: normal;
        background-color: #f9f9f9;
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
function descargarimgFormatoBaja() {
    const elemento = document.getElementById("formato-baja");

    // Actualiza fecha y hora antes de capturar
    const ahora = new Date();
    const fecha = ahora.toLocaleDateString('es-PE');
    const hora = ahora.toLocaleTimeString('es-PE', { hour: '2-digit', minute: '2-digit' });

    document.getElementById('fecha-impresion').textContent = fecha;
    document.getElementById('hora-impresion').textContent = hora;

    html2canvas(elemento, { scale: 2 }).then(canvas => {
        const link = document.createElement("a");
        link.download = `formato_baja_${fecha.replace(/\//g, '-')}.png`;
        link.href = canvas.toDataURL("image/png");
        link.click();
    });
}
function descargarPDFFormatoBaja() {
    const elemento = document.getElementById("formato-baja");

    // Actualiza fecha y hora antes de exportar
    const ahora = new Date();
    const fecha = ahora.toLocaleDateString('es-PE').replace(/\//g, '-');
    const hora = ahora.toLocaleTimeString('es-PE', { hour: '2-digit', minute: '2-digit' });

    document.getElementById('fecha-impresion').textContent = ahora.toLocaleDateString('es-PE');
    document.getElementById('hora-impresion').textContent = hora;

    const opciones = {
        filename:     `formato_baja_${fecha}.pdf`,
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2, useCORS: true },
        jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
    };

    html2pdf().set(opciones).from(elemento).save();
}
