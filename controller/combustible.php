<?php
require_once("../config/conexion.php");
require_once("../models/Combustible.php");
$combustible = new Combustible();
switch ($_GET["op"]) {
    case "combo_detalle_combustible":
        $datos = $combustible->get_combustible_detalle();
        $resultado = [];

        if (is_array($datos) && count($datos) > 0) {
            foreach ($datos as $row) {
                $resultado[] = [
                    "id" => $row["comb_id"],
                    "nombre" => $row["comb_nombre"]
                ];
            }
        }
        echo json_encode($resultado);
    break;
}
