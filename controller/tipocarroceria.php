<?php
require_once("../config/conexion.php");
require_once("../models/TipoCarroceria.php");
$tipocarroceria = new TipoCarroceria();
switch ($_GET["op"]) {
    case "listar_tipo_carroceria":
        $datos = $tipocarroceria->listar_carrocerias();
        if (is_array($datos) && count($datos) > 0) {
            $html = "<option value='' label='-- Seleccione tipo de carrocería --'></option>";
            foreach ($datos as $row) {
                $html .= "<option value='" . htmlspecialchars($row['codigo']) . "'>"
                    . htmlspecialchars($row['codigo'] . " - " . $row['carroceria'])
                    . "</option>";
            }
            echo $html;
        }
    break;
    case "listar_categoria":
        if (isset($_POST["codigo"])) {
            $codigo = $_POST["codigo"];
            $datos = $tipocarroceria->listar_categorias_por_carroceria($codigo);
            if (is_array($datos) && count($datos) > 0) {
                $html = "<option value='' label='-- Seleccione categoría --'></option>";
                foreach ($datos as $row) {
                    $html .= "<option value='" . htmlspecialchars($row['categoria']) . "'>"
                           . htmlspecialchars($row['categoria'])
                           . "</option>";
                }
                echo $html;
            }
        }
    break;
}
