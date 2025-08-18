<?php
require_once("../config/conexion.php");
require_once("../models/Combustible.php");
$combustible = new Combustible();
switch ($_GET["op"]) {
    case "combo_detalle_combustible":
        $datos = $combustible->get_combustible_detalle();
        if (is_array($datos) && count($datos) > 0) {
            $html = "<option label='-- Seleccione tipo de combustible --'></option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['comb_id'] . "'>"
                    . $row['comb_nombre'] 
                    . "</option>";
            }
            echo $html;
        }
    break;


}
