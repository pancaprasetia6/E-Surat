<?php
include '../konek.php'; 

$session_nik = $_SESSION['nik'] ?? '1234';
$scan_success = false;
$error_message = '';
$scan_kk_success = false;
$error_message_kk = '';

// ========== PROSES OCR KTP ==========
if (isset($_POST['submit_scan_ktp'])) {
    if (isset($_FILES['foto_ktp_scan']) && $_FILES['foto_ktp_scan']['error'] == 0) {

        $target_dir = "scan_ktp/";
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);

        $file_name = time() . "_" . basename($_FILES['foto_ktp_scan']['name']);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES['foto_ktp_scan']['tmp_name'], $target_file)) {

            $apiKey = "K87057573988957";

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

            if ($result && isset($result['OCRExitCode']) && $result['OCRExitCode'] == 1 && isset($result['ParsedResults'][0]['ParsedText'])) {
                $ocrText = $result['ParsedResults'][0]['ParsedText'];

                $ocr_data = [];

                if (preg_match('/NIK\s*:?\s*(\d{16})/', $ocrText, $matches)) {
                    $ocr_data['nik'] = $matches[1];
                } elseif (preg_match('/(\d{16})/', $ocrText, $matches)) {
                    $ocr_data['nik'] = $matches[1];
                }

                if (preg_match('/Nama\s*:?\s*([A-Z\s]+?)(?=\n|$)/i', $ocrText, $matches)) {
                    $ocr_data['nama'] = trim($matches[1]);
                }

                if (preg_match('/Tempat\/Tgi\s*Lahir\s*:?\s*([A-Z\s]+?),/i', $ocrText, $matches)) {
                    $ocr_data['tempat_lahir'] = trim($matches[1]);
                }

                if (preg_match('/(\d{2})-(\d{2})-(\d{4})/', $ocrText, $matches)) {
                    $ocr_data['tanggal_lahir'] = $matches[3] . '-' . $matches[2] . '-' . $matches[1];
                }

                if (preg_match('/Jenis\s*kelamin\s*:?\s*([A-Z\-]+)/i', $ocrText, $matches)) {
                    $jekel_raw = $matches[1];
                    $ocr_data['jekel'] = ($jekel_raw == 'LAKI-LAKI') ? 'Laki-Laki' : (($jekel_raw == 'PEREMPUAN') ? 'Perempuan' : $jekel_raw);
                }

                if (preg_match('/Alamat\s*:?\s*([^\n]+)/i', $ocrText, $matches)) {
                    $ocr_data['alamat'] = trim($matches[1]);
                }

                if (preg_match('/RT\/RW\s*:?\s*(\d+)\s*\/\s*(\d+)/i', $ocrText, $matches)) {
                    $ocr_data['rt'] = $matches[1];
                    $ocr_data['rw'] = $matches[2];
                }

                if (preg_match('/Agama\s*:?\s*([A-Z]+)/i', $ocrText, $matches)) {
                    $ocr_data['agama'] = ucfirst(strtolower($matches[1]));
                }

                if (preg_match('/Status\s*Perkawinan\s*:?\s*([A-Z\s]+?)(?=\n|$)/i', $ocrText, $matches)) {
                    $status_raw = trim($matches[1]);
                    if ($status_raw == 'BELUM KAWIN') $ocr_data['status_perkawinan'] = 'Belum Menikah';
                    elseif ($status_raw == 'KAWIN') $ocr_data['status_perkawinan'] = 'Menikah';
                    else $ocr_data['status_perkawinan'] = $status_raw;
                }

                if (preg_match('/Pekerjaan\s*:?\s*([A-Z\/\s]+?)(?=\n|$)/i', $ocrText, $matches)) {
                    $ocr_data['pekerjaan'] = trim($matches[1]);
                }

                $_SESSION['ocr_data'] = $ocr_data;
                $scan_success = true;

                // Simpan path foto KTP ke database
                $update_foto_ktp = "UPDATE data_user SET foto_ktp = '$target_file' WHERE nik = '$session_nik'";
                mysqli_query($konek, $update_foto_ktp);
            } else {
                $error_message = "Gagal scan KTP. Pastikan foto KTP jelas.";
            }
        } else {
            $error_message = "Gagal upload file";
        }
    }
}

// ========== PROSES OCR KK ==========
if (isset($_POST['submit_scan_kk'])) {
    if (isset($_FILES['foto_kk_scan']) && $_FILES['foto_kk_scan']['error'] == 0) {

        $target_dir_kk = "scan_kk/";
        if (!file_exists($target_dir_kk)) mkdir($target_dir_kk, 0777, true);

        $file_name_kk = time() . "_kk_" . basename($_FILES['foto_kk_scan']['name']);
        $target_file_kk = $target_dir_kk . $file_name_kk;

        if (move_uploaded_file($_FILES['foto_kk_scan']['tmp_name'], $target_file_kk)) {

            $apiKey = "K87057573988957";

            $postData_kk = [
                'apikey' => $apiKey,
                'file' => new CURLFile($target_file_kk),
                'OCREngine' => '2'
            ];

            $ch_kk = curl_init();
            curl_setopt($ch_kk, CURLOPT_URL, "https://api.ocr.space/parse/image");
            curl_setopt($ch_kk, CURLOPT_POST, true);
            curl_setopt($ch_kk, CURLOPT_POSTFIELDS, $postData_kk);
            curl_setopt($ch_kk, CURLOPT_RETURNTRANSFER, true);
            $response_kk = curl_exec($ch_kk);
            curl_close($ch_kk);

            $result_kk = json_decode($response_kk, true);

            if ($result_kk && isset($result_kk['OCRExitCode']) && $result_kk['OCRExitCode'] == 1 && isset($result_kk['ParsedResults'][0]['ParsedText'])) {
                $ocrTextKK = $result_kk['ParsedResults'][0]['ParsedText'];

                $kk_data = [];

                if (preg_match('/No\.\s*(\d{16})/', $ocrTextKK, $matches)) {
                    $kk_data['no_kk'] = $matches[1];
                } elseif (preg_match('/(\d{16})/', $ocrTextKK, $matches)) {
                    $kk_data['no_kk'] = $matches[1];
                }

                $nama_kk_temp = '';
                $lines = explode("\n", $ocrTextKK);

                for ($i = 0; $i < count($lines); $i++) {
                    $line = trim($lines[$i]);

                    if (preg_match('/No\.\s*\d{16}/', $line) || preg_match('/\d{16}/', $line)) {
                        if (isset($lines[$i + 1])) {
                            $nama_kk_temp = trim($lines[$i + 1]);
                            $nama_kk_temp = preg_replace('/\d+/', '', $nama_kk_temp);
                            $nama_kk_temp = preg_replace('/[^A-Za-z\s\.]/', '', $nama_kk_temp);
                            $nama_kk_temp = trim(preg_replace('/\s+/', ' ', $nama_kk_temp));
                            break;
                        }
                    }
                }

                if (empty($nama_kk_temp)) {
                    if (preg_match('/(?:KEPALA\s*KELUARGA|Nama\s*Keluarga)\s*:?\s*([A-Z\s\.]+)/i', $ocrTextKK, $matches)) {
                        $nama_kk_temp = trim($matches[1]);
                        $nama_kk_temp = preg_replace('/[^A-Za-z\s\.]/', '', $nama_kk_temp);
                        $nama_kk_temp = trim(preg_replace('/\s+/', ' ', $nama_kk_temp));
                    }
                }

                if (!empty($nama_kk_temp)) {
                    $nama_kk_temp = ucwords(strtolower($nama_kk_temp));
                }

                $kk_data['nama_kk'] = $nama_kk_temp;
                $kk_data['debug_text'] = $ocrTextKK;

                $_SESSION['kk_data'] = $kk_data;
                $scan_kk_success = true;

                // Simpan path foto KK ke database
                $update_foto_kk = "UPDATE data_user SET foto_kk = '$target_file_kk' WHERE nik = '$session_nik'";
                mysqli_query($konek, $update_foto_kk);

                file_put_contents('debug_kk.txt', "OCR Text:\n" . $ocrTextKK . "\n\nParsed:\nNo KK: " . ($kk_data['no_kk'] ?? '-') . "\nNama KK: " . ($kk_data['nama_kk'] ?? '-'));
            } else {
                $error_message_kk = "Gagal scan KK. Pastikan foto KK jelas.";
            }
        } else {
            $error_message_kk = "Gagal upload file KK";
        }
    }
}

// ========== PROSES UPLOAD FOTO PROFIL ==========
$foto_profil_upload = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] == 0) {
    $target_dir_profil = "uploads/profil/";
    if (!file_exists($target_dir_profil)) mkdir($target_dir_profil, 0777, true);

    $ext = pathinfo($_FILES['foto_profil']['name'], PATHINFO_EXTENSION);
    $nama_foto = time() . "_" . $session_nik . "." . $ext;
    $target_file_profil = $target_dir_profil . $nama_foto;

    if (move_uploaded_file($_FILES['foto_profil']['tmp_name'], $target_file_profil)) {
        $foto_profil_upload = $nama_foto;
    }
}

// ========== PROSES SIMPAN BIODATA ==========
if (isset($_POST['simpan'])) {

    $nama_input = $_POST['nama'] ?? '';
    $no_kk_input = $_POST['no_kk'] ?? '';
    $nama_kk_input = $_POST['nama_kk'] ?? '';
    $tempat_input = $_POST['tempat'] ?? '';
    $tgl_input = $_POST['tgl'] ?? '';
    $jekel_input = $_POST['jekel'] ?? '';
    $agama_input = $_POST['agama'] ?? '';
    $alamat_input = $_POST['alamat'] ?? '';
    $rt_input = $_POST['rt'] ?? '';
    $rw_input = $_POST['rw'] ?? '';
    $pekerjaan_input = $_POST['pekerjaan'] ?? '';
    $status_perkawinan_input = $_POST['status_perkawinan'] ?? '';
    $warga_negara_input = $_POST['warga_negara'] ?? '';
    $telepon_input = $_POST['telepon'] ?? '';
    $email_input = $_POST['email'] ?? '';

    $query_foto = "SELECT foto_profil FROM data_user WHERE nik = '$session_nik'";
    $result_foto = mysqli_query($konek, $query_foto);
    $data_foto = mysqli_fetch_assoc($result_foto);
    $foto_profil_final = $data_foto['foto_profil'] ?? '';

    if (!empty($foto_profil_upload)) {
        $foto_profil_final = $foto_profil_upload;
    }

    $update_sql = "UPDATE data_user SET
        nama = '$nama_input',
        no_kk = '$no_kk_input',
        nama_kk = '$nama_kk_input',
        tempat_lahir = '$tempat_input',
        tanggal_lahir = '$tgl_input',
        jekel = '$jekel_input',
        agama = '$agama_input',
        alamat = '$alamat_input',
        rt = '$rt_input',
        rw = '$rw_input',
        pekerjaan = '$pekerjaan_input',
        status_perkawinan = '$status_perkawinan_input',
        warga_negara = '$warga_negara_input',
        telepon = '$telepon_input',
        email = '$email_input', 
        foto_profil = '$foto_profil_final',
        is_biodata_complete = 1    
        WHERE nik = '$session_nik'";

    if (mysqli_query($konek, $update_sql)) {
        unset($_SESSION['ocr_data']);
        unset($_SESSION['kk_data']);
        echo "<script>alert('Biodata berhasil disimpan!'); window.location.href='?halaman=tampil_pemohon&nik=$session_nik';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal simpan: " . mysqli_error($konek) . "');</script>";
    }
}

// ========== AMBIL DATA DARI DATABASE ==========
$query = "SELECT * FROM data_user WHERE nik = '$session_nik'";
$result = mysqli_query($konek, $query);
$data = mysqli_fetch_assoc($result);

$nik_db = $data['nik'] ?? '';
$nama_db = $data['nama'] ?? '';
$no_kk_db = $data['no_kk'] ?? '';
$nama_kk_db = $data['nama_kk'] ?? '';
$tempat_db = $data['tempat_lahir'] ?? '';
$tanggal_db = $data['tanggal_lahir'] ?? '';
$jekel_db = $data['jekel'] ?? '';
$agama_db = $data['agama'] ?? '';
$alamat_db = $data['alamat'] ?? '';
$rt_db = $data['rt'] ?? '';
$rw_db = $data['rw'] ?? '';
$pekerjaan_db = $data['pekerjaan'] ?? '';
$status_perkawinan_db = $data['status_perkawinan'] ?? '';
$warga_negara_db = $data['warga_negara'] ?? '';
$telepon_db = $data['telepon'] ?? '';
$email_db = $data['email'] ?? '';
$foto_profil_db = $data['foto_profil'] ?? '';
$foto_ktp_db = $data['foto_ktp'] ?? '';
$foto_kk_db = $data['foto_kk'] ?? '';

$ocr_data = $_SESSION['ocr_data'] ?? [];
$kk_data = $_SESSION['kk_data'] ?? [];

// ========== PRIORITAS DATA ==========
$nik = $nik_db;
$nama = $ocr_data['nama'] ?? $nama_db;
$no_kk = $kk_data['no_kk'] ?? $no_kk_db;
$nama_kk = $kk_data['nama_kk'] ?? $nama_kk_db;
$tempat = $ocr_data['tempat_lahir'] ?? $tempat_db;
$tanggal = $ocr_data['tanggal_lahir'] ?? $tanggal_db;
$jekel = $ocr_data['jekel'] ?? $jekel_db;
$agama = $ocr_data['agama'] ?? $agama_db;
$alamat = $ocr_data['alamat'] ?? $alamat_db;
$rt = $ocr_data['rt'] ?? $rt_db;
$rw = $ocr_data['rw'] ?? $rw_db;
$pekerjaan = $ocr_data['pekerjaan'] ?? $pekerjaan_db;
$status_perkawinan = $ocr_data['status_perkawinan'] ?? $status_perkawinan_db;
$warga_negara = $ocr_data['warga_negara'] ?? $warga_negara_db;
$telepon = $telepon_db;
$email = $email_db;
$foto_profil = $foto_profil_db;
$foto_ktp = $foto_ktp_db;
$foto_kk = $foto_kk_db;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Biodata</title>
    <link href="css/sweetalert.css" rel="stylesheet" type="text/css">
    <script src="js/jquery-2.1.3.min.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f2f5; }
        .page-inner { max-width: 1400px; margin: 0 auto; padding: 30px 20px; }
        .main-card { background: white; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); overflow: hidden; }
        .card-header { background: linear-gradient(135deg, #8f9baaff 0%, #464f58ff 100%); padding: 20px 25px; color: white; }
        .card-header h3 { margin: 0; font-size: 22px; font-weight: 600; }
        .card-header p { margin: 5px 0 0; opacity: 0.9; font-size: 13px; }
        .card-body { padding: 25px; }

        .scan-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px; }
        .scan-card { border-radius: 14px; padding: 18px; border: 2px solid #e0e0e0; background: #fafafa; }
        .scan-card.ktp { background: linear-gradient(135deg, #e3f2fd 0%, #e8edf2 100%); border-color: #050d14; }
        .scan-card.kk { background: linear-gradient(135deg, #e3f2fd 0%, #e8edf2 100%); border-color: #11100d; }
        .scan-card h4 { font-size: 16px; margin-bottom: 8px; display: flex; align-items: center; gap: 8px; }
        .scan-card p { font-size: 12px; color: #555; margin-bottom: 10px; }

        .file-input-wrapper input[type="file"] { width: 100%; padding: 10px; border: 2px dashed #ccc; border-radius: 8px; background: white; cursor: pointer; font-size: 13px; }
        .file-input-wrapper input[type="file"]:hover { border-color: #667eea; background: #f5f5f5; }

        .btn-scan { background: linear-gradient(135deg, #464f58ff 0%, #2c3e50 100%); color: white; border: none; padding: 8px 16px; border-radius: 6px; font-weight: 600; cursor: pointer; transition: transform 0.2s; width: 100%; font-size: 13px; }
        .btn-scan:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.2); }

        .alert-success { background: #4caf50; color: white; padding: 8px 12px; border-radius: 6px; margin-top: 10px; font-size: 12px; display: flex; align-items: center; gap: 8px; }
        .alert-danger { background: #f44336; color: white; padding: 8px 12px; border-radius: 6px; margin-top: 10px; font-size: 12px; display: flex; align-items: center; gap: 8px; }

        .photo-section { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); border-radius: 14px; padding: 20px; margin-bottom: 25px; text-align: center; }
        .photo-preview { width: 140px; height: 140px; border-radius: 50%; overflow: hidden; margin: 0 auto 12px; background: white; border: 4px solid #8f9baaff; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
        .photo-preview img { width: 100%; height: 100%; object-fit: cover; }
        .photo-placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 50px; color: #8f9baaff; background: #f0f0f0; }

        .upload-btn-wrapper { position: relative; overflow: hidden; display: inline-block; }
        .upload-btn { background: linear-gradient(135deg, #8f9baaff 0%, #464f58ff 100%); color: white; padding: 10px 25px; border-radius: 6px; border: none; font-weight: 600; cursor: pointer; font-size: 13px; }
        .upload-btn-wrapper input[type=file] { position: absolute; left: 0; top: 0; opacity: 0; width: 100%; height: 100%; cursor: pointer; }
        .photo-info { font-size: 11px; color: #666; margin-top: 8px; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 5px; color: #333; font-size: 12px; }
        .form-group label i { width: 20px; }
        .form-control { width: 100%; padding: 10px 14px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 13px; transition: all 0.3s; background: white; }
        .form-control:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,0.1); }
        textarea.form-control { resize: vertical; min-height: 70px; }
        .rt-rw-group { display: flex; gap: 12px; }
        .rt-rw-group .form-control { flex: 1; }

        .card-action { padding: 18px 25px; background: #f8f9fa; border-top: 1px solid #e0e0e0; display: flex; gap: 12px; justify-content: flex-end; }
        .btn { padding: 10px 25px; border-radius: 6px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s; cursor: pointer; border: none; font-size: 13px; }
        .btn-success { background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; }
        .btn-success:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(40,167,69,0.3); }
        .btn-default { background: #6c757d; color: white; }
        .btn-default:hover { background: #5a6268; transform: translateY(-2px); }

        @media (max-width: 768px) {
            .scan-grid { grid-template-columns: 1fr; }
            .form-grid { grid-template-columns: 1fr; gap: 12px; }
            .card-body { padding: 15px; }
            .card-action { flex-direction: column; }
            .btn { justify-content: center; }
        }
    </style>
</head>
<body>
<div class="page-inner">
    <div class="main-card">
        <div class="card-header">
            <h3><i class="fas fa-user-edit"></i> Ubah Biodata</h3>
            <p>Lengkapi data diri Anda dengan benar.</p>
        </div>
        
        <div class="card-body">
            
            <!-- ============================================================ -->
            <!-- FORM SCAN KTP & KK (SEJAR DALAM 1 FORM) -->
            <!-- ============================================================ -->
            <form method="POST" enctype="multipart/form-data" action="">
                <div class="scan-grid">
                    <!-- Scan KTP -->
                    <div class="scan-card ktp">
                        <h4><i class="fas fa-id-card"></i> KTP</h4>
                        <p>Silahkan upload foto KTP anda!</p>
                        <div class="file-input-wrapper">
                            <input type="file" name="foto_ktp_scan" accept="image/*" >
                        </div>
                        <button type="submit" name="submit_scan_ktp" class="btn-scan">
                            <i class="fas fa-qrcode"></i> Upload & Scan KTP
                        </button>
                        
                        <?php if ($scan_success): ?>
                            <div class="alert-success"><i class="fas fa-check-circle"></i> Scan berhasil!</div>
                        <?php endif; ?>
                        
                        <?php if (!empty($error_message)): ?>
                            <div class="alert-danger"><i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($error_message) ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Scan KK -->
                    <div class="scan-card kk">
                        <h4><i class="fas fa-users"></i> Kartu Keluarga</h4>
                        <p>Silahkan upload foto KK anda!</p>
                        <div class="file-input-wrapper">
                            <input type="file" name="foto_kk_scan" accept="image/*"  >
                        </div>
                        <button type="submit" name="submit_scan_kk" class="btn-scan">
                            <i class="fas fa-qrcode"></i> Upload & Scan KK
                        </button>
                        
                        <?php if ($scan_kk_success): ?>
                            <div class="alert-success" style="background: #ff9800;"><i class="fas fa-check-circle"></i> Scan KK berhasil!</div>
                        <?php endif; ?>
                        
                        <?php if (!empty($error_message_kk)): ?>
                            <div class="alert-danger"><i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($error_message_kk) ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
            
            <!-- ============================================================ -->
            <!-- FORM BIODATA UTAMA -->
            <!-- ============================================================ -->
            <form method="POST" enctype="multipart/form-data" action="">
                
                <!-- Foto Profil -->
                <div class="photo-section">
                    <h4 style="margin-bottom: 12px;"><i class="fas fa-camera"></i> Foto Profil</h4>
                    <div class="photo-preview" id="photoPreview">
                        <?php if (!empty($foto_profil)): ?>
                            <img src="uploads/profil/<?= htmlspecialchars($foto_profil) ?>" alt="Foto Profil" id="previewImage">
                        <?php else: ?>
                            <div class="photo-placeholder"><i class="fas fa-user-circle"></i></div>
                        <?php endif; ?>
                    </div>
                    <div class="upload-btn-wrapper">
                        <button type="button" class="upload-btn"><i class="fas fa-upload"></i> Pilih Foto Profil</button>
                        <input type="file" name="foto_profil" id="foto_profil" accept="image/*">
                    </div>
                    <div class="photo-info">Format: JPG, PNG (Maks. 2MB) | Rekomendasi: 1:1</div>
                </div>
                
                <!-- Form Biodata -->
                <div class="form-grid">
                    <div>
                        <div class="form-group">
                            <label><i class="fas fa-id-card"></i> NIK</label>
                            <input type="text" name="nik" class="form-control" value="<?= htmlspecialchars($nik) ?>" readonly style="background:#f0f0f0;">
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-hashtag"></i> No. Kartu Keluarga</label>
                            <input type="text" name="no_kk" class="form-control" value="<?= htmlspecialchars($no_kk) ?>" placeholder="16 digit nomor KK" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-user"></i> Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($nama) ?>" placeholder="Nama sesuai KTP" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-user-tie"></i> Nama Kepala Keluarga</label>
                            <input type="text" name="nama_kk" class="form-control" value="<?= htmlspecialchars($nama_kk) ?>" placeholder="Nama kepala keluarga" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-venus-mars"></i> Jenis Kelamin</label>
                            <select class="form-control" name="jekel" required>
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-Laki" <?= ($jekel == 'Laki-Laki') ? 'selected' : '' ?>>Laki-Laki</option>
                                <option value="Perempuan" <?= ($jekel == 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-map-marker-alt"></i> Tempat Lahir</label>
                            <input type="text" name="tempat" class="form-control" value="<?= htmlspecialchars($tempat) ?>" placeholder="Kota tempat lahir" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-map-marker-alt"></i> Warga Negara</label>
                            <input type="text" name="warga_negara" class="form-control" value="<?= htmlspecialchars($warga_negara) ?>" placeholder="Masukkan Kewarganegaraan Anda" required>
                        </div>
                    </div>
                    
                    <div>
                        <div class="form-group">
                            <label><i class="fas fa-calendar-alt"></i> Tanggal Lahir</label>
                            <input type="date" name="tgl" class="form-control" value="<?= htmlspecialchars($tanggal) ?>" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-heart"></i> Status Perkawinan</label>
                            <input type="text" name="status_perkawinan" class="form-control" value="<?= htmlspecialchars($status_perkawinan) ?>" placeholder="Belum Menikah/Menikah" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-briefcase"></i> Pekerjaan</label>
                            <input type="text" name="pekerjaan" class="form-control" value="<?= htmlspecialchars($pekerjaan) ?>" placeholder="Pekerjaan Anda" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-pray"></i> Agama</label>
                            <input type="text" name="agama" class="form-control" value="<?= htmlspecialchars($agama) ?>" placeholder="Islam/Kristen/Hindu/Buddha" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-map-pin"></i> Alamat</label>
                            <textarea class="form-control" name="alamat" rows="3" placeholder="Alamat lengkap" required><?= htmlspecialchars($alamat) ?></textarea>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-home"></i> RT / RW</label>
                            <div class="rt-rw-group">
                                <input type="text" class="form-control" name="rt" placeholder="RT" value="<?= htmlspecialchars($rt) ?>" required>
                                <input type="text" class="form-control" name="rw" placeholder="RW" value="<?= htmlspecialchars($rw) ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-phone"></i> Telepon</label>
                            <input type="text" name="telepon" class="form-control" value="<?= htmlspecialchars($telepon) ?>" placeholder="Nomor HP/Telepon" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-envelope"></i> Email</label>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>" placeholder="email@example.com" required>
                        </div>
                    </div>
                </div>
                
                <div class="card-action">
                    <button type="submit" name="simpan" class="btn btn-success"><i class="fas fa-save"></i> Simpan Biodata</button>
                    <a href="?halaman=tampil_pemohon" class="btn btn-default"><i class="fas fa-times"></i> Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Preview Foto Profil
    document.getElementById('foto_profil').addEventListener('change', function(e) {
        var file = e.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('photoPreview').innerHTML = '<img src="' + e.target.result + '" alt="Preview" id="previewImage" style="width:140px; height:140px; object-fit:cover;">';
            }
            reader.readAsDataURL(file);
        }
    });
</script>
</body>
</html> 