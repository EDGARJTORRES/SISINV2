<?php
require_once("../config/conexion.php");
require_once("../models/Clase.php");
require_once("../models/Bitacora.php");
$bitacora = new Bitacora();
$clase = new Clase();
switch ($_GET["op"]) {
    case "guardaryeditar":
        if (empty($_POST["clase_id"])) {
            $clase->insert_clase($_POST["clase_nom"],$_POST["clase_cod"] );
            $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
        } else {
            $clase->update_clase($_POST["clase_id"],$_POST["clase_nom"],$_POST["clase_cod"]);
            $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
        }
        break;


    case "mostrar":
        $datos = $clase->get_clase_id($_POST["clase_id"]);
        if (is_array($datos) == true and count($datos) <> 0) {
            foreach ($datos as $row) {
                $output["clase_id"] = $row["clase_id"];
                $output["clase_nom"] = $row["clase_nom"];
                $output["clase_cod"] = $row["clase_cod"];
            }
            echo json_encode($output);
        }
        break;

    case "eliminar":
        $clase->delete_clase($_POST["clase_id"]);
        $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
        break;
    case "listar":
        $datos = $clase->get_clase();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = '
            <label class="checkbox-wrapper-46">
                <input type="checkbox" class="inp-cbx clase-checkbox" data-id="' . htmlspecialchars($row["clase_id"]) . '" value="' . htmlspecialchars($row["clase_id"]) . '" />
                <span class="cbx">
                <span>
                    <svg viewBox="0 0 12 10" height="10px" width="12px">
                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                    </svg>
                </span>
                <span></span>
                </span>
            </label>';
            $sub_array[] = $row["clase_cod"];
            $sub_array[] = $row["clase_nom"];
            $sub_array[] = '
            <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                </svg> Acciones
            </button>
            <ul class="dropdown-menu">
                <li>
                <a class="dropdown-item d-flex align-items-center gap-2 text-warning" href="#" onclick="editarclase(' . $row["clase_id"] . ')">
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
                <a class="dropdown-item d-flex align-items-center gap-2 text-danger" href="#" onclick="eliminarclase(' . $row["clase_id"] . ')">
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
            </div>
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
    case "eliminar_gc":
        $ids = isset($_POST['ids']) ? $_POST['ids'] : [];
        if (!empty($ids)) {
            foreach ($ids as $id) {
                $clase->delete_clase(intval($id));
            }
            echo json_encode(['status' => 'ok']);
        } else {
            echo json_encode(['status' => 'no_ids']);
        }
      break;    
    case "listar_gg_clase_actuales":
        $datos = $clase->get_clase_combo($_POST['gg_id']);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["clase_nom"];
            $sub_array[] = '<button type="button" onClick="quitarClase(' . $row["gc_id"] . ');"  id="' . $row["gc_id"] . '"  class="btn bg-danger text-light " style="width: 35px; height: 35px; padding: 0;">
                                <svg  style="transform: translateX(5px);" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-backspace">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 6a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-11l-5 -5a1.5 1.5 0 0 1 0 -2l5 -5z" /><path d="M12 10l4 4m0 -4l-4 4" />
                                </svg>
                            </button>';
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
    case "combo":
        $datos = $clase->get_clase_combo($_POST['gg_id']);
        if (is_array($datos) == true and count($datos) > 0) {
            $html = " <option label='Seleccione'></option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['gc_id'] . "'>" . $row['clase_cod'] . " - " . $row['clase_nom'] . "</option>";
            }
            echo $html;
        }
        break;
    case "eliminar_clase_usu":
        $clase->eliminar_clase_usu($_POST["claseusua_id"]);
        $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
        break;
    case "quitarclase":
        $clase->quitarclase($_POST["gc_id"]);
        $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
        break;
}
