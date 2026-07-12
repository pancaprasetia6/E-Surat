<?php 
include 'konek.php';
session_start();

// PROSES LOGIN
if (isset($_POST['login'])) {
    $password = $_POST['password'];
    $hak_akses = $_POST['hak_akses'];
    $rt = '003';
    $rw = '006';

    $sql_login = "SELECT * FROM data_user WHERE hak_akses='$hak_akses' AND password='$password'";
    $query_login = mysqli_query($konek, $sql_login);
    $data_login = mysqli_fetch_array($query_login, MYSQLI_BOTH);
    $jumlah_login = mysqli_num_rows($query_login); 

    if ($jumlah_login > 0) {
    $_SESSION['hak_akses'] = $data_login['hak_akses'];
    $_SESSION['password'] = $data_login['password'];
    $_SESSION['rt'] = $rt;
    $_SESSION['rw'] = $rw;
    
    // LANGSUNG REDIRECT, TANPA ALERT
    header("Location: demo1/main2.php");
    exit();
} else {
    echo "<script>
        alert('Password salah!');
        window.location.href = 'pegawai.php';
    </script>";
    exit();
}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Halaman Login Pegawai</title>

  <link rel="stylesheet" href="main/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="main/vendors/base/vendor.bundle.base.css">
  <link href="main/css/sweetalert.css" rel="stylesheet" type="text/css">
  <script src="main/js/jquery-2.1.3.min.js"></script>
  <script src="main/js/sweetalert.min.js"></script>
  <script src="main/js/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="main/css/style.css">

  <style>
    /* STYLE KEREN LO TARUH DISINI */
    body {
      background: linear-gradient(135deg, #667eea 0%, #2d0979 100%);
    }
    
    .auth-form-light {
      border-radius: 20px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
      transition: all 0.3s ease;
      background: white;
    }
    
    .auth-form-light:hover {
      transform: translateY(-8px);
      box-shadow: 0 30px 70px rgba(0, 0, 0, 0.4);
    }
    
    .badge-info {
      background: linear-gradient(135deg, #667eea, #2d0979);
      color: white;
      padding: 12px 20px;
      border-radius: 50px;
      text-align: center;
      margin-bottom: 25px;
      font-weight: bold;
    }
    
    .badge-info i {
      margin-right: 8px;
    }
    
    h6.text-center {
      color: #333;
      font-weight: 700;
      margin-bottom: 25px;
      font-size: 20px;
    }
    
    h6.text-center:after {
      content: '';
      display: block;
      width: 50px;
      height: 3px;
      background: linear-gradient(135deg, #667eea, #2d0979);
      margin: 10px auto 0;
      border-radius: 3px;
    }
    
    .form-group label {
      font-weight: 600;
      color: #555;
      margin-bottom: 8px;
      display: block;
    }
    
    .form-control-select, .form-control {
      width: 100%;
      padding: 12px 15px;
      border: 2px solid #e0e0e0;
      border-radius: 10px;
      transition: all 0.3s ease;
      background: #f8f9fa;
    }
    
    .form-control-select:focus, .form-control:focus {
      outline: none;
      border-color: #667eea;
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
      background: white;
    }
    
    .btn-primary {
      background: linear-gradient(135deg, #667eea, #2d0979) !important;
      border: none !important;
      border-radius: 10px !important;
      padding: 12px !important;
      font-weight: 700 !important;
      transition: all 0.3s ease !important;
    }
    
    .btn-primary:hover {
      transform: translateY(-2px) !important;
      box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4) !important;
    }
    
    .btn-danger { 
      border-radius: 10px !important;
      padding: 12px !important;
      font-weight: 700 !important;
    }
    
    .btn-danger:hover {
      transform: translateY(-2px) !important;
    }
    
    .info-text {
      text-align: center;
      margin-top: 25px;
      padding-top: 20px;
      border-top: 1px solid #eee;
      color: #888;
      font-size: 12px;
    }
    
    .auth-form-light {
      animation: fadeInUp 0.5s ease;
    }
    
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    } 
  </style>
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo text-center">
                <img src="main/img/logo_jakarta.png" alt="logo"> 
              </div>

              <div class="badge-info">
                <i class="mdi mdi-home-map-marker"></i>RT 003 / RW 006
              </div>

              <h6 class="text-center">LOGIN PENGURUS</h6>
              
              <?php if(isset($error)): ?>
                <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 8px; margin-bottom: 15px; text-align: center;">
                  <?= $error ?>
                </div>
              <?php endif; ?>

              <form method="POST" class="pt-3">
                <div class="form-group">
                  <label>Login Sebagai</label>
                  <select name="hak_akses" class="form-control-select" required>
                    <option value="" disabled selected>-- Pilih --</option>
                    <option value="RT">KETUA RT 003</option>
                    <option value="RW">KETUA RW 006</option>
                  </select>
                </div>

                <input type="hidden" name="rt" value="003">
                <input type="hidden" name="rw" value="006">

                <div class="form-group">
                  <label>Password</label>
                  <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>
                </div>

                <div class="mt-3">
                  <button type="submit" name="login" class="btn btn-primary btn-block btn-lg font-weight-medium">
                    <i class="mdi mdi-login"></i> LOGIN
                  </button>
                </div>
                
                <br>
                
                <div class="mb-2">
                  <button type="button" onclick="window.location.href='<?= $url_index; ?>'" class="btn btn-danger btn-block btn-lg font-weight-medium">
                    <i class="mdi mdi-close"></i> BATAL
                  </button>
                </div>
              </form>
              
              <div class="info-text">
                <i class="mdi mdi-information-outline"></i> Khusus Pengurus RT 003 dan RW 006
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="main/vendors/base/vendor.bundle.base.js"></script>
  <script src="main/js/off-canvas.js"></script>
  <script src="main/js/hoverable-collapse.js"></script>
  <script src="main/js/template.js"></script>
</body>

</html>