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
            $datos = $marca->get_marca();
            $data = array();
            foreach ($datos as $row) {
                $sub_array = array();
                $sub_array[] = '
                <label class="checkbox-wrapper-46">
                    <input type="checkbox" class="inp-cbx marca-checkbox" data-id="' . htmlspecialchars($row["marca_id"]) . '" value="' . htmlspecialchars($row["marca_id"]) . '" />
                    <span class="cbx">
                        <span>
                            <svg viewBox="0 0 12 10" height="10px" width="12px">
                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                            </svg>
                        </span>
                        <span></span>
                    </span>
                </label>';
                $sub_array[] = $row["marca_nom"];
                $sub_array[] = '
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Acciones
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 text-warning" href="#" onclick="editarmarca(' . $row["marca_id"] . ')">
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
                            <a class="dropdown-item d-flex align-items-center gap-2 text-danger" href="#" onclick="eliminarmarca(' . $row["marca_id"] . ')">
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
                </div>';
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