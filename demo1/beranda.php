<link href="css/sweetalert.css" rel="stylesheet" type="text/css">
<script src="js/jquery-2.1.3.min.js"></script>
<script src="js/sweetalert.min.js"></script>
<?php
if (!isset($_SESSION)) {
	session_start();
}
if (isset($_SESSION['password']) == "" || ($_SESSION['hak_akses']) == "") {
	header('location:login.php');
} else {
	$hak_akses = $_SESSION['hak_akses'];
	$nama = $_SESSION['nama'];
	$nik = $_SESSION['nik'];
}
?>
<?php
if ($hak_akses == "Pemohon") {
	// Cek status biodata
	$query_biodata = "SELECT is_biodata_complete FROM data_user WHERE nik = '$nik'";
	$result_biodata = mysqli_query($konek, $query_biodata);
	$data_biodata = mysqli_fetch_assoc($result_biodata);
	$is_biodata_complete = $data_biodata['is_biodata_complete'] ?? 0;
?>
	<style>
		.card-surat {
			transition: all 0.3s ease;
			border-radius: 15px;
			overflow: hidden;
			box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
			border: none;
			height: 100%;
		}

		.card-surat:hover {
			transform: translateY(-8px);
			box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
		}

		.surat-icon {
			font-size: 3rem;
			margin-bottom: 20px;
			opacity: 0.9;
		}

		.pricing-header {
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			padding: 30px 20px;
			color: white;
			text-align: center;
		}

		.pricing-header.sktm {
			background: linear-gradient(135deg, #8f9baaff 0%, #464f58ff 100%);
		}

		.pricing-header.sku {
			background: linear-gradient(135deg, #8f9baaff 0%, #464f58ff 100%);
		}

		.pricing-header.skd {
			background: linear-gradient(135deg, #8f9baaff 0%, #464f58ff 100%);
		}

		.pricing-header.skk {
			background: linear-gradient(135deg, #8f9baaff 0%, #464f58ff 100%);
		}

		.pricing-header.sk-kerjasama {
			background: linear-gradient(135deg, #8f9baaff 0%, #464f58ff 100%);
		}

		.pricing-header.sk-kematian {
			background: linear-gradient(135deg, #8f9baaff 0%, #464f58ff 100%);
		}

		.pricing-header.sk-skck {
			background: linear-gradient(135deg, #8f9baaff 0%, #464f58ff 100%);
		}

		.pricing-header.sk-ktp-rusak {
			background: linear-gradient(135deg, #8f9baaff 0%, #464f58ff 100%);
		}

		.pricing-header.sk-menikah {
			background: linear-gradient(135deg, #8f9baaff 0%, #464f58ff 100%);
		}

		.price-value {
			padding: 30px 20px;
			text-align: center;
			background: #f8f9fa;
		}

		.btn-request {
			border-radius: 25px;
			font-weight: 600;
			padding: 12px 30px;
			transition: all 0.3s ease;
			border: none;
			font-size: 0.8rem;
			text-transform: uppercase;
			letter-spacing: 0.5px;
		}

		.btn-request.sktm {
			background: linear-gradient(135deg, #8f9baaff 0%, #464f58ff 100%);
		}

		.btn-request.sku {
			background: linear-gradient(135deg, #8f9baaff 0%, #464f58ff 100%);
		}

		.btn-request.skd {
			background: linear-gradient(135deg, #8f9baaff 0%, #464f58ff 100%);
		}

		.btn-request.skk {
			background: linear-gradient(135deg, #8f9baaff 0%, #464f58ff 100%);
		}

		.btn-request.sk-kerjasama {
			background: linear-gradient(135deg, #8f9baaff 0%, #464f58ff 100%);
		}

		.btn-request.sk-kematian {
			background: linear-gradient(135deg, #8f9baaff 0%, #464f58ff 100%);
		}

		.btn-request.sk-skck {
			background: linear-gradient(135deg, #8f9baaff 0%, #464f58ff 100%);
		}

		.btn-request.sk-ktp-rusak {
			background: linear-gradient(135deg, #8f9baaff 0%, #464f58ff 100%);
		}

		.btn-request.sk-menikah {
			background: linear-gradient(135deg, #8f9baaff 0%, #464f58ff 100%);
		}

		.btn-request:hover {
			transform: scale(1.05);
			box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
		}

		.surat-title {
			font-size: 0.8rem;
			font-weight: 700;
			margin-bottom: 0;
			text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
		}

		.surat-desc {
			color: #6c757d;
			font-size: 0.9rem;
			line-height: 1.5;
			margin-bottom: 0;
		}

		.card-body-surat {
			padding: 25px;
		}
	</style>

	<div class="panel-header" style="background: linear-gradient(135deg, #8f9baa 0%, #464f58 100%);">
		<div class="page-inner py-5">
			<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
				<div>
					<h2 class="text-white pb-2 fw-bold">Halo <?php echo $nama; ?>!</h2>
					<h5 class="text-white op-7 mb-2">Jika Belum Melengkapi Biodata, Harap Lengkapi Biodata Terlebih Dahulu!</h5>
				</div>
				<div class="ml-md-auto py-2 py-md-0">
					<a href="?halaman=tampil_pemohon" class="btn btn-light btn-round shadow">
						<i class="fas fa-user me-2"></i> Biodata Anda
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="page-inner mt--5">
		<div class="row justify-content-center">
			<!-- SKTM -->
			<div class="col-lg-4 col-md-6 mb-4">
				<div class="card card-surat">
					<div class="pricing-header sktm">
						<div class="surat-icon text-white">
							<i class="fas fa-hand-holding-heart"></i>
						</div>
						<h5 class="surat-title">SURAT KETERANGAN TIDAK MAMPU</h5>
					</div>
					<div class="card-body-surat">
						<div class="price-value">
							<p class="surat-desc">Untuk keperluan bantuan sosial dan program pemerintah</p>
						</div>
						<div class="text-center mt-4">
							<a href="javascript:void(0)" class="btn btn-request sktm text-white"
								onclick="cekRequestSurat('request_sktm')">
								<i class="fas fa-plus-circle me-2"></i> Request Surat
							</a>
						</div>
					</div>
				</div>
			</div>

			<!-- SKU -->
			<div class="col-lg-4 col-md-6 mb-4">
				<div class="card card-surat">
					<div class="pricing-header sku">
						<div class="surat-icon text-white">
							<i class="fas fa-store"></i>
						</div>
						<h5 class="surat-title">SURAT KETERANGAN USAHA</h5>
					</div>
					<div class="card-body-surat">
						<div class="price-value">
							<p class="surat-desc">Untuk legalitas usaha dan perizinan bisnis</p>
						</div>
						<div class="text-center mt-4">
							<a href="javascript:void(0)" class="btn btn-request sku text-white"
								onclick="cekRequestSurat('request_sku')">
								<i class="fas fa-plus-circle me-2"></i> Request Surat
							</a>
						</div>
					</div>
				</div>
			</div>

			<!-- SKD -->
			<div class="col-lg-4 col-md-6 mb-4">
				<div class="card card-surat">
					<div class="pricing-header skd">
						<div class="surat-icon text-white">
							<i class="fas fa-home"></i>
						</div>
						<h5 class="surat-title">SURAT KETERANGAN DOMISILI</h5>
					</div>
					<div class="card-body-surat">
						<div class="price-value">
							<p class="surat-desc">Untuk keperluan administrasi kependudukan</p>
						</div>
						<div class="text-center mt-4">
							<a href="javascript:void(0)" class="btn btn-request skd text-white"
								onclick="cekRequestSurat('request_skd')">
								<i class="fas fa-plus-circle me-2"></i> Request Surat
							</a>
						</div>
					</div>
				</div>
			</div>

			<!-- SKK (Kematian) -->
			<div class="col-lg-4 col-md-6 mb-4">
				<div class="card card-surat">
					<div class="pricing-header sk-kematian">
						<div class="surat-icon text-white">
							<i class="fas fa-leaf"></i>
						</div>
						<h5 class="surat-title">SURAT KETERANGAN KEMATIAN</h5>
					</div>
					<div class="card-body-surat">
						<div class="price-value">
							<p class="surat-desc">Untuk keperluan administrasi dan proses hukum kematian</p>
						</div>
						<div class="text-center mt-4">
							<a href="javascript:void(0)" class="btn btn-request sk-kematian text-white"
								onclick="cekRequestSurat('request_skk')">
								<i class="fas fa-plus-circle me-2"></i> Request Surat
							</a>
						</div>
					</div>
				</div>
			</div>

			<!-- SKCK -->
			<div class="col-lg-4 col-md-6 mb-4">
				<div class="card card-surat">
					<div class="pricing-header sk-skck">
						<div class="surat-icon text-white">
							<i class="fas fa-file-contract"></i>
						</div>
						<h5 class="surat-title">SURAT PENGANTAR SKCK</h5>
					</div>
					<div class="card-body-surat">
						<div class="price-value">
							<p class="surat-desc">Untuk pengajuan Surat Keterangan Catatan Kepolisian</p>
						</div>
						<div class="text-center mt-4">
							<a href="javascript:void(0)" class="btn btn-request sk-skck text-white"
								onclick="cekRequestSurat('request_skck')">
								<i class="fas fa-plus-circle me-2"></i> Request Surat
							</a>
						</div>
					</div>
				</div>
			</div>

			<!-- SKBM (Belum Menikah) -->
			<div class="col-lg-4 col-md-6 mb-4">
				<div class="card card-surat">
					<div class="pricing-header sk-menikah">
						<div class="surat-icon text-white">
							<i class="fas fa-venus-mars"></i>
						</div>
						<h5 class="surat-title">SURAT KETERANGAN BELUM MENIKAH</h5>
					</div>
					<div class="card-body-surat">
						<div class="price-value">
							<p class="surat-desc">Untuk keperluan administrasi status perkawinan</p>
						</div>
						<div class="text-center mt-4">
							<a href="javascript:void(0)" class="btn btn-request sk-menikah text-white"
								onclick="cekRequestSurat('request_skbm')">
								<i class="fas fa-plus-circle me-2"></i> Request Surat
							</a>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>

	<!-- ===== SCRIPT CEK BIODATA ===== -->
	<script>
		function cekRequestSurat(halaman) {
			<?php if ($is_biodata_complete == 0): ?>
				swal({
					title: '⚠️ Biodata Belum Lengkap!',
					text: 'Silakan lengkapi biodata Anda terlebih dahulu melalui menu Biodata Anda sebelum mengajukan surat.',
					icon: 'warning',
					button: 'OK'
				});
			<?php else: ?>
				window.location.href = '?halaman=' + halaman;
			<?php endif; ?>
		}
	</script>

<?php
} elseif ($hak_akses == "RT") {
?>
	 
<?php
} elseif ($hak_akses == "RW") {
?>
	 
<?php
}
?> 