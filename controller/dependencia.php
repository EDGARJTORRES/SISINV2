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

        // Combinar los datos de las tres consultas en una sola estructura de datos
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

        // Actualizar los valores de objetos retirados
        foreach ($datosRetirados as $row) {
            $id = $row["depe_id"];
            if (isset($data[$id])) {
                $data[$id]["objetos_retirados"] = $row["count"];
            }
        }

        // Actualizar los valores de objetos rotados
        foreach ($datosRotados as $row) {
            $id = $row["depe_id"];
            if (isset($data[$id])) {
                $data[$id]["objetos_rotados"] = $row["count"];
            }
        }

        // Construir las filas de la tabla
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
              /*   $sub_array[] = '<button type="button" onClick="editarObjDepe('.$row["objdepe_id"].');"  id="'.$row["objdepe_id"].'" class="btn btn-outline-warning btn-icon"><div><i class="fa fa-edit"></i></div></button>';
                $sub_array[] = '<button type="button" onClick="eliminarObjDepe('.$row["objdepe_id"].');"  id="'.$row["objdepe_id"].'" class="btn btn-outline-danger btn-icon"><div><i class="fa fa-close"></i></div></button>';                
                 */
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
            $cod_cana = $datos['codigo_cana'];
            $lid = $stick->get_last_id();
            $codinterno = $lid['objdepe_id'];
            $output["codigo_cana"] = $cod_cana; // Se corrige el acceso a la variable $datos
            $output["objdepe_id"] = $codinterno; // Se corrige el nombre de la variable $lid
            echo json_encode($output);
            break;
}
