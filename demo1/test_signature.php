<?php
include 'signature_functions.php';

// Data contoh
$data = [
    'nik' => '3174090609020003',
    'nama' => 'PANCA PRASETIA',
    'keperluan' => 'BPJS',
    'tanggal' => date('Y-m-d H:i:s')
];

echo "=== TEST DIGITAL SIGNATURE ===\n\n";

// 1. Buat signature
$signature = signData($data);
echo "1. Signature (base64):\n" . $signature . "\n\n";

// 2. Verifikasi signature (seharusnya valid)
$valid = verifySignature($data, $signature);
echo "2. Verifikasi signature: " . ($valid ? "✅ VALID" : "❌ INVALID") . "\n\n";

// 3. Ubah data sedikit (contoh: nama diganti)
$dataUbah = $data;
$dataUbah['nama'] = 'NAMA DIGANTI';
$valid2 = verifySignature($dataUbah, $signature);
echo "3. Verifikasi dengan data berbeda: " . ($valid2 ? "✅ VALID" : "❌ INVALID (seharusnya invalid)") . "\n";
?>