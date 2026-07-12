<?php include 'konek.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Daftar Akun - RT 003 RW 006</title>
  
  <!-- Favicon -->
  <link rel="shortcut icon" href="main/images/favicon.png" />
  
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@500;600;700&display=swap" rel="stylesheet">
  
  <!-- CSS Libraries -->
  <link rel="stylesheet" href="main/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="main/vendors/base/vendor.bundle.base.css">
  <link href="main/css/sweetalert.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="main/css/style.css">
  
  <!-- SweetAlert JS -->
  <script src="main/js/jquery-2.1.3.min.js"></script>
  <script src="main/js/sweetalert.min.js"></script>
  <script src="main/js/sweetalert-dev.js"></script>

  <style>
    :root {
      --primary-color: #251da0ff;
      --primary-dark: #252385ff;
      --secondary-color: #6c757d;
      --accent-color: #ffc107;
      --danger-color: #dc3545;
      --success-color: #28a745;
      --light-bg: #f8f9fa;
      --card-shadow: 0 15px 35px rgba(50, 50, 93, 0.1), 0 5px 15px rgba(0, 0, 0, 0.07);
      --hover-shadow: 0 20px 40px rgba(50, 50, 93, 0.15), 0 7px 20px rgba(0, 0, 0, 0.1);
    }
    
    body { 
      min-height: 100vh;
      font-family: 'Poppins', sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .registration-container {
      width: 100%;
      max-width: 450px;
      animation: fadeIn 0.8s ease-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .auth-form-light {
      background: white;
      border-radius: 20px;
      box-shadow: var(--card-shadow);
      transition: transform 0.4s ease, box-shadow 0.4s ease;
      overflow: hidden;
      border: none;
      position: relative;
    }
    
    .auth-form-light:before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 6px;
      background: linear-gradient(to right, var(--primary-color), var(--accent-color));
    }

    .auth-form-light:hover {
      transform: translateY(-10px);
      box-shadow: var(--hover-shadow);
    }

    .brand-logo {
      text-align: center;
      margin-bottom: 25px;
      padding-top: 10px;
    }
    
    .brand-logo img {
      width: 100px;
      height: 100px;
      object-fit: contain;
      transition: transform 0.5s ease;
    }
    
    .brand-logo:hover img {
      transform: rotate(5deg) scale(1.05);
    }

    .titleLogo {
      font-family: 'Montserrat', sans-serif;
      font-weight: 700;
      color: var(--primary-dark);
      margin-top: 10px;
      font-size: 1.8rem;
      letter-spacing: 0.5px;
    }

    .registration-title {
      text-align: center;
      color: #333;
      font-weight: 600;
      margin-bottom: 5px;
      font-size: 1.8rem;
    }
    
    .registration-subtitle {
      text-align: center;
      color: var(--secondary-color);
      margin-bottom: 30px;
      font-weight: 400;
      font-size: 0.95rem;
    }

    .form-group {
      margin-bottom: 25px;
      position: relative;
    }
    
    .form-control {
      border-radius: 12px;
      border: 2px solid #e8e8e8;
      padding: 16px 20px;
      font-size: 16px;
      transition: all 0.3s ease;
      background-color: #f9f9f9;
      font-family: 'Poppins', sans-serif;
      height: auto;
    }
    
    .form-control:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 4px rgba(37, 29, 160, 0.15);
      background-color: white;
      transform: translateY(-2px);
    }
    
    .form-control.valid {
      border-color: var(--success-color);
      background-color: rgba(40, 167, 69, 0.05);
    }
    
    .form-control.invalid {
      border-color: var(--danger-color);
      background-color: rgba(220, 53, 69, 0.05);
    }

    .form-label {
      position: absolute;
      top: -10px;
      left: 15px;
      background: white;
      padding: 0 8px;
      font-size: 0.85rem;
      color: var(--primary-color);
      font-weight: 500;
      z-index: 1;
      transition: all 0.3s ease;
    }

    .input-icon {
      position: absolute;
      right: 20px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--secondary-color);
      font-size: 1.2rem;
    }
    
    .validation-icon {
      position: absolute;
      right: 50px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 1.2rem;
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    
    .validation-icon.valid {
      color: var(--success-color);
      opacity: 1;
    }
    
    .validation-icon.invalid {
      color: var(--danger-color);
      opacity: 1;
    }

    .validation-message {
      font-size: 0.85rem;
      margin-top: 5px;
      display: none;
      padding-left: 5px;
    }
    
    .validation-message.valid {
      color: var(--success-color);
      display: block;
    }
    
    .validation-message.invalid {
      color: var(--danger-color);
      display: block;
    }

    .btn {
      border-radius: 12px;
      padding: 16px;
      font-weight: 600;
      font-size: 1.1rem;
      letter-spacing: 0.5px;
      transition: all 0.3s ease;
      border: none;
      position: relative;
      overflow: hidden;
      font-family: 'Poppins', sans-serif;
    }
    
    .btn:after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 5px;
      height: 5px;
      background: rgba(255, 255, 255, 0.5);
      opacity: 0;
      border-radius: 100%;
      transform: scale(1, 1) translate(-50%);
      transform-origin: 50% 50%;
    }
    
    .btn:focus:not(:active)::after {
      animation: ripple 1s ease-out;
    }
    
    @keyframes ripple {
      0% {
        transform: scale(0, 0);
        opacity: 0.5;
      }
      20% {
        transform: scale(25, 25);
        opacity: 0.3;
      }
      100% {
        opacity: 0;
        transform: scale(40, 40);
      }
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
      box-shadow: 0 6px 20px rgba(37, 29, 160, 0.3);
    }

    .btn-primary:hover {
      background: linear-gradient(135deg, var(--primary-dark), #1a1770);
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(37, 29, 160, 0.4);
    }
    
    .btn-primary:disabled {
      background: #6c757d;
      cursor: not-allowed;
      transform: none;
      box-shadow: none;
    }

    .btn-danger {
      background: linear-gradient(135deg, var(--danger-color), #c82333);
      box-shadow: 0 6px 20px rgba(220, 53, 69, 0.3);
    }

    .btn-danger:hover {
      background: linear-gradient(135deg, #c82333, #a71d2a);
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(220, 53, 69, 0.4);
    }

    .form-footer {
      text-align: center;
      margin-top: 30px;
      padding-top: 20px;
      border-top: 1px solid #eee;
      color: var(--secondary-color);
    }
    
    .form-footer a {
      color: var(--primary-color);
      font-weight: 500;
      text-decoration: none;
      transition: color 0.3s ease;
    }
    
    .form-footer a:hover {
      color: var(--primary-dark);
      text-decoration: underline;
    }
    
    .floating {
      animation: floating 6s ease-in-out infinite;
    }
    
    @keyframes floating {
      0% { transform: translateY(0px); }
      50% { transform: translateY(-15px); }
      100% { transform: translateY(0px); }
    }

    .shake-animation {
      animation: shake 0.5s ease-in-out;
    }
    
    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
      20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
    
    .digit-hint {
      display: inline-block;
      width: 20px;
      text-align: center;
      font-weight: bold;
      color: var(--primary-color);
    }

    @media (max-width: 576px) {
      .auth-form-light {
        padding: 30px 20px !important;
      }
      
      .registration-title {
        font-size: 1.5rem;
      }
      
      .btn {
        padding: 14px;
        font-size: 1rem;
      }
      
      .validation-icon {
        right: 45px;
      }
    }
  </style>
</head>

<body>
  <div class="registration-container">
    <div class="auth-form-light text-left py-5 px-4 px-sm-5 floating">
      <div class="brand-logo">
        <img src="main/img/logo_jakarta.png" alt="logo RW 12">
        <div class="titleLogo">RT 003 RW 006</div>
      </div>
      
      <h2 class="registration-title">Daftar Akun Pemohon</h2>
      <p class="registration-subtitle">Isi formulir di bawah untuk membuat akun baru</p>
      
      <form method="POST" id="registrationForm" class="pt-2">
        <!-- Data Pribadi -->
        <div class="form-group">
          <label class="form-label" for="nik">NIK</label>
          <input type="text" name="nik" id="nik" class="form-control form-control-lg" 
                 placeholder="Masukkan 16 digit NIK" 
                 oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" 
                 maxlength="16" required autofocus>
          <div class="input-icon">
            <i class="mdi mdi-identifier"></i>
          </div>
          <small class="text-muted d-block mt-1">Masukkan 16 digit NIK tanpa spasi</small>
        </div>
        
        <div class="form-group">
          <label class="form-label" for="nama">Nama Lengkap</label>
          <input type="text" name="nama" id="nama" class="form-control form-control-lg" 
                 placeholder="Masukkan nama lengkap sesuai KTP" required>
          <div class="input-icon">
            <i class="mdi mdi-account"></i>
          </div>
        </div>
        
        <!-- Akun -->
        <div class="form-group">
          <label class="form-label" for="password">Password</label>
          <input type="password" name="password" id="password" class="form-control form-control-lg" 
                 placeholder="Buat password anda" required>
          <div class="input-icon">
            <i class="mdi mdi-lock"></i>
          </div>
        </div>
        
        <div class="form-group">
          <label class="form-label" for="confirmPassword">Konfirmasi Password</label>
          <input type="password" id="confirmPassword" class="form-control form-control-lg" 
                 placeholder="Ulangi password Anda" required>
          <div class="input-icon">
            <i class="mdi mdi-lock-check"></i>
          </div>
          <div id="passwordMatch" class="mt-2" style="font-size: 0.9rem;"></div>
        </div>
        
        <div class="mt-4">
          <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="register" id="submitBtn">
            <i class="mdi mdi-account-plus mr-2"></i> DAFTAR AKUN
          </button>
        </div>
        
        <div class="mt-3">
          <a class="btn btn-block btn-danger btn-lg font-weight-medium auth-form-btn" href="index.php">
            <i class="mdi mdi-close-circle mr-2"></i> BATAL
          </a>
        </div>
        
        <div class="form-footer">
          Sudah memiliki akun? <a href="login.php" class="text-primary">Masuk di sini</a>
        </div>
      </form>
    </div>
  </div>

  <?php
  if (isset($_POST['register'])) {
    $nik = mysqli_real_escape_string($konek, $_POST['nik']);
    $password = mysqli_real_escape_string($konek, $_POST['password']);
    $hak_akses = "Pemohon";
    $nama = mysqli_real_escape_string($konek, $_POST['nama']);

    // Validasi NIK (16 digit)
    if (strlen($nik) != 16 || !is_numeric($nik)) {
      echo "<script language='javascript'>swal('Error...', 'NIK harus 16 digit angka!', 'error');</script>";
      echo '<meta http-equiv="refresh" content="3; url=register.php">';
      exit;
    }

    // Cek apakah NIK sudah terdaftar
    $check_nik = "SELECT * FROM data_user WHERE nik = '$nik'";
    $result_check = mysqli_query($konek, $check_nik);
    
    if (mysqli_num_rows($result_check) > 0) {
      echo "<script language='javascript'>swal('Error...', 'NIK sudah terdaftar!', 'error');</script>";
      echo '<meta http-equiv="refresh" content="3; url=register.php">';
    } else {
      $sql_simpan = "INSERT INTO data_user (nik, password, hak_akses, nama) 
                     VALUES ('$nik', '$password', '$hak_akses', '$nama')";
      $query_simpan = mysqli_query($konek, $sql_simpan);

      if ($query_simpan) {
        echo "<script language='javascript'>swal('Sukses!', 'Akun berhasil dibuat!', 'success');</script>";
        echo '<meta http-equiv="refresh" content="3; url=login.php">';
      } else {
        echo "<script language='javascript'>swal('Gagal...', 'Terjadi kesalahan sistem!', 'error');</script>";
        echo '<meta http-equiv="refresh" content="3; url=register.php">';
      }
    }
  }
  ?>

  <!-- JS Libraries -->
  <script src="main/vendors/base/vendor.bundle.base.js"></script>
  <script src="main/js/off-canvas.js"></script>
  <script src="main/js/hoverable-collapse.js"></script>
  <script src="main/js/template.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  <script>
    $(document).ready(function() {
      // Validasi NIK hanya angka
      $('#nik').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length === 16) {
          $(this).removeClass('shake-animation');
          setTimeout(() => $(this).addClass('shake-animation'), 10);
        }
      });
      
      // Confirm password validation
      $('#confirmPassword').on('keyup', function() {
        var password = $('#password').val();
        var confirmPassword = $(this).val();
        var matchText = $('#passwordMatch');
        
        if (confirmPassword === '') {
          matchText.html('');
        } else if (password === confirmPassword) {
          matchText.html('<span style="color: #28a745;"><i class="mdi mdi-check-circle"></i> Password cocok</span>');
        } else {
          matchText.html('<span style="color: #dc3545;"><i class="mdi mdi-alert-circle"></i> Password tidak cocok</span>');
        }
        checkFormValidity();
      });
      
      // Cek validitas seluruh form
      function checkFormValidity() {
        var rtValid = $('#rt').val().length === 2;
        var rwValid = $('#rw').val().length === 2;
        var passwordMatch = $('#password').val() === $('#confirmPassword').val() && $('#password').val() !== '';
        
        // Cek apakah semua field terisi
        var nikFilled = $('#nik').val().trim() !== '';
        var namaFilled = $('#nama').val().trim() !== '';
        var passwordFilled = $('#password').val() !== '';
        var confirmPasswordFilled = $('#confirmPassword').val() !== '';
        
        // Enable/disable tombol submit
        if (rtValid && rwValid && passwordMatch && nikFilled && namaFilled && passwordFilled && confirmPasswordFilled) {
          $('#submitBtn').prop('disabled', false);
        } else {
          $('#submitBtn').prop('disabled', true);
        }
      }
      
      // Form submission validation
      $('#registrationForm').on('submit', function(e) {
        var password = $('#password').val();
        var confirmPassword = $('#confirmPassword').val();
        var rtValue = $('#rt').val();
        var rwValue = $('#rw').val();
        
        // Validasi password
        if (password !== confirmPassword) {
          e.preventDefault();
          $('#confirmPassword').addClass('shake-animation');
          setTimeout(() => $('#confirmPassword').removeClass('shake-animation'), 500);
          swal('Error!', 'Password dan konfirmasi password tidak cocok!', 'error');
          return false;
        }
        
        // Validasi NIK
        var nikValue = $('#nik').val();
        if (nikValue.length !== 16 || !/^\d{16}$/.test(nikValue)) {
          e.preventDefault();
          $('#nik').addClass('shake-animation');
          setTimeout(() => $('#nik').removeClass('shake-animation'), 500);
          swal('Error!', 'NIK harus 16 digit angka!', 'error');
          return false;
        }
        
        return true;
      });
      
      // Smooth animations
      $('.auth-form-light').css('opacity', '0').animate({opacity: 1}, 800);
      
      // Button hover effects
      $('.btn').on('mouseenter', function() {
        if (!$(this).prop('disabled')) {
          $(this).css('transform', 'translateY(-3px)');
        }
      }).on('mouseleave', function() {
        $(this).css('transform', 'translateY(0)');
      });
      
      // Cek validitas form saat halaman dimuat
      checkFormValidity();
      
      // Validasi saat semua field berubah
      $('#nik, #nama, #password, #confirmPassword').on('input keyup change', function() {
        checkFormValidity();
      });
    });
  </script>
</body>

</html>