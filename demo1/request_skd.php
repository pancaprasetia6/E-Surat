<?php include '../konek.php'; ?>
<link href="css/sweetalert.css" rel="stylesheet" type="text/css">
<script src="js/jquery-2.1.3.min.js"></script>
<script src="js/sweetalert.min.js"></script>
<?php
$tampil_nik = "SELECT * FROM data_user WHERE nik=$_SESSION[nik]";
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
						<div class="card-title">FORM PENGAJUAN SURAT KETERANGAN DOMISILI</div>
					</div>
					<div class="card-body">
						<div class="row">
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
									<label for="jenis_kelamin">Jenis Kelamin</label>
									<input type="text" name="jenis_kelamin" class="form-control" value="<?= $jekel; ?>" readonly>
								</div>
								<div class="form-group">
									<label for="agama">Agama</label> 
									<input type="text" name="agama" class="form-control" value="<?= $agama; ?>" readonly>
								</div>
								<div class="form-group">
									<label for="status_perkawinan">Status Perkawinan</label>
									<input type="text" name="status_perkawinan" class="form-control" value="<?= $status_perkawinan; ?>" readonly>
								</div>
								<div class="form-group">
									<label for="warga_negara">Warga Negara</label> 
									<input type="text" name="warga_negara" class="form-control" value="<?= $warga_negara; ?>" readonly>
								</div>
								<div class="form-group">
									<label>Pekerjaan</label>
									<input type="text" name="pekerjaan" class="form-control" value="<?= $pekerjaan; ?>" readonly>
								</div>
							</div>
							<div class="col-md-6 col-lg-6">
								<div class="form-group">
									<label for="alamat">Alamat</label>
									<input class="form-control" id="alamat" name="alamat" rows="3" value="<?= $alamat; ?>" readonly></input>
								</div>
								<div class="form-group">
									<label>RT</label>
									<input type="text" name="rt" value="<?= $rt; ?>" class="form-control" size="37" readonly>
								</div>
								<div class="form-group">
									<label>RW</label>
									<input type="text" name="rw" value="<?= $rw; ?>" class="form-control" size="37" readonly>
								</div>
								<div class="form-group">
									<label>No. Tlp/Whatsapp</label>
									<input type="text" name="no_telp" value="<?= $telepon; ?>" class="form-control" size="37" readonly>
								</div>
								<div class="form-group">
									<label>Email</label>
									<input type="text" name="email" class="form-control" value="<?= $email; ?>" readonly>
								</div>
								<div class="form-group">
									<label for="keperluan">Keperluan</label>
									<textarea class="form-control" id="keperluan" name="keperluan" rows="3" placeholder="Tuliskan keperluan pembuatan surat keterangan domisili" required></textarea>
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
	$pekerjaan = $_POST['pekerjaan'];
	$alamat = $_POST['alamat'];
	$rt = $_POST['rt'];
	$rw = $_POST['rw'];
	$no_telp = $_POST['no_telp'];
	$email = $_POST['email'];
	$keperluan = $_POST['keperluan'];



	$sql = "INSERT INTO data_request_skd (
				no_kk,
				nama_kk,
                nik,
                Nama, 
                Tempat_lahir, 
                Tanggal_lahir, 
                Jenis_kelamin, 
                Agama, 
                Status_perkawinan, 
                Warga_negara, 
                Pekerjaan, 
                Alamat, 
				rt,
				rw,
                No_telp, 
                Email,
                keperluan
            ) VALUES (
				'$no_kk',
				'$nama_kk',
                '$nik',
                '$nama',
                '$tempat_lahir',
                '$tanggal_lahir',
                '$jenis_kelamin',
                '$agama',
                '$status_perkawinan',
                '$warga_negara',
                '$pekerjaan',
                '$alamat',
				'$rt',
				'$rw',
                '$no_telp',
                '$email',
                '$keperluan'
            )";
	$query = mysqli_query($konek, $sql);

	if ($query) {
		echo "<script language='javascript'>swal('Selamat...', 'Kirim Berhasil', 'success');</script>";
		echo '<meta http-equiv="refresh" content="3; url=?halaman=tampil_status">';
	} else {
		// Tampilkan error detail untuk debugging
		echo "<script language='javascript'>swal('Gagal...', 'Terjadi kesalahan sistem', 'error');</script>";
		echo '<meta http-equiv="refresh" content="3; url=?halaman=request_sktm">';
	}
}
?>