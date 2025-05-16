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
            $sub_array[] = $row["clase_cod"];
            $sub_array[] = $row["clase_nom"];
            $sub_array[] = '<button type="button" onClick="editarclase(' . $row["clase_id"] . ');"  id="' . $row["clase_id"] . '" class="btn btn-outline-warning btn-icon"><div><i class="fa fa-edit"></i></div></button>';
            $sub_array[] = '<button type="button" onClick="eliminarclase(' . $row["clase_id"] . ');"  id="' . $row["clase_id"] . '" class="btn btn-outline-danger btn-icon"><div><i class="fa fa-close"></i></div></button>';
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
    case "listar_gg_clase_actuales":
        $datos = $clase->get_clase_combo($_POST['gg_id']);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["clase_nom"];
            $sub_array[] = '<button type="button" onClick="quitarClase(' . $row["gc_id"] . ');"  id="' . $row["gc_id"] . '" class="btn btn-outline-danger btn-icon"><div><i class="fa fa-close"></i></div></button>';
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
                $html .= "<option value='" . $row['gc_id'] . "'>" . $row['clase_nom'] . "</option>";
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
