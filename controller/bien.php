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
}
