<?php include '../konek.php'; ?>
<link href="css/sweetalert.css" rel="stylesheet" type="text/css">
<script src="js/jquery-2.1.3.min.js"></script>
<script src="js/sweetalert.min.js"></script>

<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <form method="POST" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">FORM PENGAJUAN SURAT KETERANGAN KEMATIAN</div>
                    </div>
                    <div class="card-body">
                        <!-- Data Orang Yang Meninggal -->
                        <h5><b>DATA ALMARHUM / ALMARHUMAH</b></h5>
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="Nama" class="form-control" placeholder="Masukkan Nama Lengkap" required>
                                </div>
                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="text" name="nik" class="form-control" placeholder="Masukkan NIK" required>
                                </div>
                                <div class="form-group">
                                    <label>No. KK</label>
                                    <input type="text" name="no_kk" class="form-control" placeholder="Masukkan No. KK" required>
                                </div>
                                <div class="form-group">
                                    <label>Tempat Lahir</label>
                                    <input type="text" name="Tempat_lahir" class="form-control" placeholder="Masukkan Tempat Lahir" required>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-control" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Agama</label>
                                    <input type="text" name="agama" class="form-control" placeholder="Masukkan Agama" required>
                                </div>
                                <div class="form-group">
                                    <label>Pekerjaan</label>
                                    <input type="text" name="pekerjaan" class="form-control" placeholder="Masukkan Pekerjaan" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea class="form-control" name="alamat" rows="3" placeholder="Masukkan Alamat Lengkap" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label>RT</label>
                                    <input type="text" name="rt" class="form-control" placeholder="Masukkan RT" required>
                                </div>
                                <div class="form-group">
                                    <label>RW</label>
                                    <input type="text" name="rw" class="form-control" placeholder="Masukkan RW" required>
                                </div>
                                <div class="form-group">
                                    <label>Hari Kematian</label>
                                    <input type="text" name="hari_kematian" class="form-control" placeholder="Contoh: Senin, Selasa, dll" required>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Kematian</label>
                                    <input type="date" name="tanggal_kematian" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Waktu Kematian</label>
                                    <input type="time" name="waktu_kematian" class="form-control" required>
                                    <small class="text-muted">
                                        AM = 00.00 - 11.59 (tengah malam sampai pagi)<br>
                                        PM = 12.00 - 23.59 (siang sampai malam)<br>
                                    </small>
                                </div>
                                <div class="form-group">
                                    <label>Usia Saat Meninggal (Tahun)</label>
                                    <input type="number" name="usia_kematian" class="form-control" placeholder="Masukkan Usia" required>
                                </div>
                                <div class="form-group">
                                    <label>Tempat Kematian</label>
                                    <input type="text" name="tempat_kematian" class="form-control" placeholder="Contoh: Rumah Sakit, Rumah, dll" required>
                                </div>
                                <div class="form-group">
                                    <label>Hubungan Pemohon Dengan Almarhum/Almarhumah</label>
                                    <input type="text" name="hubungan" class="form-control" placeholder="Contoh: anak, orangtua, istri, suami, dll" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button name="kirim" class="btn btn-success">Kirim</button>
                        <a href="?halaman=beranda" class="btn btn-default">Batal</a>
                    </div>
                </div>
        </div>
        </form>
    </div>
</div>

<?php
if (isset($_POST['kirim'])) {
    $no_kk = $_POST['no_kk'];
    $nik = $_POST['nik'];
    $nik_pemohon = $_SESSION['nik'];
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
    $request = $_POST['request'];

    $sql = "INSERT INTO data_request_skk (
				no_kk,
                nik,
                nik_pemohon,
                Nama, 
                Tempat_lahir, 
                Tanggal_lahir, 
                Jenis_kelamin, 
                Agama, 
                Pekerjaan, 
                Alamat, 
				rt,
				rw,
				hari_kematian,
				tanggal_kematian,
				waktu_kematian,
				usia_kematian,
				tempat_kematian,
				hubungan
            ) VALUES (
				'$no_kk',
                '$nik',
                '$nik_pemohon',
                '$nama',
                '$tempat_lahir',
                '$tanggal_lahir',
                '$jenis_kelamin',
                '$agama',
                '$pekerjaan',
                '$alamat',
				'$rt',
				'$rw',
				'$hari_kematian',
				'$tanggal_kematian',
				'$waktu_kematian',
				'$usia_kematian',
				'$tempat_kematian',
				'$hubungan'
            )";

    $query = mysqli_query($konek, $sql);

    if ($query) {
		echo "<script language='javascript'>swal('Selamat...', 'Kirim Berhasil', 'success');</script>";
		echo '<meta http-equiv="refresh" content="3; url=?halaman=tampil_status">';
	} else {
		// Tampilkan error detail untuk debugging
		echo "<script language='javascript'>swal('Gagal...', 'Terjadi kesalahan sistem', 'error');</script>";
		echo '<meta http-equiv="refresh" content="3; url=?halaman=request_skk">';
	}
}
?>