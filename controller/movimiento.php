<?php
    require_once("../config/conexion.php");
    require_once("../models/Movimiento.php");
    require_once("../models/Bitacora.php");
    $bitacora = new Bitacora();
    $movimiento = new Movimiento();
    switch($_GET["op"]){
       
        case "guardaryeditar":
            if (empty($_POST["mov_id"])) {
                $movimiento->insert_movimiento($_POST["mov_nom"]);
                $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
            } else {
                $movimiento->update_movimiento($_POST["mov_id"], mb_strtoupper($_POST["mov_nom"], 'UTF-8'));
                $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
            }
            break;
        case "mostrar":
            $datos = $movimiento->get_movimiento_id($_POST["mov_id"]);
            if(is_array($datos)==true and count($datos)<>0){
                foreach($datos as $row){
                    $output["mov_id"] = $row["mov_id"];
                    $output["mov_nom"] = $row["mov_nom"];
                }
                echo json_encode($output);
            }
            break;
        case "eliminar":
            $movimiento->delete_movimiento($_POST["mov_id"]);
            $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
            break;
     
        case "listar":
            $datos=$movimiento->get_movimiento();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["mov_id"];
                $sub_array[] = $row["mov_nom"];
                $sub_array[] = '<button type="button" onClick="editarmovimiento('.$row["mov_id"].');"  id="'.$row["mov_id"].'" class="btn btn-outline-warning btn-icon"><div><i class="fa fa-edit"></i></div></button>';
                $sub_array[] = '<button type="button" onClick="eliminarmovimiento('.$row["mov_id"].');"  id="'.$row["mov_id"].'" class="btn btn-outline-danger btn-icon"><div><i class="fa fa-close"></i></div></button>';                
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
            $datos=$movimiento->get_movimiento();
            if(is_array($datos)==true and count($datos)>0){
                $html= " <option label='Seleccione'></option>";
                foreach($datos as $row){
                    $html.= "<option value='".$row['mov_id']."'>".$row['mov_nom']."</option>";
                }
                echo $html;
            }
            break;
        case "eliminar_movimiento_usu":
            $movimiento->eliminar_movimiento_usu($_POST["movimientousua_id"]);
            $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
            break;
        
 
    }
?>