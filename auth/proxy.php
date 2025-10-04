<?php
header('Content-Type: application/json');
require_once '../config/conexion.php';
require_once '../config/jwt.php';

$jwt = new JwtHandler();

// Ruta base de tu API interna (forzada a controller/)
$apiBaseUrl = rtrim($_ENV["BASE_URL"], '/') . '/' . trim($_ENV["APP_NAME"], '/') . '/controller/';

// Recibir la ruta a consultar
$api      = $_POST['api'] ?? ($_GET['api'] ?? ''); // permite api por GET también
$method   = $_SERVER['REQUEST_METHOD'];
$token    = $_COOKIE['registro'] ?? $_COOKIE['2fa'] ?? $_COOKIE['blanqueamiento'] ?? $_COOKIE['session'] ?? '';

// contenido recibido (seguro si no existe)
$contentType = $_SERVER['CONTENT_TYPE'] ?? '';

if (!$api) {
    $jwt->response('No se ha ingresado la petición', [], false, 400);
    exit;
}

// ✅ Validación: solo permitimos archivo.php con parámetros opcionales (?a=1&b=2)
// Esto evita rutas con carpetas y traversal.
if (!preg_match('/^[a-zA-Z0-9_-]+\.php(\?.*)?$/', $api)) {
    $jwt->response('API inválida', [], false, 400);
    exit;
}

// Construimos la URL final siempre dentro de /controller/
$apiUrl = $apiBaseUrl . $api;

// Comprobamos que exista (como en tu versión original)
if (!urlExists($apiUrl)) {
    $jwt->response('El endpoint no existe ', [], false, 400);
    exit;
}

// Inicializar cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true); // incluir cabeceras en la respuesta
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

// Reenviar datos si es POST, PUT o PATCH
if (in_array($method, ['POST', 'PUT', 'PATCH'])) {
    if (!empty($_FILES) || stripos($contentType, 'multipart/form-data') !== false) {
        // Siempre reenvía como multipart si viene de FormData, tenga o no archivo
        $postFields = $_POST;
        foreach ($_FILES as $key => $file) {
            if ($file['error'] === UPLOAD_ERR_OK) {
                $postFields[$key] = new CURLFile(
                    $file['tmp_name'],
                    $file['type'],
                    $file['name']
                );
            }
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    } else if (strpos($contentType, "application/json") !== false) {
        $rawBody = file_get_contents("php://input");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $rawBody);
    } else {
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_POST));
    }
}


// Construir encabezados
if ($token) {
    $token = "Bearer " . $token;
}

$headers = [
    "Authorization: " . $token
];

// ⭐ Si mandamos archivos, NO forzamos Content-Type (cURL lo maneja).
// ⭐ Si se está reenviando FormData (multipart), no forzamos Content-Type
if (!empty($_FILES) || stripos($contentType, 'multipart/form-data') !== false) {
    // no seteamos nada, que cURL lo maneje
} else {
    if (!empty($contentType)) {
        $headers[] = "Content-Type: " . $contentType;
    } else {
        $headers[] = "Content-Type: application/json";
    }
}


curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Ejecutar y responder
$response = curl_exec($ch);
if ($response === false) {
    $err = curl_error($ch);
    curl_close($ch);
    $jwt->response("Error en proxy: {$err}", [], false, 502);
    exit;
}

$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

$headers_raw = substr($response, 0, $header_size);
// Reenvía Set-Cookie que provenga del backend
foreach (explode("\r\n", $headers_raw) as $hdr) {
    if (stripos($hdr, 'Set-Cookie:') === 0) {
        header($hdr, false); // reenvía tal cual al navegador
    }
}

$body = substr($response, $header_size);

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

http_response_code($httpCode);

$jsonResponse = json_decode($body, true);

if (
    isset($jsonResponse["success"], $jsonResponse["status"]) && 
    $jsonResponse["success"] == false && 
    $jsonResponse["status"] == 498
) {
    // Limpias cookies
    if (isset($_COOKIE["2fa"])) {
        $cookieName = "2fa";
    } elseif (isset($_COOKIE["blanqueamiento"])) {
        $cookieName = "blanqueamiento";
    } elseif (isset($_COOKIE["session"])) {
        $cookieName = "token";
    } elseif (isset($_COOKIE["registro"])) {
        $cookieName = "token";
    }

    $jwt->setCookie($cookieName, "", -3600, "/".$_ENV["APP_NAME"]."/");

    $warn = [
        'type' => 'warning',
        'message' => 'La sesión ha expirado'
    ];

    $jwt->setCookie("warn", $warn, 0, "/".$_ENV["APP_NAME"]."/");
}

// SIEMPRE devuelves JSON
header('Content-Type: application/json');
echo $body;
exit();

function urlExists($url) {
    $headers = @get_headers($url);
    if (!$headers) {
        return false;
    }
    // Considera 200 y 401 como "existe"
    return strpos($headers[0], '200') !== false || strpos($headers[0], '401') !== false;
}
