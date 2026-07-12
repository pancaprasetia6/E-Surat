<?php include '../konek.php'; ?>
<link href="css/sweetalert.css" rel="stylesheet" type="text/css">
<script src="js/jquery-2.1.3.min.js"></script>
<script src="js/sweetalert.min.js"></script>
<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <form method="POST" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Pengumuman</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Judul</label>
                                    <input type="text" name="judul" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Isi</label>
                                    <textarea name="isi" id="" cols="30" rows="10" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Photo</label>
                                    <input type="file" name="poto" class="form-control" required="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" card-action">
                        <button name="simpan" class="btn btn-success btn-sm">Simpan</button>
                    </div>
                </div>
        </div>
        </form>
    </div>
</div>

<?php
if (isset($_POST['simpan'])) {
    $judul = htmlspecialchars($_POST['judul']);
    $isi = htmlspecialchars($_POST['isi']);
    $poto = isset($_FILES['poto']);
    $filepoto = rand() . ".jpg";
    $sql = "insert into pengumuman (judul,isi,poto) values ('$judul','$isi','$filepoto')";
    $query = mysqli_query($konek, $sql);

    if ($query) {
        copy($_FILES['poto']['tmp_name'], "../dataFoto/pengumuman/" . $filepoto);
        echo "<script language='javascript'>swal('Selamat...', 'Simpan Berhasil', 'success');</script>";
        echo '<meta http-equiv="refresh" content="3; url=?halaman=pengumuman">';
    } else {
        echo "<script language='javascript'>swal('Gagal...', 'Simpan Gagal', 'error');</script>";
        echo '<meta http-equiv="refresh" content="3; url=?halaman=pengumuman">';
    }
}
?>