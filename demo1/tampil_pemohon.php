<?php 
include '../konek.php'; 

// PERBAIKAN: Kutip untuk session nik
$tampil_nik = "SELECT * FROM data_user WHERE nik='" . $_SESSION['nik'] . "'";
$query = mysqli_query($konek, $tampil_nik);
$data = mysqli_fetch_array($query, MYSQLI_BOTH);

$nik = $data['nik'] ?? '';
$nama = $data['nama'] ?? '';
$tempat = $data['tempat_lahir'] ?? '';
$tanggal = $data['tanggal_lahir'] ?? '';
$format = !empty($tanggal) ? date('d-m-Y', strtotime($tanggal)) : '';
$jekel = $data['jekel'] ?? '';
$alamat = $data['alamat'] ?? '';
$telepon = $data['telepon'] ?? '';
$agama = $data['agama'] ?? '';
$status_perkawinan = $data['status_perkawinan'] ?? '';
$warga_negara = $data['warga_negara'] ?? '';
$pekerjaan = $data['pekerjaan'] ?? '';
$email = $data['email'] ?? '';
$foto_profil = $data['foto_profil'] ?? '';
$foto_ktp = $data['foto_ktp'] ??'';
$foto_kk = $data['foto_kk'] ??'';
$no_kk = $data['no_kk'] ?? '';
$nama_kk = $data['nama_kk'] ?? '';
$rt = $data['rt'] ?? '';
$rw = $data['rw'] ?? '';
?>

<!-- Leaflet CSS & JS untuk peta -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
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
        border-left: 4px solid #dc3545;
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
</style>

<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title" >
                            <i class="fas fa-user-circle" style="color: white;"> BIODATA ANDA</i> 
                        </h4>
                        <a href="?halaman=ubah_pemohon&nik=<?= $nik; ?>" class="btn btn-sm btn-dark btn-round ml-auto">
                            <i class="fa fa-edit"></i>
                            Ubah Biodata
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- FOTO KTP & KK -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-info text-white">
                                        <i class="fas fa-id-card"> KTP </i>
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
                                        <i class="fas fa-users"> KARTU KELUARGA </i>
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
                    <!-- Foto Profil -->
                    <div class="profile-photo-container">
                        <?php if(!empty($foto_profil)): ?>
                            <img src="uploads/profil/<?= $foto_profil ?>" alt="Foto Profil" class="profile-photo">
                            <div style="margin-top: 10px;"> 
                            </div>
                        <?php else: ?>
                            <div class="photo-placeholder">
                                <i class="fas fa-user"></i>
                            </div>
                            <div style="margin-top: 10px;">
                                <small class="text-muted">Belum ada foto profil. 
                                    <a href="?halaman=ubah_pemohon&nik=<?= $nik; ?>" class="text-primary">Upload foto sekarang</a>
                                </small>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Data Biodata -->
                    <table class="table table-bordered">
                        <tbody>
                            <tr><th>NIK</th><td>:</td><td><?= $nik; ?></td></tr>
                            <tr><th>NO. KARTU KELUARGA</th><td>:</td><td><?= $no_kk; ?></td></tr>
                            <tr><th>NAMA KEPALA KELUARGA</th><td>:</td><td><?= $nama_kk; ?></td></tr>
                            <tr><th>NAMA</th><td>:</td><td><?= $nama; ?></td></tr>
                            <tr><th>TTL</th><td>:</td><td><?= $tempat . ', ' . $format; ?></td></tr>
                            <tr><th>JENIS KELAMIN</th><td>:</td><td><?= $jekel; ?></td></tr>
                            <tr><th>PEKERJAAN</th><td>:</td><td><?= $pekerjaan; ?></td></tr>
                            <tr><th>AGAMA</th><td>:</td><td><?= $agama; ?></td></tr>
                            <tr><th>ALAMAT</th><td>:</td><td><?= $alamat; ?></td></tr>
                            <tr><th>RT/RW</th><td>:</td><td><?= $rt . ' / ' . $rw; ?></td></tr>
                            <tr><th>TELEPON</th><td>:</td><td><?= $telepon; ?></td></tr>
                            <tr><th>EMAIL</th><td>:</td><td><?= $email; ?></td></tr>
                            <tr><th>STATUS PERKAWINAN</th><td>:</td><td><?= $status_perkawinan; ?></td></tr>
                            <tr><th>WARGA NEGARA</th><td>:</td><td><?= $warga_negara; ?></td></tr>
                        </tbody>
                    </table> 
                    </div>
                    
                </div>
            </div>
        </div>    
    </div>
</div>

 