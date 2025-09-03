<?php
require_once("../config/conexion.php");
require_once("../models/TipoServicio.php");
$tiposervicio = new TipoServicio();
switch ($_GET["op"]) {
    case "listar_tipo_servicio":
        $datos = $tiposervicio->listar_tipo_servicio();
        if (is_array($datos) && count($datos) > 0) {
            $html = "<option label='-- Seleccione tipo de servicio --'></option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['move_id'] . "'>"
                    . $row['move_descripcion'] 
                    . "</option>";
            }
            echo $html;
        }
    break;
}
