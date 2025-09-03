<?php
try{
    // Validar parámetros GET
    if (!isset($_GET['dni'])) {
        echo json_encode([
            'status' => false,
            'message' => 'Faltan parámetros obligatorios',
            'text' => 'Intente nuevamente!',
            'data' => null
        ]);
        exit;
    }
    // Obtener los valores enviados por GET
    $dni = isset($_GET['dni']) ? $_GET['dni'] : "";

    $apiUrl = "https://www.munichiclayo.gob.pe/Pide/Mtc/{$dni}";

    // Iniciar cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Deshabilitar SSL (solo en pruebas)

    // Agregar Headers si la API requiere autenticación
    $headers = [
        "User-Agent: Mozilla/5.0"
    ];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Ejecutar la solicitud
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    $response = json_decode($response, true); // Intentar decodificar JSON    

    if($http_code == 200){
        $status = true;
        $detail = 'success';
        $message = $response['message'];
        $text = $response['data']['nombres'];
        $data = $response['data'];
    }else if($http_code == 404){
        $status = false;
        $detail = 'warning';
        $message = $response['message'];
        $text = 'Intente nuevamente!';
        $data = [];
    } else{
        $status = false;
        $detail = 'error';
        $message = $response['message'];
        $text = 'Intente más tarde!';
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
?>