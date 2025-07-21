<?php
require_once("../config/conexion.php");
require_once("../models/Bien.php");
$bien = new Bien();
switch ($_GET["op"]) {
    case "contador_bien_estado":
        $datos = $bien->get_contador_bien_estado();
        echo json_encode($datos);
    break;
    case "ultimo":
         $datos = $bien->get_ultimo_bien();  
        if ($datos) {  
            echo json_encode($datos);  
        } else {
            echo json_encode(["error" => "No se encontró el último bien."]); 
        }
    break;
    case "total_adquision":
        $datos = $bien->get_total_y_variacion_adquisicion();

        $total_actual = (float)$datos['total_actual'];

        echo json_encode([[
            "total_valor_adquisicion" => round($total_actual, 2)
        ]]);
    break;
    case "total_bienes":
         $datos = $bien->get_total_bien();  
        if ($datos) {  
            echo json_encode($datos);  
        } else {
            echo json_encode(["error" => "No se encontró el total bien."]); 
        }
    break;
    case "listar_bienes_sin_asignacion":
        $datos = $bien->get_bienes_sin_dependencia();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["bien_id"];
            $sub_array[] = '<span class="badge bg-red-lt selectable">' . $row["bien_codbarras"] . '</span>';
            $sub_array[] = date("Y-m-d", strtotime($row["fecharegistro"]));
            $sub_array[] = $row["obj_nombre"];
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
           $sub_array[] = '<span class="d-inline-block ' . $badge_class . ' text-white text-center px-0 py-0 rounded-pill" style="min-width: 70px;">' . $estado_text . '</span>';
            $sub_array[] = $row["procedencia"]; 
            $sub_array[] = $row["val_adq"]; 
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
    case "grafico_valor_bienes":
        $datos = $bien->get_valores_adquisicion_y_baja();
        echo json_encode($datos);
    break;
}
