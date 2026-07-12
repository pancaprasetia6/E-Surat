<?php include '../konek.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Dashboard Pelayanan Surat Keterangan Online Kelurahan Wergu Wetan</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="../assets/img/icon.ico" type="image/x-icon" />

	<!-- Fonts and icons -->
	<script src="../assets/js/plugin/webfont/webfont.min.js"></script>
	<script>
		WebFont.load({
			google: {
				"families": ["Lato:300,400,700,900"]
			},
			custom: {
				"families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
				urls: ['../assets/css/fonts.min.css']
			},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/css/atlantis.min.css">
	<link rel="stylesheet" href="../assets/css/demo.css">
    
    <!-- Custom Color Styles -->
    <style>
        /* Option 1: Gradient Colors */
        .logo-header[data-background-color="blue"] {
            background: linear-gradient(135deg, #8f9baaff 0%, #8f9baaff 100%) !important;
        }
        
        .navbar-header[data-background-color="blue2"] {
            background: linear-gradient(135deg, #8f9baaff  0%, #464f58ff 100%) !important;
        }
        
        /* Option 2: Solid Colors */
        /*
        .logo-header[data-background-color="blue"] {
            background-color: #2E7D32 !important; 
        }
        
        .navbar-header[data-background-color="blue2"] {
            background-color: #FF6D00 !important;
        }
        */
        
        /* Option 3: Professional Blue Tones */
        /*
        .logo-header[data-background-color="blue"] {
            background: linear-gradient(135deg, #1976D2 0%, #0D47A1 100%) !important;
        }
        
        .navbar-header[data-background-color="blue2"] {
            background: linear-gradient(135deg, #42A5F5 0%, #1976D2 100%) !important;
        }
        */
    </style>
</head>

<body>
	<div class="wrapper">
		<div class="main-header">
			<!-- Logo Header -->
			<div class="logo-header" data-background-color="blue">
				<a href="#" class="logo" style="color:white;font-weight:bold;">
					<span>E-Surat</span>
				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i class="icon-menu"></i>
					</span>
				</button>
				<button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
				<div class="nav-toggle">
					<button class="btn btn-toggle toggle-sidebar">
						<i class="icon-menu"></i>
					</button>
				</div>
			</div>
			<!-- End Logo Header -->

			<!-- Navbar Header -->
			<nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">
				<!-- Navbar content -->
			</nav>
			<!-- End Navbar -->
		</div>