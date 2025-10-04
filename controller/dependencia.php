<?php
require_once("../config/conexion.php");
require_once("../models/Dependencia.php");
require_once("../models/Bitacora.php");
require_once("../models/Stick.php");
$bitacora = new Bitacora();
$dependencia = new Dependencia();
$stick = new Stick();
switch ($_GET["op"]) {
    case "guardaryeditar":
        if (empty($_POST["objdepe_id"])) {
                $dependencia->insert_registro_objeto($_POST["fecharegistro"],$_POST["depe_id"],$_POST["obj_id"],$_POST["marca_id"],$_POST["objdepe_numserie"],$_POST["codigo_barras_input"]);
                $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
            } else {
                $dependencia->update_registro_objeto($_POST["objdepe_id"],$_POST["fecharegistro"],$_POST["depe_id"],$_POST["combo_obj_depe"],$_POST["combo_marca_obj"],$_POST["objdepe_numserie"], $_POST["codigo_barras_input"]);
                $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
            }
            break;
        break;
    case "mostrarObjCate":
        $datos = $dependencia->get_dependencia_objetos_id($_POST["objdepe_id"]);
        if (is_array($datos) == true and count($datos) <> 0) {
            foreach ($datos as $row) {
                $output["objdepe_id"] = $row["objdepe_id"];
                $output["obj_id"] = $row["obj_id"];
                $output["marca_id"] = $row["marca_id"];
                $output["cate_id"] = $row["cate_id"];
                $output["fecharegistro"] = $row["fecharegistro"];
                $output["objdepe_numserie"] = $row["objdepe_numserie"];
                $output["objdepe_codbarras"] = $row["objdepe_codbarras"];
                $output["objdepe_est"] = $row["objdepe_est"];
            }
            echo json_encode($output);
        }
        break;

    case "eliminar_bien":
        $dependencia->delete_dependencia($_POST["bien_id"]);
        $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
        break;

    case "listar":
        $datos = $dependencia->get_dependencia_datos();
        $datosRetirados = $dependencia->get_dependencia_tipo_mov(5);
        $datosRotados = $dependencia->get_dependencia_tipo_mov(4);
        $data = array();
        foreach ($datos as $row) {
            $id = $row["depe_id"];
            $data[$id] = array(
                "depe_denominacion" => $row["depe_denominacion"],
                "total_objetos" => $row["count"],
                "objetos_retirados" => 0,
                "objetos_rotados" => 0
            );
        }
        foreach ($datosRetirados as $row) {
            $id = $row["depe_id"];
            if (isset($data[$id])) {
                $data[$id]["objetos_retirados"] = $row["count"];
            }
        }
        foreach ($datosRotados as $row) {
            $id = $row["depe_id"];
            if (isset($data[$id])) {
                $data[$id]["objetos_rotados"] = $row["count"];
            }
        }
        $rows = array();
        foreach ($data as $id => $row) {
            $sub_array = array(
                $row["depe_denominacion"],
                $row["total_objetos"],
                $row["objetos_retirados"],
                $row["objetos_rotados"],
                '<button type="button" onClick="verDependencia(' . $id . ');" class="btn btn-outline-success btn-icon"><div><i class="fa fa-file"></i></div></button>',
                '<button type="button" onClick="imprimirGrupo(' . $id . ');" class="btn btn-outline-danger btn-icon"><div><i class="fa fa-print"></div></button>'
            );
            $rows[] = $sub_array;
        }
        // Construir el resultado para la respuesta JSON
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($rows),
            "iTotalDisplayRecords" => count($rows),
            "aaData" => $rows
        );
        echo json_encode($results);
        break;

    case "listarObjetos":
            $datos=$dependencia->get_dependencia_objetos($_POST["depe_id"], $_POST['gc_id']);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["obj_nombre"];
                $sub_array[] = $row["fecharegistro"];
                $sub_array[] = $row["objdepe_codbarras"];
                $sub_array[] = $row["objdepe_est"];
                $sub_array[] = '
                <td class="dropdown hidden-xs-down show">
                    <a href="#" data-toggle="dropdown" class="btn pd-y-3 tx-gray-500 hover-info" aria-expanded="true"><i class="icon ion-more"></i></a>
                    <div class="dropdown-menu dropdown-menu-left pd-10">
                        <nav class="nav nav-style-1 flex-column">
                            <a href="#" class="nav-link" onclick="ImprimirObjDepe(' . $row["objdepe_id"] . ')">Imprimir</a>
                            <a href="#" class="nav-link" onclick="editarObjDepe(' . $row["objdepe_id"] . ')">Edit</a>
                            <a href="#" class="nav-link" onclick="eliminarObjetoDepe(' . $row["objdepe_id"] . ')">Delete</a>
                            <a href="#" class="nav-link" onclick="rotarObjetoDepe(' . $row["objdepe_id"] . ')">Rotar</a>
                        </nav>
                    </div><!-- dropdown-menu -->
                </td>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
            break;
    case "combo":
        $datos = $dependencia->get_dependencia_datos();
        if (is_array($datos) == true and count($datos) > 0) {
            $html = " <option label='Seleccione'></option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['depe_id'] . "'>" . $row['denominacion_concatenada'] . "</option>";
            }
            echo $html;
        }
        break;

    case "generarBarras":
        $datos = $stick->get_nro_patrimonial($_POST['obj_id']);
        $cod_cana = $datos[0]['codigo_cana']; // OJO: fetchAll devuelve array de arrays

        // Generar el nuevo código de barras
        $nuevo_codbarras = $stick->get_next_codbarras($cod_cana);

        $output["codigo_cana"] = $cod_cana;
        $output["codigo_barras"] = $nuevo_codbarras;

        echo json_encode($output);
        break;


    case "contador_bienes_por_dependencia":
        $datos = $dependencia->contadorBienesPorDependencia();
        echo json_encode($datos);
       break;
    case "listar_cantidad_bienes_por_dependencia":
        $datos = $dependencia->listarCantidadBienesPorDependencia();
        echo json_encode($datos);
       break;
    case "listar_bienes_por_dependencia":
        $depe_id = isset($_POST["depe_id"]) ? intval($_POST["depe_id"]) : 0;
        $datos = $dependencia->listarBienesPorDependencia($depe_id);
        echo json_encode($datos);
       break;
    case "listar_bienes_por_dependencia2":
        $depe_id = isset($_POST["depe_id"]) ? intval($_POST["depe_id"]) : 0;
        $datos = $dependencia->listarBienesPorDependencia2($depe_id);
        echo json_encode($datos);
       break;
    case "baja_de_bien":
        $bien_id = isset($_POST["bien_id"]) ? $_POST["bien_id"] : null;
        $motivo_baja  = isset($_POST["motivo_baja"])  ? $_POST["motivo_baja"]  : null;
        if ($bien_id && $motivo_baja) {
            $resultado = $dependencia->darDeBajaBien($bien_id, $motivo_baja);
            if ($resultado) {
                echo json_encode(["status" => "success"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error al dar de baja el bien."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Faltan datos obligatorios."]);
        }
        break;
    case "restaurarBien":
        header('Content-Type: application/json');
        ob_clean();
        $bien_id = isset($_POST["bien_id"]) ? $_POST["bien_id"] : null;
        if ($bien_id) {
            $result = $dependencia->restaurarBien($bien_id);
            if ($result) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'No se pudo restaurar el bien.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID de bien no proporcionado.']);
        }
        exit;
    case "listarBienesBaja":
     $datos = $dependencia->listarBienesBaja();
     $data = array();

     foreach ($datos as $row) {
        $sub_array = array();
        $sub_array[] = $row["area"];
        $sub_array[] = $row["representante"];
        $sub_array[] = $row["cantidad_bienes"];
        $sub_array[] = '
                <td>
                    <div class="dropdown">
                         <a class="btn dropdown-toggle align-text-top" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                           <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-settings"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" /><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /></svg>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" onclick="verBienesBaja(\'' . $row["depe_id"] . '\')">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-history mx-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 8l0 4l2 2" /><path d="M3.05 11a9 9 0 1 1 .5 4m-.5 5v-5h5" /></svg>Ver Historial
                            </a>
                        </div>
                    </div>
                </td>
            ';

        $data[] = $sub_array;
       }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );

         echo json_encode($results);
       break;
    case "obtener_ultimo_bien_baja":
        $datos = $dependencia->obtenerUltimoBienDeBaja();
        echo json_encode($datos);
     break;
    case "select_areas":
        $data = $dependencia->obtener_areas_con_baja();
        echo json_encode($data);
     break;
    case "listarBienesBajaPorArea":
        $depe_id = $_POST["depe_id"] ?? 0;
        $bien_id = $row["bien_id"] ?? 0; 
        $datos = $dependencia->listarBienesDadosDeBajaPorDependencia($depe_id); 
        $data = [];
        foreach ($datos as $row) {
            $bien_id = $row["bien_id"];
            $sub_array = [];
            $sub_array[] = explode(' ', $row["fecha_baja"])[0];
            $sub_array[] = '<span class="badge bg-cyan text-cyan-fg selectable copiar-codbarras" data-codigo="' . $row["bien_codbarras"] . '">' . $row["bien_codbarras"] . '</span>';
            $sub_array[] = htmlspecialchars($row["obj_nombre"]);
            $sub_array[] = htmlspecialchars($row["marca_nom"]);
            $sub_array[] = htmlspecialchars($row["modelo_nom"]);
            $sub_array[] = htmlspecialchars($row["bien_numserie"]);
            $motivo = str_replace(["\r", "\n"], '', $row["motivo_baja"]);
            $sub_array[] = htmlspecialchars($motivo);
            $sub_array[] = '
            <div class="dropdown">
             <a class="btn dropdown-toggle align-text-top" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-settings"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" /><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /></svg>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#" onclick="verFormato(\'' . $row["bien_id"] . '\')">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                    <path d="M9 17h6" />
                    <path d="M9 13h6" />
                </svg>
                Ver formato
                </a>
            </div>
            </div>';


            $data[] = $sub_array;
        }
        $results = [
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        ];

        echo json_encode($results);
        break;   
    case "listar_historial_movimiento":
        $codigo = $_POST["codigo_barras"] ?? '';
        $datos = $dependencia->lista_historial_movimiento($codigo);

        if (!empty($codigo)) {
            echo json_encode($datos);
        } else {
            $data = array_map(function ($row) {
                return [
                    htmlspecialchars($row["bien_codbarras"]),
                    htmlspecialchars($row["obj_nombre"])
                ];
            }, $datos);

            echo json_encode([
                "sEcho" => 1,
                "iTotalRecords" => count($data),
                "iTotalDisplayRecords" => count($data),
                "aaData" => $data
            ]);
        }
        break;


        
    }

    