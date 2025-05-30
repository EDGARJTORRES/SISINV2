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
        case "eliminar_marcas":
            $ids = isset($_POST['ids']) ? $_POST['ids'] : [];
            if (!empty($ids)) {
                foreach ($ids as $id) {
                    $marca->delete_marca(intval($id));
                }
                echo json_encode(['status' => 'ok']);
            } else {
                echo json_encode(['status' => 'no_ids']);
            }
            break;
     
        case "listar":
            $datos=$marca->get_marca();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = '<input type="checkbox" class="marca-checkbox" data-id="' 
                . htmlspecialchars($row["marca_id"]) 
                . '" value="' 
                . htmlspecialchars($row["marca_id"]) 
                . '">';
                $sub_array[] = $row["marca_nom"];
                $sub_array[] = '<button type="button" onClick="editarmarca('.$row["marca_id"].');"  id="'.$row["marca_id"].'" class="btn bg-warning text-light"   style="width: 40px; height: 40px; padding: 0;">
                                    <svg style="transform: translateX(5px);" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                        <path d="M16 5l3 3" />
                                    </svg>
                                </button>';
                $sub_array[] = '<button type="button" onClick="eliminarmarca('.$row["marca_id"].');"  id="'.$row["marca_id"].'" class="btn bg-danger text-light"  style="width: 40px; height: 40px; padding: 0;">
                                    <svg style="transform: translateX(5px);" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-backspace">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M20 6a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-11l-5 -5a1.5 1.5 0 0 1 0 -2l5 -5z" />
                                        <path d="M12 10l4 4m0 -4l-4 4" />
                                    </svg>
                                </button>';                
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