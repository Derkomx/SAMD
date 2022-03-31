<?php
	ob_start();

	include_once 'MySQL.php';
	include_once 'Configuracion.php';


	if (isset($_POST['CUIL'], $_POST['Clave'])) {
		$cuil = filter_input(INPUT_POST, 'CUIL', FILTER_SANITIZE_STRING);
		$password = filter_input(INPUT_POST, 'Clave', FILTER_SANITIZE_STRING);
		$email = filter_input(INPUT_POST, 'Correo', FILTER_SANITIZE_STRING);

		// Si la clave es inválida (más de 128 caracteres), se notifica al usuario.
		if (strlen($password) != 128) {
			echo json_encode(array("error" => "Configuracion de contraseña incorrecta."));
			exit();
		}

		// Consulta todas las cuentas registradas con el email ingresado
		$Verificacion = mysqli_query($mysqli, "SELECT * FROM usuarios2 WHERE email='$email'");

		// Verifica si ya posee 3 cuentas
		if(mysqli_num_rows($Verificacion) >= 1){
			echo json_encode(array("error" => "¡La dirección de correo electrónico no puede ser registrada nuevamente!"));
			exit();
		}

		// Prepara la base de datos
		$prep_stmt = "SELECT id_usuario FROM usuarios2 WHERE cuil = ? LIMIT 1";
		$stmt = $mysqli->prepare($prep_stmt);

		// Chequea si la base de datos está funcionando
		if ($stmt) {
			$stmt->bind_param('s', $cuil);
			$stmt->execute();
			$stmt->store_result();

			// Se chequea si ya existe un usuario con ese mismo CUIL
			if ($stmt->num_rows == 1) {
				// En caso de existir, se notifica y termina el proceso
				echo json_encode(array("error" => "¡El CUIL y/o el correo electrónico ya se encuentra/n en uso!"));
				exit();
			}
		} else {
			echo json_encode(array("error" => "Error interno: 0x088"));
			exit();
		}

		// Obtiene un decriptador aleatorio para la clave
		$random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));

		$password = hash('sha512', $password . $random_salt);

		$nivel = 3;
		$activo = 0;
	
		// Genera un código único de activación para la cuenta, mediante su CUIL y el timestamp
		$activacion = md5($cuil.time());

		if ($insert_stmt = $mysqli->prepare("INSERT INTO usuarios2 (cuil, nivel, email, password, salt, activo, activacion, alta) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())")) {
			$insert_stmt->bind_param('sisssis', $cuil, $nivel, $email, $password, $random_salt, $activo, $activacion);
		
			if (!$insert_stmt->execute()) {
				echo json_encode(array("error" => "Error interno en la base de datos!"));
				exit();
			} else {
				$stmt =  $mysqli->prepare("SELECT id_usuario FROM usuarios2 WHERE cuil = ? ");
				$stmt->bind_param('s', $cuil);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($newID);
				$stmt->fetch();
				$nid_usuario = $newID;
				$stmt2 = $mysqli->prepare("INSERT INTO menu (user) VALUES (?) ");
				$stmt2->bind_param('i', $nid_usuario); 
				$stmt2->execute();
				
				$EmailType = 'Registro';
				include 'Email.php';
				
				echo json_encode(array("success" => true));

				exit();
			}
		}
	} else {
		echo json_encode(array("error" => "Error, no hay cuil ni clave...?"));
		exit();
	}
?>