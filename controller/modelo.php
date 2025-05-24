<?php
    require_once("../config/conexion.php");
    require_once("../models/Modelo.php");
    require_once("../models/Bitacora.php");
    $bitacora = new Bitacora();
    $modelo = new Modelo();
    switch($_GET["op"]){
        case "guardaryeditar":
            if (empty($_POST["modelo_id"])) {
                $modelo->insert_modelo($_POST["modelo_nom"]);
                $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
            } else {
                $modelo->update_modelo($_POST["modelo_id"], $_POST["modelo_nom"]);
                $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
            }
            break;
            
       
        case "mostrar":
            $datos = $marca->get_marca_id($_POST["marca_id"]);
            if(is_array($datos)==true and count($datos)<>0){
                foreach($datos as $row){
                    $output["marca_id"] = $row["marca_id"];
                    $output["marca_nom"] = $row["marca_nom"];
                }
                echo json_encode($output);
            }
            break;
   
        case "eliminar":
            $modelo->delete_modelo($_POST["modelo_id"]);
            $bitacora->update_bitacora($_SESSION["usua_id_sisgi"]);
            break;
        case "listar":
            $filtro_marca = isset($_POST['filtro_marca']) ? trim($_POST['filtro_marca']) : '';
            $datos = $modelo->get_modelo($filtro_marca);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["modelo_id"];
                $sub_array[] = $row["marca_nom"];
                $sub_array[] = $row["modelo_nom"];
                $sub_array[] = '<button type="button" onClick="editarmodelo('.$row["modelo_id"].');"  id="'.$row["modelo_id"].'" class="btn bg-yellow text-yellow-fg"><div><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg></div></button>';
                $sub_array[] = '<button type="button" onClick="eliminarmodelo('.$row["modelo_id"].');"  id="'.$row["modelo_id"].'" class="btn  bg-red text-red-fg"><div><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-backspace"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 6a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-11l-5 -5a1.5 1.5 0 0 1 0 -2l5 -5z" /><path d="M12 10l4 4m0 -4l-4 4" /></svg></div></button>';                
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
            break;

    }
?>