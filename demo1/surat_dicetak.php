<?php include '../konek.php'; ?>
<link href="css/sweetalert.css" rel="stylesheet" type="text/css">
<script src="js/jquery-2.1.3.min.js"></script>
<script src="js/sweetalert.min.js"></script>

<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title">ARSIP SURAT</h4>
                        <div class="text-right">
                            <small class="text-muted">
                                <i class="fa fa-user-shield"></i>
                                Login sebagai: <strong><?= strtoupper($hak_akses) ?></strong>
                                <?php if ($hak_akses == 'RT'): ?>
                                    - RT <?= $rt_login ?>
                                <?php elseif ($hak_akses == 'RW'): ?>
                                    - RW <?= $rt_login ?>
                                <?php endif; ?>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="add1" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Request</th>
                                    <th>Jenis Surat</th>
                                    <th>NIK</th>
                                    <th>Nama Lengkap</th>
                                    <th>TTD RT</th>
                                    <th>TTD RW</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $total_data = 0;

                                // Query untuk SKTM - hanya yang sudah di ACC (status 1,2,3 atau sudah TTD)
                                if ($hak_akses == 'RT') {
                                    // RT hanya bisa lihat data dari RT-nya sendiri yang sudah di ACC
                                    $sql1 = "SELECT sktm.*, user.rt, user.rw 
                                            FROM data_request_sktm sktm 
                                            INNER JOIN data_user user ON sktm.nik = user.nik 
                                            WHERE sktm.status IN (1,2,3) 
                                            AND user.rt = '$rt_login'";
                                } else {
                                    // RW bisa lihat semua data yang sudah di ACC
                                    $sql1 = "SELECT sktm.*, user.rt, user.rw 
                                            FROM data_request_sktm sktm 
                                            INNER JOIN data_user user ON sktm.nik = user.nik 
                                            WHERE sktm.status IN (1,2,3)";
                                }

                                $query1 = mysqli_query($konek, $sql1);

                                if ($query1) {
                                    while ($data = mysqli_fetch_array($query1, MYSQLI_BOTH)) {
                                        $total_data++;
                                        $id_request_sktm = $data['id_request_sktm'];
                                        $tgl = $data['tanggal_request'];
                                        $format = date('d F Y', strtotime($tgl));
                                        $nik = $data['nik'];
                                        $nama = $data['Nama'];
                                        $ttd_rt = $data['ttd_rt'];
                                        $ttd_rw = $data['ttd_rw'];
                                        $rt = $data['rt'];
                                        $rw = $data['rw'];

                                        // Format tanggal TTD
                                        $format_ttd_rt = $ttd_rt ? date('d/m/Y H:i', strtotime($ttd_rt)) : '-';
                                        $format_ttd_rw = $ttd_rw ? date('d/m/Y H:i', strtotime($ttd_rw)) : '-';


                                ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $format; ?></td>
                                            <td><span class="badge badge-primary">SKTM</span></td>
                                            <td><?= $nik; ?></td>
                                            <td><?= $nama; ?></td>
                                            <td class="text-center">
                                                <?php if ($ttd_rt): ?>
                                                    <span class="badge badge-success" data-toggle="tooltip" title="<?= date('d F Y H:i:s', strtotime($ttd_rt)) ?>">
                                                        <i class="fa fa-check"></i> <?= $format_ttd_rt ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">BELUM</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($ttd_rw): ?>
                                                    <span class="badge badge-success" data-toggle="tooltip" title="<?= date('d F Y H:i:s', strtotime($ttd_rw)) ?>">
                                                        <i class="fa fa-check"></i> <?= $format_ttd_rw ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">BELUM</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="form-button-action">
                                                    <!-- Tombol View Detail -->
                                                    <a href="?halaman=detail_sktm&id_request_sktm=<?= $id_request_sktm; ?>">
                                                        <button type="button" data-toggle="tooltip" title="Lihat Detail" class="btn btn-link btn-info btn-lg">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </a>
                                                    
                                                    <!-- Tombol Cetak -->
                                                     <a href="cetak_sktm.php?id_request_sktm=<?= $id_request_sktm; ?>" target="_blank">
                                                        <button type="button" data-toggle="tooltip" title="Cetak Surat" class="btn btn-link btn-primary">
                                                            <i class="fa fa-print"></i>
                                                        </button>
                                                    </a>
                                                    <!-- Tombol Hapus -->
                                                    <a href="?halaman=surat_dicetak&id_request_sktm=<?= $id_request_sktm; ?>"
                                                        onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                        <button type="button" data-toggle="tooltip" title="Hapus" class="btn btn-link btn-danger">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </a>

                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                }

                                // Query untuk SKU - hanya yang sudah di ACC
                                if ($hak_akses == 'RT') {
                                    $sql2 = "SELECT sku.*, user.rt, user.rw 
                                            FROM data_request_sku sku 
                                            INNER JOIN data_user user ON sku.nik = user.nik 
                                            WHERE sku.status IN (1,2,3)
                                            AND user.rt = '$rt_login'";
                                } else {
                                    $sql2 = "SELECT sku.*, user.rt, user.rw 
                                            FROM data_request_sku sku 
                                            INNER JOIN data_user user ON sku.nik = user.nik 
                                            WHERE sku.status IN (1,2,3)";
                                }

                                $query2 = mysqli_query($konek, $sql2);

                                if ($query2) {
                                    while ($data = mysqli_fetch_array($query2, MYSQLI_BOTH)) {
                                        $total_data++;
                                        $id_request_sku = $data['id_request_sku'];
                                        $tgl = $data['tanggal_request'];
                                        $format = date('d F Y', strtotime($tgl));
                                        $nik = $data['nik'];
                                        $nama = $data['Nama'];
                                        $ttd_rt = $data['ttd_rt'];
                                        $ttd_rw = $data['ttd_rw'];
                                        $rt = $data['rt'];
                                        $rw = $data['rw'];

                                        // Format tanggal TTD
                                        $format_ttd_rt = $ttd_rt ? date('d/m/Y H:i', strtotime($ttd_rt)) : '-';
                                        $format_ttd_rw = $ttd_rw ? date('d/m/Y H:i', strtotime($ttd_rw)) : '-';

                                        
                                    ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $format; ?></td>
                                            <td><span class="badge badge-success">SKU</span></td>
                                            <td><?= $nik; ?></td>
                                            <td><?= $nama; ?></td>
                                            <td class="text-center">
                                                <?php if ($ttd_rt): ?>
                                                    <span class="badge badge-success" data-toggle="tooltip" title="<?= date('d F Y H:i:s', strtotime($ttd_rt)) ?>">
                                                        <i class="fa fa-check"></i> <?= $format_ttd_rt ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">BELUM</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($ttd_rw): ?>
                                                    <span class="badge badge-success" data-toggle="tooltip" title="<?= date('d F Y H:i:s', strtotime($ttd_rw)) ?>">
                                                        <i class="fa fa-check"></i> <?= $format_ttd_rw ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">BELUM</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="form-button-action">
                                                    <!-- Tombol View Detail -->
                                                    <a href="?halaman=detail_sku&id_request_sku=<?= $id_request_sku; ?>">
                                                        <button type="button" data-toggle="tooltip" title="Lihat Detail" class="btn btn-link btn-info btn-lg">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </a>
                                                    <!-- Tombol Cetak -->
                                                     <a href="cetak_sku.php?id_request_sku=<?= $id_request_sku; ?>" target="_blank">
                                                        <button type="button" data-toggle="tooltip" title="Cetak Surat" class="btn btn-link btn-primary">
                                                            <i class="fa fa-print"></i>
                                                        </button>
                                                    </a>
                                                    <!-- Tombol Hapus -->
                                                    <a href="?halaman=surat_dicetak&id_request_sku=<?= $id_request_sku; ?>"
                                                        onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                        <button type="button" data-toggle="tooltip" title="Hapus" class="btn btn-link btn-danger">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </a>


                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                }

                                // Query untuk SKD - hanya yang sudah di ACC
                                if ($hak_akses == 'RT') {
                                    $sql3 = "SELECT skd.*, user.rt, user.rw 
                                            FROM data_request_skd skd 
                                            INNER JOIN data_user user ON skd.nik = user.nik 
                                            WHERE skd.status IN (1,2,3)
                                            AND user.rt = '$rt_login'";
                                } else {
                                    $sql3 = "SELECT skd.*, user.rt, user.rw 
                                            FROM data_request_skd skd 
                                            INNER JOIN data_user user ON skd.nik = user.nik 
                                            WHERE skd.status IN (1,2,3)";
                                }

                                $query3 = mysqli_query($konek, $sql3);

                                if ($query3) {
                                    while ($data = mysqli_fetch_array($query3, MYSQLI_BOTH)) {
                                        $total_data++;
                                        $id_request_skd = $data['id_request_skd'];
                                        $tgl = $data['tanggal_request'];
                                        $format = date('d F Y', strtotime($tgl));
                                        $nik = $data['nik'];
                                        $nama = $data['Nama'];
                                        $ttd_rt = $data['ttd_rt'];
                                        $ttd_rw = $data['ttd_rw'];
                                        $rt = $data['rt'];
                                        $rw = $data['rw'];

                                        // Format tanggal TTD
                                        $format_ttd_rt = $ttd_rt ? date('d/m/Y H:i', strtotime($ttd_rt)) : '-';
                                        $format_ttd_rw = $ttd_rw ? date('d/m/Y H:i', strtotime($ttd_rw)) : '-';

                                        
                                    ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $format; ?></td>
                                            <td><span class="badge badge-secondary">SKD</span></td>
                                            <td><?= $nik; ?></td>
                                            <td><?= $nama; ?></td>
                                            <td class="text-center">
                                                <?php if ($ttd_rt): ?>
                                                    <span class="badge badge-success" data-toggle="tooltip" title="<?= date('d F Y H:i:s', strtotime($ttd_rt)) ?>">
                                                        <i class="fa fa-check"></i> <?= $format_ttd_rt ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">BELUM</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($ttd_rw): ?>
                                                    <span class="badge badge-success" data-toggle="tooltip" title="<?= date('d F Y H:i:s', strtotime($ttd_rw)) ?>">
                                                        <i class="fa fa-check"></i> <?= $format_ttd_rw ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">BELUM</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="form-button-action">
                                                    <!-- Tombol View Detail -->
                                                    <a href="?halaman=detail_skd&id_request_skd=<?= $id_request_skd; ?>">
                                                        <button type="button" data-toggle="tooltip" title="Lihat Detail" class="btn btn-link btn-info btn-lg">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </a>
                                                    <!-- Tombol Cetak -->
                                                     <a href="cetak_skd.php?id_request_skd=<?= $id_request_skd; ?>" target="_blank">
                                                        <button type="button" data-toggle="tooltip" title="Cetak Surat" class="btn btn-link btn-primary">
                                                            <i class="fa fa-print"></i>
                                                        </button>
                                                    </a>
                                                    <!-- Tombol Hapus -->
                                                    <a href="?halaman=surat_dicetak&id_request_skd=<?= $id_request_skd; ?>"
                                                        onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                        <button type="button" data-toggle="tooltip" title="Hapus" class="btn btn-link btn-danger">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                }

                                // Query untuk SKCK - hanya yang sudah di ACC
                                if ($hak_akses == 'RT') {
                                    $sql4 = "SELECT skck.*, user.rt, user.rw 
                                            FROM data_request_skck skck 
                                            INNER JOIN data_user user ON skck.nik = user.nik 
                                            WHERE skck.status IN (1,2,3)
                                            AND user.rt = '$rt_login'";
                                } else {
                                    $sql4 = "SELECT skck.*, user.rt, user.rw 
                                            FROM data_request_skck skck 
                                            INNER JOIN data_user user ON skck.nik = user.nik 
                                            WHERE skck.status IN (1,2,3)";
                                }

                                $query4 = mysqli_query($konek, $sql4);

                                if ($query4) {
                                    while ($data = mysqli_fetch_array($query4, MYSQLI_BOTH)) {
                                        $total_data++;
                                        $id_request_skck = $data['id_request_skck'];
                                        $tgl = $data['tanggal_request'];
                                        $format = date('d F Y', strtotime($tgl));
                                        $nik = $data['nik'];
                                        $nama = $data['Nama'];
                                        $ttd_rt = $data['ttd_rt'];
                                        $ttd_rw = $data['ttd_rw'];
                                        $rt = $data['rt'];
                                        $rw = $data['rw'];

                                        // Format tanggal TTD
                                        $format_ttd_rt = $ttd_rt ? date('d/m/Y H:i', strtotime($ttd_rt)) : '-';
                                        $format_ttd_rw = $ttd_rw ? date('d/m/Y H:i', strtotime($ttd_rw)) : '-';

                                       
                                    ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $format; ?></td>
                                            <td><span class="badge badge-info">SKCK</span></td>
                                            <td><?= $nik; ?></td>
                                            <td><?= $nama; ?></td>
                                            <td class="text-center">
                                                <?php if ($ttd_rt): ?>
                                                    <span class="badge badge-success" data-toggle="tooltip" title="<?= date('d F Y H:i:s', strtotime($ttd_rt)) ?>">
                                                        <i class="fa fa-check"></i> <?= $format_ttd_rt ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">BELUM</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($ttd_rw): ?>
                                                    <span class="badge badge-success" data-toggle="tooltip" title="<?= date('d F Y H:i:s', strtotime($ttd_rw)) ?>">
                                                        <i class="fa fa-check"></i> <?= $format_ttd_rw ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">BELUM</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="form-button-action">
                                                    <!-- Tombol View Detail -->
                                                    <a href="?halaman=detail_skck&id_request_skck=<?= $id_request_skck; ?>">
                                                        <button type="button" data-toggle="tooltip" title="Lihat Detail" class="btn btn-link btn-info btn-lg">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </a>
                                                    <!-- Tombol Cetak -->
                                                     <a href="cetak_skck.php?id_request_skck=<?= $id_request_skck; ?>" target="_blank">
                                                        <button type="button" data-toggle="tooltip" title="Cetak Surat" class="btn btn-link btn-primary">
                                                            <i class="fa fa-print"></i>
                                                        </button>
                                                    </a>
                                                    <!-- Tombol Hapus -->
                                                    <a href="?halaman=surat_dicetak&id_request_skck=<?= $id_request_skck; ?>"
                                                        onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                        <button type="button" data-toggle="tooltip" title="Hapus" class="btn btn-link btn-danger">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                }

                                // Query untuk SKBM - hanya yang sudah di ACC
                                if ($hak_akses == 'RT') {
                                    $sql5 = "SELECT skbm.*, user.rt, user.rw 
                                            FROM data_request_skbm skbm 
                                            INNER JOIN data_user user ON skbm.nik = user.nik 
                                            WHERE skbm.status IN (1,2,3)
                                            AND user.rt = '$rt_login'";
                                } else {
                                    $sql5 = "SELECT skbm.*, user.rt, user.rw 
                                            FROM data_request_skbm skbm 
                                            INNER JOIN data_user user ON skbm.nik = user.nik 
                                            WHERE skbm.status IN (1,2,3)";
                                }

                                $query5 = mysqli_query($konek, $sql5);

                                if ($query5) {
                                    while ($data = mysqli_fetch_array($query5, MYSQLI_BOTH)) {
                                        $total_data++;
                                        $id_request_skbm = $data['id_request_skbm'];
                                        $tgl = $data['tanggal_request'];
                                        $format = date('d F Y', strtotime($tgl));
                                        $nik = $data['nik'];
                                        $nama = $data['Nama'];
                                        $ttd_rt = $data['ttd_rt'];
                                        $ttd_rw = $data['ttd_rw'];
                                        $rt = $data['rt'];
                                        $rw = $data['rw'];

                                        // Format tanggal TTD
                                        $format_ttd_rt = $ttd_rt ? date('d/m/Y H:i', strtotime($ttd_rt)) : '-';
                                        $format_ttd_rw = $ttd_rw ? date('d/m/Y H:i', strtotime($ttd_rw)) : '-';

                                    ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $format; ?></td>
                                            <td><span class="badge badge-warning">SKBM</span></td>
                                            <td><?= $nik; ?></td>
                                            <td><?= $nama; ?></td>
                                            <td class="text-center">
                                                <?php if ($ttd_rt): ?>
                                                    <span class="badge badge-success" data-toggle="tooltip" title="<?= date('d F Y H:i:s', strtotime($ttd_rt)) ?>">
                                                        <i class="fa fa-check"></i> <?= $format_ttd_rt ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">BELUM</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($ttd_rw): ?>
                                                    <span class="badge badge-success" data-toggle="tooltip" title="<?= date('d F Y H:i:s', strtotime($ttd_rw)) ?>">
                                                        <i class="fa fa-check"></i> <?= $format_ttd_rw ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">BELUM</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="form-button-action">
                                                    <!-- Tombol View Detail -->
                                                    <a href="?halaman=detail_skbm&id_request_skbm=<?= $id_request_skbm; ?>">
                                                        <button type="button" data-toggle="tooltip" title="Lihat Detail" class="btn btn-link btn-info btn-lg">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </a>
                                                    <!-- Tombol Cetak -->
                                                     <a href="cetak_skbm.php?id_request_skbm=<?= $id_request_skbm; ?>" target="_blank">
                                                        <button type="button" data-toggle="tooltip" title="Cetak Surat" class="btn btn-link btn-primary">
                                                            <i class="fa fa-print"></i>
                                                        </button>
                                                    </a>
                                                    <!-- Tombol Hapus -->
                                                    <a href="?halaman=surat_dicetak&id_request_skbm=<?= $id_request_skbm; ?>"
                                                        onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                        <button type="button" data-toggle="tooltip" title="Hapus" class="btn btn-link btn-danger">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                }

                                // Query untuk SKK - hanya yang sudah di ACC
                                if ($hak_akses == 'RT') {
                                    $sql6 = "SELECT skk.*, user.rt, user.rw 
                                            FROM data_request_skk skk 
                                            INNER JOIN data_user user ON skk.nik_pemohon = user.nik 
                                            WHERE skk.status IN (1,2,3)
                                            AND user.rt = '$rt_login'";
                                } else {
                                    $sql6 = "SELECT skk.*, user.rt, user.rw 
                                            FROM data_request_skk skk 
                                            INNER JOIN data_user user ON skk.nik_pemohon = user.nik 
                                            WHERE skk.status IN (1,2,3)";
                                }

                                $query6 = mysqli_query($konek, $sql6);

                                if ($query6) {
                                    while ($data = mysqli_fetch_array($query6, MYSQLI_BOTH)) {
                                        $total_data++;
                                        $id_request_skk = $data['id_request_skk'];
                                        $tgl = $data['tanggal_request'];
                                        $format = date('d F Y', strtotime($tgl));
                                        $nik = $data['nik'];
                                        $nama = $data['Nama'];
                                        $ttd_rt = $data['ttd_rt'];
                                        $ttd_rw = $data['ttd_rw'];
                                        $rt = $data['rt'];
                                        $rw = $data['rw'];

                                        // Format tanggal TTD
                                        $format_ttd_rt = $ttd_rt ? date('d/m/Y H:i', strtotime($ttd_rt)) : '-';
                                        $format_ttd_rw = $ttd_rw ? date('d/m/Y H:i', strtotime($ttd_rw)) : '-';

                                       
                                    ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $format; ?></td>
                                            <td><span class="badge badge-danger">SKK</span></td>
                                            <td><?= $nik; ?></td>
                                            <td><?= $nama; ?></td>
                                            <td class="text-center">
                                                <?php if ($ttd_rt): ?>
                                                    <span class="badge badge-success" data-toggle="tooltip" title="<?= date('d F Y H:i:s', strtotime($ttd_rt)) ?>">
                                                        <i class="fa fa-check"></i> <?= $format_ttd_rt ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">BELUM</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($ttd_rw): ?>
                                                    <span class="badge badge-success" data-toggle="tooltip" title="<?= date('d F Y H:i:s', strtotime($ttd_rw)) ?>">
                                                        <i class="fa fa-check"></i> <?= $format_ttd_rw ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">BELUM</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="form-button-action">
                                                    <!-- Tombol View Detail -->
                                                    <a href="?halaman=detail_skk&id_request_skk=<?= $id_request_skk; ?>">
                                                        <button type="button" data-toggle="tooltip" title="Lihat Detail" class="btn btn-link btn-info btn-lg">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </a>
                                                    <!-- Tombol Cetak -->
                                                     <a href="cetak_skk.php?id_request_skk=<?= $id_request_skk; ?>" target="_blank">
                                                        <button type="button" data-toggle="tooltip" title="Cetak Surat" class="btn btn-link btn-primary">
                                                            <i class="fa fa-print"></i>
                                                        </button>
                                                    </a>
                                                    <!-- Tombol Hapus -->
                                                    <a href="?halaman=surat_dicetak&id_request_skk=<?= $id_request_skk; ?>"
                                                        onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                        <button type="button" data-toggle="tooltip" title="Hapus" class="btn btn-link btn-danger">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }

                                // Jika tidak ada data sama sekali
                                if ($total_data == 0) {
                                    echo "<tr><td colspan='9' class='text-center text-muted'>";
                                    echo "<i class='fa fa-inbox fa-3x mb-3'></i><br>";
                                    echo "<h5>Tidak ada data surat yang sudah selesai</h5>";
                                    if ($hak_akses == 'RT') {
                                        echo "<small class='text-info'>Tidak ada surat selesai dari RT $rt_login</small>";
                                    } else {
                                        echo "<small class='text-info'>Belum ada surat yang di-ACC</small>";
                                    }
                                    echo "</td></tr>";
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
// PROSES HAPUS DATA
if (isset($_GET['id_request_sktm'])) {
    $id_request_sktm = $_GET['id_request_sktm'];
    $hapus = mysqli_query($konek, "DELETE FROM data_request_sktm WHERE id_request_sktm='$id_request_sktm'");
    if ($hapus) {
        echo "<script>
            swal('Berhasil!', 'Data SKTM berhasil dihapus', 'success');
            setTimeout(function(){ window.location.href = '?halaman=surat_dicetak'; }, 2000);
        </script>";
    } else {
        echo "<script>
            swal('Gagal!', 'Terjadi kesalahan saat menghapus data', 'error');
            setTimeout(function(){ window.location.href = '?halaman=surat_dicetak'; }, 2000);
        </script>";
    }
} elseif (isset($_GET['id_request_sku'])) {
    $id_request_sku = $_GET['id_request_sku'];
    $hapus = mysqli_query($konek, "DELETE FROM data_request_sku WHERE id_request_sku='$id_request_sku'");
    if ($hapus) {
        echo "<script>
            swal('Berhasil!', 'Data SKU berhasil dihapus', 'success');
            setTimeout(function(){ window.location.href = '?halaman=surat_dicetak'; }, 2000);
        </script>";
    } else {
        echo "<script>
            swal('Gagal!', 'Terjadi kesalahan saat menghapus data', 'error');
            setTimeout(function(){ window.location.href = '?halaman=surat_dicetak'; }, 2000);
        </script>";
    }
} elseif (isset($_GET['id_request_skd'])) {
    $id_request_skd = $_GET['id_request_skd'];
    $hapus = mysqli_query($konek, "DELETE FROM data_request_skd WHERE id_request_skd='$id_request_skd'");
    if ($hapus) {
        echo "<script>
            swal('Berhasil!', 'Data SKD berhasil dihapus', 'success');
            setTimeout(function(){ window.location.href = '?halaman=surat_dicetak'; }, 2000);
        </script>";
    } else {
        echo "<script>
            swal('Gagal!', 'Terjadi kesalahan saat menghapus data', 'error');
            setTimeout(function(){ window.location.href = '?halaman=surat_dicetak'; }, 2000);
        </script>";
    }
} elseif (isset($_GET['id_request_skp'])) {
    $id_request_skp = $_GET['id_request_skp'];
    $hapus = mysqli_query($konek, "DELETE FROM data_request_skp WHERE id_request_skp='$id_request_skp'");
    if ($hapus) {
        echo "<script>
            swal('Berhasil!', 'Data SKP berhasil dihapus', 'success');
            setTimeout(function(){ window.location.href = '?halaman=surat_dicetak'; }, 2000);
        </script>";
    } else {
        echo "<script>
            swal('Gagal!', 'Terjadi kesalahan saat menghapus data', 'error');
            setTimeout(function(){ window.location.href = '?halaman=surat_dicetak'; }, 2000);
        </script>";
    }
}
?>

<script>
    $(document).ready(function() {
        $('#add1').DataTable({
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Tidak ada data surat yang sudah selesai",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "infoEmpty": "Tidak ada data tersedia",
                "infoFiltered": "(disaring dari _MAX_ total data)",
                "paginate": {
                    "previous": "<i class='fas fa-chevron-left'></i>",
                    "next": "<i class='fas fa-chevron-right'></i>"
                }
            },
            "order": [
                [1, "desc"]
            ],
            "columnDefs": [{
                "orderable": false,
                "targets": [5, 6, 8] // Non-aktifkan sorting untuk kolom TTD dan Action
            }]
        });

        // Inisialisasi tooltip
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>