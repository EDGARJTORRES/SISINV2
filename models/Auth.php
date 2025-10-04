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
$usu_pass = strip_tags(trim($_POST['usu_pass'] ?? ''));
$usu_ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
$captcha_text = strip_tags(trim($_POST['captchaInput'] ?? ''));
$usu_tipo = strip_tags(trim($_POST['usu_tipo'] ?? ''));
$sist_inic = $_ENV['SIST_INIC'];

// validar captcha
if ($captcha_text != ($_COOKIE["captcha_text"] ?? '')) {
    $warn = [
        'type' => 'danger',
        'message' => 'El código captcha es inválido'
    ];
    $jwt->setCookie("warn", $warn, 0, "/" . $_ENV["APP_NAME"] . "/");
    header("Location:" . Conectar::ruta());
    exit();
}

$jwt->setCookie("captcha_text", "", -3600, "/" . $_ENV["APP_NAME"] . "/");

// 1. Obtener token JWT del core segur
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
$token = $response['data']['token'] ?? '';

if ($token) {
    if ($usu_doc && $usu_pass && $usu_ip && $sist_inic) {

        // 2. Consumir API de login de personal
        $ch = curl_init($_ENV["BASE_URL"] . "sigur/ws/login.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $token"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'usu_doc'   => $usu_doc,
            'usu_pass'  => $usu_pass,
            'usu_ip'    => $usu_ip,
            'usu_tipo'  => $usu_tipo,
            'sist_inic' => $sist_inic
        ]));

        $curlResponse = curl_exec($ch);
        curl_close($ch);

        if ($curlResponse) {
            $data = json_decode($curlResponse);

            if (!empty($data->data)) {

                // 👉 Recuperar usu_id y guardar en $_SESSION para tu app
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION["usu_id"] = $data->data->usu_id ?? null;

                if (isset($data->data->url)) {
                    // Caso blanqueamiento
                    $param = [
                        "usu_doc" => $usu_doc,
                        "usu_tipo" => $usu_tipo,
                        "success" => $data->success ?? true,
                        "blanqueamiento" => 2
                    ];
                    $token = $jwt->encrypt($param, 'blanqueamiento', 900);  // expira en 15 minutos
                    $jwt->setCookie("blanqueamiento", $token, 0, "/sigur/");

                    header("Location:" . $_ENV["BASE_URL"] . $data->data->url);
                    exit();
                } else {
                    $param = $data->data;

                    if ($data->data->dfa != 0) {
                        // Caso 2FA
                        $token = $jwt->encrypt($param, '2fa', 900);
                        $jwt->setCookie("2fa", $token, 0, "/sigur/");
                        header("Location:" . $_ENV["BASE_URL"] . "/sigur/view/2fa");
                    } else {
                        // Sesión normal
                        $token = $jwt->encrypt($param, 'session', 3600);
                        $jwt->setCookie("session", $token, 0, "/" . $_ENV["APP_NAME"] . "/");
                        header("Location:" . Conectar::ruta() . 'view/adminMain');
                    }
                    exit();
                }
            } else {
                // Error de login
                $warn = [
                    'type' => 'danger',
                    'message' => $data->message ?? 'Error en login'
                ];
                $jwt->setCookie("warn", $warn, 0, "/" . $_ENV["APP_NAME"] . "/");
                header("Location:" . Conectar::ruta());
                exit();
            }
        } else {
            $warn = [
                'type' => 'danger',
                'message' => 'Error al conectar con el servidor de autenticación.'
            ];
            $jwt->setCookie("warn", $warn, 0, "/" . $_ENV["APP_NAME"] . "/");
            header("Location:" . Conectar::ruta());
        }
    } else {
        $warn = [
            'type' => 'danger',
            'message' => "No se han ingresados los parámetros obligatorios"
        ];
        $jwt->setCookie("warn", $warn, 0, "/" . $_ENV["APP_NAME"] . "/");
        header("Location:" . Conectar::ruta());
    }
} else {
    $warn = [
        'type' => 'danger',
        'message' => $response["message"] ?? 'Error obteniendo token'
    ];
    $jwt->setCookie("warn", $warn, 0, "/" . $_ENV["APP_NAME"] . "/");
    header("Location:" . Conectar::ruta());
}
?>
