<html>
   <head>
		<title>menu</title>

		<link rel="shortcut icon" href="./Media/favicon.ico">
		<link rel="icon" href="./Media/favicon.ico">
		
		<!-- Librería Notiflix -->
		<link rel="stylesheet" href="./librerias/notiflix-2.4.0.min.css" />
		<script src="./librerias/notiflix-2.4.0.min.js"></script>

		<!-- Librería jQuery -->
		<script src="./librerias/jQuery.js"></script>

		<!-- Librería jQuery - maskedinput -->
		<script src="./librerias/jquery.maskedinput.js"></script>

		<!-- Librería SHA512 -->
		<script src="./librerias/sha512.js"></script>

		<link rel="stylesheet" href="./css/solid.min.css" />
		<link rel="stylesheet" href="./css/style.css">

		<link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
	</head>

	<body>
		<div class="login-page">
		<p class="aligncenter">
		<img src="./media/logo.jpg" width="180" height="180" />
		</p>
		<div class="form">

				<p class="login-box-msg">Ingrese su Usuario y Contraseña</p>
				<div class="input-group mb-0">
				<input id="CUIL" name="User" type="text" maxlength="19" class="form-control" placeholder="Usuario" autocomplete="off" onkeypress="return enterKeyPressed(event)"/>
					<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-user"></span>
							</div>
					</div>
				</div>
				<form class="input-group mb-0">
				<input id="Clave" name="Pass" class="form-control" maxlength="19" type="password" placeholder="Ingrese Contraseña" autocomplete="off" onkeypress="return enterKeyPressed(event)"/>
					<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
					</div>
				</form>
				
				<label class="new-checks">Recordar usuario
					<div>
						<input type="checkbox" id="Recordar">
						<span class="checkmark"></span>
					</div>
				</label>
				<button type="submit" onclick="InicioSesion()">Iniciar sesión</button>
				<p></p>
				<div class="tab-custom-content"></div>
				<p class="mb-1">
						<a href="index.php?Enlace=Recuperar" class="link">Olvidé mi clave</a>
				</p>
				
				<p class="mb-0">
				<a href="index.php?Enlace=Registro" class="link">Registrarme</a>
				</p>
				</div>
		</div>
	</body>
	<script src="./scripts/Ingreso.js"></script>
	</html>
