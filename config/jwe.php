<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Jose\Component\Core\JWK;
use Jose\Component\Encryption\JWEBuilder;
use Jose\Component\Encryption\JWEDecrypter;
use Jose\Component\Encryption\Serializer\CompactSerializer;
use Jose\Component\Encryption\Algorithm\KeyEncryption\A256KW;
use Jose\Component\Encryption\Algorithm\ContentEncryption\A256CBCHS512;
use Jose\Component\Core\AlgorithmManager;
use Jose\Component\Encryption\Compression\CompressionMethodManager;
use Jose\Component\Core\Util\Base64UrlSafe;
use Dotenv\Dotenv;

// Cargar el archivo .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ==========================
// 1. Generar o definir una clave secreta compartida (32 bytes para AES-256)
// ==========================
$sharedSecret = substr(hash('sha256', $_ENV['JWE_SECRET'], true), 0, 32);

// ==========================
// 2. Crear JWK con la clave compartida (CORRECTO)
// ==========================
$jwk = new JWK([
    'kty' => 'oct',
    'k' => Base64UrlSafe::encodeUnpadded($sharedSecret), // Codificación correcta sin padding
    'use' => 'enc'
]);

// ==========================
// 3. Configurar algoritmos y compresión
// ==========================
$keyEncryptionAlgorithmManager = new AlgorithmManager([
    new A256KW(), // AES Key Wrap con clave de 256 bits
]);

$contentEncryptionAlgorithmManager = new AlgorithmManager([
    new A256CBCHS512(), // AES 256 en modo CBC con HMAC SHA-512
]);

$compressionManager = new CompressionMethodManager([]); // Sin compresión

// ==========================
// 4. Función para encriptar (Versión definitiva)
// ==========================
function encryptJWE($payload, $jwk) {
    global $keyEncryptionAlgorithmManager, $contentEncryptionAlgorithmManager, $compressionManager;
    
    $jweBuilder = new JWEBuilder(
        $keyEncryptionAlgorithmManager,
        $contentEncryptionAlgorithmManager,
        $compressionManager
    );
    
    $jwe = $jweBuilder
        ->create()
        ->withPayload($payload)
        ->withSharedProtectedHeader([
            'alg' => 'A256KW',
            'enc' => 'A256CBC-HS512'
        ])
        ->addRecipient($jwk)
        ->build();
    
    return (new CompactSerializer())->serialize($jwe, 0);
}

// ==========================
// 5. Función para desencriptar (Versión definitiva)
// ==========================
function decryptJWE($token, $jwk) {
    global $keyEncryptionAlgorithmManager, $contentEncryptionAlgorithmManager, $compressionManager;
    
    $jweDecrypter = new JWEDecrypter(
        $keyEncryptionAlgorithmManager,
        $contentEncryptionAlgorithmManager,
        $compressionManager
    );
    
    $jwe = (new CompactSerializer())->unserialize($token);
    
    if ($jweDecrypter->decryptUsingKey($jwe, $jwk, 0)) {
        return $jwe->getPayload();
    }
    
    return false;
}

// ==========================
// 6. Ejemplo de uso
// ==========================
// $payload = json_encode(['user' => 'giancarlos', 'role' => 'admin']);

// Encriptar
// $start = microtime(true);
// $token = encryptJWE($payload, $jwk);
// echo "JWE Token: $token <br><br>";


// $token = 'eyJhbGciOiJBMjU2S1ciLCJlbmMiOiJBMjU2Q0JDLUhTNTEyIn0.YZ9vhYmPEXt1U3yJBlxiouOC4Vk_VrtNc2wBgrJvJDTLG8Tq4g52zGgv-EWhTTUYfxDroav2llt2E54FeJEWf6N0eLxRGTXd.8Y4ZkuCDynlq9rXyFQNb_g.iyf_hmG8rmE0zwuz8PJaxu--7aWxDM4CREaqreXrD0ZA-PeUtyVvA7jnQ7Esxhb6iPQLYVuwRpzWFKcGTUnyk4OVvIyE5Cp-biacaFcowq3pTwI_SXgrqhJQP-yLtaZoEDKm-DBGXXiLsddomC6Nd_owcjMVx1v12mIE6YsIm9XBl-YVsmPZIIwdfPM1OvkLONc7bM4X9_473bx8WY4mVF8HnDMh6uOFEwFdszOYa92prAY0kjSr8kNpv0Jjhs6U3UMMqxs1y68dIlIUAH_Be_CyNgrb5S1iHbRoUq2cw5wqrl3N9UBOaL6LreibfB9VOUfoDLu-PE3z3FSw1PhG09gs_GCgwpg34cE_9T4YNabo8XC9UKVdKEpVdnIUcy6XLN6DRwsEtR7VRZURlVG0Vgn60mVw04MP5xDRQ5NHf4oulTcSV1JX2ypucOtQskTpBhkLmIFE6PapsCGwzbMPFYk8gDtKRJv6-QndWu26HEBCK9ckeTmNDc379jFVZPqRlhuWHtPuXCUDL0omNfKDsuTvSkNyPreKDZ-wFsegeq1mjxV4z22mhafZnIhD71jEsojB8g_1W-Tel6FQuw99x7SoylJKoHSgSQ9uX0mlNfWF_Q9V1oMFEE4u8S8NrAFm9Q9MBzeH3BubkrsiScc7MRFNKXHM0R3BivjNgWg55-A-oeJ8aN4BF2P8RCJAYBvRY4tQmFsUTwAW8AsTCdgCaHy-w07-ylaca5GtM_g-ROafK9Bn4pckW2oOdkOT0tzwngVBPpDWBQn49Cwm79LbRw.Os8LR6nf8gKqtNHTuzb9PggQG0GcyBuf7CDTO-GTDig';
// $decrypted = decryptJWE($token, $jwk);
// echo "Payload: $decrypted <br><br>";