<?php

require_once("../config/conexion.php");

require_once("../models/GrupoGenerico.php");
require_once("../models/Bitacora.php");
$bitacora = new Bitacora();
$grupogenerico = new GrupoGenerico();

switch ($_GET["op"]) {

    case "guardaryeditar":
        if (empty($_POST["ggidgene"])) {
            $grupogenerico->insert_grupogenerico($_POST["ggnomgene"], $_POST["ggcodgene"]);
            $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
        } else {
            $grupogenerico->update_grupogenerico($_POST["ggidgene"], $_POST["ggnomgene"], $_POST["ggcodgene"]);
            $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
        }
        break;


    case "mostrar":
        $datos = $grupogenerico->get_grupogenerico_id($_POST["gg_id_input"]);
        if (is_array($datos) == true and count($datos) <> 0) {
            foreach ($datos as $row) {
                $output["gg_id"] = $row["gg_id"];
                $output["gg_nom"] = $row["gg_nom"];
                $output["gg_cod"] = $row["gg_cod"];
            }
            echo json_encode($output);
        }
        break;

    case "eliminar":
        $grupogenerico->delete_grupogenerico($_POST["gg_id"]);
        $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
        break;
    case "listar":
        $datos = $grupogenerico->get_grupogenerico();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["gg_cod"];
            $sub_array[] = $row["gg_nom"];
            $sub_array[] = '<button type="button" onClick="editarGG(' . $row["gg_id"] . ');"  id="' . $row["gg_id"] . '" class="btn btn-outline-warning btn-icon"><div><i class="fa fa-edit"></i></div></button>';
            $sub_array[] = '<button type="button" onClick="eliminarGG(' . $row["gg_id"] . ');"  id="' . $row["gg_id"] . '" class="btn btn-outline-danger btn-icon"><div><i class="fa fa-close"></i></div></button>';
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
        case "listar_gg_bienes":
            $datos = $grupogenerico->get_grupogenerico_bienes();
            $data = array();
            foreach ($datos as $row) {
                $sub_array = array();
                $sub_array[] = $row["bien_id"];
                $sub_array[] = $row["bien_codbarras"];
                $sub_array[] = $row["obj_nombre"];
                $sub_array[] = $row["fecharegistro"];
                $sub_array[] = $row["gg_cod"];
                $sub_array[] = $row["clase_cod"];
                $sub_array[] = $row["bien_est"];
                $sub_array[] = '
                <td class="dropdown hidden-xs-down show">
                    <a href="#" data-toggle="dropdown" class="btn pd-y-3 tx-gray-500 hover-info" aria-expanded="true"><i class="icon ion-more"></i></a>
                    <div class="dropdown-menu dropdown-menu-left pd-10">
                        <nav class="nav nav-style-1 flex-column">
                            <a href="#" class="nav-link" onclick="imprimirBien(' . $row["bien_id"] . ')">Imprimir</a>
                            <a href="#" class="nav-link" onclick="editarBien(' . $row["bien_id"] . ')">Editar</a>
                            <a href="#" class="nav-link" onclick="eliminarBien(' . $row["bien_id"] . ')">Eliminar</a>
                        </nav>
                    </div><!-- dropdown-menu -->
                </td>';

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
    
    case "listar_gg_clase":
        $datos = $grupogenerico->get_clase_modal($_POST["gg_id"]);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = "<input type='checkbox' name='detallecheck[]' value='" . $row["clase_id"] . "'>";
            $sub_array[] = $row["clase_nom"];
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
    case "insert_gg_clase":
        $datos = explode(',', $_POST['clase_id']);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $idx = $grupogenerico->insert_gg_clase($_POST["gg_id"], $row);
            $sub_array[] = $idx;
            $data[] = $sub_array;
            $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
        }

        echo json_encode($data);
        break;
    case "combo":
        $datos = $grupogenerico->get_grupogenerico();
        if (is_array($datos) == true and count($datos) > 0) {
            $html = " <option label='Seleccione'></option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['gg_id'] . "'>" . $row['gg_nom'] . "</option>";
            }
            echo $html;
        }
        break;
}
