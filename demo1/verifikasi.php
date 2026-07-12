<?php
include '../konek.php';
include 'signature_functions.php';

$id = $_GET['id'] ?? '';
$jenis = $_GET['jenis'] ?? '';
$level = $_GET['level'] ?? 'rt'; // rt atau rw

if (empty($id) || empty($jenis)) {
    die("Parameter tidak lengkap!");
}

// ========== AMBIL SIGNATURE DARI DATABASE ==========
$sql = "SELECT * FROM digital_signature_log WHERE id_request='$id' AND jenis_surat='$jenis' AND level='$level'";
$query = mysqli_query($konek, $sql);

// CEK APAKAH DATA SIGNATURE DITEMUKAN
if (mysqli_num_rows($query) == 0) {
    // Tampilkan halaman error profesional
    echo '<!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Verifikasi Surat - Kelurahan Konoha</title>
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body {
                font-family: "Segoe UI", Arial, sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 20px;
            }
            .container {
                max-width: 500px;
                width: 100%;
                background: white;
                border-radius: 20px;
                box-shadow: 0 20px 60px rgba(0,0,0,0.3);
                overflow: hidden;
                animation: fadeIn 0.5s ease;
            }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(-20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .header { background: #dc3545; padding: 30px; text-align: center; }
            .header .icon { font-size: 80px; color: white; }
            .header h1 { color: white; margin-top: 10px; font-size: 28px; }
            .content { padding: 30px; }
            .message-box {
                background: #f8d7da;
                border-left: 4px solid #dc3545;
                padding: 15px;
                border-radius: 8px;
                margin-bottom: 20px;
            }
            .message-box p { color: #721c24; margin: 5px 0; }
            .info-list {
                background: #f8f9fa;
                border-radius: 10px;
                padding: 15px;
                margin: 20px 0;
            }
            .info-list li {
                padding: 8px 0;
                color: #555;
                border-bottom: 1px solid #eee;
                list-style: none;
                display: flex;
                align-items: center;
                gap: 10px;
            }
            .info-list li:last-child { border-bottom: none; }
            .info-list li i { width: 25px; color: #dc3545; }
            .btn {
                display: inline-block;
                padding: 12px 25px;
                background: #007bff;
                color: white;
                text-decoration: none;
                border-radius: 8px;
                font-weight: bold;
                transition: all 0.3s ease;
                text-align: center;
            }
            .btn:hover { background: #0056b3; transform: translateY(-2px); }
            .btn-group { display: flex; gap: 15px; justify-content: center; margin-top: 20px; }
            .btn-secondary { background: #6c757d; }
            .btn-secondary:hover { background: #545b62; }
            .footer { background: #f8f9fa; padding: 15px; text-align: center; font-size: 12px; color: #999; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <div class="icon">❌</div>
                <h1>SURAT TIDAK TERVERIFIKASI</h1>
            </div>
            <div class="content">
                <div class="message-box">
                    <p><strong>⚠️ Peringatan Keamanan</strong></p>
                    <p>Dokumen ini <strong>TIDAK SAH</strong> karena tidak memiliki tanda tangan digital yang terdaftar dalam sistem.</p>
                </div>
                <div class="info-list">
                    <li><i>🔍</i> <strong>Kode Verifikasi:</strong> Tidak ditemukan</li>
                    <li><i>📅</i> <strong>Status:</strong> <span style="color:#dc3545;">Invalid / Tidak Terdaftar</span></li>
                    <li><i>🔒</i> <strong>Digital Signature:</strong> Tidak ada</li>
                </div>
                <p style="text-align: center; color: #666; margin: 20px 0;">
                    Surat ini tidak dapat diverifikasi karena:<br>
                    • Tanda tangan digital tidak ditemukan di database<br>
                    • Atau dokumen ini bukan berasal dari sistem resmi
                </p>
            </div>
            <div class="footer">
                © Kelurahan Konoha - Sistem Administrasi Surat Digital<br>
                Verifikasi menggunakan RSA Signature (SHA-256)
            </div>
        </div>
    </body>
    </html>';
    exit;
}

// ========== AMBIL DATA DARI DATABASE ==========
$data = mysqli_fetch_assoc($query);
$data_json = $data['data_json'];
$signature_db = $data['signature'];

// Decode data asli (data saat ditandatangani)
$original_data = json_decode($data_json, true);

// Verifikasi signature
$is_valid = verifySignature($original_data, $signature_db, $level);

// Ambil nomor surat dari tabel request
$table_name = "data_request_" . $jenis;
$id_column = "id_request_" . $jenis;
$sql_surat = "SELECT * FROM $table_name WHERE $id_column='$id'";
$query_surat = mysqli_query($konek, $sql_surat);
$surat = mysqli_fetch_assoc($query_surat);
$no_surat = $surat['no_surat'] ?? '-';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Surat - Kelurahan Konoha</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
        }
        .valid {
            background: #d4edda;
            color: #155724;
            border: 2px solid #28a745;
        }
        .invalid {
            background: #f8d7da;
            color: #721c24;
            border: 2px solid #dc3545;
        }
        .status-icon {
            font-size: 80px;
            margin-bottom: 20px;
        }
        .info {
            text-align: left;
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .info table {
            width: 100%;
        }
        .info td {
            padding: 8px;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #666;
        }
        .warning {
            background: #fff3cd;
            color: #856404;
            padding: 10px;
            border-radius: 5px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
<div class="container <?= $is_valid ? 'valid' : 'invalid' ?>">
    <?php if ($is_valid): ?>
        <div class="status-icon">✅</div>
        <h2>SURAT ASLI & TERVERIFIKASI</h2>
        <p>Surat ini sah dan tidak pernah diubah sejak ditandatangani secara digital.</p>
    <?php else: ?>
        <div class="status-icon">❌</div>
        <h2>SURAT PALSU / TIDAK VALID</h2>
        <p>Surat ini <strong>TIDAK SAH</strong>! Data tidak sesuai dengan tanda tangan digital.</p>
        <div class="warning">
            <strong>⚠️ Peringatan:</strong> Dokumen ini telah diubah atau dipalsukan!<br>
            Signature tidak cocok dengan data surat.
        </div>
    <?php endif; ?>
    
    <div class="info">
        <h3>📄 Informasi Surat (Data Saat Ditandatangani)</h3>
        <table style="width: 100%;">
            <tr><td width="180"><strong>Jenis Surat</strong></td><td><?= strtoupper($jenis) ?></td></tr>
            <tr><td><strong>Nomor Surat</strong></td><td><?= htmlspecialchars($no_surat) ?></td></tr>
            <tr><td><strong>NIK</strong></td><td><?= htmlspecialchars($original_data['nik'] ?? '-') ?></td></tr>
            <tr><td><strong>Nama</strong></td><td><?= htmlspecialchars($original_data['nama'] ?? '-') ?></td></tr>
        </table>
    </div>
    
    <div class="info" style="background: #e8f5e9; margin-top: 20px;">
        <h3>🔒 Tanda Tangan Digital oleh: <?= strtoupper($level) ?></h3>
        <table style="width: 100%;">
            <tr><td width="180"><strong>Status</strong></td><td><?= $is_valid ? '✅ Tanda Tangan Valid' : '❌ Tanda Tangan Invalid' ?></td></tr>
            <tr><td><strong>Waktu Tanda Tangan</strong></td><td><?= $data['created_at'] ?? '-' ?></td></tr>
        </table>
    </div>
    
    <div class="footer">
        <p>© Pengurus RT 003 RW 006 - Sistem Administrasi Surat Digital</p>
        <p>Kelurahan Ciganjur, Kecamatan Jagakarsa Kota Jakarta Selatan</p>
    </div>
</div>
</body>
</html>