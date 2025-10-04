<?php
require_once("../../config/conexion.php");
require_once("../../models/Dependencia.php");
require_once("../../models/Formato.php");

if (isset($_SESSION["usua_id_siin"])) {
    $dependencia = new Dependencia();
    $formato = new Formato();
    $bien_id = isset($_GET['bien_id']) ? $_GET['bien_id'] : 0;
    $datos = $dependencia->obtenerDetalleVehiculoporid($bien_id);
    if (!$datos) {
        $datos = [
            "obj_nombre" => "N/A",
            "bien_codbarras" => "N/A",
            "nro_motor" => "N/A",
            "bien_placa" => "N/A",
            "vin" => "N/A",
            "anio_fabricacion" => "N/A",
            "val_adq" => 0,
            "fecharegistro" => date("Y-m-d"),
            "nombre_completo" => "N/A",
            "marca_nom" => "N/A",
            "modelo_nom" => "N/A",
            "colores" => "N/A",
            "combustibles" => "N/A",
            "tipo_carroceria_id" => "N/A",
            "depe_receptor" => null
        ];
    }

    $val_adq = isset($datos["val_adq"]) ? (float) $datos["val_adq"] : 0.00;
    $formato_valor_orden_compra = 'S/ ' . number_format($val_adq, 2, '.', ',');

    // Inicializamos variables receptoras para que nunca sean null
    $Gerencia_receptor = "N/A";
    $subgerencia_receptor = "N/A";
    $area_receptor = "N/A";

    $datos_receptor = $datos['depe_receptor'] ?? null;
    if ($datos_receptor) {
        $datos_receptor = $formato->get_dependenciadatos($datos['depe_receptor']);
        if (!empty($datos_receptor) && isset($datos_receptor[0])) {
            $nivel_actual_receptor = $datos_receptor[0]['nior_id'] ?? null;
            $nivel_superior_receptor = $datos_receptor[0]['depe_id'] ?? null;

            while ($nivel_actual_receptor >= 2 && $nivel_superior_receptor) {
                $datos_superior_receptor = $formato->get_dependenciadatos($nivel_superior_receptor);

                if (!empty($datos_superior_receptor) && isset($datos_superior_receptor[0])) {
                    $nivel_actual_receptor = $datos_superior_receptor[0]['nior_id'] ?? null;

                    if ($nivel_actual_receptor == 2) {
                        $Gerencia_receptor = $datos_superior_receptor[0]['depe_denominacion'] ?? "N/A";
                        break;
                    } elseif ($nivel_actual_receptor == 4) {
                        $subgerencia_receptor = $datos_superior_receptor[0]['depe_denominacion'] ?? "N/A";
                    } elseif ($nivel_actual_receptor == 5) {
                        $area_receptor = $datos_superior_receptor[0]['depe_denominacion'] ?? "N/A";
                    }

                    $nivel_superior_receptor = $datos_superior_receptor[0]['depe_superior'] ?? null;
                } else {
                    break; // Romper while si no hay datos
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("../html/mainHead.php"); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="../../public/css/lista.css" rel="stylesheet"/>
    <link href="../../public/css/Breadcrumb.css" rel="stylesheet"/>
    <link href="../../public/css/vistaVehiculo.css" rel="stylesheet"/>
    <title>MPCH:: Formato Detalle Bien</title>
</head>
<body>
    <?php require_once("../html/mainProfile.php"); ?>
    <div class="page-wrapper mb-5">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <nav class="breadcrumb mb-2">
                    <a href="../adminMain/">
                        Inicio
                    </a>
                    <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
                    <span class="breadcrumb-item active">Procesos</span>
                    <a href="../adminAltaBien/">
                    <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
                    Alta de Bienes
                    </a>
                    <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
                    <a href="../adminDetalleBien/">
                    Detalle de Bien Patrimonial
                    </a>
                    <svg class="breadcrumb-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.1 16.3"><path fill="currentColor" d="M0,14.4l6.2-6.2L0,1.9L2,0l8.1,8.1L2,16.3L0,14.4z"/></svg>
                    <span>Formato de Asignacion de Vehículo</span>
                </nav>
                <div class="row align-items-center">
                    <div class="col-auto">
                        <a href="../adminDetalleBien/" class="btn btn-ghost-primary">
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
                            Formato de Asignación de Vehículo
                        </h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none mb-3">
                        <div class="btn-list">
                            <button class="clase" onclick="imprimirFormatoBaja()">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-printer"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" /></svg>
                            Imprimir
                            </button>
                            <button class="clase" onclick="descargarPDFFormatoBaja()">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-text"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M9 9l1 0" /><path d="M9 13l6 0" /><path d="M9 17l6 0" /></svg>
                                PDF
                            </button>
                        </div>
                    </div>
                </div>  
            </div>  
            <div id="formato-baja" class="card p-4 border-0 mx-4" style="box-shadow: rgb(116, 142, 152) 0px 4px 16px -8px;">
                <div class="encabezado row align-items-center mx-2">
                    <div class="col-lg-6 d-flex align-items-center columna1">
                        <img src="../../static/illustrations/Escudo_de_Chiclayo.PNG" alt="Escudo de Chiclayo" style="width:60px; height:60px; margin-right:10px;">
                        <div class="text-column">
                            <strong>Sistema de Gestión de Inventario</strong><br>
                            <strong>Módulo de Patrimonio</strong>
                        </div>
                    </div>
                    <div class="col-lg-6 text-end columna2">
                        <strong>Fecha:</strong> <span id="fecha-impresion"></span><br>
                        <strong>Hora:</strong> <span id="hora-impresion"></span><br>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <h2 class="w-80 text-center">
                        FICHA DE ASIGNACIÓN EN USO DE BIENES DE VEHÍCULOS Y MAQUINARIA PESADA 
                    </h2>
                </div>
                <div class="double-column mx-2 my-0">
                    <table style="width: 50%; border-collapse: collapse;">
                        <tr>
                            <td style="border: none;"><strong>Ejecutora</strong></td>
                            <td style="border: none;"><span class="respuesta-sm"> : 001 MUNICIPALIDAD PROVINCIAL DE CHICLAYO</span></td>
                        </tr>
                        <tr>
                            <td style="border: none;"><strong>Gerencia</strong></td>
                            <td style="border: none;"><span class="respuesta-sm">: <?php echo utf8_encode($Gerencia_receptor); ?></span></td>
                        </tr>
                        </tr>
                        <tr>
                            <td style="border: none;"><strong>SubGerencia</strong></td>
                            <td style="border: none; ">: <?php echo utf8_encode($subgerencia_receptor); ?></td>
                        </tr>
                        <tr>
                            <td style="border: none;"><strong>Área</strong></td>
                            <td style="border: none;"><span class="respuesta-sm">: <?php echo utf8_encode($area_receptor); ?></td>
                        </tr>
                    </table>
                    <table style="width: 50%; border-collapse: collapse;">
                        <tr>
                            <td style="border: none;"><strong>Inventario por</strong></td>
                            <td style="border: none;"><span class="respuesta-sm">: </span></td>
                        </tr>
                        <tr>
                            <td style="border: none;"><strong>Responsable del Vehiculo</strong></td>
                            <td style="border: none;"><span class="respuesta-sm">: <?php echo ucwords(strtolower($datos["nombre_completo"])); ?></span></td>
                        </tr>
                        <tr>
                            <td style="border: none;"><strong>Ubicación</strong></td>
                            <td style="border: none;"><span class="respuesta-sm">: </span></td>
                        </tr>
                    </table>
                </div>
                <div class="row mx-2 my-0">
                    <table class="styled-table">
                        <colgroup>
                            <col style="width: 50%">
                            <col style="width: 50%">
                        </colgroup>
                        <tbody>
                            <tr>
                                <th style="text-align: center; background-color: #f8f9fa;" class="text-primary"><strong>INFORMACIÓN DEL VEHÍCULO</strong></th>
                                <th style="text-align: center; background-color: #f8f9fa;" class="text-primary"><strong>DETALLE DEL INGRESO</strong></th>
                            </th> 
                            </tr>
                            <tr>
                                <td rowspan="2">
                                    <table style="width: 100%; border-collapse: collapse;">
                                        <tr>
                                            <td style="border: none;"><strong>Denominación</strong></td>
                                            <td style="border: none;">: <?php echo ucfirst(strtolower($datos["obj_nombre"])); ?> </td>
                                            <td style="border: none;"><strong>Código Patrimonial</strong></td>
                                            <td style="border: none;">: <?php echo $datos["bien_codbarras"]; ?> </td>
                                        </tr>
                                        <tr>
                                            <td style="border: none;"><strong>Serie del Motor</strong></td>
                                            <td style="border: none;">: <?php echo $datos["nro_motor"]; ?>  </td>
                                            <td style="border: none;"><strong>Placa</strong></td>
                                            <td style="border: none;">: <?php echo $datos["bien_placa"]; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="border: none;"><strong>Serie Chasis</strong></td>
                                            <td style="border: none;">: <?php echo $datos["vin"]; ?></td>
                                            <td style="border: none;"><strong>Año de Fabricación</strong></td>
                                            <td style="border: none;">: <?php echo $datos["anio_fabricacion"]; ?>  </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td rowspan="2" colspan="2">
                                    <table style="width:100%; border-collapse: collapse;">
                                        <tr>
                                            <td style="border: none;"><strong>Val. Orden de compra S/.</strong></td>
                                            <td style="border: none;">: <?php echo $formato_valor_orden_compra; ?></td>
                                            <td style="border: none;"><strong>Fecha</strong></td>
                                            <td style="border: none;">: <?php echo date("d/m/Y", strtotime($datos["fecharegistro"])); ?></td>
                                            <td style="border: none;"><strong>Importe</strong></td>
                                            <td style="border: none;">: </td>
                                        </tr>
                                        <tr>
                                            <td style="border: none;"><strong>Pecosa</strong></td>
                                            <td style="border: none;">: </td>
                                            <td style="border: none;"><strong>Fecha</strong></td>
                                            <td style="border: none;">: </td>
                                            <td style="border: none;"><strong>Importe</strong></td>
                                            <td style="border: none;">: </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                            </tr>
                            <tr>
                                <th style="text-align: center; background-color: #f8f9fa;" class="text-primary"><strong>CARACTERISTICAS DEL VEHÍCULO</strong></th>
                                <th colspan="2" style="text-align: center; background-color: #f8f9fa;" class="text-primary"><strong>DATOS DE SEGURO Y PROPIEDAD</strong></th>
                            </tr>
                            <tr>
                                <td rowspan="1">
                                    <table style="width:100%; border-collapse: collapse;">
                                       <tr>
                                            <td style="border: none;"><strong>Marca</strong></td>
                                            <td style="border: none; ">: <?php echo ucfirst(strtolower($datos["marca_nom"])); ?> </td>
                                            <td style="border: none;"><strong>Modelo</strong></td>
                                            <td style="border: none;">: <?php echo ucfirst(strtolower($datos["modelo_nom"])); ?> </td>
                                        </tr>
                                        <tr>
                                            <td style="border: none;"><strong>Color</strong></td>
                                            <td style="border: none;">: <?php echo ucfirst(strtolower($datos["colores"])); ?></td>
                                            <td style="border: none;"><strong>Combustible</strong></td>
                                            <td style="border: none;">: <?php echo ucfirst(strtolower($datos["combustibles"])); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="border: none;"><strong>Carroceria</strong></td>
                                            <td style="border: none;">: <?php echo ucfirst(strtolower($datos["tipo_carroceria_id"])); ?></td>
                                        </tr>
                                    </table>
                                </td>
                                <td colspan="2">
                                    <table style="width:100%; border-collapse: collapse;">
                                        <tr>
                                            <td style="border: none;"><strong>Emp. Aseguradora</strong></td>
                                            <td style="border: none;" >: </td>
                                            <td style="border: none;"><strong>Poliza</strong></td>
                                            <td style="border: none;" >: </td>
                                        </tr>
                                        <tr>
                                            <td style="border: none;"><strong>Revisión Técnica</strong></td>
                                            <td style="border: none; ">: </td>
                                            <td style="border: none;"><strong>Emp. Seguros SOAT</strong></td>
                                            <td style="border: none; ">: </td>
                                        </tr>
                                        <tr>
                                            <td style="border: none;"><strong>Vigencia</strong></td>
                                            <td style="border: none; ">: </td>
                                            <td style="border: none;"><strong>N° Tarjeta Propiedad</strong></td>
                                            <td style="border: none; ">: </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <strong class="mx-2" style="padding-right: 90px;">Situación:</strong>
                                    BAJA (  )     TRAMITE DE BAJA (  )     CUSTODIA (  )     CEDIDO EN USO (  )     AFECTADO EN USO (   )
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <strong class="mx-2" style="padding-right: 90px;" >Accesorios:</strong>
                                        EXTINTOR PESO (      ) VIGENCIA (      )  GATA (      ) 
                                        TRIÁNGULO (      )   BOTIQUÍN (      )  RADIO (      ) 
                                        EQUIPO DE RADIOCOMUNICACIÓN (      )  OTROS (      )
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" >
                                    <strong class="mx-2">Ultima Observacion:</strong><br>
                                    <br>
                                    
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row mx-2 mt-5">
                    <div class="col-6 text-center">
                        <div style="margin-top: 30px; border-bottom: 1px solid #000; width: 55%; margin-left: auto; margin-right: auto;"></div>
                        <span><strong>CHOFER DEL VEHÍCULO INVENTARIADO</strong></span>
                    </div>
                    <div class="col-6 text-center">
                        <div style="margin-top: 30px; border-bottom: 1px solid #000; width: 55%; margin-left: auto; margin-right: auto;"></div>
                        <span><strong>EQUIPO / COMISIÓN DE INVENTARIO</strong></span>
                    </div>
                </div>
            </div>  
        </div>  
    </div>
    <?php require_once("../html/footer.php"); ?>
    <?php require_once("../html/mainJs.php"); ?>
    <script type="text/javascript" src="impresion.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</body>
</html>
<?php
} else {
  header("Location:" . Conectar::ruta() . "view/404/");
}
?>