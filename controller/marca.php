<?php
   
    require_once("../config/conexion.php");

    require_once("../models/Marca.php");
    require_once("../models/Bitacora.php");
    $bitacora = new Bitacora();
    $marca = new Marca();

    switch($_GET["op"]){
       
        case "guardaryeditar":
            if (empty($_POST["marca_id"])) {
                $marca->insert_marca($_POST["marca_nom"]);
                $bitacora->update_bitacora($_SESSION["usua_id_siin"]);
            } else {
                $marca->update_marca($_POST["marca_id"], $_POST["marca_nom"]);
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
            $marca->delete_marca($_POST["marca_id"]);
            $bitacora->update_bitacora($_SESSION["usua_id_sisgi"]);
            break;
     
        case "listar":
            $datos=$marca->get_marca();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["marca_id"];
                $sub_array[] = $row["marca_nom"];
                $sub_array[] = '<button type="button" onClick="editarmarca('.$row["marca_id"].');"  id="'.$row["marca_id"].'" class="btn btn-outline-warning btn-icon"><div><i class="fa fa-edit"></i></div></button>';
                $sub_array[] = '<button type="button" onClick="eliminarmarca('.$row["marca_id"].');"  id="'.$row["marca_id"].'" class="btn btn-outline-danger btn-icon"><div><i class="fa fa-close"></i></div></button>';                
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
            $datos=$marca->get_marca();
            if(is_array($datos)==true and count($datos)>0){
                $html= " <option label='Seleccione'></option>";
                foreach($datos as $row){
                    $html.= "<option value='".$row['marca_id']."'>".$row['marca_nom']."</option>";
                }
                echo $html;
            }
            break;

    }
?>