<?php

	//trae el lvl de usuario
	$lvlusr = $_SESSION['nivel'];
	//muestra errores en pantalla si usuario es lvl administrador
	if ($lvlusr == 3){
		error_reporting(0);
	}
	$id_usuario = $_SESSION['id_usuario'];
	//trae array con los nombres de distintos Menu
	$arraymenu = itemsmenu($id_usuario,$mysqli);
	// Array limpio
	$MenuArr = [];

	// Menú de nivel 3 (Usuario normal)
	$MenuArr[3] = [
            "Inicio" => [
                "Icono" => "nav-icon fas fa-home",
                "Seccion" => "Inicio",
                "Archivo" => "404.php",
            ],

            "Carpetas" => [
                "Icono" => "nav-icon fas fa-atlas",
                "Tipo" => "Sub-menu",
                "Menu" => [
                    "$arraymenu[0]" => [
                        "Icono" => "nav-icon fa fa-caret-right",
                        "Seccion" => "carpeta&core=1",
                        "Archivo" => "m1/inicio.php",
                    ],
                    
                    "$arraymenu[1]" => [
                        "Icono" => "nav-icon fa fa-caret-right",
                        "Seccion" => "carpeta&core=2",
                        "Archivo" => "m1/inicio.php",
                    ],
					"$arraymenu[2]" => [
                        "Icono" => "nav-icon fa fa-caret-right",
                        "Seccion" => "carpeta&core=3",
                        "Archivo" => "m1/inicio.php",
                    ],
					"$arraymenu[3]" => [
                        "Icono" => "nav-icon fa fa-caret-right",
                        "Seccion" => "carpeta&core=4",
                        "Archivo" => "m1/inicio.php",
                    ],
					"$arraymenu[4]" => [
                        "Icono" => "nav-icon fa fa-caret-right",
                        "Seccion" => "carpeta&core=5",
                        "Archivo" => "m1/inicio.php",
                    ],
					"$arraymenu[5]" => [
                        "Icono" => "nav-icon fa fa-caret-right",
                        "Seccion" => "carpeta&core=6",
                        "Archivo" => "m1/inicio.php",
                    ],
					"$arraymenu[6]" => [
                        "Icono" => "nav-icon fa fa-caret-right",
                        "Seccion" => "carpeta&core=7",
                        "Archivo" => "m1/inicio.php",
                    ],
					"$arraymenu[7]" => [
                        "Icono" => "nav-icon fa fa-caret-right",
                        "Seccion" => "carpeta&core=8",
                        "Archivo" => "m1/inicio.php",
                    ],
					"$arraymenu[8]" => [
                        "Icono" => "nav-icon fa fa-caret-right",
                        "Seccion" => "carpeta&core=9",
                        "Archivo" => "m1/inicio.php",
                    ],
					"$arraymenu[9]" => [
                        "Icono" => "nav-icon fa fa-caret-right",
                        "Seccion" => "carpeta&core=10",
                        "Archivo" => "m1/inicio.php",
                    ],
					"$arraymenu[10]" => [
                        "Icono" => "nav-icon fa fa-caret-right",
                        "Seccion" => "carpeta&core=11",
                        "Archivo" => "m1/inicio.php",
                    ],
					"$arraymenu[11]" => [
                        "Icono" => "nav-icon fa fa-caret-right",
                        "Seccion" => "carpeta&core=12",
                        "Archivo" => "m1/inicio.php",
                    ],
					"$arraymenu[12]" => [
                        "Icono" => "nav-icon fa fa-caret-right",
                        "Seccion" => "carpeta&core=13",
                        "Archivo" => "m1/inicio.php",
                    ],
					"$arraymenu[13]" => [
                        "Icono" => "nav-icon fa fa-caret-right",
                        "Seccion" => "carpeta&core=14",
                        "Archivo" => "m1/inicio.php",
                    ],
					"$arraymenu[14]" => [
                        "Icono" => "nav-icon fa fa-caret-right",
                        "Seccion" => "carpeta&core=15",
                        "Archivo" => "m1/inicio.php",
                    ],
                ],
            ],
			"Crear Carpetas" => [
                "Icono" => "nav-icon fa fa-cogs",
                "Seccion" => "CrearCarpeta",
                "Archivo" => "crear/crearc.php",
            ],
    ];
// Clase del menú
	class Menu {
		// Propiedades
		var $ArrayLst;
		var $Seccion;
		var $Archivo;

		// Constructor
		function __construct($ArrayLst) {
			$this->ArrayLst = $ArrayLst;
			
			if (!isset($_GET['Seccion'])) {
				$this->Seccion = "";
			} else {
				$this->Seccion = $_GET['Seccion'];
			}
		}

		/////////////
		// MÉTODOS //
		/////////////
		
		// Crear un item nuevo en el menú
		function crearItem($SubArray, $Key) {
			echo
			'<li class="nav-item">'.
				'<a href="'.(null == $SubArray['Seccion'] ? '#': '?Seccion='.$SubArray['Seccion']).'" class="nav-link '.(isset($SubArray['Activo']) ? 'active': '').'">'.
					(null == $SubArray['Icono'] ? '': '<i class="'.$SubArray['Icono'].'"></i>').
					'<p>'.$Key.'</p>'.
				'</a>
			</li>';
		}

		function crearSubMenu($SubArray, $Key) {
			echo
			'<li class="nav-item has-treeview '.(isset($SubArray['Activo']) ? 'menu-open': '').'">
				<a href="#" class="nav-link '.(isset($SubArray['Activo']) ? 'active': '').'">'.
					(null == $SubArray['Icono'] ? '': '<i class="'.$SubArray['Icono'].'"></i>').'
					<p>
						'.$Key.'
						<i class="right fas fa-angle-left"></i>
					</p>
				</a>

				<ul class="nav nav-treeview">';
		}

		// Crear un separador con texto
		function crearSeparador($SubArray, $Key) {
			echo '<li class="nav-header">'.$Key.'</li>';
		}
		
		function obtenerArchivo() {
			return $this->Archivo;
		}

		// Crea el menú completo mediante el array entregado
		function crearMenu() {
			// Primer foreach para marcar como activos los menús y los archivos de cada uno
			foreach ($this->ArrayLst as $Key => $Valor) {
				// Chequea si hay un tipo
				if (isset($Valor['Tipo'])) {
					if ($Valor['Tipo'] == "Sub-menu") {
						foreach ($Valor['Menu'] as $SubKey => $SubMenu) {
							if (null !== $SubMenu['Seccion'] && $SubMenu['Seccion'] == $this->Seccion) {
								$this->ArrayLst[$Key]['Menu'][$SubKey]['Activo'] = true;
								$this->ArrayLst[$Key]['Activo'] = true;
								$this->Archivo = $SubMenu['Archivo'];
							}
						}
					}
				} else {
					if (null !== $Valor['Seccion'] && $Valor['Seccion'] == $this->Seccion) {
						$this->ArrayLst[$Key]['Activo'] = true;
						
						if (null !== $Valor['Archivo']) {
							$this->Archivo = $Valor['Archivo'];
						}
					}
				}
			}

			// Segundo foreach, para crear el menú
			foreach ($this->ArrayLst as $Key => $Valor) {
					// Chequea si hay un tipo
					if (isset($Valor['Tipo'])) {
						if ($Valor['Tipo'] == "Sub-menu") {
							$this->crearSubMenu($Valor, $Key);
							foreach ($Valor['Menu'] as $SubKey => $SubMenu) {
								if (null == $SubKey){
								}else{
									$this->crearItem($SubMenu, $SubKey);
								}
							}
							echo '</ul> </li>';
						}
						// Funcionamiento de los separadores
						elseif ($Valor['Tipo'] == "Separador") {
							$this->crearSeparador($Valor, $Key);
						}
					} else {
						$this->crearItem($Valor, $Key);
					}
			}
		}
	}
	
	// Incluye las secciones aparte del menú
	include "Secciones.php";
?>


<?php
	//ob_start();
?>
<?php
	//isLogged();

	//$nombre = nombre($_SESSION['id_usuario'],$mysqli);
?>
<?php
setlocale(LC_CTYPE, 'es');
date_default_timezone_set('America/Argentina/Buenos_Aires');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
  <title>Menu</title>
  <link rel="shortcut icon" href="Media/favicon.ico" type="image/x-icon">
	<link rel="icon" href="Media/favicon.ico" type="image/x-icon">
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- JQVMap -->
	<link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="dist/css/adminlte.min.css">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
	<!-- summernote -->
	<link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<!-- Librería jQuery -->
	<script src="librerias/jQuery.js"></script>
	<!-- Librería jQuery - maskedinput -->
	<script src="librerias/jquery.maskedinput.js"></script>
	<!-- Librería Notiflix -->
	<link rel="stylesheet" href="librerias/Notiflix/notiflix-2.6.0.min.css" />
	<script src="librerias/Notiflix/notiflix-2.6.0.min.js"></script>	
	<!-- Librería SHA512 -->
	<script src="librerias/sha512.js"></script>
	<!-- Librería CropperJS -->
	<link  href="librerias/CropperJS/cropper.css" rel="stylesheet">
	<script src="librerias/CropperJS/cropper.js"></script>
	<!-- Librería PSWmeter -->
	<script src="librerias/pswmeter.min.js"></script>	
	<!-- Bootstrap -->
	<link href="librerias/Bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
	<!-- Owl Carousel -->
    <link href="librerias/OwlCarousel/owl.carousel.css" rel="stylesheet" type="text/css"/>
    <link href="librerias/OwlCarousel/owl.theme.default.css" rel="stylesheet" type="text/css"/>
	<!-- Modernizr JS -->
	<script src="librerias/modernizr-3.5.0.min.js"></script>	
	<!-- SweetAlert 2 -->
	<script src="librerias/sweetalert2.all.min.js"></script>	
	<!-- Librería Moment -->
	<script src="plugins/moment/moment-with-locales.min.js"></script>
	<link rel="stylesheet" href="librerias/flatpickr.min.css">
	<script src="librerias/flatpickr.min.js"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed single">
	<div class="wrapper">

		<!-- Navbar -->
		<nav class="main-header navbar navbar-expand navbar-white navbar-light">
			<!-- Left navbar links -->
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
				</li>
				<li class="nav-item d-none d-sm-inline-block">
					<a href="#" class="nav-link">Pagina de Prueba</a>
				</li>
			</ul>
		</nav>
		<!-- /.navbar -->

		<!-- Main Sidebar Container -->
		<aside class="main-sidebar sidebar-dark-primary elevation-4">
			<!-- Brand Logo -->
			<a href="#" class="brand-link">
						<?php 
                    	if (file_exists("Perfil/".$ID.".jpeg")) {
							echo '<img src="Perfil/'.$ID.'.jpeg?='.filemtime("Perfil/".$ID.".jpeg").'" alt="" class="brand-image img-circle elevation-3" style="opacity: .8" >';
						} else {
						    echo '<img src="dist/img/logo.jpg" alt="" class="brand-image img-circle elevation-3" style="opacity: .8">';
						}
						?>
				
				<span class="brand-text font-weight-light">User Ver. 1.0.0</span>		   
			</a>

			<!-- Sidebar -->
			<div class="sidebar">
				<!-- Sidebar Menu -->
				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
					<!-- Add icons to the links using the .nav-icon class
					with font-awesome or any other icon font library -->
					<?php
						$nMenu = new Menu($MenuArr[3]);
						$nMenu->crearMenu();
					?>
					
					<li class="nav-item">
						<a href="includes/Logout.php" class="nav-link">
							<i class="nav-icon fas fa-sign-out-alt"></i>
							<p>Cerrar sesión</p>
						</a>
					</li>	
				</nav>
				<!-- /.sidebar-menu -->
			</div>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<?php
				if (isset($_GET['Seccion'])) {
					$Seccion = $_GET['Seccion'];
				}

				if (null == $nMenu->obtenerArchivo() && null !== $Secciones[3][$Seccion]) {
					include './paginas/'.$Secciones[3][$Seccion];
				} elseif (null !== $nMenu->obtenerArchivo()) {
					include './paginas/'.$nMenu->obtenerArchivo();
				} else {
					include './paginas/404.php';
				}
			?>
		</div>
		<!-- /.content-wrapper -->
		<footer class="main-footer">
			Copyright &copy; 2022 <a href="">Pagina de Prueba</a>.
			<div class="float-right d-none d-sm-inline-block">
				<b> Ver.</b> 1.0.0
			</div>
		</footer>
		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
		</aside>
		<!-- /.control-sidebar -->
	</div>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<!-- jQuery -->
	<script src="plugins/jquery/jquery.min.js"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
	$.widget.bridge('uibutton', $.ui.button)
	</script>
	<!-- ChartJS -->
	<script src="plugins/chart.js/Chart.min.js"></script>
	<!-- Sparkline -->
	<script src="plugins/sparklines/sparkline.js"></script>
	<!-- jQuery Knob Chart -->
	<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
	<!-- daterangepicker -->
	<script src="plugins/moment/moment.min.js"></script>
	<script src="plugins/daterangepicker/daterangepicker.js"></script>
	<!-- Summernote -->
	<script src="plugins/summernote/summernote-bs4.min.js"></script>
	<script src="plugins/summernote/lang/summernote-es-ES.min.js"></script>
	<!-- overlayScrollbars -->
	<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
	<!-- AdminLTE App -->
	<script src="dist/js/adminlte.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="dist/js/demo.js"></script>
	
	<script src="librerias/Bootstrap/js/bootstrap.bundle.min.js"></script>
	
	<script src="librerias/bootbox.min.js"></script>
	<!-- DataTables -->
	<script src="plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	
	<script src="librerias/OwlCarousel/owl.carousel.min.js"></script>
</body>
</html>
