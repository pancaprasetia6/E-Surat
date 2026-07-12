<?php include '../konek.php'; ?>
<link href="css/sweetalert.css" rel="stylesheet" type="text/css">
<script src="js/jquery-2.1.3.min.js"></script>
<script src="js/sweetalert.min.js"></script>
<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">STATUS PENGAJUAN SURAT KETERANGAN TIDAK MAMPU</h4>
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
                                    <th>Keterangan</th>
                                    <th style="width: 10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM data_request_sktm WHERE nik=$_SESSION[nik]";
                                $query = mysqli_query($konek, $sql);

                                if (mysqli_num_rows($query) == 0) {
                                    echo "<tr><td colspan='7' class='text-center'>Tidak ada data pengajuan</td></tr>";
                                }

                                while ($data = mysqli_fetch_array($query, MYSQLI_BOTH)) {
                                    $tgl = $data['tanggal_request'];
                                    $format = date('d F Y', strtotime($tgl));
                                    $nik = $data['nik'];
                                    $nama = $data['Nama'];
                                    $status = $data['status'];
                                    $keperluan = $data['keperluan'];
                                    $keterangan = $data['keterangan'];
                                    $id_request_sktm = $data['id_request_sktm'];
                                    $ttd_rt = $data['ttd_rt'];
                                    $ttd_rw = $data['ttd_rw'];

                                    // Konversi status ke teks - DITAMBAHKAN STATUS DITOLAK
                                    if ($status == "ditolak") {
                                        $status_text = "<span class='badge badge-danger'>DITOLAK</span>";
                                    } elseif ($status == "3") {
                                        $status_text = "<span class='badge badge-success'>SELESAI DICETAK</span>";
                                    } elseif ($ttd_rw) {
                                        $status_text = "<span class='badge badge-primary'>SUDAH TTD RW</span>";
                                    } elseif ($ttd_rt) {
                                        $status_text = "<span class='badge badge-info'>SUDAH TTD RT</span>";
                                    } elseif ($status == "1") {
                                        $status_text = "<span class='badge badge-warning'>SUDAH DIACC</span>";
                                    } else {
                                        $status_text = "<span class='badge badge-warning'>MENUNGGU ACC</span>";
                                    }
                                ?>
                                    <tr>
                                        <td><?php echo $format; ?></td>
                                        <td><?php echo $nik; ?></td>
                                        <td><?php echo $nama; ?></td>
                                        <td><?php echo $keperluan; ?></td>
                                        <td class="fw-bold text-uppercase text-danger op-8"><?php echo $status_text; ?></td>
                                        <td><i>
                                                <?php
                                                // Tampilkan keterangan sesuai status
                                                if ($status == "ditolak") {
                                                    echo "<span style='color:red'>Ditolak - " . $keterangan . "</span>";
                                                } elseif ($status == "0") {
                                                    echo "Data sedang diperiksa oleh RT";
                                                } else {
                                                    echo $keterangan;
                                                }
                                                ?>
                                            </i></td>
                                        <td>
                                            <div class="form-button-action">
                                                <?php if ($status == "0" || $status == "ditolak") { ?>
                                                    <a href="?halaman=ubah_sktm&id_request_sktm=<?= $id_request_sktm; ?>">
                                                        <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Data">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                    </a>
                                                <?php } ?>

                                                <!-- Tombol Cetak (hanya untuk status yang sudah selesai) -->
                                                <?php if ($status == "1" || $ttd_rw || $status == "3") { ?>
                                                    <a href="cetak_sktm.php?id_request_sktm=<?= $id_request_sktm; ?>" target="_blank">
                                                        <button type="button" data-toggle="tooltip" title="Cetak Surat" class="btn btn-link btn-primary">
                                                            <i class="fa fa-print"></i>
                                                        </button>
                                                    </a>
                                                <?php } ?>

                                                <?php if ($status == "0") { ?>
                                                    <a href="?halaman=tampil_status&id_request_sktm=<?= $id_request_sktm; ?>">
                                                        <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">
                                                            <i class="fa fa-times"></i>
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
                        <h4 class="card-title">STATUS PENGAJUAN SURAT KETERANGAN USAHA</h4>
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
                                    <th>Keterangan</th>
                                    <th style="width: 10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM data_request_sku WHERE nik=$_SESSION[nik]";
                                $query = mysqli_query($konek, $sql);

                                if (mysqli_num_rows($query) == 0) {
                                    echo "<tr><td colspan='7' class='text-center'>Tidak ada data pengajuan</td></tr>";
                                }

                                while ($data = mysqli_fetch_array($query, MYSQLI_BOTH)) {
                                    $tgl = $data['tanggal_request'];
                                    $format = date('d F Y', strtotime($tgl));
                                    $nik = $data['nik'];
                                    $nama = $data['Nama'];
                                    $status = $data['status'];
                                    $Nama_usaha = $data['Nama_usaha'];
                                    $keterangan = $data['keterangan'];
                                    $id_request_sku = $data['id_request_sku'];
                                    $ttd_rt = $data['ttd_rt'];
                                    $ttd_rw = $data['ttd_rw'];

                                    // Konversi status ke teks - DITAMBAHKAN STATUS DITOLAK
                                    if ($status == "ditolak") {
                                        $status_text = "<span class='badge badge-danger'>DITOLAK</span>";
                                    } elseif ($status == "3") {
                                        $status_text = "<span class='badge badge-success'>SELESAI DICETAK</span>";
                                    } elseif ($ttd_rw) {
                                        $status_text = "<span class='badge badge-primary'>SUDAH TTD RW</span>";
                                    } elseif ($ttd_rt) {
                                        $status_text = "<span class='badge badge-info'>SUDAH TTD RT</span>";
                                    } elseif ($status == "1") {
                                        $status_text = "<span class='badge badge-warning'>SUDAH DIACC</span>";
                                    } else {
                                        $status_text = "<span class='badge badge-warning'>MENUNGGU ACC</span>";
                                    }
                                ?>
                                    <tr>
                                        <td><?php echo $format; ?></td>
                                        <td><?php echo $nik; ?></td>
                                        <td><?php echo $nama; ?></td>
                                        <td><?php echo $Nama_usaha; ?></td>
                                        <td class="fw-bold text-uppercase text-danger op-8"><?php echo $status_text; ?></td>
                                        <td><i>
                                                <?php
                                                // Tampilkan keterangan sesuai status
                                                if ($status == "ditolak") {
                                                    echo "<span style='color:red'>Ditolak - " . $keterangan . "</span>";
                                                } elseif ($status == "0") {
                                                    echo "Data sedang diperiksa oleh RT";
                                                } else {
                                                    echo $keterangan;
                                                }
                                                ?>
                                            </i></td>
                                        <td>
                                            <div class="form-button-action">
                                                <?php if ($status == "0" || $status == "ditolak") { ?>
                                                    <a href="?halaman=ubah_sku&id_request_sku=<?= $id_request_sku; ?>">
                                                        <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Data">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                    </a>
                                                <?php } ?>

                                                <!-- Tombol Cetak (hanya untuk status yang sudah selesai) -->
                                                <?php if ($status == "1" || $ttd_rw || $status == "3") { ?>
                                                    <a href="cetak_sku.php?id_request_sku=<?= $id_request_sku; ?>" target="_blank">
                                                        <button type="button" data-toggle="tooltip" title="Cetak Surat" class="btn btn-link btn-primary">
                                                            <i class="fa fa-print"></i>
                                                        </button>
                                                    </a>
                                                <?php } ?>

                                                <?php if ($status == "0") { ?>
                                                    <a href="?halaman=tampil_status&id_request_sku=<?= $id_request_sku; ?>">
                                                        <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">
                                                            <i class="fa fa-times"></i>
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
                        <h4 class="card-title">STATUS PENGAJUAN SURAT KETERANGAN DOMISILI</h4>
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
                                    <th>Keterangan</th>
                                    <th style="width: 10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM data_request_skd WHERE nik=$_SESSION[nik]";
                                $query = mysqli_query($konek, $sql);

                                if (mysqli_num_rows($query) == 0) {
                                    echo "<tr><td colspan='7' class='text-center'>Tidak ada data pengajuan</td></tr>";
                                }

                                while ($data = mysqli_fetch_array($query, MYSQLI_BOTH)) {
                                    $tgl = $data['tanggal_request'];
                                    $format = date('d F Y', strtotime($tgl));
                                    $nik = $data['nik'];
                                    $nama = $data['Nama'];
                                    $status = $data['status'];
                                    $keperluan = $data['keperluan'];
                                    $keterangan = $data['keterangan'];
                                    $id_request_skd = $data['id_request_skd'];
                                    $ttd_rt = $data['ttd_rt'];
                                    $ttd_rw = $data['ttd_rw'];

                                    // Konversi status ke teks - DITAMBAHKAN STATUS DITOLAK
                                    if ($status == "ditolak") {
                                        $status_text = "<span class='badge badge-danger'>DITOLAK</span>";
                                    } elseif ($status == "3") {
                                        $status_text = "<span class='badge badge-success'>SELESAI DICETAK</span>";
                                    } elseif ($ttd_rw) {
                                        $status_text = "<span class='badge badge-primary'>SUDAH TTD RW</span>";
                                    } elseif ($ttd_rt) {
                                        $status_text = "<span class='badge badge-info'>SUDAH TTD RT</span>";
                                    } elseif ($status == "1") {
                                        $status_text = "<span class='badge badge-warning'>SUDAH DIACC</span>";
                                    } else {
                                        $status_text = "<span class='badge badge-warning'>MENUNGGU ACC</span>";
                                    }
                                ?>
                                    <tr>
                                        <td><?php echo $format; ?></td>
                                        <td><?php echo $nik; ?></td>
                                        <td><?php echo $nama; ?></td>
                                        <td><?php echo $keperluan; ?></td>
                                        <td class="fw-bold text-uppercase text-danger op-8"><?php echo $status_text; ?></td>
                                        <td><i>
                                                <?php
                                                // Tampilkan keterangan sesuai status
                                                if ($status == "ditolak") {
                                                    echo "<span style='color:red'>Ditolak - " . $keterangan . "</span>";
                                                } elseif ($status == "0") {
                                                    echo "Data sedang diperiksa oleh RT";
                                                } else {
                                                    echo $keterangan;
                                                }
                                                ?>
                                            </i></td>
                                        <td>
                                            <div class="form-button-action">
                                                <?php if ($status == "0" || $status == "ditolak") { ?>
                                                    <a href="?halaman=ubah_skd&id_request_skd=<?= $id_request_skd; ?>">
                                                        <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Data">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                    </a>
                                                <?php } ?>

                                                <!-- Tombol Cetak (hanya untuk status yang sudah selesai) -->
                                                <?php if ($status == "1" || $ttd_rw || $status == "3") { ?>
                                                    <a href="cetak_skd.php?id_request_skd=<?= $id_request_skd; ?>" target="_blank">
                                                        <button type="button" data-toggle="tooltip" title="Cetak Surat" class="btn btn-link btn-primary">
                                                            <i class="fa fa-print"></i>
                                                        </button>
                                                    </a>
                                                <?php } ?>

                                                <?php if ($status == "0") { ?>
                                                    <a href="?halaman=tampil_status&id_request_skd=<?= $id_request_skd; ?>">
                                                        <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">
                                                            <i class="fa fa-times"></i>
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
                        <h4 class="card-title">STATUS PENGAJUAN SURAT PENGANTAR SKCK</h4>
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
                                    <th>Keterangan</th>
                                    <th style="width: 10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM data_request_skck WHERE nik=$_SESSION[nik]";
                                $query = mysqli_query($konek, $sql);

                                if (mysqli_num_rows($query) == 0) {
                                    echo "<tr><td colspan='7' class='text-center'>Tidak ada data pengajuan</td></tr>";
                                }

                                while ($data = mysqli_fetch_array($query, MYSQLI_BOTH)) {
                                    $tgl = $data['tanggal_request'];
                                    $format = date('d F Y', strtotime($tgl));
                                    $nik = $data['nik'];
                                    $nama = $data['Nama'];
                                    $status = $data['status'];
                                    $keperluan = $data['keperluan'];
                                    $keterangan = $data['keterangan'];
                                    $id_request_skck = $data['id_request_skck'];
                                    $ttd_rt = $data['ttd_rt'];
                                    $ttd_rw = $data['ttd_rw'];

                                    // Konversi status ke teks - DITAMBAHKAN STATUS DITOLAK
                                    if ($status == "ditolak") {
                                        $status_text = "<span class='badge badge-danger'>DITOLAK</span>";
                                    } elseif ($status == "3") {
                                        $status_text = "<span class='badge badge-success'>SELESAI DICETAK</span>";
                                    } elseif ($ttd_rw) {
                                        $status_text = "<span class='badge badge-primary'>SUDAH TTD RW</span>";
                                    } elseif ($ttd_rt) {
                                        $status_text = "<span class='badge badge-info'>SUDAH TTD RT</span>";
                                    } elseif ($status == "1") {
                                        $status_text = "<span class='badge badge-warning'>SUDAH DIACC</span>";
                                    } else {
                                        $status_text = "<span class='badge badge-warning'>MENUNGGU ACC</span>";
                                    }
                                ?>
                                    <tr>
                                        <td><?php echo $format; ?></td>
                                        <td><?php echo $nik; ?></td>
                                        <td><?php echo $nama; ?></td>
                                        <td><?php echo $keperluan; ?></td>
                                        <td class="fw-bold text-uppercase text-danger op-8"><?php echo $status_text; ?></td>
                                        <td><i>
                                                <?php
                                                // Tampilkan keterangan sesuai status
                                                if ($status == "ditolak") {
                                                    echo "<span style='color:red'>Ditolak - " . $keterangan . "</span>";
                                                } elseif ($status == "0") {
                                                    echo "Data sedang diperiksa oleh RT";
                                                } else {
                                                    echo $keterangan;
                                                }
                                                ?>
                                            </i></td>
                                        <td>
                                            <div class="form-button-action">
                                                <?php if ($status == "0" || $status == "ditolak") { ?>
                                                    <a href="?halaman=ubah_skck&id_request_skck=<?= $id_request_skck; ?>">
                                                        <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Data">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                    </a>
                                                <?php } ?>

                                                <!-- Tombol Cetak (hanya untuk status yang sudah selesai) -->
                                                <?php if ($status == "1" || $ttd_rw || $status == "3") { ?>
                                                    <a href="cetak_skck.php?id_request_skck=<?= $id_request_skck; ?>" target="_blank">
                                                        <button type="button" data-toggle="tooltip" title="Cetak Surat" class="btn btn-link btn-primary">
                                                            <i class="fa fa-print"></i>
                                                        </button>
                                                    </a>
                                                <?php } ?>

                                                <?php if ($status == "0") { ?>
                                                    <a href="?halaman=tampil_status&id_request_skck=<?= $id_request_skck; ?>">
                                                        <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">
                                                            <i class="fa fa-times"></i>
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
                        <h4 class="card-title">STATUS PENGAJUAN SURAT KETERANGAN BELUM MENIKAH</h4>
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
                                    <th>Keterangan</th>
                                    <th style="width: 10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM data_request_skbm WHERE nik=$_SESSION[nik]";
                                $query = mysqli_query($konek, $sql);

                                if (mysqli_num_rows($query) == 0) {
                                    echo "<tr><td colspan='7' class='text-center'>Tidak ada data pengajuan</td></tr>";
                                }

                                while ($data = mysqli_fetch_array($query, MYSQLI_BOTH)) {
                                    $tgl = $data['tanggal_request'];
                                    $format = date('d F Y', strtotime($tgl));
                                    $nik = $data['nik'];
                                    $nama = $data['Nama'];
                                    $status = $data['status'];
                                    $keperluan = $data['keperluan'];
                                    $keterangan = $data['keterangan'];
                                    $id_request_skbm = $data['id_request_skbm'];
                                    $ttd_rt = $data['ttd_rt'];
                                    $ttd_rw = $data['ttd_rw'];

                                    // Konversi status ke teks - DITAMBAHKAN STATUS DITOLAK
                                    if ($status == "ditolak") {
                                        $status_text = "<span class='badge badge-danger'>DITOLAK</span>";
                                    } elseif ($status == "3") {
                                        $status_text = "<span class='badge badge-success'>SELESAI DICETAK</span>";
                                    } elseif ($ttd_rw) {
                                        $status_text = "<span class='badge badge-primary'>SUDAH TTD RW</span>";
                                    } elseif ($ttd_rt) {
                                        $status_text = "<span class='badge badge-info'>SUDAH TTD RT</span>";
                                    } elseif ($status == "1") {
                                        $status_text = "<span class='badge badge-warning'>SUDAH DIACC</span>";
                                    } else {
                                        $status_text = "<span class='badge badge-warning'>MENUNGGU ACC</span>";
                                    }
                                ?>
                                    <tr>
                                        <td><?php echo $format; ?></td>
                                        <td><?php echo $nik; ?></td>
                                        <td><?php echo $nama; ?></td>
                                        <td><?php echo $keperluan; ?></td>
                                        <td class="fw-bold text-uppercase text-danger op-8"><?php echo $status_text; ?></td>
                                        <td><i>
                                                <?php
                                                // Tampilkan keterangan sesuai status
                                                if ($status == "ditolak") {
                                                    echo "<span style='color:red'>Ditolak - " . $keterangan . "</span>";
                                                } elseif ($status == "0") {
                                                    echo "Data sedang diperiksa oleh RT";
                                                } else {
                                                    echo $keterangan;
                                                }
                                                ?>
                                            </i></td>
                                        <td>
                                            <div class="form-button-action">
                                                <?php if ($status == "0" || $status == "ditolak") { ?>
                                                    <a href="?halaman=ubah_skbm&id_request_skbm=<?= $id_request_skbm; ?>">
                                                        <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Data">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                    </a>
                                                <?php } ?>

                                                <!-- Tombol Cetak (hanya untuk status yang sudah selesai) -->
                                                <?php if ($status == "1" || $ttd_rw || $status == "3") { ?>
                                                    <a href="cetak_skbm.php?id_request_skbm=<?= $id_request_skbm; ?>" target="_blank">
                                                        <button type="button" data-toggle="tooltip" title="Cetak Surat" class="btn btn-link btn-primary">
                                                            <i class="fa fa-print"></i>
                                                        </button>
                                                    </a>
                                                <?php } ?>

                                                <?php if ($status == "0") { ?>
                                                    <a href="?halaman=tampil_status&id_request_skbm=<?= $id_request_skbm; ?>">
                                                        <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">
                                                            <i class="fa fa-times"></i>
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
                        <h4 class="card-title">STATUS PENGAJUAN SURAT KETERANGAN KEMATIAN</h4>
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
                                    <th>Hubungan</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th style="width: 10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM data_request_skk WHERE nik_pemohon=$_SESSION[nik]";
                                $query = mysqli_query($konek, $sql);
                                
                                if (mysqli_num_rows($query) == 0) {
                                    echo "<tr><td colspan='7' class='text-center'>Tidak ada data pengajuan</td></tr>";
                                }

                                while ($data = mysqli_fetch_array($query, MYSQLI_BOTH)) {
                                    $tgl = $data['tanggal_request'];
                                    $format = date('d F Y', strtotime($tgl));
                                    $nik = $data['nik'];
                                    $nama = $data['Nama'];
                                    $status = $data['status'];
                                    $hubungan = $data['hubungan'];
                                    $keterangan = $data['keterangan'];
                                    $id_request_skk = $data['id_request_skk'];
                                    $ttd_rt = $data['ttd_rt'];
                                    $ttd_rw = $data['ttd_rw'];

                                    // Konversi status ke teks - DITAMBAHKAN STATUS DITOLAK
                                    if ($status == "ditolak") {
                                        $status_text = "<span class='badge badge-danger'>DITOLAK</span>";
                                    } elseif ($status == "3") {
                                        $status_text = "<span class='badge badge-success'>SELESAI DICETAK</span>";
                                    } elseif ($ttd_rw) {
                                        $status_text = "<span class='badge badge-primary'>SUDAH TTD RW</span>";
                                    } elseif ($ttd_rt) {
                                        $status_text = "<span class='badge badge-info'>SUDAH TTD RT</span>";
                                    } elseif ($status == "1") {
                                        $status_text = "<span class='badge badge-warning'>SUDAH DIACC</span>";
                                    } else {
                                        $status_text = "<span class='badge badge-warning'>MENUNGGU ACC</span>";
                                    }
                                ?>
                                    <tr>
                                        <td><?php echo $format; ?></td>
                                        <td><?php echo $nik; ?></td>
                                        <td><?php echo $nama; ?></td>
                                        <td><?php echo $hubungan; ?></td>
                                        <td class="fw-bold text-uppercase text-danger op-8"><?php echo $status_text; ?></td>
                                        <td><i>
                                                <?php
                                                // Tampilkan keterangan sesuai status
                                                if ($status == "ditolak") {
                                                    echo "<span style='color:red'>Ditolak - " . $keterangan . "</span>";
                                                } elseif ($status == "0") {
                                                    echo "Data sedang diperiksa oleh RT";
                                                } else {
                                                    echo $keterangan;
                                                }
                                                ?>
                                            </i></td>
                                        <td>
                                            <div class="form-button-action">
                                                <?php if ($status == "0" || $status == "ditolak") { ?>
                                                    <a href="?halaman=ubah_skk&id_request_skk=<?= $id_request_skk; ?>">
                                                        <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Data">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                    </a>
                                                <?php } ?>

                                                <!-- Tombol Cetak (hanya untuk status yang sudah selesai) -->
                                                <?php if ($status == "1" || $ttd_rw || $status == "3") { ?>
                                                    <a href="cetak_skk.php?id_request_skk=<?= $id_request_skk; ?>" target="_blank">
                                                        <button type="button" data-toggle="tooltip" title="Cetak Surat" class="btn btn-link btn-primary">
                                                            <i class="fa fa-print"></i>
                                                        </button>
                                                    </a>
                                                <?php } ?>

                                                <?php if ($status == "0") { ?>
                                                    <a href="?halaman=tampil_status&id_request_skk=<?= $id_request_skk; ?>">
                                                        <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">
                                                            <i class="fa fa-times"></i>
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
<?php
if (isset($_GET['id_request_skd'])) {
    $id_request_skd = $_GET['id_request_skd'];
    $hapus = mysqli_query($konek, "DELETE FROM data_request_skd WHERE id_request_skd=$id_request_skd");
    if ($hapus) {
        echo "<script language='javascript'>swal('Selamat...', 'Hapus Berhasil', 'success');</script>";
        echo '<meta http-equiv="refresh" content="3; url=?halaman=tampil_status">';
    } else {
        echo "<script language='javascript'>swal('Gagal...', 'Hapus Gagal', 'error');</script>";
        echo '<meta http-equiv="refresh" content="3; url=?halaman=tampil_status">';
    }
} elseif (isset($_GET['id_request_sktm'])) {
    $id_request_sktm = $_GET['id_request_sktm'];
    $hapus = mysqli_query($konek, "DELETE FROM data_request_sktm WHERE id_request_sktm=$id_request_sktm");
    if ($hapus) {
        echo "<script language='javascript'>swal('Selamat...', 'Hapus Berhasil', 'success');</script>";
        echo '<meta http-equiv="refresh" content="3; url=?halaman=tampil_status">';
    } else {
        echo "<script language='javascript'>swal('Gagal...', 'Hapus Gagal', 'error');</script>";
        echo '<meta http-equiv="refresh" content="3; url=?halaman=tampil_status">';
    }
} elseif (isset($_GET['id_request_skck'])) {
    $id_request_skck = $_GET['id_request_skck'];
    $hapus = mysqli_query($konek, "DELETE FROM data_request_skck WHERE id_request_skck=$id_request_skck");
    if ($hapus) {
        echo "<script language='javascript'>swal('Selamat...', 'Hapus Berhasil', 'success');</script>";
        echo '<meta http-equiv="refresh" content="3; url=?halaman=tampil_status">';
    } else {
        echo "<script language='javascript'>swal('Gagal...', 'Hapus Gagal', 'error');</script>";
        echo '<meta http-equiv="refresh" content="3; url=?halaman=tampil_status">';
    }
} elseif (isset($_GET['id_request_sku'])) {
    $id_request_sku = $_GET['id_request_sku'];
    $hapus = mysqli_query($konek, "DELETE FROM data_request_sku WHERE id_request_sku=$id_request_sku");
    if ($hapus) {
        echo "<script language='javascript'>swal('Selamat...', 'Hapus Berhasil', 'success');</script>";
        echo '<meta http-equiv="refresh" content="3; url=?halaman=tampil_status">';
    } else {
        echo "<script language='javascript'>swal('Gagal...', 'Hapus Gagal', 'error');</script>";
        echo '<meta http-equiv="refresh" content="3; url=?halaman=tampil_status">';
    }
} elseif (isset($_GET['id_request_skbm'])) {
    $id_request_skbm = $_GET['id_request_skbm'];
    $hapus = mysqli_query($konek, "DELETE FROM data_request_skbm WHERE id_request_skbm=$id_request_skbm");
    if ($hapus) {
        echo "<script language='javascript'>swal('Selamat...', 'Hapus Berhasil', 'success');</script>";
        echo '<meta http-equiv="refresh" content="3; url=?halaman=tampil_status">';
    } else {
        echo "<script language='javascript'>swal('Gagal...', 'Hapus Gagal', 'error');</script>";
        echo '<meta http-equiv="refresh" content="3; url=?halaman=tampil_status">';
    }
} elseif (isset($_GET['id_request_skk'])) {
    $id_request_skk = $_GET['id_request_skk'];
    $hapus = mysqli_query($konek, "DELETE FROM data_request_skk WHERE id_request_skk=$id_request_skk");
    if ($hapus) {
        echo "<script language='javascript'>swal('Selamat...', 'Hapus Berhasil', 'success');</script>";
        echo '<meta http-equiv="refresh" content="3; url=?halaman=tampil_status">';
    } else {
        echo "<script language='javascript'>swal('Gagal...', 'Hapus Gagal', 'error');</script>";
        echo '<meta http-equiv="refresh" content="3; url=?halaman=tampil_status">';
    }
}
?>