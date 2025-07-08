<?php
require_once("../../config/conexion.php");
require_once("../../models/Dependencia.php");

if (isset($_SESSION["usua_id_siin"])) {
    $dependencia = new Dependencia();
    $bien_id = isset($_GET['bien_id']) ? $_GET['bien_id'] : 0;
    $datos = $dependencia->obtenerBienBajaPorId($bien_id);
    $fecha_baja = new DateTime(substr($datos["fecha_baja"], 0, 10));
    $fecha_creacion = new DateTime(substr($datos["fechacrea"], 0, 10));
    $intervalo = $fecha_creacion->diff($fecha_baja);
    $vida_util = $intervalo->format('%y años, %m meses, %d días');
    $val_adq = isset($datos["val_adq"]) ? (float) $datos["val_adq"] : 0.00;
    $vida_util_anios = isset($datos["vida_util"]) ? (int) $datos["vida_util"] : 10;
    $meses_transcurridos = ($intervalo->y * 12) + $intervalo->m;
    $vida_util_meses = $vida_util_anios * 12;
    $depreciacion_mensual = $val_adq / $vida_util_meses;
    $depreciacion_acumulada = min($val_adq, $depreciacion_mensual * $meses_transcurridos);
    $valor_en_libros = max(0, $val_adq - $depreciacion_acumulada);
    $valor_neto = $valor_en_libros;
    $formato_valor_orden_compra     = 'S/ ' . number_format($val_adq, 2, '.', ',');
    $formato_valor_libros           = 'S/ ' . number_format($valor_en_libros, 2, '.', ',');
    $formato_depreciacion_acumulada = 'S/ ' . number_format($depreciacion_acumulada, 2, '.', ',');
    $formato_valor_neto             = 'S/ ' . number_format($valor_neto, 2, '.', ',');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("../html/mainHead.php"); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="../../public/css/sinasignacion.css" rel="stylesheet"/>
    <link href="../../public/css/Breadcrumb.css" rel="stylesheet"/>
    <title>MPCH::</title>
    <style>
  @page {
    size: A4 portrait;
    margin:1cm;
  }

  body {
    font-family: Arial, sans-serif;
  }

  h2 {
    text-align: center;
    text-transform: uppercase;
    font-size: 14pt;
    margin-bottom: 20px;
  }

  .encabezado {
    display: flex;
    justify-content: space-between;
  }

  .encabezado div {
    width: 32%;
  }

  .label {
    font-weight: bold;
    display: inline-block;
    width: 160px;
    vertical-align: top;
  }
  .section-title {
    background: #f0f0f0;
    font-weight: bold;
    padding: 5px;
    margin: 25px 0 10px;
    border: 1px solid #ccc;
  }

  .double-column {
    display: flex;
    justify-content: space-between;
    gap: 0px;
    font-size: 12px;
  }

  .double-column .col {
    width: 45%;
  }

  .observaciones {
    min-height: 60px;
    border: 1px solid #000;
    padding: 6px;
    margin-top: 20px;
  }

  /* 🔽 Fuerza impresión a ancho completo */
  @media print {
    .page-header,
    .btn,
    .d-print-none {
      display: none !important;
    }

    #formato-baja {
      width: 100% !important;
      margin: 0;
      padding: 0;
      border: none !important;
      box-shadow: none !important;
    }
    .container-xl,
    .card,
    .col-lg-6,
    .col {
      width: 100% !important;
      max-width: 100% !important;
      padding: 0 !important;
    }

    body {
      margin: 0;
      padding: 0;
    }
    
.tg .tg-0lax{text-align:left;vertical-align:top}
  }
      .styled-table {
        width: 100%;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
        font-size: 14px;
        margin-top: 20px;
    }

    .styled-table th, .styled-table td {
        border: 1px solid #cccccc;
        padding: 10px;
        vertical-align: top;
        text-align: left;
    }

    .styled-table thead th {
        background-color: #f2f2f2;
        font-weight: bold;
        text-align: center;
    }
</style>
  </head>
<body>
    <?php require_once("../html/mainProfile.php"); ?>
     <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <nav class="breadcrumb mb-3">
                    <a href="../adminMain/">Inicio</a>
                    <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
                    <span class="breadcrumb-item active">Procesos</span>
                    <a href="../adminMntDependencias/">
                    <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
                    Baja de Bienes
                    </a>
                    <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
                    <span>Formato de Baja de Bien</span>
                </nav>
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                        FORMATO DE BAJA DE BIEN PATRIMONIAL
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none mb-3">
                        <div class="btn-list">
                            <button class="Btn" onclick="window.location.href = '../adminMntDependencias/';">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-back-up-double"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13 14l-4 -4l4 -4" /><path d="M8 14l-4 -4l4 -4" /><path d="M9 10h7a4 4 0 1 1 0 8h-1" /></svg>
                                Regresar
                            </button>
                            <button class="Btn" onclick="imprimirFormatoBaja()">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-printer"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" /></svg>
                            Imprimir
                            </button>
                            <button class="Btn"  onclick=" descargarimgFormatoBaja()">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-download"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 11l5 5l5 -5" /><path d="M12 4l0 12" /></svg>
                            Imagen
                            </button>
                            <button class="Btn" onclick="descargarPDFFormatoBaja()">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-text"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M9 9l1 0" /><path d="M9 13l6 0" /><path d="M9 17l6 0" /></svg>
                                PDF
                            </button>
                        </div>
                    </div>
                </div>  
                <div id="formato-baja" class="card py-4 px-5 border-0" style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                    <div class="encabezado">
                        <div>
                            <strong>Sistema de Gestión de Inventario</strong><br>
                            <strong>Módulo de Patrimonio</strong><br>
                        </div>
                        <div style="text-align: right;">
                            <strong>Fecha:</strong> <span id="fecha-impresion"></span><br>
                            <strong>Hora:</strong> <span id="hora-impresion"></span><br>
                            <strong>Página:</strong> 1
                        </div>
                    </div>
                    <h2>DATOS DEL ACTIVO FIJO</h2>
                    <div class="double-column my-2">
                        <table style="width: 50%; border-collapse: collapse;">
                            <tr>
                                <td style="width: 30%; border: none;"><strong>Ejecutora:</strong></td>
                                <td style="border: none;"><span class="respuesta-sm"> : 001 MUNICIPALIDAD PROVINCIAL DE CHICLAYO</span></td>
                            </tr>
                            <tr>
                                <td style="border: none;"><strong>Nro Identificación</strong></td>
                                <td style="border: none;"><span class="respuesta-sm">: <?php echo str_pad($datos["bien_id"], 6, '0', STR_PAD_LEFT); ?></span></td>
                            </tr>
                            </tr>
                            <tr>
                                <td style="border: none;"><strong>Responsable del Bien</strong></td>
                                <td style="border: none; font-size: 12px;">: <?php echo ucfirst(strtolower($datos["repre_id"])); ?></td>
                            </tr>
                            <tr>
                                <td style="border: none;"><strong>Fecha Asignación</strong></td>
                                <td style="border: none;"><span class="respuesta-sm">:</span></td>
                            </tr>
                        </table>
                        <table style="width: 50%; border-collapse: collapse;">
                            <tr>
                                <td style="width: 25%; border: none;"><strong>Sede</strong></td>
                                <td style="border: none;"><span class="respuesta-sm">: SEDE CENTRAL</span></td>
                            </tr>
                            <tr>
                                <td style="border: none;"><strong>Centro de Costo</strong></td>
                                <td style="border: none;"><span class="respuesta-sm">: SUB GERENCIA DE LOGISTICA Y CONTROL PATRIMONIAL</span></td>
                            </tr>
                            <tr>
                                <td style="border: none;"><strong>Ubicación</strong></td>
                                <td style="border: none;"><span class="respuesta-sm">: ALMACÉN DE CHATARRA (PARQUE INDUSTRIAL)</span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="row mx-2">
                        <table class="styled-table">
                            <colgroup>
                                <col style="width: 50%">
                                <col style="width: 35%">
                                <col style="width: 15%">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th style="text-align: center;"><strong>Identificación del Bien</strong></th>
                                    <th style="text-align: center;"><strong>Ingreso del Bien</strong></th>
                                    <th style="text-align: center;"><strong>Fecha</strong>
                                </th> 
                                </tr>
                                <tr>
                                    <td rowspan="3">
                                        <table style="width: 100%; border-collapse: collapse;">
                                            <tr>
                                                <td style="width: 45%; border: none;"><strong>Código Patrimonial</strong></td>
                                               <td style="border: none; font-size: 12px;">: <?php echo $datos["bien_codbarras"]; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: none;"><strong>Código Barra / Inv.</strong></td>
                                                <td style="border: none; font-size: 12px;">: <?php echo $datos["bien_codbarras"]; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: none;"><strong>Descripción:</strong></td>
                                                <td style="border: none; font-size: 12px;">: <?php echo ucfirst(strtolower($datos["obj_nombre"])); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: none;"><strong>Cuenta Contable:</strong></td>
                                                <td style="border: none; font-size: 12px;">: <?php echo '---'; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: none;"><strong>Estado del Bien:</strong></td>
                                                <td style="border: none; font-size: 12px;">
                                                    : <?php
                                                        echo ($datos["bien_est"] === 'I') ? 'Inactivo - Chatarra' : ucfirst(strtolower($datos["bien_est"]));
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="border: none;"><strong>Procedencia:</strong></td>
                                                <td style="border: none; font-size: 12px;">: <?php echo ucfirst(strtolower($datos["procedencia"])); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: none;"><strong>Características:</strong></td>
                                                <td style="border: none; font-size: 12px;">: <?php echo ucfirst(strtolower($datos["bien_obs"])); ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table style="width:100%; border-collapse: collapse;">
                                            <tr>
                                                <td style="width: 70%; border: none;"><strong>Inventario Inicial</strong></td>
                                                 <td style="border: none; font-size: 12px;">: <?php echo ucfirst(strtolower($datos["bien_id"])); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: none;"><strong>Nro Pecosa:</strong></td>
                                                <td style="border: none;"> :<?php echo '---'; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php echo date("d/m/Y", strtotime($datos["fecharegistro"])); ?>
                                        <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td rowspan="2" colspan="2">
                                        <table style="width:100%; border-collapse: collapse;">
                                            <tr>
                                                <td style="width: 60%; border: none;"><strong>Val. Orden de compra S/.</strong></td>
                                                <td style="border: none;">: <?php echo $formato_valor_orden_compra; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: none;"><strong>Valor en Libros S/.</strong></td>
                                                <td style="border: none;">:<?php echo $formato_valor_libros; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: none;"><strong>Valor Tasado S/.</strong></td>
                                                <td style="border: none;">: <?php echo '---'; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: none;"><strong>Valor Neto S/.</strong></td>
                                                <td style="border: none;">: <?php echo $formato_valor_neto; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: none;"><strong>Deprec. Acumulada S/.</strong></td>
                                                <td style="border: none;">: <?php echo $formato_depreciacion_acumulada; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                </tr>
                                <tr>
                                    <th style="text-align: center;"><strong>Especificaciones Técnicas</strong></th>
                                    <th colspan="2" style="text-align: center;"><strong>Baja del Bien</strong></th>
                                </tr>
                                <tr>
                                   <td rowspan="2">
                                        <table style="width:100%; border-collapse: collapse;">
                                            <tr>
                                                <td style="width: 30%; border: none;"><strong>Marca</strong></td>
                                                <td style="border: none; font-size: 12px;">: <?php echo ucfirst(strtolower($datos["marca_nom"])); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: none;"><strong>Nro Serie</strong></td>
                                                <td style="border: none; font-size: 12px;">: <?php echo ucfirst(strtolower($datos["bien_numserie"])); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: none;"><strong>Modelo</strong></td>
                                                <td style="border: none; font-size: 12px;">: <?php echo ucfirst(strtolower($datos["modelo_nom"])); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: none;"><strong>Medidas</strong></td>
                                                <td style="border: none; font-size: 12px;">: <?php echo ucfirst(strtolower($datos["bien_dim"])); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: none;"><strong>Color</strong></td>
                                                <td style="border: none; font-size: 12px;">: <?php echo ucfirst(strtolower($datos["bien_color"])); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: none;"><strong>Vida Útil</strong></td>
                                                 <td style="border: none; font-size: 12px;">: <?php echo $vida_util; ?></td>
                                            </tr>

                                        </table>
                                    </td>
                                    <td colspan="2">
                                        <table style="width:100%; border-collapse: collapse;">
                                            <tr>
                                                <td style="width: 50%; border: none;"><strong>N° de Resolución</strong></td>
                                                <td style="border: none; font-size: 12px;">: <?php echo ucfirst(strtolower('---')); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: none;"><strong>Fecha Resolución</strong></td>
                                                <td style="border: none;font-size: 12px;" >: <?php echo date("d/m/Y", strtotime($datos["fecha_baja"]));?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: none;"><strong>Fecha Baja</strong></td>
                                                <td style="border: none;font-size: 12px;" >: <?php echo date("d/m/Y", strtotime($datos["fecha_baja"]));?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: none;"><strong>Causal de Baja</strong></td>
                                                <td style="border: none; font-size: 12px;">: <?php echo ucfirst(strtolower($datos["motivo_baja"]));?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table style="width:100%; border-collapse: collapse;">
                                            <tr>
                                                <td style="width: 50%; border: none;"><strong>Proveedor:</strong></td>
                                                <td style="border: none;"><?php echo '---'; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="width: 50%; border: none;"><strong>Pais:</strong></td>
                                                <td style="border: none;"><?php echo '---'; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <strong>Ultima Observacion:</strong><br>
                                        <br>
                                        <?php echo $datos["biendepe_obs"]; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>  
    </div>
    <?php require_once("../html/footer.php"); ?>
    <?php require_once("../html/mainjs.php"); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
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
    </script>
</body>
</html>
<?php
} else {
  header("Location:" . Conectar::ruta() . "view/404/");
}
?>