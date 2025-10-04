<?php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../config/jwt.php';

$jwt = new JwtHandler();
$headers = getallheaders();

// Inicializamos data siempr
$global_data = null;

// Endpoints públicos (sin token)
$publicEndpoints = [
    '/' . $_ENV["APP_NAME"] . '/view/registro/',
    '/' . $_ENV["APP_NAME"] . '/controller/bien.php',
    '/' . $_ENV["APP_NAME"] . '/controller/ubigeo.php',
    '/' . $_ENV["APP_NAME"] . '/controller/ciudadano.php?op=consultar',
    '/' . $_ENV["APP_NAME"] . '/controller/empresa.php',
    '/' . $_ENV["APP_NAME"] . '/controller/casilla.php?op=insertar_solicitud',
    '/' . $_ENV["APP_NAME"] . '/controller/casilla.php?op=autorizar_solicitud'
];

$dfaWhitelist = [];

$resetWhitelist = [];

$registerWhitelist = [
    '/' . $_ENV["APP_NAME"] . '/view/registro/',
    '/' . $_ENV["APP_NAME"] . '/controller/ubigeo.php',
    '/' . $_ENV["APP_NAME"] . '/controller/ciudadano.php?op=consultar',
    '/' . $_ENV["APP_NAME"] . '/controller/empresa.php',
    '/' . $_ENV["APP_NAME"] . '/controller/casilla.php?op=insertar_casilla',
    '/' . $_ENV["APP_NAME"] . '/controller/casilla.php?op=aprobar'
];

$viewCiud = [
    '/' . $_ENV["APP_NAME"] . '/view/adminMain/',
    '/' . $_ENV["APP_NAME"] . '/view/setting/'
];

$currentFile = $_SERVER['REQUEST_URI'];
$path = parse_url($currentFile, PHP_URL_PATH);

// ---------------- VALIDACIÓN DE PUBLIC ENDPOINTS ----------------
$allowed = false;
foreach ($publicEndpoints as $w) {
    if ($currentFile === $w) {
        $allowed = true;
        break;
    }
    $wPath = parse_url($w, PHP_URL_PATH);
    $wQuery = parse_url($w, PHP_URL_QUERY);
    if ($path === $wPath && !$wQuery) {
        $allowed = true;
        break;
    }
}
if ($allowed) {
    return;
}

// ---------------- VALIDACIÓN DE RAÍZ ----------------
if (
    $path === '/' . $_ENV["APP_NAME"] . '/' ||
    $path === '/' . $_ENV["APP_NAME"] . '/index.php/' ||
    $path === '/' . $_ENV["APP_NAME"] . '/index.php' ||
    $path === '/' . $_ENV["APP_NAME"]
) {
    if (isset($_COOKIE["session"])) {
        $global_data = $jwt->decrypt($_COOKIE["session"]);
        if (($global_data->type ?? null) === 'session') {
            header("Location: " . Conectar::ruta() . "view/adminMain");
            exit();
        }
    }
}

// ---------------- VALIDACIÓN DE VISTAS ----------------
else if (strpos($_SERVER['SCRIPT_NAME'], '/view/') !== false) {
    $cookieName = null;

    if (isset($_COOKIE["2fa"])) {
        $cookieName = "2fa";
    } elseif (isset($_COOKIE["blanqueamiento"])) {
        $cookieName = "blanqueamiento";
    } elseif (isset($_COOKIE["session"])) {
        $cookieName = "session";
    } elseif (isset($_COOKIE["registro"])) {
        $cookieName = "registro";
    }

    if (!$cookieName) {
        header("Location: " . Conectar::ruta() . "view/404/");
        exit(); 
    }

    $global_data = $jwt->decrypt($_COOKIE[$cookieName]);

    if (!$global_data || $global_data->type != $cookieName) {
        header("Location: " . Conectar::ruta() . "view/404/");
        $jwt->setCookie($cookieName, "", -3600, "/" . $_ENV["APP_NAME"] . "/");
        exit();
    }
    else if ($global_data && $global_data->success == false) {
        header("Location: " . Conectar::ruta() . "view/401/");
        $jwt->setCookie($cookieName, "", -3600, "/" . $_ENV["APP_NAME"] . "/");
        exit();
    } elseif (!$global_data || !isset($global_data->type)) {
        header("Location: " . Conectar::ruta() . "view/404/");
        $jwt->setCookie($cookieName, "", -3600, "/" . $_ENV["APP_NAME"] . "/");
        exit();
    }
    else if ($global_data->data->usu_tipo == 'C') {
        foreach ($viewCiud as $w) {
            if ($currentFile === $w) {
                $allowed = true;
                break;
            }
            $wPath = parse_url($w, PHP_URL_PATH);
            $wQuery = parse_url($w, PHP_URL_QUERY);
            if ($path === $wPath && !$wQuery) {
                $allowed = true;
                break;
            }
        }
        if (!$allowed) {
            header("Location: " . Conectar::ruta() . "view/404/");
            exit();
        }
    }

    // ---------------- VALIDACIÓN POR TIPO ----------------
    $allowed = false;

    if ($global_data->type === 'registro') {
        foreach ($registerWhitelist as $w) {
            if ($currentFile === $w) {
                $allowed = true;
                break;
            }
            $wPath = parse_url($w, PHP_URL_PATH);
            $wQuery = parse_url($w, PHP_URL_QUERY);
            if ($path === $wPath && !$wQuery) {
                $allowed = true;
                break;
            }
        }
        if (!$allowed) {
            header("Location: " . Conectar::ruta() . "view/404/");
            exit();
        }
    }
    else if ($global_data->type === "blanqueamiento") {
        foreach ($resetWhitelist as $w) {
            if ($currentFile === $w) {
                $allowed = true;
                break;
            }
            $wPath = parse_url($w, PHP_URL_PATH);
            $wQuery = parse_url($w, PHP_URL_QUERY);
            if ($path === $wPath && !$wQuery) {
                $allowed = true;
                break;
            }
        }
        if (!$allowed) {
            header("Location: " . Conectar::ruta() . "view/404/a");
            exit();
        }
    }
    else if ($global_data->type === 'session') {
        foreach (array_merge($resetWhitelist, $dfaWhitelist, $registerWhitelist) as $w) {
            if ($currentFile === $w) {
                $allowed = true;
                break;
            }
            $wPath = parse_url($w, PHP_URL_PATH);
            $wQuery = parse_url($w, PHP_URL_QUERY);
            if ($path === $wPath && !$wQuery) {
                $allowed = true;
                break;
            }
        }
        if ($allowed) {
            header("Location: " . Conectar::ruta() . "view/404/");
            exit();
        }
    }
    else if ($global_data->type === '2fa') {
        foreach ($dfaWhitelist as $w) {
            if ($currentFile === $w) {
                $allowed = true;
                break;
            }
            $wPath = parse_url($w, PHP_URL_PATH);
            $wQuery = parse_url($w, PHP_URL_QUERY);
            if ($path === $wPath && !$wQuery) {
                $allowed = true;
                break;
            }
        }
        if (!$allowed) {
            header("Location: " . Conectar::ruta() . "view/404/");
            exit();
        }
    }
}

// ---------------- VALIDACIÓN DE API ----------------
else if (strpos($_SERVER['SCRIPT_NAME'], '/controller/') !== false) {
    header('Content-Type: application/json');

    if (!isset($headers['Authorization'])) {
        header('HTTP/1.1 401 Unauthorized');
        $jwt->response("El token no se ha proporcionado", [], false, 498);
        exit();
    }

    $token = str_replace('Bearer ', '', $headers['Authorization']);
    $global_data = $jwt->decrypt($token);

    if (!$global_data || !isset($global_data->type)) {
        header('HTTP/1.1 401 Unauthorized');
        $jwt->response($global_data->message ?? "Token inválido", [], false, 498);
        exit();
    }

    if ($global_data->type === "blanqueamiento") {
        $allowed = false;
        foreach ($resetWhitelist as $w) {
            if ($currentFile === $w) {
                $allowed = true;
                break;
            }
            $wPath = parse_url($w, PHP_URL_PATH);
            $wQuery = parse_url($w, PHP_URL_QUERY);
            if ($path === $wPath && !$wQuery) {
                $allowed = true;
                break;
            }
        }
        if (!$allowed) {
            header('HTTP/1.1 403 Forbidden');
            $jwt->response("Este endpoint requiere token sesión", [], false, 403);
            exit();
        }
    }
    elseif ($global_data->type === 'session') {
        $blocked = false;
        foreach (array_merge($resetWhitelist, $dfaWhitelist) as $w) {
            if ($currentFile === $w) {
                $blocked = true;
                break;
            }
            $wPath = parse_url($w, PHP_URL_PATH);
            $wQuery = parse_url($w, PHP_URL_QUERY);
            if ($path === $wPath && !$wQuery) {
                $blocked = true;
                break;
            }
        }
        if ($blocked) {
            header('HTTP/1.1 403 Forbidden');
            $jwt->response("No tiene acceso a este endpoint", [], false, 403);
            exit();
        }
    }
    elseif ($global_data->type === '2fa') {
        $allowed = false;
        foreach ($dfaWhitelist as $w) {
            if ($currentFile === $w) {
                $allowed = true;
                break;
            }
            $wPath = parse_url($w, PHP_URL_PATH);
            $wQuery = parse_url($w, PHP_URL_QUERY);
            if ($path === $wPath && !$wQuery) {
                $allowed = true;
                break;
            }
        }
        if (!$allowed) {
            header('HTTP/1.1 403 Forbidden');
            $jwt->response("Este endpoint requiere un token autorizado", [], false, 403);
            exit();
        }
    }
}

// siempre retorna algo (aunque sea null)
return $GLOBALS['data'] = $global_data;
