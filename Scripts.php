<html>
   <head>
        <title>Menu</title>

		<!-- Librería jQuery - maskedinput -->
		<script src="librerias/jquery.maskedinput.js"></script>


		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
		
		<!-- Librería Notiflix -->
		<link rel="stylesheet" href="librerias/notiflix-2.4.0.min.css" />
		<script src="librerias/notiflix-2.4.0.min.js"></script>

		<!-- Librería jQuery -->
		<script src="librerias/jQuery.js"></script>

		<!-- Librería SHA512 -->
		<script src="librerias/sha512.js"></script>

		<link rel="stylesheet" href="css/solid.min.css" />
		<link rel="stylesheet" href="css/style.css">

		<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
	</head>

	<body>
		<div class="recover-page" style="display: none;">
			<p class="aligncenter">
				<img src="Media/logo.jpg" width="180" height="180" />
			</p>
			<div class="form">
				<p class="login-box-msg">Ingrese una nueva contraseña</p>
				<div class="input-group mb-0">
					<input id="Clave" name="Clave" type="password" class="form-control" placeholder="Contraseña" autocomplete="off"/>
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-lock"></span>
						</div>
					</div>
				</div>

				<div class="input-group mb-0">
					<input id="CClave" name="CClave" class="form-control" type="password" placeholder="Repita Contraseña" autocomplete="off"/>
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-lock"></span>
						</div>
				</div>
			</div>

			<button type="submit" onclick="Recuperar()">Confirmar</button>
			<p></p>
		</div>
	</body>

	<script>
	Notiflix.Report.Init({
		plainText: false,
		svgSize:"50px",
	});

	// Función para obtener los parametros de la URL actual
	function obtenerParametro(Parametro) {
		var sPaginaURL = window.location.search.substring(1);
		var sURLVariables = sPaginaURL.split('&');

		for (var i = 0; i < sURLVariables.length; i++) {
			var sParametro = sURLVariables[i].split('=');
			if (sParametro[0] == Parametro) {
				return sParametro[1];
			}
		}
		// Si no puede obtener el parametro, retorna null
		return null;
	}

	function Inicio() {
		// Activa la pantalla de carga
		Notiflix.Loading.Circle('Cargando...');

		// Chequea si existen los parametros "Token" o "Recovery"
		if (!obtenerParametro('Token') && !obtenerParametro('Recovery') && !obtenerParametro('cambiarEmail')) {
			document.location = 'index.php';
			return;
		}

		// Activación de una cuenta
		if (obtenerParametro('Token')) {
			$.ajax({
				type: 'POST',
				url: 'Inyector.php',
				data: {Archivo: 'Activacion.php', Token: obtenerParametro('Token')},
				dataType: 'html',
				success: function(data) {
					console.log(data);
					var Resultado = JSON.parse(data);
					Notiflix.Loading.Remove();

					if (Resultado.error) {
						Notiflix.Report.Failure(
							'¡Error!',
							Resultado.error,
							'Aceptar',
							
							function(){
								document.location = "index.php";
							}
						);

						return;
					}

					if (Resultado.success) {
						Notiflix.Report.Success(
							'¡Confirmación éxitosa!',
							'Tu correo electronico ha sido confirmado con éxito, ya puedes iniciar sesión en tu cuenta.',
							'Aceptar',
							
							function(){
								document.location = "index.php";
							}
						)
					}
				},
				
				error: function(data) {
					Notiflix.Report.Failure(
						'¡Ocurrió un problema!',
						'Tu correo electrónico pudo ser confirmado , vuelve a intentar más tarde, si esto persiste, por favor contáctese con soporte.',
						'Aceptar',
						function(){
							document.location = "index.php";
						}
					)
				}
			});

			return;
		}
		
		// Recuperación de una cuenta
		if (obtenerParametro('Recovery')) {
			$.ajax({
				type: 'POST',
				url: 'Inyector.php',
				data: {Archivo: 'Recuperar.php', Recovery: obtenerParametro('Recovery')},
				dataType: 'html',
				success: function(data) {
					console.log(data);
					var Resultado = JSON.parse(data);
					Notiflix.Loading.Remove();

					if (Resultado.error) {
						Notiflix.Report.Failure(
							'¡Error!',
							Resultado.error,
							'Aceptar',
							
							function(){
								document.location = "index.php";
								return;
							}
						);
					}

					if (Resultado.success) {
						document.getElementsByClassName('recover-page')[0].style.display = 'block';
					}
				},
				error: function(data) {
					Notiflix.Report.Failure(
						'¡Ocurrio un Problema!',
						'Tu clave no fue modificada',
						'Aceptar',
						function(){
							document.location = "index.php";
						}
					)
				}
			});

			return;
		}

		// Recuperación de una cuenta
		if (obtenerParametro('cambiarEmail')) {
			$.ajax({
				type: 'POST',
				url: 'Inyector.php',
				data: {Archivo: 'CambiarCorreo.php', Activacion: obtenerParametro('cambiarEmail')},
				dataType: 'html',
				success: function(data) {
					console.log(data);
					var Resultado = JSON.parse(data);
					Notiflix.Loading.Remove();

					if (Resultado.error) {
						Notiflix.Report.Failure(
							'¡Error!',
							Resultado.error,
							'Aceptar',
							
							function(){
								document.location = "index.php";
							}
						);
					}

					if (Resultado.success) {
						Notiflix.Report.Success(
							'¡Éxito!',
							'Tu correo electrónico ha sido actualizado satisfactoriamente.',
							'Aceptar',
							
							function(){
								document.location = "index.php";
							}
						);
					}
				},
				error: function(data) {
					Notiflix.Report.Failure(
						'¡Ocurrio un problema!',
						'Tu correo no fue modificada',
						'Aceptar',
							
						function(){
							document.location = "index.php";
						}
					)
				}
			});
		}
		
		return;
	}

	function Recuperar(){
		var Clave = document.getElementById("Clave").value;
		var Confirmacion = document.getElementById("CClave").value;

		if (Clave.length == 0) {
			Notiflix.Notify.Failure("Debes ingresar una contraseña!");
			return;
		}
		
		if (Confirmacion.length == 0) {
			Notiflix.Notify.Failure("Debes confirmar tu contraseña!");
			return;
		}

        if (Clave == Confirmacion){
			$.ajax({
				type: 'POST',
				url: 'Inyector.php',
				data: {Archivo: 'Recuperar.php', salt: obtenerParametro('Recovery'), Clave: hex_sha512(Clave)},
				dataType: 'html',
				success: function(data) {
					console.log(data);
					var Resultado = JSON.parse(data);
					Notiflix.Loading.Remove();

					if (Resultado.error) {
                   		Notiflix.Report.Failure(
                   			'¡Error!',
                   			Resultado.error,
                   			'Aceptar',
                   		);
                   	}

                   	if (Resultado.success) {
                   		Notiflix.Report.Success(
							'¡Cambio exitoso!',
                   			'Tu contraseña fue modificada con exito!',
                   			'Aceptar',

                   			function(){
                   				document.location = "index.php";
                   			}
                   		)
					}
				},

				error: function(data) {
                   	Notiflix.Report.Failure(
                   		'¡Ocurrio un Problema!',
                   		'Su contraseña no fue modificada',
                   		'Aceptar',
                   		
						function(){
                   			document.location = "index.php";
                   		}
                   	)
				}
			});
		}
	}

	Inicio();
</script>
</html>