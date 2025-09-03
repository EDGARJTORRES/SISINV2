<?php
// Obtener los valores enviados por GET
$tipo_documento = isset($_GET['tipo_documento']) ? $_GET['tipo_documento'] : "";
$nro_documento = isset($_GET['nro_documento']) ? $_GET['nro_documento'] : "";

if($tipo_documento == 1){
    $apiUrl = "https://www.munichiclayo.gob.pe/Pide/Reniec/{$nro_documento}";
}else if( $tipo_documento == 3){
    $apiUrl = "https://www.munichiclayo.gob.pe/Pide/Migraciones/{$nro_documento}";
}

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

// Verificar si la API respondió correctamente
if ($http_code == 200) {
    header('Content-Type: application/json');
    echo $response;
} else {
    echo json_encode(["error" => "Error al acceder a la API. Código HTTP: $http_code"]);
}
?>