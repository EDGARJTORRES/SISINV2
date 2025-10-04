<?php
header('Content-Type: application/json');
require_once '../config/conexion.php';
require_once '../config/jwt.php';

$jwt = new JwtHandler();

$conectar = new Conectar();

$sist_inic = $_POST['sist_inic'] ?? null;
$sist_pass = $_POST['sist_pass'] ?? null;

// Validar sistema
$conectar = $conectar->conexion();
$sql = "SELECT sist_id, sist_denominacion, sist_iniciales, sist_pass, sist_estado
FROM sc_seguridad.tb_sistema WHERE sist_iniciales = ?";
$stmt = $conectar->prepare($sql);
$stmt->bindValue(1, $sist_inic);
$stmt->execute();
$auth = $stmt->fetch(PDO::FETCH_ASSOC);

if ($auth && password_verify($sist_pass, $auth['sist_pass'])) {
    switch($auth["sist_estado"]){
        case 'I':
            $jwt->response("El sistema se encuentra inactivo", [], false, 503);
            break;

        case 'E':
            $jwt->response("El sistema ha sido eliminado", [], false, 410);
            break;

        case 'M':
            $jwt->response("El sistema se encuentra en mantenimiento", [], false, 503);
            break;
    }
    $token = $jwt->encrypt();
    $jwt->response("Token generado correctamente", ['token' => $token], true, 200);
}
else {
    $jwt->response("Las credenciales de generación de token son inválidas", [], false, 401);
}

?>