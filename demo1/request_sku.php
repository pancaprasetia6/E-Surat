<?php 
include '../konek.php'; 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} 

?>

<link href="css/sweetalert.css" rel="stylesheet" type="text/css">
<script src="js/jquery-2.1.3.min.js"></script>
<script src="js/sweetalert.min.js"></script> 

<?php
// Pastikan session nik sudah ada
if (!isset($_SESSION['nik'])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location='login.php';</script>";
    exit;
}

// Ambil data user dari tabel data_user
$tampil_nik = "SELECT * FROM data_user WHERE nik='$_SESSION[nik]'";
$query = mysqli_query($konek, $tampil_nik);
$data = mysqli_fetch_array($query, MYSQLI_BOTH);
$no_kk = $data['no_kk'];
$nama_kk = $data['nama_kk'];
$nik = $data['nik'];
$nama = $data['nama'];
$tempat_lahir = $data['tempat_lahir'];
$tanggal_lahir = $data['tanggal_lahir'];
$jekel = $data['jekel'];
$agama = $data['agama'];
$alamat = $data['alamat'];
$rt = $data['rt'];
$rw = $data['rw'];
$telepon = $data['telepon'];
$status_perkawinan = $data['status_perkawinan'];
$warga_negara = $data['warga_negara'];
$pekerjaan = $data['pekerjaan'];
$email = $data['email'];
?>

<div class="page-inner">
	<div class="row">
		<div class="col-md-12">
			<form method="POST" enctype="multipart/form-data">
				<div class="card">
					<div class="card-header">
						<div class="card-title">FORM PENGAJUAN SURAT KETERANGAN USAHA</div>
					</div>
					<div class="card-body">
						<div class="row">
							<!-- KOLOM KIRI -->
							<div class="col-md-6 col-lg-6">
								<div class="form-group">
									<label>No. KK</label>
									<input type="text" name="no_kk" class="form-control" value="<?= $no_kk ?>" readonly>
								</div> 
								<div class="form-group">
									<label>Nama Kepala Keluarga</label>
									<input type="text" name="nama_kk" class="form-control" value="<?= $nama_kk ?>" readonly>
								</div> 
								<div class="form-group">
									<label>NIK</label>
									<input type="text" name="nik" class="form-control" value="<?= $nik ?>" readonly>
								</div> 
								<div class="form-group">
									<label>Nama</label>
									<input type="text" name="Nama" class="form-control" value="<?= $nama; ?>" readonly>
								</div>
								<div class="form-group">
									<label>Tempat Lahir</label>
									<input type="text" name="Tempat_lahir" class="form-control" value="<?= $tempat_lahir; ?>" readonly>
								</div>
								<div class="form-group">
									<label>Tanggal Lahir</label>
									<input type="date" name="tanggal_lahir" class="form-control" value="<?= $tanggal_lahir; ?>" readonly>
								</div>
								<div class="form-group">
    								<label>Jenis Kelamin</label>
    								<input type="text" name="jenis_kelamin" class="form-control" value="<?= $jekel; ?>" readonly>
								</div>
								<div class="form-group">
    								<label>Agama</label>
    								<input type="text" name="agama" class="form-control" value="<?= $agama; ?>" readonly>
								</div>
								<div class="form-group">
									<label>Status Perkawinan</label> 
									<input type="text" name="status_perkawinan" class="form-control" value="<?= $status_perkawinan; ?>" readonly>
								</div>
								<div class="form-group">
									<label>Warga Negara</label>
									<input type="text" name="warga_negara" class="form-control" value="<?= $warga_negara; ?>" readonly>
								</div> 
								<div class="form-group">
									<label>Pekerjaan</label>
									<input type="text" name="pekerjaan" class="form-control" value="<?= $pekerjaan; ?>" readonly>
								</div> 
							</div>

							<!-- KOLOM KANAN -->
							<div class="col-md-6 col-lg-6">
								<div class="form-group">
									<label>Nama Usaha</label>
									<input type="text" name="nama_usaha" class="form-control" placeholder="Nama Usaha" required>
								</div> 
								<div class="form-group">
  									<label>Omset</label>
  									<div class="input-group">
    									<span class="input-group-text">Rp</span>
   									 		<input type="text" name="omset" id="omset" class="form-control" placeholder="Masukkan jumlah omset">
  									</div>
								</div>
								<div class="form-group">
									<label>Penanggung Jawab</label>
									<input type="text" name="penanggung_jawab" class="form-control" placeholder="Penanggung Jawab" required>
								</div> 
								<div class="form-group">
									<label>Jenis Usaha</label>
									<input type="text" name="jenis_usaha" class="form-control" placeholder="Masukkan Jenis Usaha" required>
								</div> 
								<div class="form-group">
									<label>Alamat Usaha</label>
									<textarea class="form-control" name="alamat_usaha" rows="4" placeholder="Masukkan Alamat Usaha" required></textarea>
								</div>
								<div class="form-group">
    								<label>Alamat</label>
    								<input type="text" name="alamat" class="form-control" value="<?= $alamat; ?>" readonly>
								</div>
								<div class="form-group">
    								<label>RT</label>
    								<input type="text" name="rt" class="form-control" value="<?= $rt; ?>" readonly>
								</div>
								<div class="form-group">
    								<label>RW</label>
    								<input type="text" name="rw" class="form-control" value="<?= $rw; ?>" readonly>
								</div>
								<div class="form-group">
									<label>No. Tlp/Whatsapp</label>
									<input type="text" name="no_telp" class="form-control" value="<?= $telepon; ?>" readonly>
								</div>
								<div class="form-group">
									<label>Email</label>
									<input type="text" name="email" class="form-control" value="<?= $email; ?>" readonly>
								</div> 
							</div>
						</div>
					</div>
					<div class="card-action text-right">
						<button name="kirim" class="btn btn-success">Kirim</button>
						<a href="?halaman=beranda" class="btn btn-default">Batal</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
if (isset($_POST['kirim'])) {
	$no_kk = $_POST['no_kk'];
	$nama_kk = $_POST['nama_kk'];
    $nik = $_POST['nik'];
    $nama = $_POST['Nama'];
    $tempat_lahir = $_POST['Tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jk = strtolower(trim($_POST['jenis_kelamin']));
	$jenis_kelamin = ($jk == 'laki-laki') ? 'L' : 'P';
    $agama = $_POST['agama'];
    $status_perkawinan = $_POST['status_perkawinan'];
    $warga_negara = $_POST['warga_negara'];
    $nama_usaha = $_POST['nama_usaha'];
    $omset = $_POST['omset'];
    $penanggung_jawab = $_POST['penanggung_jawab'];
    $jenis_usaha = $_POST['jenis_usaha'];
    $pekerjaan = $_POST['pekerjaan'];
    $alamat_usaha = $_POST['alamat_usaha'];
    $alamat = $_POST['alamat'];
	$rt = $_POST['rt'];
	$rw = $_POST['rw'];
    $no_telp = $_POST['no_telp'];
    $email = $_POST['email']; 

    // Query insert
    $sql = "INSERT INTO data_request_sku (
        no_kk, nama_kk, nik, Nama, Tempat_lahir, Tanggal_lahir, Jenis_kelamin, Agama, 
        Status_perkawinan, Warga_negara, Nama_usaha, Omset, Penanggung_jawab, 
        Jenis_usaha, Pekerjaan, Alamat_usaha, Alamat, rt, rw, No_telp, Email
    ) VALUES (
        '$no_kk', '$nama_kk', '$nik', '$nama', '$tempat_lahir', '$tanggal_lahir', '$jenis_kelamin', '$agama', 
        '$status_perkawinan', '$warga_negara', '$nama_usaha', '$omset', '$penanggung_jawab', 
        '$jenis_usaha', '$pekerjaan', '$alamat_usaha', '$alamat', '$rt', '$rw', '$no_telp', '$email'
    )";

    $query = mysqli_query($konek, $sql);

    if ($query) {
        echo "<script>swal('Berhasil!', 'Pengajuan Surat Keterangan Usaha telah dikirim', 'success');</script>";
        echo "<meta http-equiv='refresh' content='2; url=?halaman=tampil_status'>";
    } else {
        echo "<script>swal('Gagal!', 'Terjadi kesalahan sistem: ".mysqli_error($konek)."', 'error');</script>";
    }
}
?>
 