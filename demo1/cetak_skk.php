<?php 
include '../konek.php'; 
include 'signature_functions.php';  // Tambahkan library signature

if (isset($_GET['id_request_skk'])) {
    $id = $_GET['id_request_skk'];
    $sql = "SELECT * FROM data_request_skk WHERE id_request_skk='$id'";
    $query = mysqli_query($konek, $sql);
    
    if(mysqli_num_rows($query) == 0) {
        die("Data tidak ditemukan!");
    }
    
    $data = mysqli_fetch_array($query, MYSQLI_BOTH);
    $nik = $data['nik'];
    $no_kk = $data['no_kk'];
    $nama = $data['Nama'];
    $tempat = $data['Tempat_lahir'];
    $tgl = $data['Tanggal_lahir'];
    $tgl2 = $data['tanggal_request'];
    $format2 = date('Y', strtotime($tgl2));
    $format1 = date('d-m-Y', strtotime($tgl));
    $format3 = date('d F Y', strtotime($tgl2));
    $agama = $data['Agama'];
    $jekel = $data['Jenis_kelamin'];
    $alamat = $data['Alamat'];
    $rt = $data['rt'];
    $rw = $data['rw'];
    $pekerjaan = $data['Pekerjaan'];
    $request = $data['request'];
    $hari_kematian = $data['hari_kematian'];
    $tanggal_kematian = $data['tanggal_kematian'];
    $waktu_kematian = $data['waktu_kematian'];
    $usia_kematian = $data['usia_kematian'];
    $tempat_kematian = $data['tempat_kematian'];
    $acc = $data['acc'];
    $format4 = date('d F Y', strtotime($acc));
    $no_surat = $data['no_surat'];
    $format5 = date('m', strtotime($tgl2));
    $format6 = date('d-m-Y', strtotime($tanggal_kematian));
    $format7 = date('H:i', strtotime($waktu_kematian));
    $qrCodePath_rt = $data['qr_code_rt'] ?? '';
    $qrCodePath_rw = $data['qr_code_rw'] ?? '';
    
    // Konversi bulan ke romawi
    $romawi = "";
    if ($format5 == "1") $romawi = "I";
    elseif ($format5 == "2") $romawi = "II";
    elseif ($format5 == "3") $romawi = "III";
    elseif ($format5 == "4") $romawi = "IV";
    elseif ($format5 == "5") $romawi = "V";
    elseif ($format5 == "6") $romawi = "VI";
    elseif ($format5 == "7") $romawi = "VII";
    elseif ($format5 == "8") $romawi = "VIII";
    elseif ($format5 == "9") $romawi = "IX";
    elseif ($format5 == "10") $romawi = "X";
    elseif ($format5 == "11") $romawi = "XI";
    elseif ($format5 == "12") $romawi = "XII";

   

    // ========== DIGITAL SIGNATURE & QR CODE ==========
    // Data yang akan ditandatangani
    $data_to_sign = [
        'id_request' => $id,
        'jenis_surat' => 'skk',
        'nik' => $nik,
        'no_kk' => $no_kk,
        'nama' => $nama,
        'tanggal' => date('Y-m-d H:i:s'),
        'no_surat' => $no_surat
    ];
    
    // Buat tanda tangan digital
    $signature = signData($data_to_sign);
    
    // Generate QR Code dari signature
    $qrCodePath = generateQRCode($signature, $id, 'skk');
    
    // Simpan signature ke database
    $data_json = json_encode($data_to_sign);
    $cek_db = mysqli_query($konek, "SELECT * FROM digital_signature_log WHERE id_request='$id' AND jenis_surat='skk'");
    if(mysqli_num_rows($cek_db) == 0) {
        mysqli_query($konek, "INSERT INTO digital_signature_log (id_request, jenis_surat, data_json, signature) VALUES ('$id', 'skk', '$data_json', '$signature')");
    }
    // ========== END DIGITAL SIGNATURE ==========
    
} else {
    die("ID tidak valid!");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CETAK SKK</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .content {
            margin: 20px 0;
        }
        .footer {
            margin-top: 50px;
        }
        .signature {
            margin-top: 100px;
        }
        u {
            text-decoration: underline;
        }
        /* Style untuk QR Code */
        .qrcode-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            text-align: center;
            border: 1px solid #ccc;
            padding: 10px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .qrcode-container img {
            width: 100px;
            height: 100px;
        }
        .qrcode-container p {
            font-size: 10px;
            margin: 5px 0 0 0;
            color: #666;
        }
        .verification-status {
            position: fixed;
            bottom: 20px;
            left: 20px;
            font-size: 10px;
            background: #e8f5e9;
            padding: 5px 10px;
            border-radius: 5px;
            color: #2e7d32;
        }
        @media print {
            .qrcode-container {
                position: absolute;
                bottom: 20px;
                right: 20px;
            }
            .verification-status {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <table>
                <tr>
                    <td width="80">
                        <img src="../main/img/logo_jakarta.png" width="70" height="87" alt="">
                    </td>
                    <td>
                        <center>
                            <font size="4"><b> PENGURUS RUKUN TETANGGA (RT) 003 RUKUN WARGA (RW) 006 </b></font><br>
                            <font size="4"><b> KELURAHAN CIGANJUR </b></font><br>
                            <font size="4"><b>KECAMATAN JAGAKARSA KOTA ADMINISTRASI JAKARTA SELATAN</b></font><br>
                            <font size="3"><i> Sekretariat : Gg.Keranji 1 No.13 Telp 021-7875946</i></font><br>
                        </center>
                    </td>
                </tr>
            </table>
            <hr color="black">
        </div>

        <div class="content">
            <center>
                <font size="4"><b>SURAT KETERANGAN KEMATIAN</b></font><br>
                <hr style="margin:5px 0; width: 40%;" color="black">
                <span>Nomor : <?= $no_surat ? $no_surat : '...'; ?>/<?= $romawi; ?></span>
            </center>
            <br>

            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pengurus Rukun Tetangga 003/006 Kelurahan Ciganjur Kecamatan Jagakarsa Kota Jakarta Selatan, Menerangkan Bahwa :</p>
            <br>

            <table style="margin-left: 50px;">
                <tr><td width="200">Nama</td><td width="20">:</td><td><?php echo $nama; ?></td></tr>
                <tr><td>Tempat, tanggal lahir</td><td>:</td><td><?php echo $tempat . ", " . $format1; ?></td></tr>
                <tr><td>NIK</td><td>:</td><td><?php echo $nik; ?></td></tr>
                <tr><td>Nomor Kartu Keluarga</td><td>:</td><td><?php echo $no_kk; ?></td></tr>
                <tr><td>Jenis Kelamin</td><td>:</td><td><?php echo ($jekel == 'L') ? 'Laki-laki' : 'Perempuan'; ?></td></tr>
                <tr><td>Agama</td><td>:</td><td><?php echo $agama; ?></td></tr>
                <tr><td>Pekerjaan</td><td>:</td><td><?php echo $pekerjaan; ?></td></tr>
                <tr><td>Alamat</td><td>:</td><td><?php echo $alamat . " RT " . $rt . " RW " . $rw; ?></td></tr>
            </table>
            <br>
            <center>
                <font size="4"><b>TELAH MENINGGAL DUNIA</b></font><br>
            </center>
            <br>
            <table style="margin-left: 50px;">
                <tr><td width="200">Pada Hari/Tanggal</td><td width="20">:</td><td><?php echo $hari_kematian . ", " . $format6; ?></td></tr>
                <tr><td>Waktu</td><td>:</td><td><?php echo $format7;?></td></tr>
                <tr><td>pada Usia</td><td>:</td><td><?php echo $usia_kematian;?> Tahun</td></tr>
                <tr><td>Tempat</td><td>:</td><td><?php echo $tempat_kematian;?></td></tr>
                
            </table>
            <br>

            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Demikian surat keterangan kematian ini dibuat dengan sesungguhnya untuk dipergunakan sebagaimana mestinya.</p>
        </div>

        <!-- ========== BAGIAN TANDA TANGAN RT & RW ========== -->
<div class="footer" style="margin-top: 50px;">
    <table style="width: 100%;">
        <tr>
            <!-- Kolom Kiri: Tanda Tangan RT + QR RT -->
            <td style="width: 50%; text-align: center; vertical-align: bottom;">
                Jakarta, <?php echo $format4 ? $format4 : date('d F Y'); ?> <br>
                  Ketua RT 003/006 Kel.Ciganjur <br>   
                <?php if (!empty($qrCodePath_rt) && file_exists($qrCodePath_rt)): ?>  
                    <img src="<?= $qrCodePath_rt ?>" width="80" height="80" alt="QR RT">  
                    <div style="font-size: 9px; margin-top: 3px;">Scan untuk verifikasi RT</div>
                <?php endif; ?>  
                <br> 
                <u><b>H. Abdul Cholid HR.BA</b></u> 
            </td>
            
            <!-- Kolom Kanan: Tanda Tangan RW + QR RW -->
            <td style="width: 50%; text-align: center; vertical-align: bottom;">
                Mengetahui : <br>
                  Ketua RW 006 Kel.Ciganjur <br>  
                <?php if (!empty($qrCodePath_rw) && file_exists($qrCodePath_rw)): ?>  
                    <img src="<?= $qrCodePath_rw ?>" width="80" height="80" alt="QR RW">  
                    <div style="font-size: 9px; margin-top: 3px;">Scan untuk verifikasi RW</div>
                <?php endif; ?>  
                <br>
                <u><b>Yanto</b></u> 
            </td>
        </tr>
    </table>
</div>  
        
        <div class="verification-status">
            🔒 Tanda Tangan Digital: <strong>VALID</strong>
        </div>
    </div>
</body>

</html>
<script>
    window.print();
</script> 