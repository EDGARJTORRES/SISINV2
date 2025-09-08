<?php
require_once("../config/conexion.php");
require_once("../models/ClaseVehiculo.php");
$clasevehiculo = new ClaseVehiculo();
switch ($_GET["op"]) {
    case "listar_clase_vehiculo":
        $datos = $clasevehiculo->listar_clase_vehiculo();
        if (is_array($datos) && count($datos) > 0) {
            $html = "<option label='-- Seleccione clase vehiculo --'></option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['veh_clase_id'] . "'>"
                    . $row['veh_clase_nom'] 
                    . "</option>";
            }
            echo $html;
        }
    break;
}
