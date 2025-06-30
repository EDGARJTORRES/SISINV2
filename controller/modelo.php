<?php
    require_once("../config/conexion.php");
    require_once("../models/Modelo.php");
    require_once("../models/Bitacora.php");
    $bitacora = new Bitacora();
    $modelo = new Modelo();
    switch($_GET["op"]){
        case "guardaryeditar":
            if (empty($_POST["modelo_id"])) {
                $modelo->insert_modelo($_POST["modelo_nom"], $_POST["combo_marca_obj"]);
                $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
            } else {
               $modelo->update_modelo($_POST["modelo_id"], $_POST["modelo_nom"], $_POST["combo_marca_obj"]);
                $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
            }
            break;
        case "mostrar":
            $datos = $modelo->get_modelo_id($_POST["modelo_id_input"]);
            if (is_array($datos) && count($datos) > 0) {
                $output["modelo_id"] = $datos["modelo_id"];
                $output["modelo_nom"] = $datos["modelo_nom"];
                $output["marca_id"] = $datos["marca_id"];
                $output["marca_nom"] = $datos["marca_nom"];
                echo json_encode($output);
            }
            break;
   
        case "eliminar":
            $modelo->delete_modelo($_POST["modelo_id"]);
            $bitacora->update_bitacora($_SESSION["usua_id_sisgi"]);
            break;
        case "eliminar_modelos":
            $ids = isset($_POST['ids']) ? $_POST['ids'] : [];
            if (!empty($ids)) {
                foreach ($ids as $id) {
                    $modelo->delete_modelo(intval($id));
                }
                echo json_encode(['status' => 'ok']);
            } else {
                echo json_encode(['status' => 'no_ids']);
            }
            break; 
        case "listar":
            $datos = $modelo->get_modelo();
            $data = array();
            foreach ($datos as $row) {
                $sub_array = array();
                $sub_array[] = '
                <label class="checkbox-wrapper-46">
                    <input type="checkbox" class="inp-cbx modelo-checkbox" data-id="' . htmlspecialchars($row["modelo_id"]) . '" value="' . htmlspecialchars($row["modelo_id"]) . '" />
                    <span class="cbx">
                        <span>
                            <svg viewBox="0 0 12 10" height="10px" width="12px">
                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                            </svg>
                        </span>
                        <span></span>
                    </span>
                </label>';
                $sub_array[] = $row["marca_nom"];
                $sub_array[] = $row["modelo_nom"];
                $sub_array[] = '
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Acciones
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 text-warning" href="#" onclick="editarmodelo(' . $row["modelo_id"] . ')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icon-tabler-edit">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                    <path d="M16 5l3 3" />
                                </svg>
                                Editar
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 text-danger" href="#" onclick="eliminarmodelo(' . $row["modelo_id"] . ')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icon-tabler-backspace">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M20 6a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-11l-5 -5a1.5 1.5 0 0 1 0 -2l5 -5z" />
                                    <path d="M12 10l4 4m0 -4l-4 4" />
                                </svg>
                                Eliminar
                            </a>
                        </li>
                    </ul>
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

            }
?>