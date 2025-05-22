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
            $sub_array[] = '<button type="button" onClick="editarGG(' . $row["gg_id"] . ');"  id="' . $row["gg_id"] . '" class="btn bg-yellow text-yellow-fg "><div><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg></div></button>';
            $sub_array[] = '<button type="button" onClick="eliminarGG(' . $row["gg_id"] . ');"  id="' . $row["gg_id"] . '" class="btn  bg-red text-red-fg"><div><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-backspace"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 6a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-11l-5 -5a1.5 1.5 0 0 1 0 -2l5 -5z" /><path d="M12 10l4 4m0 -4l-4 4" /></svg></div></button>';
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
            $estado = strtolower($row["bien_est"]); 
            switch ($estado) {
                case 'a':
                    $badge_class = 'bg-primary';
                    $estado_text = 'Activo';
                    break;
                case 'n':
                    $badge_class = 'bg-purple';
                    $estado_text = 'Nuevo';
                break;
                case 'r':
                    $badge_class = 'bg-warning';
                    $estado_text = 'Regular';
                    break;
                case 'm':
                    $badge_class = 'bg-danger';
                    $estado_text = 'Malo';
                    break;
                case 'b':
                    $badge_class = 'bg-success';
                    $estado_text = 'Bueno';
                    break;
                default:
                    $badge_class = 'bg-secondary';
                    $estado_text = 'Inactivo';
            }

            $sub_array[] = '<span class="d-inline-block rounded-circle ' . $badge_class . '" style="width: 12px; height: 12px;"></span> ' . $estado_text;

            $sub_array[] = '
            <td class="text-end">
                <div class="dropdown">
                    <a href="#" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Acciones
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="#" class="dropdown-item" onclick="imprimirBien(' . $row['bien_id'] . ')">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-printer mx-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" /></svg>
                        Imprimir
                        </a>
                        <a href="#" class="dropdown-item" onclick="editarBien(' . $row['bien_id'] . ')">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit mx-1 "><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                        Editar
                        </a>
                        <a href="#" class="dropdown-item" onclick="eliminarBien(' . $row['bien_id'] . ')">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-backspace mx-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 6a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-11l-5 -5a1.5 1.5 0 0 1 0 -2l5 -5z" /><path d="M12 10l4 4m0 -4l-4 4" /></svg>
                        Eliminar
                        </a>
                    </div>
                </div>
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
            $sub_array[] = "<input type='checkbox' class='m-3' name='detallecheck[]' value='" . $row["clase_id"] . "'>";
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
