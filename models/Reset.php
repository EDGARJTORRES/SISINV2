<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../config/jwt.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$jwt = new JwtHandler();

// Capturar datos enviados por POST
$usu_doc = filter_var(trim($_POST['usu_doc'] ?? ''), FILTER_SANITIZE_NUMBER_INT);
$usu_tipo  = $_POST['usu_tipo'] ?? null;
$sist_inic  = $_ENV['SIST_INIC'];

$jwt->setCookie("captcha_text", "", -3600, "/".$_ENV["APP_NAME"]."/");

if($usu_doc == ''){
    $warn = [
        'type' => 'danger',
        'message' => 'Debe completar los campos obligatorios'
    ];

    $jwt->setCookie("warn", $warn, 0, "/".$_ENV["APP_NAME"]."/");
    header("Location:" . Conectar::ruta());
    exit();
}

// Obtener token JWT
$login = curl_init($_ENV["BASE_URL"] . "sigur/auth/");
curl_setopt($login, CURLOPT_ENCODING, 'true');
curl_setopt($login, CURLOPT_RETURNTRANSFER, true);
curl_setopt($login, CURLOPT_POST, true);
curl_setopt($login, CURLOPT_POSTFIELDS, http_build_query([
    'sist_inic' => $_ENV['SIST_INIC'],
    'sist_pass' => $_ENV['SIST_PASS']
]));
$response = json_decode(curl_exec($login), true);
curl_close($login);

// Extraer token
$token = $response['data']['token'] ?? null;

if ($token) {
    if ($usu_doc) {
        // 4. Consumir el API de login de personal
        $ch = curl_init($_ENV["BASE_URL"] . "sigur/ws/reset.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $token"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'usu_doc'   => $usu_doc,
            'usu_tipo'  => $usu_tipo
        ]));
        $data = curl_exec($ch);

        if ($data) {
            $data = json_decode($data);
            if($data->data){
                $param = $data->data;
                $token = $jwt->encrypt($param, 'blanqueamiento', 900);  // expira en 15 minutos
                $jwt->setCookie("blanqueamiento", $token, 0, "/sigur/");
                header("Location:" . $_ENV["BASE_URL"] . 'sigur/view/clave/recuperar/');
                exit();
            }
            else{
                $warn = [
                    'type' => 'danger',
                    'message' => $data->message
                ];
                $jwt->setCookie("warn", $warn, 0, "/".$_ENV["APP_NAME"]."/");
                header("Location:" . Conectar::ruta());
                exit();

                // $enc = $jwt->encrypt(["usu_doc" => $usu_doc, "message" => $data->message, "success" => $data->success], 20);
                // header("Location:" . Conectar::ruta() . "?data=" . urlencode($enc));
            }
            
        }
        else{
            $warn = [
                'type' => 'danger',
                'message' => 'Error al conectar con el servidor de autenticación'
            ];
            $jwt->setCookie("warn", $warn, 0, "/".$_ENV["APP_NAME"]."/");
            header("Location:" . Conectar::ruta());
        }

        curl_close($ch);

        // echo $result;
    } else {
        $warn = [
            'type' => 'danger',
            'message' => 'No se han ingresados los parámetros obligatorios'
        ];
        $jwt->setCookie("warn", $warn, 0, "/".$_ENV["APP_NAME"]."/");
        header("Location:" . Conectar::ruta());
        // $jwt->response("No se han ingresados los parámetros obligatorios", [], false, 422);
    }
} else {
    $warn = [
        'type' => 'danger',
        'message' => $response["message"]
    ];
    $jwt->setCookie("warn", $warn, 0, "/".$_ENV["APP_NAME"]."/");
    header("Location:" . Conectar::ruta());
    // $jwt->response($response['message'], $response['data'], $response['success'], $response['status']);
}

?>