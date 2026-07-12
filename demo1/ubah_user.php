<?php 
include '../konek.php';

// Cek apakah parameter nik ada
if(isset($_GET['nik'])){
    $nik = $_GET['nik'];
    $tampil_nik = "SELECT * FROM data_user WHERE nik = '$nik'";
    $query = mysqli_query($konek, $tampil_nik);
    
    if(mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_array($query, MYSQLI_BOTH);
        $nik = $data['nik'];
        $nama = $data['nama'];
        $tempat = $data['tempat_lahir'];
        $tanggal = $data['tanggal_lahir'];
        $jekel = $data['jekel'];
        $agama = $data['agama'];
        $alamat = $data['alamat'];
        $telepon = $data['telepon'];
        $password = $data['password'];
        $hak_akses = $data['hak_akses'];
        $no_kk = $data['no_kk'];
        $nama_kk = $data['nama_kk'];
        $rt = $data['rt'];
        $rw = $data['rw'];
        $email = $data['email'];
        $status_perkawinan = $data['status_perkawinan'];
        $warga_negara = $data['warga_negara'];
        $pekerjaan = $data['pekerjaan'];
    } else {
        die("Data user tidak ditemukan");
    }
} else {
    die("NIK tidak ditemukan");
}
?>

<link href="css/sweetalert.css" rel="stylesheet" type="text/css">
<script src="js/jquery-2.1.3.min.js"></script>
<script src="js/sweetalert.min.js"></script>

<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        border: none;
    }
    
    .card-header {
        background: linear-gradient(135deg, #8f9baaff 0%, #464f58ff 100%);
        color: white;
        border-radius: 10px 10px 0 0 !important;
        padding: 20px;
    }
    
    .card-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
    }
    
    .form-group label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
    }
    
    .form-control {
        border-radius: 6px;
        border: 1px solid #e0e0e0;
        padding: 10px 15px;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #1572e8;
        box-shadow: 0 0 0 0.2rem rgba(21, 114, 232, 0.25);
    }
    
    .btn-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        border-radius: 6px;
        padding: 10px 25px;
        font-weight: 600;
    }
    
    .btn-default {
        background: #6c757d;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 10px 25px;
        font-weight: 600;
    }
    
    .btn-success:hover, .btn-default:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    
    .section-title {
        color: #1572e8;
        font-weight: 600;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e9ecef;
    }
</style>

<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <form method="POST">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h4 class="card-title mb-0">
                                    <i class="fas fa-user-edit mr-2" style="color: white;"> Ubah Data User</i>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Kolom Kiri - Data Pribadi -->
                            <div class="col-md-6">
                                <h5 class="section-title">
                                    <i class="fas fa-user-circle mr-2"></i>Data Pribadi
                                </h5>

								<div class="form-group">
                                    <label>No Kartu Keluarga</label>
                                    <input type="number" name="no_kk" class="form-control" value="<?= $no_kk ?>" >
                                </div>
                                
								<div class="form-group">
                                    <label>Nama Kepala Keluarga</label>
                                    <input type="text" name="nama_kk" class="form-control" value="<?= $nama_kk ?>" required>
                                </div>

                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="number" name="nik" class="form-control" value="<?= $nik ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control" value="<?= $nama ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <select name="jekel" class="form-control" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-Laki" <?= $jekel == "Laki-Laki" ? 'selected' : '' ?>>Laki-Laki</option>
                                        <option value="Perempuan" <?= $jekel == "Perempuan" ? 'selected' : '' ?>>Perempuan</option>
                                    </select>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tempat Lahir</label>
                                            <input type="text" name="tempat" class="form-control" value="<?= $tempat ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tanggal Lahir</label>
                                            <input type="date" name="tgl" class="form-control" value="<?= $tanggal ?>" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Agama</label>
                                    <select name="agama" class="form-control">
                                        <option value="">Pilih Agama</option>
                                        <option value="Islam" <?= $agama == "Islam" ? 'selected' : '' ?>>Islam</option>
                                        <option value="Kristen" <?= $agama == "Kristen" ? 'selected' : '' ?>>Kristen</option>
                                        <option value="Katolik" <?= $agama == "Katolik" ? 'selected' : '' ?>>Katolik</option>
                                        <option value="Hindu" <?= $agama == "Hindu" ? 'selected' : '' ?>>Hindu</option>
                                        <option value="Buddha" <?= $agama == "Buddha" ? 'selected' : '' ?>>Buddha</option>
                                        <option value="Konghucu" <?= $agama == "Konghucu" ? 'selected' : '' ?>>Konghucu</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label>Status Perkawinan</label>
                                    <select name="status_perkawinan" class="form-control">
                                        <option value="">Pilih Status</option>
                                        <option value="Belum Menikah" <?= $status_perkawinan == "Belum Menikah" ? 'selected' : '' ?>>Belum Menikah</option>
                                        <option value="Menikah" <?= $status_perkawinan == "Menikah" ? 'selected' : '' ?>>Menikah</option>
                                        <option value="Cerai" <?= $status_perkawinan == "Cerai" ? 'selected' : '' ?>>Cerai</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Kolom Kanan - Data Lainnya -->
                            <div class="col-md-6">
                                <h5 class="section-title">
                                    <i class="fas fa-home mr-2"></i>Data Alamat & Kontak
                                </h5>
                                
                                <div class="form-group">
                                    <label>Alamat Lengkap</label>
                                    <textarea class="form-control" name="alamat" rows="3" required><?= $alamat ?></textarea>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>RT</label>
                                            <input type="text" name="rt" class="form-control" value="<?= $rt ?>" placeholder="RT">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>RW</label>
                                            <input type="text" name="rw" class="form-control" value="<?= $rw ?>" placeholder="RW">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>No. Telepon</label>
                                    <input type="text" name="telepon" class="form-control" value="<?= $telepon ?>" placeholder="No. Telepon">
                                </div>
                                
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="<?= $email ?>" placeholder="Email">
                                </div>
                                
                                <h5 class="section-title mt-4">
                                    <i class="fas fa-briefcase mr-2"></i>Data Lainnya
                                </h5>
                                
                                <div class="form-group">
                                    <label>Pekerjaan</label>
                                    <input type="text" name="pekerjaan" class="form-control" value="<?= $pekerjaan ?>" placeholder="Pekerjaan">
                                </div>
                                
                                <div class="form-group">
                                    <label>Warga Negara</label>
                                    <input type="text" name="warga_negara" class="form-control" value="<?= $warga_negara ?>" placeholder="Warga Negara">
                                </div>
                                
                                <div class="form-group">
                                    <label>Password *</label>
                                    <input type="text" name="password" class="form-control" value="<?= $password ?>" required>
                                    <small class="form-text text-muted">Password untuk login user</small>
                                </div>
                                
                                <div class="form-group">
                                    <label>Hak Akses *</label>
                                    <select name="hak_akses" class="form-control" required>
                                        <option value="">Pilih Hak Akses</option>
                                        <option value="Pemohon" <?= $hak_akses == "Pemohon" ? 'selected' : '' ?>>Pemohon</option>
                                        <option value="RT" <?= $hak_akses == "RT" ? 'selected' : '' ?>>RT</option>
                                        <option value="RW" <?= $hak_akses == "RW" ? 'selected' : '' ?>>RW</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action text-right" style="padding: 20px;">
                        <button type="submit" name="ubah" class="btn btn-success">
                            <i class="fas fa-save mr-2"></i>Simpan Perubahan
                        </button>
                        <a href="?halaman=tampil_user" class="btn btn-default">
                            <i class="fas fa-times mr-2"></i>Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
if(isset($_POST['ubah'])){
    // Ambil data dari form
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $tempat = $_POST['tempat'];
    $tgl = $_POST['tgl'];
    $jekel = $_POST['jekel'];
    $agama = $_POST['agama'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $password = $_POST['password'];
    $hak_akses = $_POST['hak_akses'];
    $rt = $_POST['rt'];
    $rw = $_POST['rw'];
    $email = $_POST['email'];
    $status_perkawinan = $_POST['status_perkawinan'];
    $warga_negara = $_POST['warga_negara'];
    $pekerjaan = $_POST['pekerjaan'];
    
    // Query update
    $sql = "UPDATE data_user SET
        nama = '$nama',
        tanggal_lahir = '$tgl',
        tempat_lahir = '$tempat',
        jekel = '$jekel',
        agama = '$agama',
        alamat = '$alamat',
        telepon = '$telepon',
        password = '$password',
        hak_akses = '$hak_akses',
        rt = '$rt',
        rw = '$rw',
        email = '$email',
        status_perkawinan = '$status_perkawinan',
        warga_negara = '$warga_negara',
        pekerjaan = '$pekerjaan'
    WHERE nik = '$nik'";
    
    $query = mysqli_query($konek, $sql);

    if($query){
        echo "<script language='javascript'>
                swal('Berhasil!', 'Data user berhasil diubah', 'success');
                setTimeout(function(){
                    window.location.href = '?halaman=tampil_user';
                }, 2000);
              </script>";
    } else {
        echo "<script language='javascript'>
                swal('Gagal!', 'Terjadi kesalahan saat mengubah data', 'error');
              </script>";
    }
}
?>