<?php
session_start();
if (empty($_SESSION['password']) || empty($_SESSION['hak_akses'])) {
    header('location:login.php');
    exit;
} else {
    $hak_akses = $_SESSION['hak_akses'];
    $rt_login = isset($_SESSION['rt']) ? $_SESSION['rt'] : '';
}
?>

<?php include 'header.php'; ?>

<!-- Sidebar -->
<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-primary">
                <li class="mx-4 mt-2 text-center">
                    <a href="main2.php" class="btn btn-block">
                        <img src="../main/img/logo_jakarta.png" width="100px" alt="">
                    </a>
                </li>

                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section" style="color: black; font-weight:bold; font-family:sans-serif;">FITUR</h4>
                </li>

                <?php if ($hak_akses == "RT") { ?>
                    <li class="nav-item">
                        <a href="main2.php">
                            <i class="fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="?halaman=tampil_user">
                            <i class="fas fa-users"></i>
                            <p>Data User</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="?halaman=permohonan_surat">
                            <i class="fas fa-file-alt"></i>
                            <p>Manajemen Surat</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="?halaman=surat_dicetak">
                            <i class="fas fa-archive"></i>
                            <p>Arsip Surat</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="?halaman=pengumuman">
                            <i class="fas fa-bullhorn"></i>
                            <p>Pengumuman</p>
                        </a>
                    </li>

                <?php } elseif ($hak_akses == "RW") { ?>
                    <li class="nav-item">
                        <a href="main2.php">
                            <i class="fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="?halaman=tampil_user">
                            <i class="fas fa-users"></i>
                            <p>Data User</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="?halaman=permohonan_surat">
                            <i class="fas fa-file-alt"></i>
                            <p>Manajemen Surat</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="?halaman=surat_dicetak">
                            <i class="fas fa-archive"></i>
                            <p>Arsip Surat</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="?halaman=pengumuman">
                            <i class="fas fa-bullhorn"></i>
                            <p>Pengumuman</p>
                        </a>
                    </li>
                <?php } ?>

                <li class="mx-4 mt-2">
                    <a href="logout.php" class="btn btn-dark btn-block">
                        <span class="btn-label mr-2"><i class="icon-logout"></i></span>Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->

<div class="main-panel">
    <div class="content">
        <?php
        if (isset($_GET['halaman'])) {
            $hal = $_GET['halaman'];
            switch ($hal) {
                case 'beranda':
                    include 'beranda.php';
                    break;
                case 'ubah_pemohon':
                    include 'ubah_pemohon.php';
                    break;
                case 'tampil_pemohon':
                    include 'tampil_pemohon.php';
                    break;
                case 'request_sktm':
                    include 'request_sktm.php';
                    break;
                case 'request_sku':
                    include 'request_sku.php';
                    break;
                case 'request_skp':
                    include 'request_skp.php';
                    break;
                case 'request_skd':
                    include 'request_skd.php';
                    break;
                case 'tampil_status':
                    include 'status_request.php';
                    break;
                case 'belum_acc_sktm':
                    include 'belum_acc_sktm.php';
                    break;
                case 'belum_acc_sku':
                    include 'belum_acc_sku.php';
                    break;
                case 'belum_acc_skp':
                    include 'belum_acc_skp.php';
                    break;
                case 'belum_acc_skd':
                    include 'belum_acc_skd.php';
                    break;
                case 'sudah_acc_sktm':
                    include 'acc_sktm.php';
                    break;
                case 'sudah_acc_sku':
                    include 'acc_sku.php';
                    break;
                case 'sudah_acc_skp':
                    include 'acc_skp.php';
                    break;
                case 'sudah_acc_skd':
                    include 'acc_skd.php';
                    break;
                case 'detail_sktm':
                    include 'detail_sktm.php';
                    break;
                case 'detail_sku':
                    include 'detail_sku.php';
                    break;
                case 'detail_skck':
                    include 'detail_skck.php';
                    break;
                case 'detail_skd':
                    include 'detail_skd.php';
                    break;
                case 'detail_skbm':
                    include 'detail_skbm.php';
                    break;
                case 'detail_skk':
                    include 'detail_skk.php';
                    break;
                case 'cetak_sktm':
                    include 'cetak_sktm.php';
                    break;
                case 'tampil_user':
                    include 'tampil_user.php';
                    break;
                case 'tambah_user':
                    include 'tambah_user.php';
                    break;
                case 'ubah_user':
                    include 'ubah_user.php';
                    break;
                case 'detail_user':
                    include 'detail_user.php';
                    break;
                case 'view_sktm':
                    include 'view_sktm.php';
                    break;
                case 'view_sku':
                    include 'view_sku.php';
                    break;
                case 'view_skp':
                    include 'view_skp.php';
                    break;
                case 'view_skd':
                    include 'view_skd.php';
                    break;
                case 'view_cetak_sktm':
                    include 'view_cetak_sktm.php';
                    break;
                case 'view_cetak_sku':
                    include 'view_cetak_sku.php';
                    break;
                case 'view_cetak_skp':
                    include 'view_cetak_skp.php';
                    break;
                case 'view_cetak_skd':
                    include 'view_cetak_skd.php';
                    break;
                case 'surat_dicetak':
                    include 'surat_dicetak.php';
                    break;
                case 'laporan_perbulan':
                    include 'laporan_perbulan.php';
                    break;
                case 'laporan_pertahun':
                    include 'laporan_pertahun.php';
                    break;
                case 'permohonan_surat':
                    include 'permohonan_surat.php';
                    break;
                case 'profil':
                    include 'profil.php';
                    break;
                case 'editprofil':
                    include 'editprofil.php';
                    break;
                case 'pengumuman':
                    include 'pengumuman.php';
                    break;
                case 'editpengumuman':
                    include 'edit_pengumuman.php';
                    break;
                case 'add_pengumuman':
                    include 'add_pengumuman.php';
                    break;
                default:
                    echo "<center>HALAMAN KOSONG</center>";
                    break;
            }
        } else {
            include 'beranda2.php';
        }
        ?>
    </div>

    <?php include 'footer.php'; ?>
</div>