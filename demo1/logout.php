<?php
include "../konek.php";
session_start();
session_destroy();
unset($_SESSION['username']);
header("Location: ../pegawai.php"); // atau login.php tergantung struktur project kamu
exit;
?>
