<?php
require_once("../config/conexion.php");
require_once("../models/DetalleBien.php");
$detalleBien = new DetalleBien();
switch ($_GET["op"]) {
    case "mostrar_detalle_bien_id":
        $datos = $detalleBien->get_detalle_bien_x_id($_POST['bien_id']);
        $output = array();
        if (is_array($datos) && count($datos) > 0) {
            foreach ($datos as $row) {
                $output = $row;
            }
        }
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        break;

    case "actualizar_detalle_bien":
        $detalleBien->actualizar_detalle_bien(
            $_POST["bien_id"],
            $_POST["placa"],
            $_POST["ruta"],
            $_POST["tipo_movilidad"],
            $_POST["categoria"],
            $_POST["anio_fabricacion"],
            $_POST["peso_neto"],
            $_POST["carga_util"],
            $_POST["peso_bruto"],
            $_POST["ruedas"],
            $_POST["cilindros"],
            $_POST["ejes"],
            $_POST["nro_motor"],
            $_POST["pasajeros"],
            $_POST["asientos"],
            $_POST["carroceria"],
            $_POST["comb_id"]
        );
        echo "ok";
        break;
}

