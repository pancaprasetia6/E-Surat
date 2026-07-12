<?php 
include '../konek.php';

// Ambil NIK dari parameter URL
$nik = $_GET['nik'] ?? '';

if(empty($nik)) {
    die("NIK tidak ditemukan");
}

// Query untuk mengambil data user berdasarkan NIK
$tampil_nik = "SELECT * FROM data_user WHERE nik = '$nik'";
$query = mysqli_query($konek, $tampil_nik);

if(!$query || mysqli_num_rows($query) == 0) {
    die("Data user dengan NIK $nik tidak ditemukan");
}

$data = mysqli_fetch_array($query, MYSQLI_BOTH);

// Assign data ke variabel
$nik = $data['nik'];
$nama = $data['nama'];
$tempat = $data['tempat_lahir'];
$tanggal = $data['tanggal_lahir'];
$format = date('d-m-Y', strtotime($tanggal));
$jekel = $data['jekel'];
$alamat = $data['alamat'];
$telepon = $data['telepon'];
$agama = $data['agama'];
$status_perkawinan = $data['status_perkawinan'];
$warga_negara = $data['warga_negara'];
$pekerjaan = $data['pekerjaan'];
$email = $data['email'];
$foto_profil = $data['foto_profil'];
$foto_ktp = $data['foto_ktp'] ?? '';  // TAMBAHKAN
$foto_kk = $data['foto_kk'] ?? '';    // TAMBAHKAN
$no_kk = $data['no_kk'];
$nama_kk = $data['nama_kk'];
$rt = $data['rt'];
$rw = $data['rw'];
$hak_akses = $data['hak_akses'];
$latitude = $data['latitude'] ?? '';
$longitude = $data['longitude'] ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail User - Admin</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <style>
        .profile-photo-container {
            text-align: center;
            margin-bottom: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }
        .profile-photo {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .photo-placeholder {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 5px solid #dee2e6;
            margin: 0 auto;
        }
        .photo-placeholder i {
            font-size: 60px;
            color: #6c757d;
        }
        #locationMap {
            width: 100%;
            height: 300px;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
            margin-top: 10px;
        }
        .location-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            border-left: 4px solid #464f58ff;
        }
        .coordinate-badge {
            background: #464f58ff;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            margin-top: 10px;
            display: inline-block;
        }
        .no-location {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            border-left: 4px solid #464f58ff;
        }
        .table-bordered {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .table-bordered th {
            background: #464f58ff;
            color: white;
            font-weight: 600;
            width: 250px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            border: none;
        }
        .card-header {
            background: linear-gradient(135deg, #8f9baaff 0%, #464f58ff 100%);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
        }
        .admin-badge {
            background: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
        }
        .user-badge {
            background: #17a2b8;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="card-title mb-0" style="color: white;">
                                <i class="fas fa-user-circle"></i> Detail Data User
                            </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        
                        <!-- FOTO KTP & KK -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-info text-white">
                                        <i class="fas fa-id-card"></i> KTP
                                    </div>
                                    <div class="card-body text-center">
                                        <?php if(!empty($foto_ktp)): ?>
                                            <img src="<?= $foto_ktp ?>" alt="Foto KTP" class="img-fluid rounded" style="max-height: 300px; object-fit: contain;">
                                            <div class="mt-2">
                                                <a href="<?= $foto_ktp ?>" target="_blank" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-expand"></i> Lihat Full
                                                </a>
                                            </div>
                                        <?php else: ?>
                                            <div class="p-5 bg-light rounded">
                                                <i class="fas fa-id-card" style="font-size: 60px; color: #6c757d;"></i>
                                                <p class="mt-2 text-muted">Belum ada foto KTP</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-success text-white">
                                        <i class="fas fa-users"></i> Kartu Keluarga
                                    </div>
                                    <div class="card-body text-center">
                                        <?php if(!empty($foto_kk)): ?>
                                            <img src="<?= $foto_kk ?>" alt="Foto KK" class="img-fluid rounded" style="max-height: 300px; object-fit: contain;">
                                            <div class="mt-2">
                                                <a href="<?= $foto_kk ?>" target="_blank" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-expand"></i> Lihat Full
                                                </a>
                                            </div>
                                        <?php else: ?>
                                            <div class="p-5 bg-light rounded">
                                                <i class="fas fa-users" style="font-size: 60px; color: #6c757d;"></i>
                                                <p class="mt-2 text-muted">Belum ada foto Kartu Keluarga</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- FOTO PROFIL -->
                        <div class="profile-photo-container">
                            <?php if(!empty($foto_profil)): ?>
                                <img src="uploads/profil/<?= $foto_profil ?>" alt="Foto Profil" class="profile-photo">
                            <?php else: ?>
                                <div class="photo-placeholder">
                                    <i class="fas fa-user"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- DATA BIODATA -->
                        <table class="table table-bordered">
                            <tbody>
                                <tr><th>NO. KARTU KELUARGA</th><td>:</td><td><?= $no_kk ?></td></tr>
                                <tr><th>NAMA KEPALA KELUARGA</th><td>:</td><td><?= $nama_kk ?></td></tr>
                                <tr><th>NIK</th><td>:</td><td><?= $nik ?></td></tr>
                                <tr><th>NAMA LENGKAP</th><td>:</td><td><?= $nama ?></td></tr>
                                <tr><th>TEMPAT, TANGGAL LAHIR</th><td>:</td><td><?= $tempat . ', ' . $format ?></td></tr>
                                <tr><th>JENIS KELAMIN</th><td>:</td><td><?= $jekel ?></td></tr>
                                <tr><th>PEKERJAAN</th><td>:</td><td><?= $pekerjaan ?></td></tr>
                                <tr><th>AGAMA</th><td>:</td><td><?= $agama ?></td></tr>
                                <tr><th>ALAMAT LENGKAP</th><td>:</td><td><?= $alamat ?></td></tr>
                                <tr><th>RT / RW</th><td>:</td><td><?= $rt . ' / ' . $rw ?></td></tr>
                                <tr><th>NOMOR TELEPON</th><td>:</td><td><?= $telepon ?></td></tr>
                                <tr><th>EMAIL</th><td>:</td><td><?= $email ?></td></tr>
                                <tr><th>STATUS PERKAWINAN</th><td>:</td><td><?= $status_perkawinan ?></td></tr>
                                <tr><th>WARGA NEGARA</th><td>:</td><td><?= $warga_negara ?></td></tr>
                                <tr><th>HAK AKSES</th><td>:</td><td><span class="<?= $hak_akses == 'admin' ? 'admin-badge' : 'user-badge' ?>"><?= strtoupper($hak_akses) ?></span></td></tr>
                            </tbody>
                        </table>
                        
                        <!-- TOMBOL AKSI -->
                        <div class="action-buttons">
                            <a href="main2.php?halaman=tampil_user" class="btn btn-dark">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                        
                    </div>
                </div>
            </div>    
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <?php if(!empty($latitude) && !empty($longitude)): ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const map = L.map('locationMap').setView([<?= $latitude ?>, <?= $longitude ?>], 16);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);
        const marker = L.marker([<?= $latitude ?>, <?= $longitude ?>]).addTo(map);
        marker.bindPopup(`
            <div style="text-align: center;">
                <strong>📍 Lokasi Rumah</strong><br>
                <small><?= $nama ?></small><br>
                <small style="font-family: monospace;">
                    <?= number_format($latitude, 6) ?>, <?= number_format($longitude, 6) ?>
                </small>
            </div>
        `).openPopup();
    });
    </script>
    <?php endif; ?>
</body>
</html>