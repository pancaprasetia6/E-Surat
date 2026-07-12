<?php
session_start();
echo "<pre>";
echo "1. Session nik: " . ($_SESSION['nik'] ?? 'TIDAK ADA') . "\n";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto_ktp'])) {
    echo "2. File diterima: " . $_FILES['foto_ktp']['name'] . "\n";
    
    $target_dir = "scan_ktp/";
    $file_name = time() . "_" . basename($_FILES['foto_ktp']['name']);
    $target_file = $target_dir . $file_name;
    
    if (move_uploaded_file($_FILES['foto_ktp']['tmp_name'], $target_file)) {
        echo "3. File berhasil diupload ke: " . $target_file . "\n";
        
        $apiKey = "K87057573988957"; // Ganti dengan API key lo
        
        $postData = [
            'apikey' => $apiKey,
            'file' => new CURLFile($target_file), 
            'OCREngine' => '2'
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.ocr.space/parse/image");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        
        $result = json_decode($response, true);
        
        echo "4. Response dari OCR:\n";
        print_r($result);
        
    } else {
        echo "3. GAGAL upload file! Cek folder scan_kpt/\n";
    }
}
echo "</pre>";
?>

<form method="POST" enctype="multipart/form-data">
    <input type="file" name="foto_ktp" accept="image/*" required>
    <button type="submit">Test OCR</button>
</form>