<?php
session_start();
include 'konek.php';
$level = "pemohon";

// profil
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem E-Surat Online RW 012 - Permudah urusan administrasi surat menyurat">
    <meta name="author" content="RW 012">
    <title>RT 003 RW 006</title>
    <!-- core CSS -->
    <link href="main/css/bootstrap.min.css" rel="stylesheet">
    <link href="main/css/font-awesome.min.css" rel="stylesheet">
    <link href="main/css/animate.min.css" rel="stylesheet">
    <link href="main/css/owl.carousel.css" rel="stylesheet">
    <link href="main/css/owl.transitions.css" rel="stylesheet">
    <link href="main/css/prettyPhoto.css" rel="stylesheet">
    <link href="main/css/main.css" rel="stylesheet">
    <link href="main/css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Protest+Riot&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0e6dbbff;
            --primary-dark: #c0392b;
            --secondary-color: #2c3e50;
            --accent-color: #3498db;
            --light-color: #f9f9f9;
            --dark-color: #242a33;
            --gray-light: #f5f7fa;
            --text-color: #333;
            --text-light: #6c757d;
            --border-radius: 8px;
            --box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            color: var(--text-color);
            line-height: 1.6;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 0.5rem;
        }

        p {
            margin-bottom: 1rem;
        }

        a {
            text-decoration: none;
            transition: var(--transition);
        }

        .container {
            max-width: 1140px;
        }

        /* Hero Section */
        #cta2 {
            background: linear-gradient(rgba(36, 42, 51, 0.85), rgba(36, 42, 51, 0.85)), url(demo1/img/sliderdepok.jpg) no-repeat center center;
            background-size: cover;
            color: #fff;
            padding: 150px 0 100px;
            position: relative;
            display: flex;
            align-items: center;
            min-height: 100vh;
        }

        .hero-content {
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }

        .titleLogo {
            font-family: 'Protest Riot', cursive;
            font-size: 2.5rem;
            color: var(--primary-color);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        /* Navigation */
        .navbar {
            background-color: rgba(255, 255, 255, 0.98);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
            padding: 15px 0;
        }

        .navbar.navbar-scrolled {
            padding: 10px 0;
            background-color: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--secondary-color) !important;
            display: flex;
            align-items: center;
        }

        .navbar-nav>li>a {
            color: var(--secondary-color) !important;
            font-weight: 500;
            padding: 10px 15px !important;
            transition: var(--transition);
            position: relative;
        }

        .navbar-nav>li>a:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 15px;
            right: 15px;
            height: 2px;
            background-color: var(--primary-color);
            transform: scaleX(0);
            transition: var(--transition);
        }

        .navbar-nav>li>a:hover,
        .navbar-nav>li>a.active {
            color: var(--primary-color) !important;
        }

        .navbar-nav>li>a:hover:after,
        .navbar-nav>li>a.active:after {
            transform: scaleX(1);
        }

        /* Buttons */
        .btn-primary-custom {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 600;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(71, 136, 219, 0.4);
            display: inline-block;
            text-align: center;
        }

        .btn-primary-custom:hover {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(71, 136, 219, 0.4);
            color: white;
        }

        .btn-secondary-custom {
            background-color: transparent;
            border: 2px solid white;
            color: white;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 600;
            transition: var(--transition);
            display: inline-block;
            text-align: center;
        }

        .btn-secondary-custom:hover {
            background-color: white;
            color: var(--dark-color);
            transform: translateY(-3px);
        }

        /* Section Styling */
        .section-header {
            margin-bottom: 60px;
            text-align: center;
        }

        .section-header h2 {
            color: var(--secondary-color);
            font-weight: 700;
            margin-bottom: 15px;
            position: relative;
            padding-bottom: 15px;
        }

        .section-header h2:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background-color: var(--primary-color);
        }

        .section-header p {
            color: var(--text-light);
            max-width: 600px;
            margin: 0 auto;
        }

        section {
            padding: 80px 0;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            overflow: hidden;
            height: 100%;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .announcement-card {
            transition: var(--transition);
            border-left: 4px solid var(--primary-color);
        }

        .announcement-card:hover {
            border-left-color: var(--accent-color);
        }

        .announcement-img {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: var(--secondary-color);
        }

        .card-text {
            color: var(--text-light);
            margin-bottom: 1rem;
        }

        /* Service Box */
        .service-box {
            padding: 30px 20px;
            border-radius: var(--border-radius);
            background-color: white;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            height: 100%;
            display: flex;
            align-items: flex-start;
        }

        .service-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .service-box .pull-left {
            margin-right: 20px;
            flex-shrink: 0;
        }

        .step-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .media-body h4 {
            color: var(--secondary-color);
            margin-bottom: 10px;
        }

        /* Features */
        .feature-box {
            text-align: center;
            padding: 30px 20px;
        }

        .feature-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 20px;
            display: inline-block;
        }

        .feature-box h4 {
            color: var(--secondary-color);
            margin-bottom: 15px;
        }

        .feature-box p {
            color: var(--text-light);
        }

        /* Footer */
        footer {
            background-color: var(--secondary-color);
            color: white;
            padding: 60px 0 30px;
        }

        .footer-logo {
            font-family: 'Protest Riot', cursive;
            font-size: 1.8rem;
            color: var(--primary-color);
            margin-bottom: 20px;
            display: inline-block;
        }

        .footer-about {
            margin-bottom: 30px;
        }

        .footer-links h5,
        .footer-contact h5 {
            color: white;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-links h5:after,
        .footer-contact h5:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background-color: var(--primary-color);
        }

        .footer-links ul {
            list-style: none;
            padding: 0;
        }

        .footer-links ul li {
            margin-bottom: 10px;
        }

        .footer-links ul li a {
            color: rgba(255, 255, 255, 0.7);
            transition: var(--transition);
        }

        .footer-links ul li a:hover {
            color: var(--primary-color);
            padding-left: 5px;
        }

        .footer-contact p {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
        }

        .footer-contact i {
            margin-right: 10px;
            color: var(--primary-color);
            width: 20px;
        }

        .social-icons {
            display: flex;
            list-style: none;
            padding: 0;
            margin-top: 20px;
        }

        .social-icons li {
            margin-right: 10px;
        }

        .social-icons li a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            transition: var(--transition);
        }

        .social-icons li a:hover {
            background-color: var(--primary-color);
            transform: translateY(-3px);
        }

        .copyright {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
            margin-top: 40px;
            text-align: center;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.9rem;
        }

        /* Animations */
        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0% {
                transform: translate(0, 0px);
            }

            50% {
                transform: translate(0, 15px);
            }

            100% {
                transform: translate(0, -0px);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-content h2 {
                font-size: 2rem;
            }

            .hero-content h4 {
                font-size: 1rem;
            }

            .navbar-brand {
                font-size: 1.2rem;
            }

            section {
                padding: 60px 0;
            }

            .service-box {
                flex-direction: column;
                text-align: center;
            }

            .service-box .pull-left {
                margin-right: 0;
                margin-bottom: 15px;
            }

            .footer-links,
            .footer-contact {
                margin-bottom: 30px;
            }
        }

        /* Modal */
        .modal-content {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            border-bottom: 1px solid #eee;
            padding: 1.5rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            border-top: 1px solid #eee;
            padding: 1rem 1.5rem;
        }

        /* Map */
        #contact {
            margin-bottom: -7px;
            /* Remove gap between map and footer */
        }

        #contact iframe {
            display: block;
        }
    </style>
</head>

<body id="home" class="homepage">

    <header id="header">
        <nav id="main-menu" class="navbar navbar-default navbar-fixed-top" role="banner">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a class="navbar-brand" href="index.php">
                        <span class="titleLogo">E-Surat RT 03 RW 06</span>
                    </a>
                </div>

                <div class="collapse navbar-collapse navbar-right">
                    <ul class="nav navbar-nav">
                        <li class="scroll active"><a href="#home">Beranda</a></li>
                        <li class="scroll"><a href="#meet-team">Pengumuman</a></li>
                        <li class="scroll"><a href="#services">Prosedur</a></li>
                        <li class="scroll"><a href="login.php" class="btn btn-sm btn-primary-custom" style="padding: 8px 20px; margin-top: 5px; margin-left: 10px;">Daftar/Login</a></li>
                    </ul>
                </div>
            </div>
            <!--/.container-->
        </nav>
        <!--/nav-->
    </header>
    <!--/header-->

    <section id="cta2">
        <div class="container">
            <div class="hero-content">
                <div class="wow fadeInUp" data-wow-duration="300ms" data-wow-delay="0ms">
                    <img src="main/img/logo_jakarta.png" width="150px" class="floating" alt="Logo E-Surat RW 012">
                </div>
                <h2 class="wow fadeInUp" data-wow-duration="300ms" data-wow-delay="100ms">
                    Pelayanan Administrasi Surat Menyurat Online
                </h2>
                <h4 class="wow fadeInUp" style="color:white;" data-wow-duration="300ms" data-wow-delay="200ms">
                    Permudah urusan administrasi Anda dengan layanan surat online RT 03 RW 06
                </h4>
                <div class="wow fadeInUp" data-wow-duration="300ms" data-wow-delay="300ms" style="margin-top: 30px;">
                    <a href="login.php" class="btn btn-primary-custom">Login</a>
                    <a href="register.php" class="btn btn-secondary-custom">Daftar</a>
                </div>
            </div>
        </div>
    </section>

    <section id="meet-team">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title wow fadeInDown">Pengumuman</h2>
                <p class="wow fadeInDown" data-wow-delay="100ms">Informasi terkini dari RW 06 untuk warga</p>
            </div>

            <div class="row">
                <?php
                $query = mysqli_query($konek, "SELECT * FROM pengumuman ORDER BY id_pengumuman DESC LIMIT 4");
                while ($data = mysqli_fetch_array($query)) {
                ?>
                    <div class="col-md-6 col-sm-6 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="0ms">
                        <div class="card announcement-card mb-4">
                            <img class="card-img-top announcement-img" src="dataFoto/pengumuman/<?= $data['poto']; ?>" alt="<?= $data['judul']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= $data['judul']; ?></h5>
                                <p class="card-text"><?= substr($data['isi'], 0, 100); ?>...</p>
                                <a href="#" class="btn btn-primary-custom" data-toggle="modal" data-target="#exampleModal<?= $data['id_pengumuman']; ?>">Selengkapnya</a>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal<?= $data['id_pengumuman']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><?= $data['judul']; ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <center>
                                        <img src="dataFoto/pengumuman/<?= $data['poto']; ?>" class="img-fluid mb-3" alt="<?= $data['judul']; ?>">
                                    </center>
                                    <p><?= nl2br($data['isi']); ?></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>

    <section id="services" style="background-color: var(--gray-light);">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title wow fadeInDown">Prosedur Permohonan Surat</h2>
                <p class="wow fadeInDown" data-wow-delay="100ms">Ikuti langkah-langkah berikut untuk mengajukan surat secara online</p>
            </div>

            <div class="row">
                <div class="col-md-6 col-sm-6 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="0ms">
                    <div class="media service-box">
                        <div class="pull-left">
                            <div class="step-number">1</div>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Login / Daftar</h4>
                            <p>Pemohon melakukan login atau mendaftar terlebih dahulu melalui halaman Login/Daftar.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-6 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="100ms">
                    <div class="media service-box">
                        <div class="pull-left">
                            <div class="step-number">2</div>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Mengisi Data Diri</h4>
                            <p>Lengkapi data pemohon dengan benar dan sesuai dengan dokumen identitas yang dimiliki.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-6 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="200ms">
                    <div class="media service-box">
                        <div class="pull-left">
                            <div class="step-number">3</div>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Mengajukan Permohonan Surat</h4>
                            <p>Pilih jenis surat yang diperlukan, lengkapi data permohonan, kemudian kirim permohonan.</p>
                        </div>
                    </div>
                </div>


                <div class="col-md-6 col-sm-6 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="300ms">
                    <div class="media service-box">
                        <div class="pull-left">
                            <div class="step-number">4</div>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Mencetak Surat</h4>
                            <p>Setelah disetujui, cetak surat kemudian membawa surat kerumah RT dan RW untuk di tandatangani.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-4 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="0ms">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fa fa-clock-o"></i>
                        </div>
                        <h4>Proses Cepat</h4>
                        <p>Pengajuan surat diproses dengan cepat dan efisien</p>
                    </div>
                </div>
                <div class="col-md-4 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="100ms">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fa fa-lock"></i>
                        </div>
                        <h4>Aman & Terpercaya</h4>
                        <p>Data Anda terlindungi dengan sistem keamanan terbaik</p>
                    </div>
                </div>
                <div class="col-md-4 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="200ms">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fa fa-mobile"></i>
                        </div>
                        <h4>Akses Mudah</h4>
                        <p>Dapat diakses kapan saja dan di mana saja</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <a href="index.php" class="footer-logo">E-Surat RT 03 RW 06</a>
                    <div class="footer-about">
                        <p>Sistem E-Surat Online RT 03 RW 06 memudahkan warga dalam mengurus administrasi surat menyurat secara digital dengan proses yang cepat dan efisien.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="footer-contact">
                        <h5>Kontak Kami</h5>

                        <p><strong>RT 03</strong></p>
                        <p><i class="fa fa-map-marker"></i> Mohammad Kahfi 1 Gg.Keranji RT 03/06 Kel.Ciganjur Kec. Jagakarsa Jakarta Selatan</p>
                        <p><i class="fa fa-phone"></i> (021) 1234-5678</p>
                        <p><i class="fa fa-envelope"></i> info@rt03_ciganjur.com</p>

                        <p><strong>RW 06</strong></p>
                        <p><i class="fa fa-map-marker"></i> Mohammad Kahfi 1 Gg.Keranji RT 03/06 Kel.Ciganjur Kec. Jagakarsa Jakarta Selatan</p>
                        <p><i class="fa fa-phone"></i> (021) 1234-5678</p>
                        <p><i class="fa fa-envelope"></i> info@rw06_ciganjur.com</p>
                    </div>
                    <ul class="social-icons">
                        <li><a href="#" target="_blank"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="#" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#" target="_blank"><i class="fa fa-youtube"></i></a></li>
                        <li><a href="#" target="_blank"><i class="fa fa-github"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; <?php echo date('Y'); ?> E-Surat RT 03 RW 06. Semua Hak Dilindungi.</p>
            </div>
        </div>
    </footer>

    <script src="main/js/jquery.js"></script>
    <script src="main/js/bootstrap.min.js"></script>
    <script src="http://maps.google.com/maps/api/js?sensor=true"></script>
    <script src="main/js/owl.carousel.min.js"></script>
    <script src="main/js/mousescroll.js"></script>
    <script src="main/js/smoothscroll.js"></script>
    <script src="main/js/jquery.prettyPhoto.js"></script>
    <script src="main/js/jquery.isotope.min.js"></script>
    <script src="main/js/jquery.inview.min.js"></script>
    <script src="main/js/wow.min.js"></script>
    <script src="main/js/main.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Swal -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.15.2/dist/sweetalert2.all.min.js"></script>
    <!-- Optional: include a polyfill for ES6 Promises for IE11 -->
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>

    <script>
        // Navbar scroll effect
        $(window).scroll(function() {
            if ($(this).scrollTop() > 50) {
                $('.navbar').addClass('navbar-scrolled');
            } else {
                $('.navbar').removeClass('navbar-scrolled');
            }
        });

        // Smooth scrolling for anchor links
        $('a.scroll').on('click', function(e) {
            e.preventDefault();

            var target = this.hash;
            var $target = $(target);

            $('html, body').stop().animate({
                'scrollTop': $target.offset().top - 70
            }, 900, 'swing', function() {
                window.location.hash = target;
            });
        });

        // Update active nav link on scroll
        $(window).scroll(function() {
            var scrollDistance = $(window).scrollTop() + 80;

            $('section').each(function(i) {
                if ($(this).position().top <= scrollDistance) {
                    $('.nav li.active').removeClass('active');
                    $('.nav li').eq(i).addClass('active');
                }
            });
        }).scroll();

        // Initialize WOW.js for animations
        new WOW().init();
    </script>
</body>

</html>