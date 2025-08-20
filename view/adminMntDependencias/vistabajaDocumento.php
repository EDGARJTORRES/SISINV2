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
    <link href="../../public/css/lista.css" rel="stylesheet"/>
    <link href="../../public/css/Breadcrumb.css" rel="stylesheet"/>
    <link href="../../public/css/vistaDocumento.css" rel="stylesheet"/>
    <title>MPCH::</title>
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
                    <div class="col-auto">
                        <a href="../adminMntDependencias/" class="btn btn-ghost-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M5 12l14 0" />
                                <path d="M5 12l6 6" />
                                <path d="M5 12l6 -6" />
                            </svg>
                            Volver
                        </a>
                    </div>
                    <div class="col">
                        <h2 class="page-title" style="border-left: 1px solid #000; padding-left: 8px;">
                            FORMATO DE BAJA DE BIEN PATRIMONIAL
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none mb-3">
                        <div class="btn-list">
                            <button class="clase" onclick="imprimirFormatoBaja()">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-printer"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" /></svg>
                            Imprimir
                            </button>
                            <button class="clase"  onclick=" descargarimgFormatoBaja()">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-download"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 11l5 5l5 -5" /><path d="M12 4l0 12" /></svg>
                            Imagen
                            </button>
                            <button class="clase" onclick="descargarPDFFormatoBaja()">
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
                                <td style="width: 30%; border: none;"><strong>Ejecutora</strong></td>
                                <td style="border: none;"><span class="respuesta-sm"> : 001 MUNICIPALIDAD PROVINCIAL DE CHICLAYO</span></td>
                            </tr>
                            <tr>
                                <td style="border: none;"><strong>Nro Identificación</strong></td>
                                <td style="border: none;"><span class="respuesta-sm">: <?php echo str_pad($datos["bien_id"], 6, '0', STR_PAD_LEFT); ?></span></td>
                            </tr>
                            </tr>
                            <tr>
                                <td style="border: none;"><strong>Responsable del Bien</strong></td>
                                <td style="border: none; font-size: 12px;">: <?php echo ucwords(strtolower($datos["nombre_completo"])); ?></td>
                            </tr>
                            <tr>
                                <td style="border: none;"><strong>Fecha Asignación</strong></td>
                                <td style="border: none;"><span class="respuesta-sm">: <?php echo date("d/m/Y", strtotime($datos["fecha_asignacion"])); ?></td>
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
                                    <th style="text-align: center;"><strong>IDENTIFICACION DEL BIEN</strong></th>
                                    <th style="text-align: center;"><strong>INGRESO DEL BIEN</strong></th>
                                    <th style="text-align: center;"><strong>FECHA</strong>
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
                                                <td style="border: none;"><strong>Descripción</strong></td>
                                                <td style="border: none; font-size: 12px;">: <?php echo ucfirst(strtolower($datos["obj_nombre"])); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: none;"><strong>Cuenta Contable</strong></td>
                                                <td style="border: none; font-size: 12px;">: <?php echo ucfirst(strtolower($datos["bien_cuenta"])); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: none;"><strong>Estado del Bien</strong></td>
                                                <td style="border: none; font-size: 12px;">
                                                    : <?php
                                                        echo ($datos["bien_est"] === 'I') ? 'Inactivo - Chatarra' : ucfirst(strtolower($datos["bien_est"]));
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="border: none;"><strong>Procedencia</strong></td>
                                                <td style="border: none; font-size: 12px;">: <?php echo ucfirst(strtolower($datos["procedencia"])); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: none;"><strong>Características</strong></td>
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
                                                <td style="border: none;"><strong>Nro Pecosa</strong></td>
                                                <td style="border: none;"><span class="respuesta-sm">: <?php echo str_pad($datos["form_id"], 6, '0', STR_PAD_LEFT); ?></span></td>
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
                                                <td style="border: none;">: <?php echo $formato_valor_libros; ?></td>
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
                                    <th style="text-align: center;"><strong>ESPECIFICACIONES TECNICAS</strong></th>
                                    <th colspan="2" style="text-align: center;"><strong>BAJA DEL BIEN</strong></th>
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
                                               <td style="border: none; font-size: 12px;">: <?php echo ucfirst(strtolower($datos["colores"])); ?></td>
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
                                                <td style="border: none;"><strong>Fecha Resolución</strong></td>
                                                <td style="border: none;font-size: 12px;" >: <?php echo date("d/m/Y", strtotime($datos["fecha_baja"]));?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: none;"><strong>Fecha Baja</strong></td>
                                                <td style="border: none;font-size: 12px;" >: <?php echo date("d/m/Y", strtotime($datos["fecha_baja"]));?></td>
                                            </tr>
                                            <tr>
                                                <td style="border: none;"><strong>Resolucion de Baja</strong></td>
                                                <td style="border: none; font-size: 12px;">: <?php echo ucfirst(strtolower($datos["motivo_baja"]));?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table style="width:100%; border-collapse: collapse;">
                                            <tr>
                                                <td style="width: 50%; border: none;"><strong>Proveedor</strong></td>
                                                <td style="border: none;">: <?php echo '---'; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="width: 50%; border: none;"><strong>Pais</strong></td>
                                                <td style="border: none;">: <?php echo 'Perú'; ?></td>
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
    <?php require_once("../html/mainJs.php"); ?>
    <script type="text/javascript" src="impresion.js"></script>
    <script type="text/javascript" src="color.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</body>
</html>
<?php
} else {
  header("Location:" . Conectar::ruta() . "view/404/");
}
?>