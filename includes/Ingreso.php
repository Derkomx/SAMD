<?php
	
	session_start();
	include_once 'MySQL.php';
	include 'functions.php';

	
	if (isset($_POST['CUIL'], $_POST['Clave'])) {
		$cuil = $_POST['CUIL'];
		$password = $_POST['Clave'];
		
		// Intenta iniciar sesión
		if (login($cuil, $password, $mysqli) == true) {
			// Si inicia sesión, se lo envía al index, donde será redirigido a su correspondiente vista
			echo json_encode(array("location" => "deberia funcionar"));
			exit();
		} else {
			// Si no se pudo ingresar a la cuenta, significa que los datos son incorrectos y se da aviso
			echo json_encode(array("error" => "Usuario o Contraseña Incorrectos"));
			exit();
		}
	} else {
		// Si por alguna razón no se procesa el ingreso, se da aviso
		echo json_encode(array("error" => "¡Ocurrió un error inesperado!"));
		exit();
	}
?>