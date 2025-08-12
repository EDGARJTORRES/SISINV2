<?php
require_once("../config/conexion.php");
require_once("../models/Color.php");
require_once("../models/Bitacora.php");
$bitacora = new Bitacora();
$color = new Color();
switch ($_GET["op"]) {
    case "guardaryeditar":
        $color_nom = $_POST["color_nom"] ?? null;
        $color_id = $_POST["color_id"] ?? null;

        if ($color_nom === null || trim($color_nom) === "") {
            echo "Error: El campo 'color_nom' es obligatorio.";
            exit();
        }

        if (empty($color_id)) {
            $color->insert_color($color_nom);
        } else {
            $color->update_color($color_id, $color_nom);
        }

        $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
        break;


    case "mostrar":
        $datos = $color->get_color_id($_POST["color_id"]);
        if (is_array($datos) == true and count($datos) <> 0) {
            foreach ($datos as $row) {
                $output["color_id"] = $row["color_id"];
                $output["color_nom"] = $row["color_nom"];
            }
            echo json_encode($output);
        }
        break;

    case "eliminar":
        $ids = isset($_POST['ids']) ? $_POST['ids'] : [];
        if (!empty($ids)) {
            foreach ($ids as $id) {
                $color->delete_color(intval($id));
            }
            $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
            echo json_encode(['status' => 'ok']);
        } else {
            echo json_encode(['status' => 'no_ids']);
        }
        break;
    case "listar":
        $datos = $color->get_color();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = '
            <label class="checkbox-wrapper-46">
                <input type="checkbox" class="inp-cbx color-checkbox" data-id="' . htmlspecialchars($row["color_id"]) . '" value="' . htmlspecialchars($row["color_id"]) . '" />
                <span class="cbx">
                <span>
                    <svg viewBox="0 0 12 10" height="10px" width="12px">
                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                    </svg>
                </span>
                <span></span>
                </span>
            </label>';
            $sub_array[] = $row["color_nom"];
            $sub_array[] = '
            <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                </svg> Acciones
            </button>
            <ul class="dropdown-menu">
                <li>
                <a class="dropdown-item d-flex align-items-center gap-2 text-warning" href="#" onClick="editarcolor(' . $row["color_id"] . ');">
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
                <a class="dropdown-item d-flex align-items-center gap-2 text-danger" href="#" onClick="eliminarcolor(' . $row["color_id"] . ');" >
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
    case "eliminar_colores":
        $ids = isset($_POST['ids']) ? $_POST['ids'] : [];
        if (!empty($ids)) {
            foreach ($ids as $id) {
                $color->delete_color(intval($id));
            }
            echo json_encode(['status' => 'ok']);
        } else {
            echo json_encode(['status' => 'no_ids']);
        }
      break;    
}
