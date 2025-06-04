<?php

require_once("../config/conexion.php");

require_once("../models/Persona.php");
require_once("../models/Bitacora.php");
$bitacora = new Bitacora();
$persona = new Persona();

switch ($_GET["op"]) {

   case "buscarDNI":
    $datos = $persona->get_persona_dni($_POST["pers_dni"]);
    if (is_array($datos) && count($datos) > 0) {
        foreach ($datos as $row) {
            $output["pers_id"] = $row["pers_id"];
            $output["pers_dni"] = $row["pers_dni"];
            $output["nombre_completo"] = $row["nombre_completo"];
        }
        echo json_encode($output);
    } else {
        echo json_encode([]); // En caso de que no se encuentre el DNI
    }
    break;

    case "combo":
    $datos = $persona->get_all_dnis(); // obtener solo los DNI
    if (is_array($datos) && count($datos) > 0) {
        $html = "<option value='' disabled selected>Seleccione</option>";
        foreach ($datos as $row) {
            $html .= "<option value='" . $row['pers_dni'] . "'>" . $row['pers_dni'] . "</option>";
        }
        echo $html;
    }
    break;

}
