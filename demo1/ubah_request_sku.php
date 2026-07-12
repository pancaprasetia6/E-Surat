 <?php include '../konek.php';?>
<link href="css/sweetalert.css" rel="stylesheet" type="text/css">
<script src="js/jquery-2.1.3.min.js"></script>
<script src="js/sweetalert.min.js"></script>  
<?php
if(isset($_GET['id_request_sku'])){
    $id = $_GET['id_request_sku'];
    $tampil_nik = "SELECT * FROM data_request_sku WHERE id_request_sku=$id";
    $query = mysqli_query($konek, $tampil_nik);
    
    // Cek apakah data ditemukan
    if(mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_array($query, MYSQLI_BOTH);
        $id = $data['id_request_sku'];
        $no_kk = $data['no_kk'];
        $nama_kk = $data['nama_kk'];
        $nik = $data['nik'];
        $nama = $data['Nama']; // Perhatikan: 'Nama' bukan 'nama'
        $tempat_lahir = $data['Tempat_lahir'];
        $tanggal_lahir = $data['Tanggal_lahir'];
        $jenis_kelamin = $data['Jenis_kelamin'];
        $agama = $data['Agama'];
        $status_perkawinan = $data['Status_perkawinan'];
        $warga_negara = $data['Warga_negara'];
		$nama_usaha = $data['Nama_usaha'];
		$omset = $data['Omset'];
		$penanggung_jawab = $data['Penanggung_jawab'];
		$jenis_usaha = $data['Jenis_usaha'];
        $pekerjaan = $data['Pekerjaan'];
		$alamat_usaha = $data['Alamat_usaha'];
        $alamat = $data['Alamat'];
        $rt = $data['rt'];
        $rw = $data['rw'];
        $no_telp = $data['No_telp'];
        $email = $data['Email']; 
    } else {
        echo "<script>alert('Data tidak ditemukan!'); window.location='?halaman=tampil_status';</script>";
        exit();
    }
} else {
    echo "<script>alert('ID tidak valid!'); window.location='?halaman=tampil_status';</script>";
    exit();
}
?>
<div class="page-inner">
    <div class="row">
        <div class="col-md-12">	
            <form method="POST" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">UBAH PENGAJUAN SKU</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>No. KK</label>
                                    <input type="text" name="no_kk" class="form-control" value="<?= $no_kk; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Nama Kepala Keluarga</label>
                                    <input type="text" name="nama_kk" class="form-control" value="<?= $nama_kk; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="text" name="nik" class="form-control" value="<?= $nik; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="Nama" class="form-control" value="<?= $nama; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Tempat Lahir</label>
                                    <input type="text" name="Tempat_lahir" class="form-control" value="<?= $tempat_lahir; ?>" placeholder="Tempat Lahir">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control" value="<?= $tanggal_lahir; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="" disabled selected hidden>Pilih Jenis Kelamin</option>
                                        <option value="L" <?= ($jenis_kelamin == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                                        <option value="P" <?= ($jenis_kelamin == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="agama">Agama</label>
                                    <select class="form-control" id="agama" name="agama" required>
                                        <option value="" disabled selected hidden>Pilih Agama</option>
                                        <option value="Islam" <?= ($agama == 'Islam') ? 'selected' : ''; ?>>Islam</option>
                                        <option value="Kristen" <?= ($agama == 'Kristen') ? 'selected' : ''; ?>>Kristen</option>
                                        <option value="Katolik" <?= ($agama == 'Katolik') ? 'selected' : ''; ?>>Katolik</option>
                                        <option value="Hindu" <?= ($agama == 'Hindu') ? 'selected' : ''; ?>>Hindu</option>
                                        <option value="Budha" <?= ($agama == 'Budha') ? 'selected' : ''; ?>>Budha</option>
                                        <option value="Konghucu" <?= ($agama == 'Konghucu') ? 'selected' : ''; ?>>Konghucu</option>
                                    </select>
                                </div>
								<div class="form-group">
									<label for="status_perkawinan">Status Perkawinan</label>
									<select class="form-control" id="status_perkawinan" name="status_perkawinan" required>
										<option value="" disabled selected hidden>Pilih Status Perkawinan</option>
										<option value="Belum Menikah" <?= ($status_perkawinan == 'Belum Menikah') ? 'selected' : ''; ?>>Belum Menikah</option>
										<option value="Menikah" <?= ($status_perkawinan == 'Menikah') ? 'selected' : ''; ?>>Menikah</option>
										<option value="Duda" <?= ($status_perkawinan == 'Duda') ? 'selected' : ''; ?>>Duda</option>
										<option value="Janda" <?= ($status_perkawinan == 'Janda') ? 'selected' : ''; ?>>Janda</option>
										<option value="Cerai Mati" <?= ($status_perkawinan == 'Cerai Mati') ? 'selected' : ''; ?>>Cerai Mati</option>
										<option value="Cerai Hidup" <?= ($status_perkawinan == 'Cerai Hidup') ? 'selected' : ''; ?>>Cerai Hidup</option>
									</select>
								</div>
								<div class="form-group">
                                    <label for="warga_negara">Warga Negara</label>
                                    <select class="form-control" id="warga_negara" name="warga_negara" required>
                                        <option value="" disabled selected hidden>Pilih Warga Negara</option>
                                        <option value="Indonesia" <?= ($warga_negara == 'Indonesia') ? 'selected' : ''; ?>>Indonesia</option>
                                        <option value="Asing" <?= ($warga_negara == 'Asing') ? 'selected' : ''; ?>>Asing</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>No. Tlp/Whatsapp</label>
                                    <input type="text" name="no_telp" class="form-control" value="<?= $no_telp; ?>" placeholder="08xxx" required>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" class="form-control" value="<?= $email; ?>" placeholder="nama@domain.com" required>
                                </div> 
                            </div>
							<div class="col-md-6 col-lg-6">  
                                <div class="form-group">
                                    <label>Nama Usaha</label>
                                    <input type="text" name="nama_usaha" class="form-control" value="<?= $nama_usaha; ?>" placeholder="Nama Usaha">
                                </div>
                                <div class="form-group">
                                    <label>Omset</label>
                                    <input type="text" name="omset" class="form-control" value="<?= $omset; ?>" placeholder="Omset">
                                </div>
                                <div class="form-group">
                                    <label>Penanggung Jawab</label>
                                    <input type="text" name="penanggung_jawab" class="form-control" value="<?= $penanggung_jawab; ?>" placeholder="Penanggung_jawab">
                                </div>
                                <div class="form-group">
                                    <label>Jenis Usaha</label>
                                    <input type="text" name="jenis_usaha" class="form-control" value="<?= $jenis_usaha; ?>" placeholder="Jenis_usaha">
                                </div>
                                <div class="form-group">
                                    <label>Pekerjaan</label>
                                    <input type="text" name="pekerjaan" class="form-control" value="<?= $pekerjaan; ?>" placeholder="Pekerjaan">
                                </div>
								<div class="form-group">
                                    <label for="alamat">Alamat Usaha</label>
                                    <textarea class="form-control" id="alamat_usaha" name="alamat_usaha" rows="4" placeholder="Masukkan Alamat Lengkap" required><?= $alamat_usaha; ?></textarea>
                                </div> 
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="4" placeholder="Masukkan Alamat Lengkap" required><?= $alamat; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>RT</label>
                                    <input type="text" name="rt" class="form-control" value="<?= $rt; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>RW</label>
                                    <input type="text" name="rw" class="form-control" value="<?= $rw; ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button name="ubah" class="btn btn-success">Ubah</button>
                        <a href="?halaman=tampil_status" class="btn btn-default">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
if(isset($_POST['ubah'])){
    $tempat_lahir = $_POST['Tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $status_perkawinan = $_POST['status_perkawinan'];
    $warga_negara = $_POST['warga_negara'];
	$nama_usaha = $_POST['nama_usaha'];
	$omset = $_POST['omset'];
	$penanggung_jawab = $_POST['penanggung_jawab'];
	$jenis_usaha = $_POST['jenis_usaha'];
    $pekerjaan = $_POST['pekerjaan'];
	$alamat_usaha = $_POST['alamat_usaha'];
    $alamat = $_POST['alamat'];
    $rt = $_POST['rt'];
    $rw = $_POST['rw'];
    $no_telp = $_POST['no_telp'];
    $email = $_POST['email']; 
    
    $sql = "UPDATE data_request_sku SET
        Tempat_lahir = '$tempat_lahir',
        Tanggal_lahir = '$tanggal_lahir',
        Jenis_kelamin = '$jenis_kelamin',
        Agama = '$agama',
        Status_perkawinan = '$status_perkawinan',
        Warga_negara = '$warga_negara',
		Nama_usaha = '$nama_usaha',
		Omset = '$omset',
		Penanggung_jawab = '$penanggung_jawab',
		Jenis_usaha = '$jenis_usaha',
        Pekerjaan = '$pekerjaan',
		Alamat_usaha = '$alamat_usaha',
        Alamat = '$alamat',
        No_telp = '$no_telp',
        Email = '$email' 
    WHERE id_request_sku = $id";
    
    $query = mysqli_query($konek, $sql);

    if($query){
        echo "<script language='javascript'>swal('Selamat...', 'Ubah Berhasil', 'success');</script>";
        echo '<meta http-equiv="refresh" content="3; url=?halaman=tampil_status">';
    } else {
        echo "<script language='javascript'>swal('Gagal...', 'Ubah Gagal: ".mysqli_error($konek)."', 'error');</script>";
        echo '<meta http-equiv="refresh" content="3; url=?halaman=ubah_sktm&id_request_sktm='.$id.'">';
    }
}
?>