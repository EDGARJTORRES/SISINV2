<?php
require_once("../config/conexion.php");
require_once("../models/DetalleBien.php");
$detalleBien = new DetalleBien();
switch ($_GET["op"]) {
    case "mostrar_estado_bien":
        $datos = $detalleBien->mostrar_estado($_POST['bien_id']);
        $output = array();
        if (is_array($datos) && count($datos) > 0) {
            $output = $datos[0];
        }
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
    break;
    case "consultar_placa":
        try {
            if (!isset($_POST['bien_placa'])) {
                echo json_encode([
                    "status" => false,
                    "detail" => "warning",
                    "message" => "Falta el parámetro bien_placa",
                    "text" => "Ingrese una placa válida",
                    "data" => []
                ], JSON_UNESCAPED_UNICODE);
                exit;
            }

            $placa = trim($_POST['bien_placa']);
            $url = "https://www.munichiclayo.gob.pe/Pide/Sunarp/Placa/?placa=" . urlencode($placa);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["User-Agent: Mozilla/5.0"]);
            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error) {
                echo json_encode([
                    "status" => false,
                    "detail" => "error",
                    "message" => "Error al consultar API: " . $error,
                    "text" => "Intente nuevamente más tarde",
                    "data" => []
                ], JSON_UNESCAPED_UNICODE);
                exit;
            }

            $data = json_decode($response, true);

            if ($http_code == 200 && !empty($data)) {
                echo json_encode([
                    "status" => true,
                    "detail" => "success",
                    "message" => $data['message'] ?? "Consulta realizada correctamente",
                    "text" => $data['data']['propietario'] ?? "",
                    "data" => $data['data'] ?? []
                ], JSON_UNESCAPED_UNICODE);
            } elseif ($http_code == 404) {
                echo json_encode([
                    "status" => false,
                    "detail" => "warning",
                    "message" => $data['message'] ?? "No se encontraron datos para la placa",
                    "text" => "Intente nuevamente",
                    "data" => []
                ], JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode([
                    "status" => false,
                    "detail" => "error",
                    "message" => "Error en la búsqueda",
                    "text" => "¿Desea ingresar los datos manualmente?",
                    "data" => []
                ], JSON_UNESCAPED_UNICODE);
            }

        } catch (Exception $e) {
            echo json_encode([
                "status" => false,
                "detail" => "danger",
                "message" => "Error inesperado: " . $e->getMessage(),
                "text" => "Intente más tarde!",
                "data" => []
            ], JSON_UNESCAPED_UNICODE);
        }
    break;
    case "editar_identificacion":
        $combustibles = [];
        if (isset($_POST["bien_comb"])) {
            $combustibles = is_array($_POST["bien_comb"]) 
                ? $_POST["bien_comb"] 
                : array_filter(array_map('trim', explode(',', $_POST["bien_comb"])));
        }
        $bien_id = $_POST["bien_id"] ?? null;
        if (!$bien_id) {
            echo json_encode(["status"=>false,"message"=>"Falta bien_id"], JSON_UNESCAPED_UNICODE);
            exit;
        }
        $ok = $detalleBien->update_identificacion(
            (int)$bien_id,
            $_POST["ruta"] ?? '',
            $_POST["tipo_servicio"] ?? null,
            $_POST["vin"] ?? '',
            $_POST["categoria"] ?? '',
            $_POST["anio_fabricacion"] ?? null,
            $_POST["tipo_carroceria"] ?? null,
            $combustibles,
            $_POST["version"] ?? ''
        );
        echo json_encode([
            "status"  => $ok,
            "message" => $ok ? "Identificación actualizada correctamente" : "Error al actualizar",
            "bien_id" => $bien_id
        ], JSON_UNESCAPED_UNICODE);
    break;


    case "editar_caracteristicas":
        $detalleBien->update_caracteristicas(
            $_POST["bien_id"],
            $_POST["nro_motor"],
            $_POST["ruedas"],
            $_POST["cilindros"],
            $_POST["cilindrada"],
            $_POST["potencia"],
            $_POST["form_rodaje"],
            $_POST["ejes"]
        );
        echo $_POST["bien_id"];
    break;
    case "editar_capacidades":
        $detalleBien->update_capacidades(
            $_POST["bien_id"],
            $_POST["pasajero"],
            $_POST["asiento"],
            $_POST["peso_neto"],
            $_POST["carga_util"],
            $_POST["peso_bruto"],
        );
        echo $_POST["bien_id"];
    break;
    case "mostrar_identificacion":
        if (!isset($_POST['bien_id'])) {
            echo json_encode([
                "status" => false,
                "message" => "Falta el parámetro bien_id",
                "data" => []
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }
        $bien_id = $_POST['bien_id'];
        $datos = $detalleBien->get_identificacion($bien_id);

        echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    break;
    case "mostrar_caracteristicas":
        if (!isset($_POST['bien_id'])) {
            echo json_encode([
                "status" => false,
                "message" => "Falta el parámetro bien_id",
                "data" => []
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }
        $bien_id = $_POST['bien_id'];
        $datos = $detalleBien->get_caracteristicas($bien_id);

        echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    break;
    case "mostrar_capacidades":
        if (!isset($_POST['bien_id'])) {
            echo json_encode([
                "status" => false,
                "message" => "Falta el parámetro bien_id",
                "data" => []
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }
        $bien_id = $_POST['bien_id'];
        $datos = $detalleBien->get_capacidades($bien_id);

        echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    break;
}
