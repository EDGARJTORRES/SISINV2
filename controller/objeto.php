<?php

require_once("../config/conexion.php");

require_once("../models/Objeto.php");
require_once("../models/Bitacora.php");
$bitacora = new Bitacora();
$objeto = new Objeto();

switch ($_GET["op"]) {
    case "guardaryeditar":
        if (empty($_POST["obj_id"])) {
            $resultado = $objeto->insert_objeto($_POST["obj_nombre"], $_POST["codigo_cana"], $_POST["gc_id"]);
        } else {
            $resultado = $objeto->update_objeto($_POST["obj_id"], $_POST["obj_nombre"], $_POST["codigo_cana"]);
        }
        if ($resultado) {
            $mensaje = "Operación realizada con éxito.";
        } else {
            $mensaje = "Error: El código CANA ya existe.";
        }
        echo json_encode(["success" => $resultado, "message" => $mensaje]);
        break;
    case "guardaryeditarbien":
        if (empty($_POST["bien_id"])) {

            $bien_color_texto = "{" . $_POST["bien_color"] . "}";

            echo $bien_color_texto;
            $objeto->insert_registro_bien($_POST["fecharegistro"], $_POST["obj_id"], $_POST["modelo_id"], $_POST["bien_numserie"], $_POST["codigo_barras_input"], $bien_color_texto, $_POST["obj_dim"]);
            $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
        } else {
            $objeto->update_registro_bien($_POST["bien_id"], $_POST["fecharegistro"], $_POST["edit_obj_id"], $_POST["modelo_id"], $_POST["bien_numserie"], $_POST["codigo_barras_input"], $bien_color_texto, $_POST["obj_dim"]);
            $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
        }
        break;


    case "mostrar":
        $datos = $objeto->get_objeto_id($_POST["obj_id"]);
        if (is_array($datos) == true and count($datos) <> 0) {
            foreach ($datos as $row) {
                $output["obj_id"] = $row["obj_id"];
                $output["codigo_cana"] = $row["codigo_cana"];
                $output["obj_nombre"] = $row["obj_nombre"];
            }
            echo json_encode($output);
        }
        break;

    case "eliminar":
        $objeto->delete_objeto($_POST["obj_id"]);
        $bitacora->update_bitacora($_SESSION["usua_id_sisgi"]);
        break;
    case "eliminarBien":
        $objeto->delete_bien($_POST["bien_id"]);
        $bitacora->update_bitacora($_SESSION["usua_id_sisgi"]);
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
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M17 17v4h-10v-4" />
                            <path d="M6 10v-5h12v5" />
                            <path d="M6 14h12" />
                            <path d="M9 17h6" />
                        </svg>
                        Editar
                    </a>
                    <a class="dropdown-item" href="#" onclick="eliminarObjeto(' .$row["obj_id"]  . ')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M6 6l12 12" />
                            <path d="M6 18l12 -12" />
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
        $datos = $objeto->get_bien_repre($_POST['pers_id']);
        $data = array();

        // Recorre los datos obtenidos de los bienes representados
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["bien_codbarras"];
            $sub_array[] = $row["obj_nombre"];

            // Lista para almacenar los nombres de colores
            $colorNames = [];

            // Eliminar signos de llaves de la cadena de colores
            $color_ids_string = trim($row["bien_color"], "{}");

            // Separar los IDs de color por comas
            $color_ids = explode(",", $color_ids_string);

            // Obtener los nombres de color para cada ID
            foreach ($color_ids as $color_id) {
                $colorData = $objeto->get_color($color_id);

                // Verificar si $colorData no está vacío antes de acceder a él
                if (!empty($colorData) && isset($colorData[0]["color_nom"])) {
                    // Agregar el nombre del color a la lista de nombres de color
                    $colorNames[] = $colorData[0]["color_nom"];
                }
            }

            // Unir los nombres de color en una cadena separada por comas
            $colorNameString = implode(", ", $colorNames);

            // Agregar la cadena de colores concatenada al sub_array
            $sub_array[] = $colorNameString;

            // Agrega los demás datos al sub_array
            // Generar el select para el estado del bien
            $estadoSelect =
                "  <style>
                table tr td select {
                  width: 100%;
                  padding: 0.5rem;
                  border-radius: 0.25rem;
                  border: 1px solid #ced4da;
                  font-size: 1rem;
                  background-color: white;
                  color: #8e8ba1;
                  outline: none;
                }
              </style><select class='form-select'>" .
                "<option value='N'" .
                ($row["bien_est"] === "N" ? " selected" : "") .
                ">N - Nuevo</option>" .
                "<option value='B'" .
                ($row["bien_est"] === "B" ? " selected" : "") .
                ">B - Bueno</option>" .
                "<option value='R'" .
                ($row["bien_est"] === "R" ? " selected" : "") .
                ">R - Regular</option>" .
                "<option value='M'" .
                ($row["bien_est"] === "M" ? " selected" : "") .
                ">M - Malo</option>" .
                "</select>";

            $sub_array[] = $estadoSelect; // Añadir el select al sub_array
            $sub_array[] = '<input type="text" class="form-control" placeholder="Comentario">';
            $sub_array[] = '<button type="button"  onclick="verDatosbien(\''. $row["bien_codbarras"] .'\')" id="' . $row["bien_codbarras"] . '" class="btn btn-outline-warning btn-icon"><div><i class="fa fa-eye"></i></div></button>';
            $sub_array[] = '<input type="checkbox" name="select_bien" value="' . $row["obj_id"] . '" style="transform: scale(1.5);" onclick="validarCheckbox(this)">';

            $data[] = $sub_array;
        }

        // Prepara la respuesta en formato JSON
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );

        // Devuelve la respuesta JSON
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
        $datos = $objeto->get_codinterno();
        if ($datos !== false) {
            echo $datos['bien_id']; // Devuelve solo el valor de bien_id
        } else {
            // Manejar el caso en el que no se obtengan datos
            echo "No se encontraron datos";
        }
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
}
