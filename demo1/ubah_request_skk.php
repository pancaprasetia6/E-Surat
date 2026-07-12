<?php include '../konek.php';?>
<link href="css/sweetalert.css" rel="stylesheet" type="text/css">
<script src="js/jquery-2.1.3.min.js"></script>
<script src="js/sweetalert.min.js"></script>  
<?php
if(isset($_GET['id_request_skk'])){
    $id = $_GET['id_request_skk'];
    $tampil_nik = "SELECT * FROM data_request_skk WHERE id_request_skk=$id";
    $query = mysqli_query($konek, $tampil_nik);
    
    if(mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_array($query, MYSQLI_BOTH);
        $id = $data['id_request_skk'];
        $no_kk = $data['no_kk'];
        $nik = $data['nik'];
        $nama = $data['Nama']; 
        $tempat_lahir = $data['Tempat_lahir'];
        $tanggal_lahir = $data['Tanggal_lahir'];
        $jenis_kelamin = $data['Jenis_kelamin'];
        $agama = $data['Agama'];
        $pekerjaan = $data['Pekerjaan'];
        $alamat = $data['Alamat'];
        $rt = $data['rt'];
        $rw = $data['rw'];
        $hari_kematian = $data['hari_kematian'];
        $tanggal_kematian = $data['tanggal_kematian'];
        $waktu_kematian = $data['waktu_kematian'];
        $usia_kematian = $data['usia_kematian'];
        $tempat_kematian = $data['tempat_kematian'];
        $hubungan = $data['hubungan'];
    } else {
        echo "<script>alert('Data tidak ditemukan!'); window.location='?halaman=tampil_status';</script>";
        exit();
    }
} else {
    echo "<script>alert('ID tidak valid!'); window.location='?halaman=tampil_status';</script>";
    exit();
}
?>
<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <form method="POST" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">UBAH PENGAJUAN SURAT KETERANGAN KEMATIAN</div>
                    </div>
                    <div class="card-body">
                        <h5><b>DATA ALMARHUM / ALMARHUMAH</b></h5>
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="Nama" class="form-control" value="<?= $nama; ?>" placeholder="Masukkan Nama Lengkap" required>
                                </div>
                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="text" name="nik" class="form-control" value="<?= $nik; ?>" placeholder="Masukkan NIK" required>
                                </div>
                                <div class="form-group">
                                    <label>No. KK</label>
                                    <input type="text" name="no_kk" class="form-control" value="<?= $no_kk; ?>" placeholder="Masukkan No. KK" required>
                                </div>
                                <div class="form-group">
                                    <label>Tempat Lahir</label>
                                    <input type="text" name="Tempat_lahir" class="form-control" value="<?= $tempat_lahir; ?>" placeholder="Masukkan Tempat Lahir" required>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control" value="<?= $tanggal_lahir; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-control" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L" <?= $jenis_kelamin == 'L' ? 'selected' : ''; ?>>Laki-laki</option>
                                        <option value="P" <?= $jenis_kelamin == 'P' ? 'selected' : ''; ?>>Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Agama</label>
                                    <input type="text" name="agama" class="form-control" value="<?= $agama; ?>" placeholder="Masukkan Agama" required>
                                </div>
                                <div class="form-group">
                                    <label>Pekerjaan</label>
                                    <input type="text" name="pekerjaan" class="form-control" value="<?= $pekerjaan; ?>" placeholder="Masukkan Pekerjaan" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea class="form-control" name="alamat" rows="3" placeholder="Masukkan Alamat Lengkap" required><?= $alamat; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>RT</label>
                                    <input type="text" name="rt" class="form-control" value="<?= $rt; ?>" placeholder="Masukkan RT" required>
                                </div>
                                <div class="form-group">
                                    <label>RW</label>
                                    <input type="text" name="rw" class="form-control" value="<?= $rw; ?>" placeholder="Masukkan RW" required>
                                </div>
                                <div class="form-group">
                                    <label>Hari Kematian</label>
                                    <input type="text" name="hari_kematian" class="form-control" value="<?= $hari_kematian; ?>" placeholder="Contoh: Senin, Selasa, dll" required>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Kematian</label>
                                    <input type="date" name="tanggal_kematian" class="form-control" value="<?= $tanggal_kematian; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Waktu Kematian</label>
                                    <input type="time" name="waktu_kematian" class="form-control" value="<?= $waktu_kematian; ?>" required>
                                    <small class="text-muted">
                                        AM = 00.00 - 11.59 (tengah malam sampai pagi)<br>
                                        PM = 12.00 - 23.59 (siang sampai malam)<br>
                                    </small>
                                </div>
                                <div class="form-group">
                                    <label>Usia Saat Meninggal (Tahun)</label>
                                    <input type="number" name="usia_kematian" class="form-control" value="<?= $usia_kematian; ?>" placeholder="Masukkan Usia" required>
                                </div>
                                <div class="form-group">
                                    <label>Tempat Kematian</label>
                                    <input type="text" name="tempat_kematian" class="form-control" value="<?= $tempat_kematian; ?>" placeholder="Contoh: Rumah Sakit, Rumah, dll" required>
                                </div>
                                <div class="form-group">
                                    <label>Hubungan Pemohon Dengan Almarhum/Almarhumah</label>
                                    <input type="text" name="hubungan" class="form-control" value="<?= $hubungan; ?>" placeholder="Contoh: anak, orangtua, istri, suami, dll" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button name="ubah" class="btn btn-success">Ubah</button>
                        <a href="?halaman=tampil_status" class="btn btn-default">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
if(isset($_POST['ubah'])){
    $no_kk = $_POST['no_kk'];
    $nik = $_POST['nik'];
    $nama = $_POST['Nama'];
    $tempat_lahir = $_POST['Tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $pekerjaan = $_POST['pekerjaan'];
    $alamat = $_POST['alamat'];
    $rt = $_POST['rt'];
    $rw = $_POST['rw'];
    $hari_kematian = $_POST['hari_kematian'];
    $tanggal_kematian = $_POST['tanggal_kematian'];
    $waktu_kematian = $_POST['waktu_kematian'];
    $usia_kematian = $_POST['usia_kematian'];
    $tempat_kematian = $_POST['tempat_kematian'];
    $hubungan = $_POST['hubungan'];
    
    $sql = "UPDATE data_request_skk SET
        no_kk = '$no_kk',
        nik = '$nik',
        Nama = '$nama',
        Tempat_lahir = '$tempat_lahir',
        Tanggal_lahir = '$tanggal_lahir',
        Jenis_kelamin = '$jenis_kelamin',
        Agama = '$agama',
        Pekerjaan = '$pekerjaan',
        Alamat = '$alamat',
        rt = '$rt',
        rw = '$rw',
        hari_kematian = '$hari_kematian',
        tanggal_kematian = '$tanggal_kematian',
        waktu_kematian = '$waktu_kematian',
        usia_kematian = '$usia_kematian',
        tempat_kematian = '$tempat_kematian',
        hubungan = '$hubungan'
    WHERE id_request_skk = $id";
    
    $query = mysqli_query($konek, $sql);

    if($query){
        echo "<script language='javascript'>swal('Selamat...', 'Ubah Berhasil', 'success');</script>";
        echo '<meta http-equiv="refresh" content="3; url=?halaman=tampil_status">';
    } else {
        echo "<script language='javascript'>swal('Gagal...', 'Ubah Gagal: ".mysqli_error($konek)."', 'error');</script>";
        echo '<meta http-equiv="refresh" content="3; url=?halaman=ubah_skk&id_request_skk='.$id.'">';
    }
}
?>