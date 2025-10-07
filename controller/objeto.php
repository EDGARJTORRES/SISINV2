<?php
require_once("../config/conexion.php");
require_once("../models/Objeto.php");
require_once("../models/Bitacora.php");
$bitacora = new Bitacora();
$objeto = new Objeto();
switch ($_GET["op"]) {
    case "guardaryeditar":
        $obj_img = "";
        if (isset($_FILES["obj_img"]) && $_FILES["obj_img"]["error"] === UPLOAD_ERR_OK) {
            $directorio = __DIR__ . "/../img/"; 
            if (!file_exists($directorio)) {
                mkdir($directorio, 0777, true);
            }
            $nombreArchivo = time() . "_" . basename($_FILES["obj_img"]["name"]);
            $rutaDestino = $directorio . $nombreArchivo;
            if (move_uploaded_file($_FILES["obj_img"]["tmp_name"], $rutaDestino)) {
                $obj_img = "img/" . $nombreArchivo;
            } else {
                error_log(" Error al mover archivo: " . $_FILES["obj_img"]["error"]);
            }
        }
        if (empty($_POST["obj_id"])) {
            $resultado = $objeto->insert_objeto(
                $_POST["obj_nombre"], 
                $_POST["codigo_cana"], 
                $obj_img, 
                $_POST["gc_id"]
            );
        } else {
            $resultado = $objeto->update_objeto(
                $_POST["obj_id"], 
                $_POST["obj_nombre"], 
                $_POST["codigo_cana"], 
                $obj_img, 
                $_POST["gc_id"]
            );
        }
        echo json_encode([
            "success" => $resultado,
            "message" => $resultado ? "Operación realizada con éxito." : "Error: El código CANA ya existe."
        ]);
        break;
    case "guardaryeditarbien":
       $bien_color = is_array($_POST["bien_color"]) ? $_POST["bien_color"] : explode(',', $_POST["bien_color"]);
       $bien_color_texto = '{' . implode(',', $bien_color) . '}';
        if (empty($_POST["bien_id"])) {
            $objeto->insert_registro_bien(
                $_POST["fecharegistro"],
                $_POST["obj_id"],
                $_POST["modelo_id"],
                $_POST["bien_numserie"],
                $_POST["codigo_barras_input"],
                $bien_color_texto,
                $_POST["obj_dim"],
                $_POST["procedencia"],
                $_POST["val_adq"],
                $_POST["doc_adq"],
                $_POST["bien_obs"],
                $_POST["bien_cuenta"],
                $_POST["bien_placa"]
            );
            echo json_encode([
                "status" => "ok",
                "bien_id" => $nuevo_bien_id
            ]);
        } else {
            $objeto->update_registro_bien(
                $_POST["bien_id"],
                $_POST["fecharegistro"],
                $_POST["obj_id"], 
                $_POST["modelo_id"],
                $_POST["bien_numserie"],
                $_POST["codigo_barras_input"],
                $bien_color_texto,
                $_POST["obj_dim"],
                $_POST["val_adq"],
                $_POST["doc_adq"],
                $_POST["bien_obs"],
                $_POST["bien_cuenta"],
                $_POST["bien_placa"],
                $_POST["procedencia"]
            );
        }
        break;
    case "mostrar":
        $datos = $objeto->get_objeto_id($_POST["obj_id"]);
        if (is_array($datos) && count($datos) > 0) {
            foreach ($datos as $row) {
                $output["obj_id"] = $row["obj_id"];
                $output["codigo_cana"] = $row["codigo_cana"];
                $output["obj_nombre"] = $row["obj_nombre"];
                $output["obj_img"] = !empty($row["obj_img"]) ? $row["obj_img"] : "img/default.png";
            }
            echo json_encode($output);
        }
        break;


    case "eliminar":
        $objeto->delete_objeto($_POST["obj_id"]);
        $bitacora->update_bitacora($_SESSION["usua_id_sisgi"]);
        break;
    case "eliminarBien":
        header('Content-Type: application/json');
        $bien_id = $_POST["bien_id"];
        $tieneHistorial = $objeto->verificar_historial_bien($bien_id);
        if ($tieneHistorial) {
            echo json_encode([
                "status" => "error",
                "message" => "Este bien tiene historial o dependencias asignadas."
            ]);
        } else {
            $objeto->delete_bien($bien_id); // ← ya no lanza error
            echo json_encode([
                "status" => "success",
                "message" => "El bien ha sido eliminado correctamente."
            ]);
        }
        break;
    case "listar":
        $datos = $objeto->get_objeto($_POST['gc_id']);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["obj_id"];
            $sub_array[] = $row["obj_nombre"];
            $sub_array[] = $row["codigo_cana"];
            $sub_array[] = '
            <div class="dropdown">
                <a class="btn dropdown-toggle align-text-top" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                Acciones
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#" onclick="editarObjeto(' . $row["obj_id"] . ')">
                         <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit mx-2 "><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                        Editar
                    </a>
                    <a class="dropdown-item text-danger" href="#" onclick="eliminarObjeto(' .$row["obj_id"]  . ')">
                        <svg xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-backspace mx-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 6a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-11l-5 -5a1.5 1.5 0 0 1 0 -2l5 -5z" /><path d="M12 10l4 4m0 -4l-4 4" />
                        </svg>
                        Eliminar
                    </a>
                </div>
            </div>';
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
        
    case "listarBienRepre":
        // Protege la entrada
        $pers_id = $_POST['pers_id'] ?? null;

        if (!$pers_id) {
            echo json_encode([
                "sEcho" => 1,
                "iTotalRecords" => 0,
                "iTotalDisplayRecords" => 0,
                "aaData" => [],
                "error" => "pers_id no proporcionado"
            ]);
            exit;
        }

        $datos = $objeto->get_bien_repre($pers_id);
        $data = array();

        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["bien_codbarras"];
            $sub_array[] = $row["obj_nombre"];

            // Obtener nombres de colores
            $colorNames = [];
            $color_ids_string = trim($row["bien_color"], "{}");
            $color_ids = explode(",", $color_ids_string);

            foreach ($color_ids as $color_id) {
                $colorData = $objeto->get_color($color_id);
                if (!empty($colorData) && isset($colorData[0]["color_nom"])) {
                    $colorNames[] = $colorData[0]["color_nom"];
                }
            }

            $colorNameString = implode(", ", $colorNames);
            $sub_array[] = $colorNameString;

            // Select de estado SIN incluir <style>
            $estadoSelect = "<select class='form-select'>";
            $estadoSelect .= "<option value='N'" . ($row["bien_est"] === "N" ? " selected" : "") . ">N - Nuevo</option>";
            $estadoSelect .= "<option value='B'" . ($row["bien_est"] === "B" ? " selected" : "") . ">B - Bueno</option>";
            $estadoSelect .= "<option value='R'" . ($row["bien_est"] === "R" ? " selected" : "") . ">R - Regular</option>";
            $estadoSelect .= "<option value='M'" . ($row["bien_est"] === "M" ? " selected" : "") . ">M - Malo</option>";
            $estadoSelect .= "</select>";

            $sub_array[] = $estadoSelect;

            // Comentario input
            $sub_array[] = '<input type="text" class="form-control" placeholder="Comentario">';
            // Ícono Ver (solo el icono, color fijo)
            $sub_array[] = '
            <svg xmlns="http://www.w3.org/2000/svg" 
                onclick="verDatosbien(\'' . htmlspecialchars($row["bien_codbarras"]) . '\')" 
                class="icon icon-tabler icon-tabler-eye" style="height: 30px; width: 30px; cursor: pointer;"
                width="30" height="30" viewBox="0 0 24 24" 
                stroke-width="2" stroke="#0d6efd" fill="none" 
                stroke-linecap="round" stroke-linejoin="round"
                style="cursor: pointer; transition: transform 0.2s ease, stroke 0.2s ease;"
                title="Ver detalles">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                <path d="M21 12c-2.4 4 -5.4 6 -9 6s-6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6s6.6 2 9 6" />
            </svg>
            <style>
            .icon-tabler-eye:hover {
            transform: scale(1.15);
            stroke: #6610f2;
            }
            </style>';
            $obj_id = $row["obj_id"] ?? '';
            $sub_array[] = '
            <label class="checkbox-wrapper-46">
                <input type="checkbox" name="select_bien" 
                    class="inp-cbx gb-checkbox" 
                    value="' . htmlspecialchars($obj_id) . '" 
                    onclick="validarCheckbox(this)" 
                    style="transform: scale(1.5);" />
                <span class="cbx">
                    <span>
                        <svg viewBox="0 0 12 10" height="10px" width="12px">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                        </svg>
                    </span>
                    <span></span>
                </span>
            </label>';



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
    case "combo_clase":
        $datos = $objeto->get_objeto_categoria($_POST['gc_id']);
        if (is_array($datos) == true and count($datos) > 0) {
            $html = " <option label='Seleccione'></option>";
            foreach ($datos as $row) {
                // Agregar el código cana como parte del valor y del texto de la opción
                $html .= "<option value='" . $row['obj_id'] . "' data-codigo-cana='" . $row['codigo_cana'] . "'>" . $row['obj_nombre'] . "</option>";
            }
            echo $html;
        }
        break;
    case "combo_modelo":
        $datos = $objeto->get_objeto_modelo($_POST['marca_id']);
        if (is_array($datos) == true and count($datos) > 0) {
            $html = " <option label='Seleccione'></option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['modelo_id'] . "'>" . $row['modelo_nom'] . "</option>";
            }
            echo $html;
        }
        break;
    case "combo_color":
        $datos = $objeto->get_colores();
        if (is_array($datos) == true and count($datos) > 0) {
            $html = "";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['color_id'] . "'>" . $row['color_nom'] . "</option>";
            }
            echo $html;
        }
        break;
    case "getcodinterno":
        $codigo_cana = $_POST['codigo_cana'];
        $correlativo = $objeto->get_codinterno($codigo_cana);

        echo $correlativo ?? "0000";
        break;

    case "buscar_obj_barras":
        $datos = $objeto->buscar_obj_barras_simple($_POST['cod_bar']);
        $output = array();
        if (is_array($datos) == true and count($datos) <> 0) {
            foreach ($datos as $row) {
                $output["bien_id"] = $row["bien_id"];
                $output["bien_codbarras"] = $row["bien_codbarras"];
                $output["fecharegistro"] = $row["fecharegistro"];
                $output["obj_nombre"] = $row["obj_nombre"];
                $output["bien_numserie"] = $row["bien_numserie"];
                $output["bien_est"] = $row["bien_est"];
                $output["procedencia"] = $row["procedencia"];
                $output["bien_dim"] = $row["bien_dim"];
                $output["bien_color"] = $row["bien_color"];
                $output["depe_denominacion"] = $row["depe_denominacion"];
            }
            echo json_encode($output);
        } else echo json_encode($output);
        break;
    case "buscar_obj_barras_consultas":
            $datos = $objeto->buscar_obj_barras_simple($_POST['cod_bar']);
            $output = array();
            if (is_array($datos) == true and count($datos) <> 0) {
                foreach ($datos as $row) {
                    $output["bien_id"] = $row["bien_id"];
                    $output["bien_codbarras"] = $row["bien_codbarras"];
                    $output["fecharegistro"] = $row["fecharegistro"];
                    $output["obj_nombre"] = $row["obj_nombre"];
                    $output["bien_numserie"] = $row["bien_numserie"];
                    if($row["bien_est"] =='A'){
                        $output["bien_est"] = 'Activo';
                    }else if($row["bien_est"] =='N'){
                        $output["bien_est"] = 'Nuevo';
                    }else if($row["bien_est"] =='B'){
                        $output["bien_est"] = 'Bueno';
                    }else if($row["bien_est"] =='R'){
                        $output["bien_est"] = 'Regular';
                    }else{
                        $output["bien_est"] = 'Malo';
                    }
                    $output["procedencia"] = $row["procedencia"];
                    $output["bien_dim"] = $row["bien_dim"];
                    $output["val_adq"] = $row["val_adq"];
                    $output["doc_adq"] = $row["doc_adq"];
                    $output["bien_obs"] = $row["bien_obs"];
                    $output["marca_nom"] = $row["marca_nom"];
                    $output["modelo_nom"] = $row["modelo_nom"];
                    $output["bien_color"] = $row["bien_color"];
                    $output["depe_denominacion"] = $row["depe_denominacion"];
                    $output["nombre_completo"] = $row["nombre_completo"];
                    $output["pers_dni"] = $row["pers_dni"];
                }
                echo json_encode($output);
            } else echo json_encode($output);
            break;
    case "buscar_obj_barras_consultas2":
        $datos = $objeto->buscar_obj_barras_simple($_POST['cod_bar']);
        $output = array();
        if (is_array($datos) == true and count($datos) <> 0) {
            foreach ($datos as $row) {
                $output["bien_id"] = $row["bien_id"];
                $output["bien_codbarras"] = $row["bien_codbarras"];
                $output["fecharegistro"] = $row["fecharegistro"];
                $output["obj_nombre"] = $row["obj_nombre"];
                $output["obj_img"] = $row["obj_img"];
                $output["bien_obs"] = $row["bien_obs"];
                if($row["bien_est"] =='A'){
                    $output["bien_est"] = 'Activo';
                }else if($row["bien_est"] =='N'){
                    $output["bien_est"] = 'Nuevo';
                }else if($row["bien_est"] =='B'){
                    $output["bien_est"] = 'Bueno';
                }else if($row["bien_est"] =='R'){
                    $output["bien_est"] = 'Regular';
                }else{
                    $output["bien_est"] = 'Malo';
                }
                $output["procedencia"] = $row["procedencia"];
                $output["bien_dim"] = $row["bien_dim"];
                $output["val_adq"] = $row["val_adq"];
                $output["doc_adq"] = $row["doc_adq"];
                $output["bien_obs"] = $row["bien_obs"];
                $output["marca_nom"] = $row["marca_nom"];
                $output["modelo_nom"] = $row["modelo_nom"];
                $output["bien_color"] = $row["bien_color"];
                $output["depe_denominacion"] = $row["depe_denominacion"];
                $output["nombre_completo"] = $row["nombre_completo"];
                $output["pers_dni"] = $row["pers_dni"];
            }
            echo json_encode($output);
        } else echo json_encode($output);
        break;
    case "buscar_bien_id":
        $datos = $objeto->buscar_bien_id($_POST['bien_id']);
        $output = array();
        if (is_array($datos) == true and count($datos) <> 0) {
            foreach ($datos as $row) {
                $output["bien_id"] = $row["bien_id"];
                $output["gc_id"] = $row["gc_id"];
                $output["clase_nom"] = $row["clase_nom"];
                $output["gg_id"] = $row["gg_id"];
                $output["gg_nom"] = $row["gg_nom"];
                $output["obj_id"] = $row["obj_id"];
                $output["bien_codbarras"] = $row["bien_codbarras"];
                $output["fecharegistro"] = $row["fecharegistro"];
                $output["obj_nombre"] = $row["obj_nombre"];
                $output["marca_id"] = $row["marca_id"];
                $output["marca_nom"] = $row["marca_nom"];
                $output["modelo_id"] = $row["modelo_id"];
                $output["modelo_nom"] = $row["modelo_nom"];
                $output["bien_numserie"] = $row["bien_numserie"];
                $output["bien_est"] = $row["bien_est"];
                $output["bien_dim"] = $row["bien_dim"];
                $output["bien_color"] = $row["bien_color"];
                $output["depe_denominacion"] = $row["depe_denominacion"];
            }
            echo json_encode($output);
        } else echo json_encode($output);
        break;
    case "get_color":
        $datos = $objeto->get_color($_POST['color_id']);
        $output = array();
        if (is_array($datos) == true and count($datos) <> 0) {
            foreach ($datos as $row) {
                $output["color_nom"] = $row["color_nom"];
            }
            echo json_encode($output);
        } else echo json_encode($output);
        break;
    case "mostrar_bien_id":
        $datos = $objeto->mostrar_bien_id($_POST['bien_id']);
        $output = array();
        if (is_array($datos) && count($datos) > 0) {
            foreach ($datos as $row) {
                $output["bien_id"] = $row["bien_id"];
                $output["gc_id"] = $row["gc_id"];
                $output["clase_nom"] = $row["clase_nom"];
                $output["gg_id"] = $row["gg_id"];
                $output["gg_nom"] = $row["gg_nom"];
                $output["obj_id"] = $row["obj_id"];
                $output["bien_codbarras"] = $row["bien_codbarras"];
                $output["fecharegistro"] = $row["fecharegistro"];
                $output["obj_nombre"] = $row["obj_nombre"];
                $output["marca_id"] = $row["marca_id"];
                $output["marca_nom"] = $row["marca_nom"];
                $output["modelo_id"] = $row["modelo_id"];
                $output["modelo_nom"] = $row["modelo_nom"];
                $output["bien_numserie"] = $row["bien_numserie"];
                $output["bien_est"] = $row["bien_est"];
                $output["bien_dim"] = $row["bien_dim"];
                $output["bien_color"] = $row["bien_color"];
                $output["depe_denominacion"] = $row["depe_denominacion"];
                $output["val_adq"] = $row["val_adq"];
                $output["doc_adq"] = $row["doc_adq"];
                $output["bien_obs"] = $row["bien_obs"];
                $output["bien_cuenta"] = $row["bien_cuenta"];
                $output["procedencia"] = $row["procedencia"];
                $output["bien_placa"] = $row["bien_placa"];
            }
        }
        echo json_encode($output);
       break;
    case "combo_objetos_todos":
        $datos = $objeto->get_todos_objetos();
        $html = "<option value='' disabled selected>Seleccione</option>";
        foreach ($datos as $row) {
            $texto = $row['codigo_cana'] . " - " . $row['obj_nombre'];
            $html .= "<option value='" . $row['obj_id'] . "' data-codigo-cana='" . $row['codigo_cana'] . "'>" . $texto . "</option>";
        }
        echo $html;
        break;

}