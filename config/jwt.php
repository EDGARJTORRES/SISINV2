<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/jwe.php'; // Asegúrate de que la ruta sea correcta

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;

use Jose\Component\Core\JWK;
use Jose\Component\Core\Util\Base64UrlSafe;

use Dotenv\Dotenv;

// Cargar el archivo .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad(); // Usar safeLoad() para evitar errores si el archivo no existe

error_reporting(E_ALL);
ini_set('display_errors', 1);

class JwtHandler {
    private $jwt_key;
    private $jwe_key;
    private $algorithm = 'HS256';

    public function __construct() {
        $this->jwt_key = $_ENV['JWT_SECRET'] ?? ''; // Usar operador null coalescing

        $sharedSecret = substr(hash('sha256', $_ENV['JWE_SECRET'] ?? '', true), 0, 32);
        $this->jwe_key = new JWK([
            'kty' => 'oct',
            'k' => Base64UrlSafe::encodeUnpadded($sharedSecret),
            'use' => 'enc'
        ]);
    }

    public function response($message, $data = [], $suc = true, $httpStatusCode = 200) {
        date_default_timezone_set('UTC');
        $status = $httpStatusCode;
        $success = $suc;
        $timestamp = date("Y-m-d H:i:s");
        http_response_code($httpStatusCode);
        echo json_encode(compact('timestamp', 'status', 'success', 'message', 'data'), JSON_UNESCAPED_UNICODE);
        exit();
    }

    public function encrypt($data = null, $type = '', $time = 500) {
        try {
            $payload = [
                'iss' => $_ENV["DB_HOST"] ?? 'localhost',
                'aud' => $_ENV["DB_HOST"] ?? 'localhost',
                'success' => 'true',
                'type' => $type,
                'iat' => time(),
                'exp' => time() + $time,
                'system' => [
                    "BASE_URL" => $_ENV["BASE_URL"],
                    "DOMAIN" => $_ENV["DOMAIN"],
                    "APP_NAME" => $_ENV["APP_NAME"]
                ],
                'data' => $data
            ];
            
            $data = JWT::encode($payload, $this->jwt_key, $this->algorithm);
            return encryptJWE($data, $this->jwe_key);
        } catch (Exception $e) {
            $this->response("Error al encriptar: " . $e->getMessage(), [], false, 500);
        }
    }

    public function decrypt($token) {
        try {
            $decrypted = decryptJWE($token, $this->jwe_key);
            return JWT::decode($decrypted, new Key($this->jwt_key, $this->algorithm));
        } catch (ExpiredException $e) {
            return (object)[
                "message" => "El token ha expirado",
                "success" => false,
                "status" => 498
            ];
        } catch (SignatureInvalidException $e) {
            return (object)[
                "message" => "La firma es inválida",
                "success" => false,
                "status" => 498
            ];
        } catch (BeforeValidException $e) {
            return (object)[
                "message" => "El token aún no es válido",
                "success" => false,
                "status" => 498
            ];
        } catch (Exception $e) {
            return (object)[
                "message" => "Token inválido: " . $e->getMessage(),
                "success" => false,
                "status" => 498
            ];
        }
    }

    public function setCookie(string $name, $value, int $time = 0, string $path = '/')
    {
        try {
            // Si el valor es array u objeto, lo convertimos a JSON
            if (is_array($value) || is_object($value)) {
                $value = json_encode($value, JSON_UNESCAPED_UNICODE);
            }

            // Si es tiempo relativo, sumamos a la hora actual
            $expires = $time > 0 ? time() + $time : 0;

            if ($path !== '/') {
                // Elimina posibles slashes duplicados
                $path = '/' . trim($path, '/') . '/';
            }

            // Opciones de cookie seguras
            $options = [
                "expires"  => $expires,
                "path"     => $path,
                "domain"   => $_ENV["DOMAIN"] ?? "", // Evita error si no existe
                "secure"   => ($_ENV["APP_ENV"] ?? "dev") === "produccion",
                "httponly" => true,
                "samesite" => "Strict"
            ];

            // Crear cookie
            setcookie($name, $value, $options);

            return true;
        } catch (\Throwable $e) {
            $this->response("Error al asignar el cookie: " . $e->getMessage(), [], false, 500);
            return false;
        }
    }



}