<?php include 'konek.php'; 
if (isset($_POST['login'])) {
    $nik = $_POST['nik'];
    $password = $_POST['password'];

    $sql_login = "SELECT * FROM data_user WHERE nik='$nik' AND password='$password'";
    $query_login = mysqli_query($konek, $sql_login);
    $data_login = mysqli_fetch_array($query_login, MYSQLI_BOTH);
    $jumlah_login = mysqli_num_rows($query_login);

    if ($jumlah_login > 0) {
        session_start();
        $_SESSION['hak_akses'] = $data_login['hak_akses'];
        $_SESSION['nama'] = $data_login['nama'];
        $_SESSION['password'] = $data_login['password'];
        $_SESSION['nik'] = $data_login['nik'];

        // PAKE ALERT BIASA + REDIRECT LANGSUNG - SAMA KAYA PEGAWAI.PHP
        echo "<script>
            alert('Login Berhasil! Selamat datang {$data_login['nama']}');
            window.location.href = 'demo1/main.php';
        </script>";
        exit();
    } else {
        echo "<script>
            alert('Login Gagal! NIK atau Password yang Anda masukkan salah');
            window.location.href = 'login.php';
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
  <title>Halaman Login Warga - RT 003 RW 006</title>

  <link rel="stylesheet" href="main/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="main/vendors/base/vendor.bundle.base.css">
  <link href="main/css/sweetalert.css" rel="stylesheet" type="text/css">
  <script src="main/js/sweetalert.min.js"></script>
  <link rel="stylesheet" href="main/css/style.css">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #6b8cce 100%);
      min-height: 100vh;
      position: relative;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    

    @keyframes rise {
      0% {
        bottom: -100px;
        transform: translateX(0);
        opacity: 0;
      }
      50% {
        opacity: 0.5;
      }
      100% {
        bottom: 100%;
        transform: translateX(100px);
        opacity: 0;
      }
    }

    /* Card Login */
    .auth-form-light {
      background: rgba(255, 255, 255, 0.98);
      border-radius: 25px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
      transition: all 0.3s ease;
      backdrop-filter: blur(10px);
      animation: fadeInUp 0.6s ease;
    }

    .auth-form-light:hover {
      transform: translateY(-8px);
      box-shadow: 0 30px 70px rgba(0, 0, 0, 0.4);
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

    /* Title */
    h6.text-center {
      color: #1e3c72;
      font-size: 22px;
      font-weight: 700;
      margin-bottom: 25px;
      position: relative;
    }

    h6.text-center:after {
      content: '';
      display: block;
      width: 60px;
      height: 3px;
      background: linear-gradient(135deg, #1e3c72, #2a5298);
      margin: 12px auto 0;
      border-radius: 3px;
    }

    /* Badge Info */
    .badge-rt {
      background: linear-gradient(135deg, #1e3c72, #2a5298);
      color: white;
      text-align: center;
      padding: 10px;
      border-radius: 50px;
      margin-bottom: 20px;
      font-size: 13px;
      font-weight: 600;
    }

    .badge-rt i {
      margin-right: 8px;
    }

    /* Form Control */
    .form-group {
      margin-bottom: 20px;
    }

    .form-control {
      width: 100%;
      padding: 14px 18px;
      border: 2px solid #e1e5e9;
      border-radius: 12px;
      font-size: 14px;
      transition: all 0.3s ease;
      background: #f8f9fa;
    }

    .form-control:focus {
      outline: none;
      border-color: #2a5298;
      background: white;
      box-shadow: 0 0 0 4px rgba(42, 82, 152, 0.1);
    }

    /* Buttons */
    .btn {
      padding: 14px;
      border-radius: 12px;
      font-weight: 700;
      transition: all 0.3s ease;
    }

    .btn-primary {
      background: linear-gradient(135deg, #1e3c72, #2a5298);
      border: none;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(30, 60, 114, 0.4);
      background: linear-gradient(135deg, #162d54, #1e3c72);
    }

    .btn-danger {
      background: linear-gradient(135deg, #dc3545, #c82333);
      border: none;
    }

    .btn-danger:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(220, 53, 69, 0.4);
    }

    /* Link */
    .text-primary {
      color: #2a5298 !important;
      text-decoration: none;
      font-weight: 600;
    }

    .text-primary:hover {
      text-decoration: underline;
    }

    .font-weight-light {
      font-size: 13px;
    }

    /* Title Logo */
    .titleLogo {
      font-family: monospace;
      font-weight: bold;
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

              <!-- Badge Info -->
              <div class="badge-rt">
                <i class="mdi mdi-home-map-marker"></i>RT 003 / RW 006
              </div>

              <h6 class="text-center">LOGIN WARGA</h6>
              
              <form method="POST" class="pt-3">
                <div class="form-group">
                  <input type="text" name="nik" class="form-control" placeholder="NIK (16 Digit)" 
                         oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" 
                         maxlength="16" required autofocus>
                </div>
                <div class="form-group">
                  <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="mt-3">
                  <button type="submit" name="login" class="btn btn-primary btn-block btn-lg">
                    <i class="mdi mdi-login"></i> LOGIN
                  </button>
                </div>
                <br>
                <div class="mb-2">
                  <a class="btn btn-danger btn-block btn-lg" href="<?= $url_index; ?>">
                    <i class="mdi mdi-close"></i> BATAL
                  </a>
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Belum memiliki akun? <a href="register.php" class="text-primary">Daftar Sekarang</a>
                </div>
                <div class="text-center mt-2 font-weight-light">
                  Anda Pengurus RT/RW? <a href="pegawai.php" class="text-primary">Login RT/RW</a>
                </div>
              </form>
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
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>