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
                        <h4 class="card-title">Data Pengumuman</h4>
                        <a href="?halaman=add_pengumuman" class="btn btn-dark btn-round ml-auto">
                            <i class="fa fa-plus"></i>
                            Pengumuman
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="">
                            <div class="table-responsive">
                                <table id="add" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5%">No.</th>
                                            <th width="20%">Judul</th>
                                            <th width="50%">Isi</th>
                                            <th width="15%">Foto</th>
                                            <th width="10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $tampil = "SELECT * FROM pengumuman";
                                        $query = mysqli_query($konek, $tampil);
                                        while ($data = mysqli_fetch_array($query, MYSQLI_BOTH)) {
                                            $judul = $data['judul'];
                                            $isi = $data['isi'];
                                            $poto = $data['poto'];
                                            // Potong teks maksimal 150 karakter
                                            $isi_pendek = strlen($isi) > 150 ? substr($isi, 0, 150) . '...' : $isi;
                                        ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++; ?></td>
                                                <td><strong><?php echo $judul; ?></strong></td>
                                                <td>
                                                    <?php echo $isi_pendek; ?>
                                                    <?php if(strlen($isi) > 150): ?>
                                                        <a href="#" onclick="showFullText(<?= $data['id_pengumuman']; ?>)" class="text-primary"><br><small>Selengkapnya...</small></a>
                                                        <div id="full_<?= $data['id_pengumuman']; ?>" style="display:none;">
                                                            <?php echo $isi; ?>
                                                            <a href="#" onclick="hideFullText(<?= $data['id_pengumuman']; ?>)" class="text-danger"><br><small>Sembunyikan</small></a>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <img src="../dataFoto/pengumuman/<?= $poto; ?>" width="80px" style="border-radius: 5px;" alt="">
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-button-action">
                                                        <a href="?halaman=editpengumuman&id=<?= $data['id_pengumuman']; ?>" type="button" class="btn btn-link btn-primary btn-lg" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <a href="?halaman=pengumuma&id=<?= $data['id_pengumuman']; ?>" type="button" class="btn btn-link btn-danger btn-lg" title="Hapus" onclick="return confirm('Yakin ingin menghapus?')">
                                                            <i class="fa fa-times"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "DELETE FROM pengumuman WHERE id_pengumuman='$id'";
        $query = mysqli_query($konek, $sql);

        if ($query) {
            echo "<script language='javascript'>swal('Selamat...', 'Hapus Berhasil', 'success');</script>";
            echo '<meta http-equiv="refresh" content="3; url=?halaman=pengumuman">';
        } else {
            echo "<script language='javascript'>swal('Gagal...', 'Hapus Gagal', 'error');</script>";
            echo '<meta http-equiv="refresh" content="3; url=?halaman=pengumuman">';
        }
    }
    ?>
</div>

<script>
    function showFullText(id) {
        document.getElementById('full_' + id).style.display = 'block';
        event.preventDefault();
    }

    function hideFullText(id) {
        document.getElementById('full_' + id).style.display = 'none';
        event.preventDefault();
    }
</script>