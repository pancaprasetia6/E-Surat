<?php
error_reporting(0);
if (!isset($_SESSION)) {
	session_start();
}
if (isset($_SESSION['password']) == "" || ($_SESSION['hak_akses']) == "") {
	header('location:login.php');
} else {
	$hak_akses = $_SESSION['hak_akses'];
	$rt_login = $_SESSION['rt']; // ambil RT user yang login
	$rw_login = $_SESSION['rw']; // ambil RW user yang login
}
?>

<?php
if ($hak_akses == "RT") {
?>
	<div class="panel-header" style="background: linear-gradient(135deg, #8f9baaff 0%, #464f58ff 100%);">
		<div class="page-inner py-5">
			<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
				<div>
					<h2 class="text-white pb-2 fw-bold">Halo <?php echo $hak_akses . " " . $rt_login; ?>!</h2>
				</div>
			</div>
		</div>
	</div>

	<div class="page-inner">
		<h3 class="fw-bold text-uppercase">DAFTAR PENGAJUAN SURAT WARGA</h3>
		<div class="row">
			<!-- SKTM -->
			<div class="col-sm-6">
				<div class="card card-stats card-round">
					<div class="card-body">
						<div class="row align-items-center">
							<a href="?halaman=permohonan_surat">
								<div class="col-icon">
									<div class="icon-big text-center icon-primary bubble-shadow-small">
										<i class="flaticon-envelope-1"></i>
									</div>
								</div>
							</a>
							<div class="col col-stats ml-3 ml-sm-0">
								<div class="numbers">
									<p class="card-category">SURAT KETERANGAN TIDAK MAMPU</p>
									<?php
									include '../konek.php';
									$sql = "SELECT * FROM data_request_sktm WHERE status=0 AND rt='$rt_login'";
									$query = mysqli_query($konek, $sql);
									$count = mysqli_num_rows($query);
									?>
									<h4 class="card-title"><?= $count; ?></h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- SKU -->
			<div class="col-sm-6">
				<div class="card card-stats card-round">
					<div class="card-body">
						<div class="row align-items-center">
							<a href="?halaman=permohonan_surat">
								<div class="col-icon">
									<div class="icon-big text-center icon-success bubble-shadow-small">
										<i class="flaticon-envelope-1"></i>
									</div>
								</div>
							</a>
							<div class="col col-stats ml-3 ml-sm-0">
								<div class="numbers">
									<p class="card-category">SURAT KETERANGAN USAHA</p>
									<?php
									$sql = "SELECT * FROM data_request_sku WHERE status=0 AND rt='$rt_login'";
									$query = mysqli_query($konek, $sql);
									$count = mysqli_num_rows($query);
									?>
									<h4 class="card-title"><?= $count; ?></h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- SKD -->
			<div class="col-sm-6">
				<div class="card card-stats card-round">
					<div class="card-body">
						<div class="row align-items-center">
							<a href="?halaman=permohonan_surat">
								<div class="col-icon">
									<div class="icon-big text-center icon-secondary bubble-shadow-small">
										<i class="flaticon-envelope-1"></i>
									</div>
								</div>
							</a>
							<div class="col col-stats ml-3 ml-sm-0">
								<div class="numbers">
									<p class="card-category">SURAT KETERANGAN DOMISILI</p>
									<?php
									$sql = "SELECT * FROM data_request_skd WHERE status=0 AND rt='$rt_login'";
									$query = mysqli_query($konek, $sql);
									$count = mysqli_num_rows($query);
									?>
									<h4 class="card-title"><?= $count; ?></h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- SKK -->
			<div class="col-sm-6">
				<div class="card card-stats card-round">
					<div class="card-body">
						<div class="row align-items-center">
							<a href="?halaman=permohonan_surat">
								<div class="col-icon">
									<div class="icon-big text-center icon-danger bubble-shadow-small">
										<i class="flaticon-envelope-1"></i>
									</div>
								</div>
							</a>
							<div class="col col-stats ml-3 ml-sm-0">
								<div class="numbers">
									<p class="card-category">SURAT KETERANGAN KEMATIAN</p>
									<?php
									$sql = "SELECT * FROM data_request_skk WHERE status=0 AND rt='$rt_login'";
									$query = mysqli_query($konek, $sql);
									$count = mysqli_num_rows($query);
									?>
									<h4 class="card-title"><?= $count; ?></h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- SKBM -->
			<div class="col-sm-6">
				<div class="card card-stats card-round">
					<div class="card-body">
						<div class="row align-items-center">
							<a href="?halaman=permohonan_surat">
								<div class="col-icon">
									<div class="icon-big text-center icon-warning bubble-shadow-small">
										<i class="flaticon-envelope-1"></i>
									</div>
								</div>
							</a>
							<div class="col col-stats ml-3 ml-sm-0">
								<div class="numbers">
									<p class="card-category">SURAT KETERANGAN BELUM MENIKAH</p>
									<?php
									$sql = "SELECT * FROM data_request_skbm WHERE status=0 AND rt='$rt_login'";
									$query = mysqli_query($konek, $sql);
									$count = mysqli_num_rows($query);
									?>
									<h4 class="card-title"><?= $count; ?></h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- SKCK -->
			<div class="col-sm-6">
				<div class="card card-stats card-round">
					<div class="card-body">
						<div class="row align-items-center">
							<a href="?halaman=permohonan_surat">
								<div class="col-icon">
									<div class="icon-big text-center icon-info bubble-shadow-small">
										<i class="flaticon-envelope-1"></i>
									</div>
								</div>
							</a>
							<div class="col col-stats ml-3 ml-sm-0">
								<div class="numbers">
									<p class="card-category">SURAT PENGANTAR SKCK</p>
									<?php
									$sql = "SELECT * FROM data_request_skck WHERE status=0 AND rt='$rt_login'";
									$query = mysqli_query($konek, $sql);
									$count = mysqli_num_rows($query);
									?>
									<h4 class="card-title"><?= $count; ?></h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php
// ==== HALAMAN RW ====
} elseif ($hak_akses == "RW") {
?>
	<div class="panel-header" style="background: linear-gradient(135deg, #8f9baaff 0%, #464f58ff 100%);">
		<div class="page-inner py-5">
			<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
				<div>
					<h2 class="text-white pb-2 fw-bold">Halo <?php echo $hak_akses . " " . $rw_login; ?>!</h2>
				</div>
			</div>
		</div>
	</div>

	<div class="page-inner">
		<h3 class="fw-bold text-uppercase">DAFTAR PENGAJUAN SURAT WARGA</h3>
		<div class="row">
			<!-- SKTM - Permohonan -->
			<div class="col-sm-6">
				<div class="card card-stats card-round">
					<div class="card-body">
						<div class="row align-items-center">
							<a href="?halaman=permohonan_surat">
								<div class="col-icon">
									<div class="icon-big text-center icon-primary bubble-shadow-small">
										<i class="flaticon-envelope-1"></i>
									</div>
								</div>
							</a>
							<div class="col col-stats ml-3 ml-sm-0">
								<div class="numbers">
									<p class="card-category">SURAT KETERANGAN TIDAK MAMPU</p>
									<?php
									include '../konek.php';
									// Permohonan SKTM baru (status 0)
									$sql = "SELECT * FROM data_request_sktm WHERE status=1 AND ttd_rt IS NOT NULL AND ttd_rw IS NULL";
									$query = mysqli_query($konek, $sql);
									$count = mysqli_num_rows($query);
									?>
									<h4 class="card-title"><?= $count; ?></h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div> 

			<!-- SKU - Permohonan -->
			<div class="col-sm-6">
				<div class="card card-stats card-round">
					<div class="card-body">
						<div class="row align-items-center">
							<a href="?halaman=permohonan_surat">
								<div class="col-icon">
									<div class="icon-big text-center icon-success bubble-shadow-small">
										<i class="flaticon-envelope-1"></i>
									</div>
								</div>
							</a>
							<div class="col col-stats ml-3 ml-sm-0">
								<div class="numbers">
									<p class="card-category">SURAT KETERANGAN USAHA</p>
									<?php
									// Permohonan SKU (status 1)
									$sql = "SELECT * FROM data_request_sku WHERE status=1 AND ttd_rt IS NOT NULL AND ttd_rw IS NULL";
									$query = mysqli_query($konek, $sql);
									$count = mysqli_num_rows($query);
									?>
									<h4 class="card-title"><?= $count; ?></h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- SKD - Permohonan -->
			<div class="col-sm-6">
				<div class="card card-stats card-round">
					<div class="card-body">
						<div class="row align-items-center">
							<a href="?halaman=permohonan_surat">
								<div class="col-icon">
									<div class="icon-big text-center icon-secondary bubble-shadow-small">
										<i class="flaticon-envelope-1"></i>
									</div>
								</div>
							</a>
							<div class="col col-stats ml-3 ml-sm-0">
								<div class="numbers">
									<p class="card-category">SURAT KETERANGAN DOMISILI</p>
									<?php
									// Permohonan SKD (status 1)
									$sql = "SELECT * FROM data_request_skd WHERE status=1 AND ttd_rt IS NOT NULL AND ttd_rw IS NULL";
									$query = mysqli_query($konek, $sql);
									$count = mysqli_num_rows($query);
									?>
									<h4 class="card-title"><?= $count; ?></h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- SKK - Permohonan -->
			<div class="col-sm-6">
				<div class="card card-stats card-round">
					<div class="card-body">
						<div class="row align-items-center">
							<a href="?halaman=permohonan_surat">
								<div class="col-icon">
									<div class="icon-big text-center icon-danger bubble-shadow-small">
										<i class="flaticon-envelope-1"></i>
									</div>
								</div>
							</a>
							<div class="col col-stats ml-3 ml-sm-0">
								<div class="numbers">
									<p class="card-category">SURAT KETERANGAN KEMATIAN</p>
									<?php
									// Permohonan SKK (status 1)
									$sql = "SELECT * FROM data_request_skk WHERE status=1 AND ttd_rt IS NOT NULL AND ttd_rw IS NULL";
									$query = mysqli_query($konek, $sql);
									$count = mysqli_num_rows($query);
									?>
									<h4 class="card-title"><?= $count; ?></h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- SKBM - Permohonan -->
			<div class="col-sm-6">
				<div class="card card-stats card-round">
					<div class="card-body">
						<div class="row align-items-center">
							<a href="?halaman=permohonan_surat">
								<div class="col-icon">
									<div class="icon-big text-center icon-warning bubble-shadow-small">
										<i class="flaticon-envelope-1"></i>
									</div>
								</div>
							</a>
							<div class="col col-stats ml-3 ml-sm-0">
								<div class="numbers">
									<p class="card-category">SURAT KETERANGAN BELUM MENIKAH</p>
									<?php
									// Permohonan SKBM (status 1)
									$sql = "SELECT * FROM data_request_skbm WHERE status=1 AND ttd_rt IS NOT NULL AND ttd_rw IS NULL";
									$query = mysqli_query($konek, $sql);
									$count = mysqli_num_rows($query);
									?>
									<h4 class="card-title"><?= $count; ?></h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- SKCK - Permohonan -->
			<div class="col-sm-6 ">
				<div class="card card-stats card-round">
					<div class="card-body">
						<div class="row align-items-center">
							<a href="?halaman=permohonan_surat">
								<div class="col-icon">
									<div class="icon-big text-center icon-info bubble-shadow-small">
										<i class="flaticon-envelope-1"></i>
									</div>
								</div>
							</a>
							<div class="col col-stats ml-3 ml-sm-0">
								<div class="numbers">
									<p class="card-category">SURAT PENGANTAR SKCK</p>
									<?php
									// Permohonan SKU (status 1)
									$sql = "SELECT * FROM data_request_skck WHERE status=1 AND ttd_rt IS NOT NULL AND ttd_rw IS NULL";
									$query = mysqli_query($konek, $sql);
									$count = mysqli_num_rows($query);
									?>
									<h4 class="card-title"><?= $count; ?></h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>


		</div>
	</div>
<?php
}
?>