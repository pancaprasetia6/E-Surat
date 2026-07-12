<?php
// ========== PATH KEY FILE ==========
define('PRIVATE_KEY_RT', __DIR__ . '/private_key_rt.pem');
define('PUBLIC_KEY_RT', __DIR__ . '/public_key_rt.pem');
define('PRIVATE_KEY_RW', __DIR__ . '/private_key_rw.pem');
define('PUBLIC_KEY_RW', __DIR__ . '/public_key_rw.pem');

/**
 * Membuat tanda tangan digital berdasarkan level (RT/RW)
 * @param array $data Data yang akan ditandatangani
 * @param string $level 'rt' atau 'rw'
 * @return string|false Signature dalam base64
 */
function signData($data, $level = 'rt') {
    $dataJson = json_encode($data);
    
    if ($level == 'rt') {
        $privateKey = openssl_pkey_get_private(file_get_contents(PRIVATE_KEY_RT));
    } else {
        $privateKey = openssl_pkey_get_private(file_get_contents(PRIVATE_KEY_RW));
    }
    
    if (!$privateKey) return false;
    
    openssl_sign($dataJson, $signature, $privateKey, OPENSSL_ALGO_SHA256);
    return base64_encode($signature);
}

/**
 * Verifikasi tanda tangan digital
 * @param array $data Data asli
 * @param string $signatureBase64 Signature dalam base64
 * @param string $level 'rt' atau 'rw'
 * @return bool True jika valid
 */
function verifySignature($data, $signatureBase64, $level = 'rt') {
    $dataJson = json_encode($data);
    $signature = base64_decode($signatureBase64);
    
    if ($level == 'rt') {
        $publicKey = openssl_pkey_get_public(file_get_contents(PUBLIC_KEY_RT));
    } else {
        $publicKey = openssl_pkey_get_public(file_get_contents(PUBLIC_KEY_RW));
    }
    
    if (!$publicKey) return false;
    
    $result = openssl_verify($dataJson, $signature, $publicKey, OPENSSL_ALGO_SHA256);
    return $result === 1;
}

/**
 * Generate QR Code untuk level tertentu (RT/RW)
 * @param string $signatureBase64 Signature dalam base64
 * @param string $idRequest ID request surat
 * @param string $jenisSurat sktm/sku/skd
 * @param string $level 'rt' atau 'rw'
 * @return string Path file QR Code
 */
function generateQRCode($signatureBase64, $idRequest, $jenisSurat, $level = 'rt') {
    // Deteksi base URL
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $baseUrl = $protocol . "://" . $host . "/web_rw12/demo1";
    
    // URL verifikasi dengan parameter level
    $verificationUrl = $baseUrl . "/verifikasi.php?id=" . $idRequest . "&jenis=" . $jenisSurat . "&level=" . $level;
    
    // Buat folder qrcodes jika belum ada
    $qrDir = __DIR__ . '/qrcodes';
    if (!file_exists($qrDir)) {
        mkdir($qrDir, 0777, true);
    }
    
    // Path file QR (beda nama untuk RT dan RW)
    $qrFile = $qrDir . '/' . $jenisSurat . '_' . $idRequest . '_' . $level . '.png';
    
    // Load library phpqrcode
    require_once __DIR__ . '/libs/phpqrcode/qrlib.php';
    
    // Generate QR Code
    QRcode::png($verificationUrl, $qrFile, QR_ECLEVEL_L, 10);
    
    return 'qrcodes/' . $jenisSurat . '_' . $idRequest . '_' . $level . '.png';
}
?> 