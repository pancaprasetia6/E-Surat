<?php
include '../konek.php';
include 'signature_functions.php';

// ==================== FUNGSI HELPER ====================
function processAcc($id, $jenis)
{
	$konek = $GLOBALS['konek'];

	$surat = [
		'sktm' => ['table' => 'data_request_sktm', 'id_col' => 'id_request_sktm', 'prefix' => 'SKTM'],
		'sku'  => ['table' => 'data_request_sku',  'id_col' => 'id_request_sku',  'prefix' => 'SKU'],
		'skd'  => ['table' => 'data_request_skd',  'id_col' => 'id_request_skd',  'prefix' => 'SKD'],
		'skck'  => ['table' => 'data_request_skck',  'id_col' => 'id_request_skck',  'prefix' => 'SKCK'],
		'skk'  => ['table' => 'data_request_skk',  'id_col' => 'id_request_skk',  'prefix' => 'SKK'],
		'skbm' => ['table' => 'data_request_skbm', 'id_col' => 'id_request_skbm', 'prefix' => 'SKBM']
	];

	// Cek apakah jenis surat valid
	if (!isset($surat[$jenis])) {
		echo "<script>swal('Error!', 'Jenis surat tidak valid', 'error');</script>";
		return;
	}

	$s = $surat[$jenis];
	$no_surat = $s['prefix'] . "/" . date('Y') . "/" . str_pad($id, 4, '0', STR_PAD_LEFT);
	$sql = "UPDATE {$s['table']} SET status='1', no_surat='$no_surat', acc=NOW(), keterangan='Surat sudah bisa dicetak' WHERE {$s['id_col']}='$id'";
	$query = mysqli_query($konek, $sql);

	$nama_surat = strtoupper($jenis);
	if ($query) {
		echo "<script>swal('Berhasil!', 'Pengajuan $nama_surat telah disetujui', 'success'); setTimeout(function(){ window.location.href = '?halaman=permohonan_surat'; }, 2000);</script>";
	} else {
		echo "<script>swal('Gagal!', 'Terjadi kesalahan sistem: " . mysqli_error($konek) . "', 'error'); setTimeout(function(){ window.location.href = '?halaman=permohonan_surat'; }, 2000);</script>";
	}
}

function processTTD($id, $jenis, $level)
{
	$konek = $GLOBALS['konek'];

	$surat = [
		'sktm' => ['table' => 'data_request_sktm', 'id_col' => 'id_request_sktm'],
		'sku'  => ['table' => 'data_request_sku',  'id_col' => 'id_request_sku'],
		'skd'  => ['table' => 'data_request_skd',  'id_col' => 'id_request_skd'],
		'skck'  => ['table' => 'data_request_skck',  'id_col' => 'id_request_skck'],
		'skk'  => ['table' => 'data_request_skk',  'id_col' => 'id_request_skk'],
		'skbm' => ['table' => 'data_request_skbm', 'id_col' => 'id_request_skbm']
	];

	// Cek apakah jenis surat valid
	if (!isset($surat[$jenis])) {
		echo "<script>swal('Error!', 'Jenis surat tidak valid', 'error');</script>";
		return;
	}

	$s = $surat[$jenis];
	$sql = "SELECT * FROM {$s['table']} WHERE {$s['id_col']}='$id'";
	$result = mysqli_query($konek, $sql);
	$data = mysqli_fetch_assoc($result);

	// Cek apakah data ditemukan
	if (!$data) {
		echo "<script>swal('Error!', 'Data surat tidak ditemukan', 'error');</script>";
		return;
	}

	$data_to_sign = [
		'id_request' => $id,
		'jenis_surat' => $jenis,
		'nik' => $data['nik'],
		'nama' => $data['Nama'],
		'keperluan' => $data['keperluan'] ?? '-',
		'tanggal_sign' => date('Y-m-d H:i:s'),
		'level' => $level
	];

	$signature = signData($data_to_sign, $level);
	$qrPath = generateQRCode($signature, $id, $jenis, $level);
	$data_json = json_encode($data_to_sign);

	$cek = mysqli_query($konek, "SELECT * FROM digital_signature_log WHERE id_request='$id' AND jenis_surat='$jenis' AND level='$level'");
	if (mysqli_num_rows($cek) == 0) {
		mysqli_query($konek, "INSERT INTO digital_signature_log (id_request, jenis_surat, data_json, signature, level) VALUES ('$id', '$jenis', '$data_json', '$signature', '$level')");
	} else {
		mysqli_query($konek, "UPDATE digital_signature_log SET signature='$signature', data_json='$data_json' WHERE id_request='$id' AND jenis_surat='$jenis' AND level='$level'");
	}

	$field_ttd = ($level == 'rt') ? 'ttd_rt' : 'ttd_rw';
	$field_sign = ($level == 'rt') ? 'tanda_tangan_rt' : 'tanda_tangan_rw';
	$field_qr = ($level == 'rt') ? 'qr_code_rt' : 'qr_code_rw';
	$keterangan = ($level == 'rt') ? 'Sudah ditandatangani RT' : 'Sudah ditandatangani RT & RW';

	$sql = "UPDATE {$s['table']} SET $field_ttd=NOW(), $field_sign='$signature', $field_qr='$qrPath', keterangan='$keterangan' WHERE {$s['id_col']}='$id'";
	$query = mysqli_query($konek, $sql);

	$nama_level = strtoupper($level);
	$nama_surat = strtoupper($jenis);
	if ($query) {
		echo "<script>swal('Berhasil!', 'Surat $nama_surat sudah ditandatangani $nama_level (Digital Signature RSA)', 'success'); setTimeout(function(){ window.location.href = '?halaman=permohonan_surat'; }, 2000);</script>";
	} else {
		echo "<script>swal('Gagal!', 'Terjadi kesalahan sistem: " . mysqli_error($konek) . "', 'error'); setTimeout(function(){ window.location.href = '?halaman=permohonan_surat'; }, 2000);</script>";
	}
}

// ==================== PROSES AKSI ====================
if (isset($_GET['aksi']) && isset($_GET['id'])) {
	$id = $_GET['id'];
	$aksi = $_GET['aksi'];

	// ACC (semua surat)
	if ($aksi == 'acc' || $aksi == 'acc_sku' || $aksi == 'acc_skd' || $aksi == 'acc_skck' || $aksi == 'acc_skk' || $aksi == 'acc_skbm') {
		if ($aksi == 'acc') {
			$jenis = 'sktm';
		} else {
			$jenis = substr($aksi, 4); // acc_sku -> sku
		}
		processAcc($id, $jenis);
	}

	// TTD RT (semua surat)
	if ($aksi == 'ttd_rt' || $aksi == 'ttd_rt_sku' || $aksi == 'ttd_rt_skd' || $aksi == 'ttd_rt_skck' || $aksi == 'ttd_rt_skk' || $aksi == 'ttd_rt_skbm') {
		if ($aksi == 'ttd_rt') {
			$jenis = 'sktm';
		} else {
			$jenis = substr($aksi, 7); // ttd_rt_sku -> sku
		}
		processTTD($id, $jenis, 'rt');
	}

	// TTD RW (semua surat)
	if ($aksi == 'ttd_rw' || $aksi == 'ttd_rw_sku' || $aksi == 'ttd_rw_skd' || $aksi == 'ttd_rw_skck' || $aksi == 'ttd_rw_skk' || $aksi == 'ttd_rw_skbm') {
		if ($aksi == 'ttd_rw') {
			$jenis = 'sktm';
		} else {
			$jenis = substr($aksi, 7); // ttd_rw_sku -> sku
		}
		processTTD($id, $jenis, 'rw');
	}
}

// PROSES FORM TOLAK
if (isset($_POST['submit_tolak'])) {
	$id = $_POST['id_penolakan'];
	$type = $_POST['type_penolakan'];
	$alasan = mysqli_real_escape_string($konek, $_POST['alasan_penolakan']);

	$surat_mapping = array(
		'sku'   => array('table' => 'data_request_sku', 'id_column' => 'id_request_sku'),
		'sktm'  => array('table' => 'data_request_sktm', 'id_column' => 'id_request_sktm'),
		'skd'   => array('table' => 'data_request_skd', 'id_column' => 'id_request_skd'),
		'skck'   => array('table' => 'data_request_skp', 'id_column' => 'id_request_skp'),
		'skk'   => array('table' => 'data_request_skk', 'id_column' => 'id_request_skk'),
		'skbm'  => array('table' => 'data_request_skbm', 'id_column' => 'id_request_skbm')
	);

	if (isset($surat_mapping[$type])) {
		$table = $surat_mapping[$type]['table'];
		$id_column = $surat_mapping[$type]['id_column'];

		$sql = "UPDATE $table SET status='ditolak', keterangan='$alasan' WHERE $id_column='$id'";
		$query = mysqli_query($konek, $sql);

		if ($query) {
			echo "<script>
                swal('Ditolak!', 'Pengajuan telah ditolak', 'warning');
                setTimeout(function(){ window.location.href = '?halaman=permohonan_surat'; }, 2000);
            </script>";
		} else {
			echo "<script>
                swal('Gagal!', 'Error: " . mysqli_error($konek) . "', 'error');
                setTimeout(function(){ window.location.href = '?halaman=permohonan_surat'; }, 2000);
            </script>";
		}
	}
}


// PROSES FORM TOLAK (sama seperti sebelumnya, tidak berubah)
if (isset($_POST['submit_tolak'])) {
	$id = $_POST['id_penolakan'];
	$type = $_POST['type_penolakan'];
	$alasan = mysqli_real_escape_string($konek, $_POST['alasan_penolakan']);

	$surat_mapping = array(
		'sku'   => array('table' => 'data_request_sku', 'id_column' => 'id_request_sku'),
		'sktm'  => array('table' => 'data_request_sktm', 'id_column' => 'id_request_sktm'),
		'skd'   => array('table' => 'data_request_skd', 'id_column' => 'id_request_skd'),
		'skck'   => array('table' => 'data_request_skck', 'id_column' => 'id_request_skck'),
		'skk'   => array('table' => 'data_request_skk', 'id_column' => 'id_request_skk'),
		'skbm'  => array('table' => 'data_request_skbm', 'id_column' => 'id_request_skbm')
	);

	if (isset($surat_mapping[$type])) {
		$table = $surat_mapping[$type]['table'];
		$id_column = $surat_mapping[$type]['id_column'];

		$sql = "UPDATE $table SET status='ditolak', keterangan='$alasan' WHERE $id_column='$id'";
		$query = mysqli_query($konek, $sql);

		if ($query) {
			echo "<script>
                swal('Ditolak!', 'Pengajuan telah ditolak', 'warning');
                setTimeout(function(){ window.location.href = '?halaman=permohonan_surat'; }, 2000);
            </script>";
		} else {
			echo "<script>
                swal('Gagal!', 'Error: " . mysqli_error($konek) . "', 'error');
                setTimeout(function(){ window.location.href = '?halaman=permohonan_surat'; }, 2000);
            </script>";
		}
	}
}
?>
<link href="css/sweetalert.css" rel="stylesheet" type="text/css">
<script src="js/jquery-2.1.3.min.js"></script>
<script src="js/sweetalert.min.js"></script>

<div class="page-inner">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="d-flex align-items-center">
						<h4 class="card-title">PERMOHONAN SURAT KETERANGAN TIDAK MAMPU</h4>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table id="add1" class="display table table-striped table-hover">
							<thead>
								<tr>
									<th>Tanggal Request</th>
									<th>NIK</th>
									<th>Nama Lengkap</th>
									<th>Keperluan</th>
									<th>Status</th>
									<th style="width: 15%">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if ($hak_akses == 'RT') {
									$sql = "SELECT sktm.*, user.rt, user.rw FROM data_request_sktm sktm 
											INNER JOIN data_user user ON sktm.nik = user.nik 
											WHERE (sktm.status = 0 OR (sktm.status = 1 AND sktm.ttd_rt IS NULL))
											AND user.rt = '$rt_login' 
											ORDER BY sktm.tanggal_request DESC";
								} else {
									$sql = "SELECT sktm.*, user.rt, user.rw FROM data_request_sktm sktm 
											INNER JOIN data_user user ON sktm.nik = user.nik 
											WHERE sktm.status = 1 
											AND sktm.ttd_rt IS NOT NULL 
											AND sktm.ttd_rw IS NULL 
											ORDER BY sktm.tanggal_request DESC";
								}

								$query = mysqli_query($konek, $sql);

								if (mysqli_num_rows($query) == 0) {
									echo "<tr><td colspan='7' class='text-center'>Tidak ada data permohonan</td></tr>";
								}

								while ($data = mysqli_fetch_array($query, MYSQLI_BOTH)) {
									$id_request_sktm = $data['id_request_sktm'];
									$tgl = $data['tanggal_request'];
									$format = date('d F Y', strtotime($tgl));
									$nik = $data['nik'];
									$nama = $data['Nama'];
									$status = $data['status'];
									$keperluan = $data['keperluan'];
									$ttd_rt = $data['ttd_rt'];
									$ttd_rw = $data['ttd_rw'];
									$rt = $data['rt'];
									$rw = $data['rw'];

									if ($status == "ditolak") {
										$status_text = "<span class='badge badge-danger'>DITOLAK</span>";
									} elseif ($ttd_rw) {
										$status_text = "<span class='badge badge-success'>SUDAH TTD RW ✓</span>";
									} elseif ($ttd_rt) {
										$status_text = "<span class='badge badge-info'>SUDAH TTD RT ✓</span>";
									} elseif ($status == "1") {
										$status_text = "<span class='badge badge-warning'>SUDAH DIACC</span>";
									} else {
										$status_text = "<span class='badge badge-secondary'>MENUNGGU ACC</span>";
									}
								?>
									<tr>
										<td><?php echo $format; ?></td>
										<td><?php echo $nik; ?></td>
										<td><?php echo $nama; ?></td>
										<td><?php echo $keperluan; ?></td>
										<td><?php echo $status_text; ?></td>
										<td>
											<div class="form-button-action">
												<a href="?halaman=detail_sktm&id_request_sktm=<?= $id_request_sktm; ?>">
													<button type="button" data-toggle="tooltip" title="Lihat Detail" class="btn btn-link btn-info btn-lg">
														<i class="fa fa-eye"></i>
													</button>
												</a>

												<?php if ($hak_akses == 'RT'): ?>
													<?php if ($status == "0" || $status == "ditolak") { ?>
														<a href="?halaman=permohonan_surat&aksi=acc&id=<?= $id_request_sktm; ?>" onclick="return confirm('Anda yakin ingin mengACC pengajuan ini?')">
															<button type="button" data-toggle="tooltip" title="ACC Pengajuan" class="btn btn-link btn-success btn-lg">
																<i class="fa fa-check"></i>
															</button>
														</a>
													<?php } ?>

													<?php if ($status == "0" || $status == "ditolak") { ?>
														<button type="button" data-toggle="tooltip" title="Tolak Pengajuan" class="btn btn-link btn-danger" onclick="openTolakModal('<?= $id_request_sktm; ?>', 'sktm')">
															<i class="fa fa-times"></i>
														</button>
													<?php } ?>

													<?php if ($status == "1" && !$ttd_rt) { ?>
														<a href="?halaman=permohonan_surat&aksi=ttd_rt&id=<?= $id_request_sktm; ?>" onclick="return confirm('Anda yakin sudah menandatangani surat ini? Tanda tangan digital RSA akan dibuat.')">
															<button type="button" data-toggle="tooltip" title="TTD Digital RT" class="btn btn-link btn-warning">
																<i class="fa fa-pen"></i> RT
															</button>
														</a>
													<?php } ?>

												<?php else: ?>
													<?php if ($status == "1" && $ttd_rt && !$ttd_rw) { ?>
														<a href="?halaman=permohonan_surat&aksi=ttd_rw&id=<?= $id_request_sktm; ?>" onclick="return confirm('Anda yakin sudah menandatangani surat ini? Tanda tangan digital RSA akan dibuat.')">
															<button type="button" data-toggle="tooltip" title="TTD Digital RW" class="btn btn-link btn-primary">
																<i class="fa fa-pen"></i> RW
															</button>
														</a>
													<?php } ?>
												<?php endif; ?>

												<?php if ($status == "1" && $ttd_rw) { ?>
													<a href="cetak_sktm.php?id_request_sktm=<?= $id_request_sktm; ?>" target="_blank">
														<button type="button" data-toggle="tooltip" title="Cetak Surat" class="btn btn-link btn-primary">
															<i class="fa fa-print"></i>
														</button>
													</a>
												<?php } ?>
											</div>
										</td>
									</tr>
								<?php
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="d-flex align-items-center">
						<h4 class="card-title">PERMOHONAN SURAT KETERANGAN USAHA</h4>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table id="add2" class="display table table-striped table-hover">
							<thead>
								<tr>
									<th>Tanggal Request</th>
									<th>NIK</th>
									<th>Nama Lengkap</th>
									<th>Nama Usaha</th>
									<th>Status</th>
									<th style="width: 15%">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if ($hak_akses == 'RT') {
									$sql = "SELECT sku.*, user.rt, user.rw FROM data_request_sku sku 
											INNER JOIN data_user user ON sku.nik = user.nik 
											WHERE (sku.status = 0 OR (sku.status = 1 AND sku.ttd_rt IS NULL))
											AND user.rt = '$rt_login' 
											ORDER BY sku.tanggal_request DESC";
								} else {
									$sql = "SELECT sku.*, user.rt, user.rw FROM data_request_sku sku 
											INNER JOIN data_user user ON sku.nik = user.nik 
											WHERE sku.status = 1 
											AND sku.ttd_rt IS NOT NULL 
											AND sku.ttd_rw IS NULL 
											ORDER BY sku.tanggal_request DESC";
								}

								$query = mysqli_query($konek, $sql);

								if (mysqli_num_rows($query) == 0) {
									echo "<tr><td colspan='7' class='text-center'>Tidak ada data permohonan</td></tr>";
								}

								while ($data = mysqli_fetch_array($query, MYSQLI_BOTH)) {
									$id_request_sku = $data['id_request_sku'];
									$tgl = $data['tanggal_request'];
									$format = date('d F Y', strtotime($tgl));
									$nik = $data['nik'];
									$nama = $data['Nama'];
									$status = $data['status'];
									$nama_usaha = $data['Nama_usaha'];
									$ttd_rt = $data['ttd_rt'];
									$ttd_rw = $data['ttd_rw'];
									$rt = $data['rt'];

									if ($status == "ditolak") {
										$status_text = "<span class='badge badge-danger'>DITOLAK</span>";
									} elseif ($ttd_rw) {
										$status_text = "<span class='badge badge-success'>SUDAH TTD RW ✓</span>";
									} elseif ($ttd_rt) {
										$status_text = "<span class='badge badge-info'>SUDAH TTD RT ✓</span>";
									} elseif ($status == "1") {
										$status_text = "<span class='badge badge-warning'>SUDAH DIACC</span>";
									} else {
										$status_text = "<span class='badge badge-secondary'>MENUNGGU ACC</span>";
									}
								?>
									<tr>
										<td><?php echo $format; ?></td>
										<td><?php echo $nik; ?></td>
										<td><?php echo $nama; ?></td>
										<td><?php echo $nama_usaha; ?></td>
										<td><?php echo $status_text; ?></td>
										<td>
											<div class="form-button-action">
												<a href="?halaman=detail_sku&id_request_sku=<?= $id_request_sku; ?>">
													<button type="button" data-toggle="tooltip" title="Lihat Detail" class="btn btn-link btn-info btn-lg">
														<i class="fa fa-eye"></i>
													</button>
												</a>

												<?php if ($hak_akses == 'RT'): ?>
													<?php if ($status == "0" || $status == "ditolak") { ?>
														<a href="?halaman=permohonan_surat&aksi=acc_sku&id=<?= $id_request_sku; ?>" onclick="return confirm('Anda yakin ingin mengACC pengajuan ini?')">
															<button type="button" data-toggle="tooltip" title="ACC Pengajuan" class="btn btn-link btn-success btn-lg">
																<i class="fa fa-check"></i>
															</button>
														</a>
													<?php } ?>

													<?php if ($status == "0" || $status == "ditolak") { ?>
														<button type="button" data-toggle="tooltip" title="Tolak Pengajuan" class="btn btn-link btn-danger" onclick="openTolakModal('<?= $id_request_sku; ?>', 'sku')">
															<i class="fa fa-times"></i>
														</button>
													<?php } ?>

													<?php if ($status == "1" && !$ttd_rt) { ?>
														<a href="?halaman=permohonan_surat&aksi=ttd_rt_sku&id=<?= $id_request_sku; ?>" onclick="return confirm('Anda yakin sudah menandatangani surat ini? Tanda tangan digital RSA akan dibuat.')">
															<button type="button" data-toggle="tooltip" title="TTD Digital RT" class="btn btn-link btn-warning">
																<i class="fa fa-pen"></i> RT
															</button>
														</a>
													<?php } ?>

												<?php else: ?>
													<?php if ($status == "1" && $ttd_rt && !$ttd_rw) { ?>
														<a href="?halaman=permohonan_surat&aksi=ttd_rw_sku&id=<?= $id_request_sku; ?>" onclick="return confirm('Anda yakin sudah menandatangani surat ini? Tanda tangan digital RSA akan dibuat.')">
															<button type="button" data-toggle="tooltip" title="TTD Digital RW" class="btn btn-link btn-primary">
																<i class="fa fa-pen"></i> RW
															</button>
														</a>
													<?php } ?>
												<?php endif; ?>

												<?php if ($status == "1" && $ttd_rw) { ?>
													<a href="cetak_sku.php?id_request_sku=<?= $id_request_sku; ?>" target="_blank">
														<button type="button" data-toggle="tooltip" title="Cetak Surat" class="btn btn-link btn-primary">
															<i class="fa fa-print"></i>
														</button>
													</a>
												<?php } ?>
											</div>
										</td>
									</tr>
								<?php
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<div class="d-flex align-items-center">
				<h4 class="card-title">PERMOHONAN SURAT KETERANGAN DOMISILI</h4>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table id="add3" class="display table table-striped table-hover">
					<thead>
						<tr>
							<th>Tanggal Request</th>
							<th>NIK</th>
							<th>Nama Lengkap</th>
							<th>Keperluan</th>
							<th>Status</th>
							<th style="width: 15%">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if ($hak_akses == 'RT') {
							$sql = "SELECT skd.*, user.rt, user.rw FROM data_request_skd skd 
											INNER JOIN data_user user ON skd.nik = user.nik 
											WHERE (skd.status = 0 OR (skd.status = 1 AND skd.ttd_rt IS NULL))
											AND user.rt = '$rt_login' 
											ORDER BY skd.tanggal_request DESC";
						} else {
							$sql = "SELECT skd.*, user.rt, user.rw FROM data_request_skd skd 
											INNER JOIN data_user user ON skd.nik = user.nik 
											WHERE skd.status = 1 
											AND skd.ttd_rt IS NOT NULL 
											AND skd.ttd_rw IS NULL 
											ORDER BY skd.tanggal_request DESC";
						}

						$query = mysqli_query($konek, $sql);

						if (mysqli_num_rows($query) == 0) {
							echo "<tr><td colspan='7' class='text-center'>Tidak ada data permohonan</td></tr>";
						}

						while ($data = mysqli_fetch_array($query, MYSQLI_BOTH)) {
							$id_request_skd = $data['id_request_skd'];
							$tgl = $data['tanggal_request'];
							$format = date('d F Y', strtotime($tgl));
							$nik = $data['nik'];
							$nama = $data['Nama'];
							$status = $data['status'];
							$keperluan = $data['keperluan'];
							$ttd_rt = $data['ttd_rt'];
							$ttd_rw = $data['ttd_rw'];
							$rt = $data['rt'];
							$rw = $data['rw'];

							if ($status == "ditolak") {
								$status_text = "<span class='badge badge-danger'>DITOLAK</span>";
							} elseif ($ttd_rw) {
								$status_text = "<span class='badge badge-success'>SUDAH TTD RW ✓</span>";
							} elseif ($ttd_rt) {
								$status_text = "<span class='badge badge-info'>SUDAH TTD RT ✓</span>";
							} elseif ($status == "1") {
								$status_text = "<span class='badge badge-warning'>SUDAH DIACC</span>";
							} else {
								$status_text = "<span class='badge badge-secondary'>MENUNGGU ACC</span>";
							}
						?>
							<tr>
								<td><?php echo $format; ?></td>
								<td><?php echo $nik; ?></td>
								<td><?php echo $nama; ?></td>
								<td><?php echo $keperluan; ?></td>
								<td><?php echo $status_text; ?></td>
								<td>
									<div class="form-button-action">
										<a href="?halaman=detail_skd&id_request_skd=<?= $id_request_skd; ?>">
											<button type="button" data-toggle="tooltip" title="Lihat Detail" class="btn btn-link btn-info btn-lg">
												<i class="fa fa-eye"></i>
											</button>
										</a>

										<?php if ($hak_akses == 'RT'): ?>
											<?php if ($status == "0" || $status == "ditolak") { ?>
												<a href="?halaman=permohonan_surat&aksi=acc_skd&id=<?= $id_request_skd; ?>" onclick="return confirm('Anda yakin ingin mengACC pengajuan ini?')">
													<button type="button" data-toggle="tooltip" title="ACC Pengajuan" class="btn btn-link btn-success btn-lg"><i class="fa fa-check"></i></button>
												</a>
												<button type="button" data-toggle="tooltip" title="Tolak Pengajuan" class="btn btn-link btn-danger" onclick="openTolakModal('<?= $id_request_skd; ?>', 'skd')"><i class="fa fa-times"></i></button>
											<?php } ?>
											<?php if ($status == "1" && !$ttd_rt) { ?>
												<a href="?halaman=permohonan_surat&aksi=ttd_rt_skd&id=<?= $id_request_skd; ?>" onclick="return confirm('Anda yakin sudah menandatangani surat ini? Tanda tangan digital RSA akan dibuat.')">
													<button type="button" data-toggle="tooltip" title="TTD Digital RT" class="btn btn-link btn-warning"><i class="fa fa-pen"></i> RT</button>
												</a>
											<?php } ?>
										<?php else: ?>
											<?php if ($status == "1" && $ttd_rt && !$ttd_rw) { ?>
												<a href="?halaman=permohonan_surat&aksi=ttd_rw_skd&id=<?= $id_request_skd; ?>" onclick="return confirm('Anda yakin sudah menandatangani surat ini? Tanda tangan digital RSA akan dibuat.')">
													<button type="button" data-toggle="tooltip" title="TTD Digital RW" class="btn btn-link btn-primary"><i class="fa fa-pen"></i> RW</button>
												</a>
											<?php } ?>
										<?php endif; ?>
										<?php if ($status == "1" && $ttd_rw) { ?>
											<a href="cetak_skd.php?id_request_skd=<?= $id_request_skd; ?>" target="_blank">
												<button type="button" data-toggle="tooltip" title="Cetak Surat" class="btn btn-link btn-primary"><i class="fa fa-print"></i></button>
											</a>
										<?php } ?>
									</div>
								</td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<div class="d-flex align-items-center">
				<h4 class="card-title">PERMOHONAN SURAT PENGANTAR SKCK</h4>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table id="add4" class="display table table-striped table-hover">
					<thead>
						<tr>
							<th>Tanggal Request</th>
							<th>NIK</th>
							<th>Nama Lengkap</th>
							<th>Keperluan</th>
							<th>Status</th>
							<th style="width: 15%">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if ($hak_akses == 'RT') {
							$sql = "SELECT skck.*, user.rt, user.rw FROM data_request_skck skck
											INNER JOIN data_user user ON skck.nik = user.nik 
											WHERE (skck.status = 0 OR (skck.status = 1 AND skck.ttd_rt IS NULL))
											AND user.rt = '$rt_login' 
											ORDER BY skck.tanggal_request DESC";
						} else {
							$sql = "SELECT skck.*, user.rt, user.rw FROM data_request_skck skck
											INNER JOIN data_user user ON skck.nik = user.nik 
											WHERE skck.status = 1 
											AND skck.ttd_rt IS NOT NULL 
											AND skck.ttd_rw IS NULL 
											ORDER BY skck.tanggal_request DESC";
						}

						$query = mysqli_query($konek, $sql);

						if (mysqli_num_rows($query) == 0) {
							echo "<tr><td colspan='7' class='text-center'>Tidak ada data permohonan</td></tr>";
						}

						while ($data = mysqli_fetch_array($query, MYSQLI_BOTH)) {
							$id_request_skck = $data['id_request_skck'];
							$tgl = $data['tanggal_request'];
							$format = date('d F Y', strtotime($tgl));
							$nik = $data['nik'];
							$nama = $data['Nama'];
							$status = $data['status'];
							$keperluan = $data['keperluan'];
							$ttd_rt = $data['ttd_rt'];
							$ttd_rw = $data['ttd_rw'];
							$rt = $data['rt'];
							$rw = $data['rw'];

							if ($status == "ditolak") {
								$status_text = "<span class='badge badge-danger'>DITOLAK</span>";
							} elseif ($ttd_rw) {
								$status_text = "<span class='badge badge-success'>SUDAH TTD RW ✓</span>";
							} elseif ($ttd_rt) {
								$status_text = "<span class='badge badge-info'>SUDAH TTD RT ✓</span>";
							} elseif ($status == "1") {
								$status_text = "<span class='badge badge-warning'>SUDAH DIACC</span>";
							} else {
								$status_text = "<span class='badge badge-secondary'>MENUNGGU ACC</span>";
							}
						?>
							<tr>
								<td><?php echo $format; ?></td>
								<td><?php echo $nik; ?></td>
								<td><?php echo $nama; ?></td>
								<td><?php echo $keperluan; ?></td>
								<td><?php echo $status_text; ?></td>
								<td>
									<div class="form-button-action">
										<a href="?halaman=detail_skck&id_request_skck=<?= $id_request_skck; ?>">
											<button type="button" data-toggle="tooltip" title="Lihat Detail" class="btn btn-link btn-info btn-lg">
												<i class="fa fa-eye"></i>
											</button>
										</a>

										<?php if ($hak_akses == 'RT'): ?>
											<?php if ($status == "0" || $status == "ditolak") { ?>
												<a href="?halaman=permohonan_surat&aksi=acc_skck&id=<?= $id_request_skck; ?>" onclick="return confirm('Anda yakin ingin mengACC pengajuan ini?')">
													<button type="button" data-toggle="tooltip" title="ACC Pengajuan" class="btn btn-link btn-success btn-lg"><i class="fa fa-check"></i></button>
												</a>
												<button type="button" data-toggle="tooltip" title="Tolak Pengajuan" class="btn btn-link btn-danger" onclick="openTolakModal('<?= $id_request_skck; ?>', 'skck')"><i class="fa fa-times"></i></button>
											<?php } ?>
											<?php if ($status == "1" && !$ttd_rt) { ?>
												<a href="?halaman=permohonan_surat&aksi=ttd_rt_skck&id=<?= $id_request_skck; ?>" onclick="return confirm('Anda yakin sudah menandatangani surat ini? Tanda tangan digital RSA akan dibuat.')">
													<button type="button" data-toggle="tooltip" title="TTD Digital RT" class="btn btn-link btn-warning"><i class="fa fa-pen"></i> RT</button>
												</a>
											<?php } ?>
										<?php else: ?>
											<?php if ($status == "1" && $ttd_rt && !$ttd_rw) { ?>
												<a href="?halaman=permohonan_surat&aksi=ttd_rw_skck&id=<?= $id_request_skck; ?>" onclick="return confirm('Anda yakin sudah menandatangani surat ini? Tanda tangan digital RSA akan dibuat.')">
													<button type="button" data-toggle="tooltip" title="TTD Digital RW" class="btn btn-link btn-primary"><i class="fa fa-pen"></i> RW</button>
												</a>
											<?php } ?>
										<?php endif; ?>
										<?php if ($status == "1" && $ttd_rw) { ?>
											<a href="cetak_skck.php?id_request_skck=<?= $id_request_skck; ?>" target="_blank">
												<button type="button" data-toggle="tooltip" title="Cetak Surat" class="btn btn-link btn-primary"><i class="fa fa-print"></i></button>
											</a>
										<?php } ?>
									</div>
								</td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<div class="d-flex align-items-center">
				<h4 class="card-title">PERMOHONAN SURAT KETERANGAN BELUM MENIKAH</h4>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table id="add5" class="display table table-striped table-hover">
					<thead>
						<tr>
							<th>Tanggal Request</th>
							<th>NIK</th>
							<th>Nama Lengkap</th>
							<th>Keperluan</th>
							<th>Status</th>
							<th style="width: 15%">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if ($hak_akses == 'RT') {
							$sql = "SELECT skbm.*, user.rt, user.rw FROM data_request_skbm skbm
											INNER JOIN data_user user ON skbm.nik = user.nik 
											WHERE (skbm.status = 0 OR (skbm.status = 1 AND skbm.ttd_rt IS NULL))
											AND user.rt = '$rt_login' 
											ORDER BY skbm.tanggal_request DESC";
						} else {
							$sql = "SELECT skbm.*, user.rt, user.rw FROM data_request_skbm skbm
											INNER JOIN data_user user ON skbm.nik = user.nik 
											WHERE skbm.status = 1 
											AND skbm.ttd_rt IS NOT NULL 
											AND skbm.ttd_rw IS NULL 
											ORDER BY skbm.tanggal_request DESC";
						}

						$query = mysqli_query($konek, $sql);

						if (mysqli_num_rows($query) == 0) {
							echo "<tr><td colspan='7' class='text-center'>Tidak ada data permohonan</td></tr>";
						}

						while ($data = mysqli_fetch_array($query, MYSQLI_BOTH)) {
							$id_request_skbm = $data['id_request_skbm'];
							$tgl = $data['tanggal_request'];
							$format = date('d F Y', strtotime($tgl));
							$nik = $data['nik'];
							$nama = $data['Nama'];
							$status = $data['status'];
							$keperluan = $data['keperluan'];
							$ttd_rt = $data['ttd_rt'];
							$ttd_rw = $data['ttd_rw'];
							$rt = $data['rt'];
							$rw = $data['rw'];

							if ($status == "ditolak") {
								$status_text = "<span class='badge badge-danger'>DITOLAK</span>";
							} elseif ($ttd_rw) {
								$status_text = "<span class='badge badge-success'>SUDAH TTD RW ✓</span>";
							} elseif ($ttd_rt) {
								$status_text = "<span class='badge badge-info'>SUDAH TTD RT ✓</span>";
							} elseif ($status == "1") {
								$status_text = "<span class='badge badge-warning'>SUDAH DIACC</span>";
							} else {
								$status_text = "<span class='badge badge-secondary'>MENUNGGU ACC</span>";
							}
						?>
							<tr>
								<td><?php echo $format; ?></td>
								<td><?php echo $nik; ?></td>
								<td><?php echo $nama; ?></td>
								<td><?php echo $keperluan; ?></td>
								<td><?php echo $status_text; ?></td>
								<td>
									<div class="form-button-action">
										<a href="?halaman=detail_skbm&id_request_skbm=<?= $id_request_skbm; ?>">
											<button type="button" data-toggle="tooltip" title="Lihat Detail" class="btn btn-link btn-info btn-lg">
												<i class="fa fa-eye"></i>
											</button>
										</a>

										<?php if ($hak_akses == 'RT'): ?>
											<?php if ($status == "0" || $status == "ditolak") { ?>
												<a href="?halaman=permohonan_surat&aksi=acc_skbm&id=<?= $id_request_skbm; ?>" onclick="return confirm('Anda yakin ingin mengACC pengajuan ini?')">
													<button type="button" data-toggle="tooltip" title="ACC Pengajuan" class="btn btn-link btn-success btn-lg"><i class="fa fa-check"></i></button>
												</a>
												<button type="button" data-toggle="tooltip" title="Tolak Pengajuan" class="btn btn-link btn-danger" onclick="openTolakModal('<?= $id_request_skbm; ?>', 'skbm')"><i class="fa fa-times"></i></button>
											<?php } ?>
											<?php if ($status == "1" && !$ttd_rt) { ?>
												<a href="?halaman=permohonan_surat&aksi=ttd_rt_skbm&id=<?= $id_request_skbm; ?>" onclick="return confirm('Anda yakin sudah menandatangani surat ini? Tanda tangan digital RSA akan dibuat.')">
													<button type="button" data-toggle="tooltip" title="TTD Digital RT" class="btn btn-link btn-warning"><i class="fa fa-pen"></i> RT</button>
												</a>
											<?php } ?>
										<?php else: ?>
											<?php if ($status == "1" && $ttd_rt && !$ttd_rw) { ?>
												<a href="?halaman=permohonan_surat&aksi=ttd_rw_skbm&id=<?= $id_request_skbm; ?>" onclick="return confirm('Anda yakin sudah menandatangani surat ini? Tanda tangan digital RSA akan dibuat.')">
													<button type="button" data-toggle="tooltip" title="TTD Digital RW" class="btn btn-link btn-primary"><i class="fa fa-pen"></i> RW</button>
												</a>
											<?php } ?>
										<?php endif; ?>
										<?php if ($status == "1" && $ttd_rw) { ?>
											<a href="cetak_skbm.php?id_request_skbm=<?= $id_request_skbm; ?>" target="_blank">
												<button type="button" data-toggle="tooltip" title="Cetak Surat" class="btn btn-link btn-primary"><i class="fa fa-print"></i></button>
											</a>
										<?php } ?>
									</div>
								</td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<div class="d-flex align-items-center">
				<h4 class="card-title">PERMOHONAN SURAT KETERANGAN KEMATIAN</h4>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table id="add6" class="display table table-striped table-hover">
					<thead>
						<tr>
							<th>Tanggal Request</th>
							<th>NIK</th>
							<th>Nama Lengkap</th>
							<th>Hubungan Pemohon</th>
							<th>Status</th>
							<th style="width: 15%">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if ($hak_akses == 'RT') {
							$sql = "SELECT skk.*, user.rt, user.rw FROM data_request_skk skk
											INNER JOIN data_user user ON skk.nik_pemohon = user.nik 
											WHERE (skk.status = 0 OR (skk.status = 1 AND skk.ttd_rt IS NULL))
											AND user.rt = '$rt_login' 
											ORDER BY skk.tanggal_request DESC";
						} else {
							$sql = "SELECT skk.*, user.rt, user.rw FROM data_request_skk skk
											INNER JOIN data_user user ON skk.nik_pemohon = user.nik 
											WHERE skk.status = 1 
											AND skk.ttd_rt IS NOT NULL 
											AND skk.ttd_rw IS NULL 
											ORDER BY skk.tanggal_request DESC";
						}

						$query = mysqli_query($konek, $sql);

						if (mysqli_num_rows($query) == 0) {
							echo "<tr><td colspan='7' class='text-center'>Tidak ada data permohonan</td></tr>";
						}

						while ($data = mysqli_fetch_array($query, MYSQLI_BOTH)) {
							$id_request_skk = $data['id_request_skk'];
							$tgl = $data['tanggal_request'];
							$format = date('d F Y', strtotime($tgl));
							$nik = $data['nik'];
							$nama = $data['Nama'];
							$status = $data['status'];
							$hubungan = $data['hubungan'];
							$ttd_rt = $data['ttd_rt'];
							$ttd_rw = $data['ttd_rw'];
							$rt = $data['rt'];
							$rw = $data['rw'];

							if ($status == "ditolak") {
								$status_text = "<span class='badge badge-danger'>DITOLAK</span>";
							} elseif ($ttd_rw) {
								$status_text = "<span class='badge badge-success'>SUDAH TTD RW ✓</span>";
							} elseif ($ttd_rt) {
								$status_text = "<span class='badge badge-info'>SUDAH TTD RT ✓</span>";
							} elseif ($status == "1") {
								$status_text = "<span class='badge badge-warning'>SUDAH DIACC</span>";
							} else {
								$status_text = "<span class='badge badge-secondary'>MENUNGGU ACC</span>";
							}
						?>
							<tr>
								<td><?php echo $format; ?></td>
								<td><?php echo $nik; ?></td>
								<td><?php echo $nama; ?></td>
								<td><?php echo $hubungan; ?></td>
								<td><?php echo $status_text; ?></td>
								<td>
									<div class="form-button-action">
										<a href="?halaman=detail_skk&id_request_skk=<?= $id_request_skk; ?>">
											<button type="button" data-toggle="tooltip" title="Lihat Detail" class="btn btn-link btn-info btn-lg">
												<i class="fa fa-eye"></i>
											</button>
										</a>

										<?php if ($hak_akses == 'RT'): ?>
											<?php if ($status == "0" || $status == "ditolak") { ?>
												<a href="?halaman=permohonan_surat&aksi=acc_skk&id=<?= $id_request_skk; ?>" onclick="return confirm('Anda yakin ingin mengACC pengajuan ini?')">
													<button type="button" data-toggle="tooltip" title="ACC Pengajuan" class="btn btn-link btn-success btn-lg"><i class="fa fa-check"></i></button>
												</a>
												<button type="button" data-toggle="tooltip" title="Tolak Pengajuan" class="btn btn-link btn-danger" onclick="openTolakModal('<?= $id_request_skk; ?>', 'skk')"><i class="fa fa-times"></i></button>
											<?php } ?>
											<?php if ($status == "1" && !$ttd_rt) { ?>
												<a href="?halaman=permohonan_surat&aksi=ttd_rt_skk&id=<?= $id_request_skk; ?>" onclick="return confirm('Anda yakin sudah menandatangani surat ini? Tanda tangan digital RSA akan dibuat.')">
													<button type="button" data-toggle="tooltip" title="TTD Digital RT" class="btn btn-link btn-warning"><i class="fa fa-pen"></i> RT</button>
												</a>
											<?php } ?>
										<?php else: ?>
											<?php if ($status == "1" && $ttd_rt && !$ttd_rw) { ?>
												<a href="?halaman=permohonan_surat&aksi=ttd_rw_skk&id=<?= $id_request_skk; ?>" onclick="return confirm('Anda yakin sudah menandatangani surat ini? Tanda tangan digital RSA akan dibuat.')">
													<button type="button" data-toggle="tooltip" title="TTD Digital RW" class="btn btn-link btn-primary"><i class="fa fa-pen"></i> RW</button>
												</a>
											<?php } ?>
										<?php endif; ?>
										<?php if ($status == "1" && $ttd_rw) { ?>
											<a href="cetak_skk.php?id_request_skk=<?= $id_request_skk; ?>" target="_blank">
												<button type="button" data-toggle="tooltip" title="Cetak Surat" class="btn btn-link btn-primary"><i class="fa fa-print"></i></button>
											</a>
										<?php } ?>
									</div>
								</td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- Modal Form Alasan Penolakan -->
<div class="modal fade" id="modalTolak" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Alasan Penolakan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" action="">
				<div class="modal-body">
					<input type="hidden" name="id_penolakan" id="id_penolakan">
					<input type="hidden" name="type_penolakan" id="type_penolakan">

					<div class="form-group">
						<label for="alasan_penolakan">Berikan alasan penolakan:</label>
						<textarea class="form-control" id="alasan_penolakan" name="alasan_penolakan" rows="4"
							placeholder="Masukkan alasan mengapa pengajuan ditolak..." required></textarea>
					</div>

					<div class="form-group">
						<label>Pilihan alasan cepat:</label>
						<div class="d-flex flex-wrap gap-2">
							<button type="button" class="btn btn-sm btn-outline-secondary" onclick="setAlasan('Data tidak lengkap')">Data tidak lengkap</button>
							<button type="button" class="btn btn-sm btn-outline-secondary" onclick="setAlasan('Data tidak sesuai')">Data tidak sesuai</button>
							<button type="button" class="btn btn-sm btn-outline-secondary" onclick="setAlasan('Berkas tidak jelas')">Berkas tidak jelas</button>
							<button type="button" class="btn btn-sm btn-outline-secondary" onclick="setAlasan('Tidak memenuhi syarat')">Tidak memenuhi syarat</button>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
					<button type="submit" name="submit_tolak" class="btn btn-danger">Tolak Pengajuan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	function setAlasan(alasan) {
		document.getElementById('alasan_penolakan').value = alasan;
	}

	function openTolakModal(id, type) {
		document.getElementById('id_penolakan').value = id;
		document.getElementById('type_penolakan').value = type;
		document.getElementById('alasan_penolakan').value = '';
		$('#modalTolak').modal('show');
	}
</script>