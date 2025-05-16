<?php
require_once("../config/conexion.php");
require_once("../models/Usuario.php");
require_once("../models/Bitacora.php");
$bitacora = new Bitacora();
$usuario =  new Usuario();
switch ($_GET["op"]) {
    case "mostrar":
        $datos = $usuario->get_usuarios($_POST["usua_id"]);
        if (is_array($datos) == true and count($datos) <> 0) {
            foreach ($datos as $row) {
                $output["usua_id"] = $row["usua_id"];
                $output["usu_nom"] = $row["usu_nom"];
                $output["usu_apep"] = $row["usu_apep"];
                $output["usu_apem"] = $row["usu_apem"];
                $output["usu_pass"] = $row["usu_pass"];
                $output["usu_rol"] = $row["usu_rol"];
                $output["usu_dni"] = $row["usu_dni"];
            }

            echo json_encode($output);
        }
        break;
    case "mostrarPerfil":
        $datos = $usuario->get_usuario_x_id($_SESSION["usua_id_siin"]);
        if (is_array($datos) == true and count($datos) <> 0) {
            foreach ($datos as $row) {
                $output["pers_nombre"] = $row["pers_nombre"];
                $output["pers_apelpat"] = $row["pers_apelpat"];
                $output["pers_apelmat"] = $row["pers_apelmat"];
                $output["pers_dni"] = $row["pers_dni"];
            }
            echo json_encode($output);
        }
        break;
    case "cambiar_contrasena":
        $id =  $_SESSION["usua_id_siin"];
        $claveantigua =  $_POST["usua_pass"];
        $clave = $_POST["nuevaPass"];
        $clave2 = $_POST["confirmarPass"];

        $data = $usuario->cambiar_contrasena_API($id, $claveantigua, $clave, $clave2);

        echo $data;

        break;
    case "eliminar":
        $usuario->delete_usuario($_POST["usua_id"]);
        $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
        break;
    case "listar":
        $datos = $usuario->get_usuario();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["pers_dni"];
            $sub_array[] = $row["pers_nombre"];
            $sub_array[] = $row["pers_apelpat"];
            $sub_array[] = $row["pers_apelmat"];
            if ($row["perf_id"] == 2) {
                $sub_array[] = "Usuario";
            } else {
                $sub_array[] = "Admin";
            }
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

    case "consulta_dni":
        $datos = $usuario->get_usuario_x_dni($_POST["usu_dni"]);
        if (is_array($datos) == true and count($datos) <> 0) {
            foreach ($datos as $row) {
                $output["usua_id"] = $row["usua_id"];
                $output["usu_nom"] = $row["usu_nom"];
                $output["usu_apep"] = $row["usu_apep"];
                $output["usu_apem"] = $row["usu_apem"];
                $output["usu_sex"] = $row["usu_sex"];
                $output["usu_pass"] = $row["usu_pass"];
                $output["usu_rol"] = $row["usu_rol"];
                $output["usu_dni"] = $row["usu_dni"];
            }
            echo json_encode($output);
        }
        break;
    case "listar_detalle_usu":
        $datos = $usuario->get_usu_modal($_POST["area_id"]);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = "<input type='checkbox' name='detallecheck[]' value='" . $row["pers_id"] . "'>";
            $sub_array[] = $row["pers_dni"];
            $sub_array[] = $row["pers_nombre"];
            $sub_array[] = $row["pers_apelpat"];
            $sub_array[] = $row["pers_apelmat"];
            if ($row["perf_id"] == 4) {
                $sub_array[] = "Usuario";
            } else {
                $sub_array[] = "Admin";
            }

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
    case "listar_area_usu":
        $datos = $usuario->get_area_usu_x_id($_POST["area_id"]);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["pers_dni"];
            $sub_array[] = $row["pers_nombre"];
            $sub_array[] = $row["pers_apelpat"];
            $sub_array[] = $row["pers_apelmat"];
            $sub_array[] = '<button type="button" onClick="eliminar(' . $row["areausu_id"] . ');"  id="' . $row["areausu_id"] . '" class="btn btn-outline-danger btn-icon"><div><i class="fa fa-close"></i></div></button>';
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
