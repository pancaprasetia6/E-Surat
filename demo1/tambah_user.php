<?php include '../konek.php'; ?>
<link href="css/sweetalert.css" rel="stylesheet" type="text/css">
<script src="js/jquery-2.1.3.min.js"></script>
<script src="js/sweetalert.min.js"></script>

<style>
	.card {
		border-radius: 10px;
		box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
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

	.btn-success:hover,
	.btn-default:hover {
		transform: translateY(-1px);
		box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
	}

	.section-title {
		color: #1572e8;
		font-weight: 600;
		margin-bottom: 20px;
		padding-bottom: 10px;
		border-bottom: 2px solid #e9ecef;
	}

	.required::after {
		content: " *";
		color: #dc3545;
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
									<i class="fas fa-user-plus mr-2" style="color: white;"> Tambah User</i>
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
									<label class="required">NIK</label>
									<input type="number" name="nik" class="form-control" placeholder="Masukkan NIK..." required autofocus>
									<small class="form-text text-muted">Nomor Induk Kependudukan (16 digit)</small>
								</div>

								<div class="form-group">
									<label class="required">Nama Lengkap</label>
									<input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap..." required>
								</div>

								<div class="form-group">
									<label class="required">Jenis Kelamin</label>
									<select name="jekel" class="form-control" required>
										<option value="">Pilih Jenis Kelamin</option>
										<option value="Laki-Laki">Laki-Laki</option>
										<option value="Perempuan">Perempuan</option>
									</select>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="required">Tempat Lahir</label>
											<input type="text" name="tempat" class="form-control" placeholder="Tempat lahir..." required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="required">Tanggal Lahir</label>
											<input type="date" name="tanggal" class="form-control" required>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label>Agama</label>
									<select name="agama" class="form-control">
										<option value="">Pilih Agama</option>
										<option value="Islam">Islam</option>
										<option value="Kristen">Kristen</option>
										<option value="Katolik">Katolik</option>
										<option value="Hindu">Hindu</option>
										<option value="Buddha">Buddha</option>
										<option value="Konghucu">Konghucu</option>
									</select>
								</div>

								<div class="form-group">
									<label>Status Perkawinan</label>
									<select name="status_perkawinan" class="form-control">
										<option value="">Pilih Status</option>
										<option value="Belum Menikah">Belum Menikah</option>
										<option value="Menikah">Menikah</option>
										<option value="Cerai">Cerai</option>
									</select>
								</div>

								<div class="form-group">
									<label>No. Kartu Keluarga</label>
									<input type="number" name="no_kk" class="form-control" placeholder="Nomor Kartu Keluarga...">
								</div>

								<div class="form-group">
									<label>Nama Kepala Keluarga</label>
									<input type="text" name="nama_kk" class="form-control" placeholder="Nama kepala keluarga...">
								</div>
							</div>

							<!-- Kolom Kanan - Data Alamat & Lainnya -->
							<div class="col-md-6">
								<h5 class="section-title">
									<i class="fas fa-home mr-2"></i>Data Alamat & Kontak
								</h5>

								<div class="form-group">
									<label class="required">Alamat Lengkap</label>
									<textarea class="form-control" name="alamat" rows="3" placeholder="Alamat lengkap..." required></textarea>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>RT</label>
											<input type="text" name="rt" class="form-control" placeholder="RT">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>RW</label>
											<input type="text" name="rw" class="form-control" placeholder="RW">
										</div>
									</div>
								</div>

								<div class="form-group">
									<label>No. Telepon</label>
									<input type="text" name="telepon" class="form-control" placeholder="Nomor telepon...">
								</div>

								<div class="form-group">
									<label>Email</label>
									<input type="email" name="email" class="form-control" placeholder="Alamat email...">
								</div>

								<h5 class="section-title mt-4">
									<i class="fas fa-briefcase mr-2"></i>Data Lainnya
								</h5>

								<div class="form-group">
									<label>Pekerjaan</label>
									<input type="text" name="pekerjaan" class="form-control" placeholder="Pekerjaan...">
								</div>

								<div class="form-group">
									<label>Warga Negara</label>
									<input type="text" name="warga_negara" class="form-control" placeholder="Warga negara...">
								</div>

								<div class="form-group">
									<label class="required">Password</label>
									<input type="password" name="password" class="form-control" placeholder="Password untuk login..." required>
								</div>

								<div class="form-group">
									<label class="required">Hak Akses</label>
									<select name="hak_akses" class="form-control" required>
										<option value="">Pilih Hak Akses</option>
										<option value="Pemohon">Pemohon</option>
										<option value="RT">RT</option>
										<option value="RW">RW</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="card-action text-right" style="padding: 20px;">
						<button type="submit" name="simpan" class="btn btn-success">
							<i class="fas fa-save mr-2"></i>Simpan User
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
if (isset($_POST['simpan'])) {
	// Ambil data dari form
	$nik = $_POST['nik'];
	$nama = $_POST['nama'];
	$jekel = $_POST['jekel'];
	$tempat = $_POST['tempat'];
	$tanggal = $_POST['tanggal'];
	$agama = $_POST['agama'];
	$status_perkawinan = $_POST['status_perkawinan'];
	$no_kk = $_POST['no_kk'];
	$nama_kk = $_POST['nama_kk'];
	$alamat = $_POST['alamat'];
	$rt = $_POST['rt'];
	$rw = $_POST['rw'];
	$telepon = $_POST['telepon'];
	$email = $_POST['email'];
	$pekerjaan = $_POST['pekerjaan'];
	$warga_negara = $_POST['warga_negara'];
	$password = $_POST['password'];
	$hak_akses = $_POST['hak_akses'];

	// Cek apakah NIK sudah ada
	$cek_nik = "SELECT * FROM data_user WHERE nik = '$nik'";
	$query_cek = mysqli_query($konek, $cek_nik);

	if (mysqli_num_rows($query_cek) > 0) {
		echo "<script language='javascript'>
                swal('Peringatan!', 'NIK $nik sudah terdaftar', 'warning');
              </script>";
	} else {
		// Query insert
		$sql = "INSERT INTO data_user (
            nik, nama, jekel, tempat_lahir, tanggal_lahir, agama, status_perkawinan, 
            no_kk, nama_kk, alamat, rt, rw, telepon, email, pekerjaan, 
            warga_negara, password, hak_akses
        ) VALUES (
            '$nik', '$nama', '$jekel', '$tempat', '$tanggal', '$agama', '$status_perkawinan',
            '$no_kk', '$nama_kk', '$alamat', '$rt', '$rw', '$telepon', '$email', '$pekerjaan', 
			 '$warga_negara', '$password', '$hak_akses'
        )";

		$query = mysqli_query($konek, $sql);

		if ($query) {
			echo "<script language='javascript'>
                    swal('Berhasil!', 'Data user berhasil disimpan', 'success');
                    setTimeout(function(){
                        window.location.href = '?halaman=tampil_user';
                    }, 2000);
                  </script>";
		} else {
			echo "<script language='javascript'>
                    swal('Gagal!', 'Terjadi kesalahan saat menyimpan data', 'error');
                  </script>";
		}
	}
}
?>