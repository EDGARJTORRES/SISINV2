<?php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../config/jwt.php';
session_start(); 
$jwt = new JwtHandler();
if (!isset($_COOKIE['session'])) {
    header("Location:" . Conectar::ruta() . "/view/404");
    exit();
} else {
    $data = $jwt->decrypt($_COOKIE['session']);
    if ($data && isset($data->data)) {
        $_SESSION['usu_id'] = $data->data->usu_id ?? null;
        $usuario     = ($data->data->usu_nom ?? '') . ' ' . ($data->data->usu_apep ?? '') . ' ' . ($data->data->usu_apem ?? '');
        $perf_nombre = $data->data->perf_nombre ?? '';
        $perf_id     = $data->data->perf_id ?? '';
        $usu_doc     = $data->data->usu_doc ?? '';
        $usu_nom     = $data->data->usu_nom ?? '';
        $usu_apep    = $data->data->usu_apep ?? '';
        $usu_apem    = $data->data->usu_apem ?? '';
        $usu_tipo    = $data->data->usu_tipo ?? '';
        $url         = $data->data->url ?? '';
    } else {
        header("Location:" . Conectar::ruta() . "/view/401");
        exit();
    }
}
?>
