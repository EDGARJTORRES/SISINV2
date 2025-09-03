<?php
try {
    if (!isset($_GET['placa'])) {
        echo json_encode([
            'status' => false,
            'message' => 'Falta el parámetro obligatorio: placa.',
            'data' => null
        ]);
        exit;
    }
    $placa = $_GET['placa'];
    $apiUrl = "https://www.munichiclayo.gob.pe/Pide/Sunarp/Placa/?placa={$placa}";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

    $headers = [
        "User-Agent: Mozilla/5.0"
    ];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $response = json_decode($response, true); // Intentar decodificar JSON

    if ($http_code == 200 && isset($response['data'])) {
        $status = true;
        $detail = 'success';
        $message = $response['message'] ?? 'Consulta realizada correctamente';
        $text = $response['data']['propietario'] ?? '';
        $data = $response['data'];
    } elseif ($http_code == 404) {
        $status = false;
        $detail = 'warning';
        $message = $response['message'] ?? 'No se encontraron datos para la placa';
        $text = 'Intente nuevamente!';
        $data = [];
    } else {
        $status = false;
        $detail = 'error';
        $message = 'Error en la búsqueda';
        $text = '¿Desea ingresar los datos manualmente?';
        $data = [];
    }

    echo json_encode([
        'status' => $status,
        'detail' => $detail,
        'message' => $message,
        'text' => $text,
        'data' => $data
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => false,
        'detail' => 'danger',
        'message' => 'Error inesperado: ' . $e->getMessage(),
        'text' => 'Intente más tarde!',
        'data' => []
    ]);
}