<?php
date_default_timezone_set('Asia/Jakarta');

$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'sim-surat';

// Koneksi ke database
$konek = mysqli_connect($hostname, $username, $password, $database);

// Cek koneksi dan tampilkan error jika gagal
if (!$konek) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

$url_index = "http://localhost/web_rw12/";
?>

