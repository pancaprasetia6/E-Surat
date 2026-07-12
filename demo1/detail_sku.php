<?php
// Di AWAL file view_detail_sktm.php, tambahkan kode proses ACC/Tolak
include '../konek.php';

//TOLAK
if (isset($_POST['submit_tolak'])) {
    $id = $_POST['id_penolakan'];
    $type = $_POST['type_penolakan'];
    $alasan = mysqli_real_escape_string($konek, $_POST['alasan_penolakan']);

    $surat_mapping = array(
        'sku'   => array('table' => 'data_request_sku', 'id_column' => 'id_request_sku'),
        'sktm'  => array('table' => 'data_request_sktm', 'id_column' => 'id_request_sktm')
    );

    // CEK APAKAH TYPE VALID
    if (isset($surat_mapping[$type])) {
        $table = $surat_mapping[$type]['table'];
        $id_column = $surat_mapping[$type]['id_column'];

        // QUERY UPDATE
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
                setTimeout(function(){ window.location.href = '?halaman=detail_sktm&id_request_sktm=$id'; }, 2000);
            </script>";
        }
    } else {
        echo "<script>
            swal('Error!', 'Tipe surat tidak valid', 'error');
            setTimeout(function(){ window.location.href = '?halaman=detail_sktm&id_request_sktm=$id'; }, 2000);
        </script>";
    }
}

//ACC
if (isset($_GET['aksi']) && isset($_GET['id_request_sku'])) {
    $id = $_GET['id_request_sku'];
    $aksi = $_GET['aksi'];

    if ($aksi == 'acc') {
        $no_surat = "SKU/" . date('Y') . "/" . str_pad($id, 4, '0', STR_PAD_LEFT);
        $sql = "UPDATE data_request_sku SET status='1', no_surat='$no_surat', acc=NOW(), keterangan='Surat sudah bisa dicetak' WHERE id_request_sku='$id'";
        $query = mysqli_query($konek, $sql);

        if ($query) {
            echo "<script>
                swal('Berhasil!', 'Pengajuan SKU telah disetujui', 'success');
                setTimeout(function(){ window.location.href = '?halaman=detail_sku&id_request_sku=$id'; }, 2000);
            </script>";
        } else {
            echo "<script>
                swal('Gagal!', 'Terjadi kesalahan sistem', 'error');
                setTimeout(function(){ window.location.href = '?halaman=detail_sku&id_request_sku=$id'; }, 2000);
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
                        <h4 class="card-title">DETAIL PENGAJUAN SURAT KETERANGAN USAHA</h4>
                        <a href="?halaman=permohonan_surat" class="btn btn-primary btn-round ml-auto">
                            <i class="fa fa-arrow-left"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php
                    if (isset($_GET['id_request_sku'])) {
                        $id = $_GET['id_request_sku'];
                        $sql = "SELECT * FROM data_request_sku WHERE id_request_sku='$id'";
                        $query = mysqli_query($konek, $sql);

                        if (mysqli_num_rows($query) > 0) {
                            $data = mysqli_fetch_array($query, MYSQLI_BOTH);
                            $status = $data['status'];
                            $ttd_rt = $data['ttd_rt'];
                            $ttd_rw = $data['ttd_rw'];
                    ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Data Pribadi</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td width="40%"><b>No. KK</b></td>
                                                    <td><?= $data['no_kk']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="40%"><b>Nama Kepala Keluarga</b></td>
                                                    <td><?= $data['nama_kk']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="40%"><b>NIK</b></td>
                                                    <td><?= $data['nik']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Nama Lengkap</b></td>
                                                    <td><?= $data['Nama']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Tempat Lahir</b></td>
                                                    <td><?= $data['Tempat_lahir']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Tanggal Lahir</b></td>
                                                    <td><?= date('d F Y', strtotime($data['Tanggal_lahir'])); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Jenis Kelamin</b></td>
                                                    <td><?= ($data['Jenis_kelamin'] == 'L') ? 'Laki-laki' : 'Perempuan'; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Agama</b></td>
                                                    <td><?= $data['Agama']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="20%"><b>Alamat</b></td>
                                                    <td><?= $data['Alamat']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="20%"><b>RT</b></td>
                                                    <td><?= $data['rt']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="20%"><b>RW</b></td>
                                                    <td><?= $data['rw']; ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Data Lainnya</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td width="40%"><b>Status Perkawinan</b></td>
                                                    <td><?= $data['Status_perkawinan']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Warga Negara</b></td>
                                                    <td><?= $data['Warga_negara']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Pekerjaan</b></td>
                                                    <td><?= $data['Pekerjaan']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>No. Telepon/WhatsApp</b></td>
                                                    <td><?= $data['No_telp']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Email</b></td>
                                                    <td><?= $data['Email']; ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Detail Usaha</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td><b>Nama Usaha</b></td>
                                                    <td><?= $data['Nama_usaha']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Omset</b></td>
                                                    <td><?= $data['Omset']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Penanggung Jawab</b></td>
                                                    <td><?= $data['Penanggung_jawab']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Jenis Usaha</b></td>
                                                    <td><?= $data['Jenis_usaha']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="20%"><b>Alamat Usaha</b></td>
                                                    <td><?= $data['Alamat_usaha']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Status</b></td>
                                                    <td>
                                                        <?php
                                                        if ($status == "ditolak") {
                                                            echo "<span class='badge badge-danger'>DITOLAK</span>";
                                                        } elseif ($ttd_rw) {
                                                            echo "<span class='badge badge-success'>SUDAH TTD RW</span>";
                                                        } elseif ($ttd_rt) {
                                                            echo "<span class='badge badge-info'>SUDAH TTD RT</span>";
                                                        } elseif ($status == "1") {
                                                            echo "<span class='badge badge-warning'>SUDAH DIACC</span>";
                                                        } else {
                                                            echo "<span class='badge badge-secondary'>MENUNGGU ACC</span>";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                </tr>
                                                <?php if ($status == "ditolak") { ?>
                                                <tr>
                                                    <td><b>Alasan Penolakan</b></td>
                                                    <td><span class="text-danger"><?= $data['keterangan']; ?></span></td>
                                                </tr>
                                                <?php } ?>
                                                <tr>
                                                <tr>
                                                    <td><b>Tanggal Request</b></td>
                                                    <td><?= date('d F Y H:i', strtotime($data['tanggal_request'])); ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TOMBOL ACTION - PERBAIKI BAGIAN INI -->
                            <?php if ($status == "0" || $status == "ditolak") { ?>
                                <div class="row mt-3">
                                    <div class="col-md-12 text-center">
                                        <a href="?halaman=detail_sku&id_request_sku=<?= $id; ?>&aksi=acc"
                                            class="btn btn-success btn-lg"
                                            onclick="return confirm('Anda yakin ingin mengACC pengajuan ini?')">
                                            <i class="fa fa-check"></i> ACC Pengajuan
                                        </a>
                                        <!-- PERBAIKAN: Hapus href dan gunakan onclick saja -->
                                        <button type="button"
                                            class="btn btn-danger btn-lg"
                                            onclick="openTolakModal('<?= $id; ?>', 'sku')">
                                            <i class="fa fa-times"></i> Tolak Pengajuan
                                        </button>
                                    </div>
                                </div>
                            <?php } ?>

                        <?php } else { ?>
                            <div class="alert alert-danger">Data tidak ditemukan!</div>
                        <?php } ?>

                    <?php } else { ?>
                        <div class="alert alert-danger">ID tidak valid!</div>
                    <?php } ?>
                </div>
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
            <!-- PERBAIKAN: Tambahkan action yang jelas -->
            <form method="POST" action="?halaman=detail_sku&id_request_sku=<?= $id; ?>">
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
    // Fungsi untuk set alasan cepat
    function setAlasan(alasan) {
        document.getElementById('alasan_penolakan').value = alasan;
    }

    // Fungsi untuk buka modal tolak
    function openTolakModal(id, type) {
        document.getElementById('id_penolakan').value = id;
        document.getElementById('type_penolakan').value = type;
        document.getElementById('alasan_penolakan').value = '';
        $('#modalTolak').modal('show');
    }
</script>