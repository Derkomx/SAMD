<?php

	// Definiciones de los correos

	// Ejemplo:
	// $Correos['Nombre'] = array("Archivo" => "Archivo.php", "Título" => "Título del mensaje", "Título corto" => "Título reducido");
	// NOTA: El archivo debe estar en la carpeta "Emails".

	$Correos['Registro'] = array(
		"Archivo" => "Email_Registro.php",
		"Título" => "Confirmar registro - Ya le pondre nombre a la app",
		"Título corto" => "Confirmar registro"
	);

	$Correos['Recuperar'] = array(
		"Archivo" => "Email_Recuperar.php",
		"Título" => "Recuperar contraseña - Ya le pondre nombre a la app",
		"Título corto" => "Recuperar contraseña"
	);

	$Correos['Verificado'] = array(
		"Archivo" => "Email_Verificado.php",
		"Título" => "Verificación éxitosa - Ya le pondre nombre a la app",
		"Título corto" => "Aviso de verificación"
	);

	$Correos['Seguridad'] = array(
		"Archivo" => "Email_Seguridad.php",
		"Título" => "Código de seguridad - Ya le pondre nombre a la app",
		"Título corto" => "Código de seguridad"
	);
	
	$Correos['CambioCorreo'] = array(
		"Archivo" => "Email_Cambio.php",
		"Título" => "Confirmación de nuevo correo electrónico - Ya le pondre nombre a la app",
		"Título corto" => "Nuevo correo electrónico"
	);

	$Correos['Denegado'] = array(
		"Archivo" => "Email_Denegado.php",
		"Título" => "Verificación de datos personales - Ya le pondre nombre a la app",
		"Título corto" => "Verificación de datos"
	);

	// Establece la zona horaria
	setlocale(LC_CTYPE, 'es');
	date_default_timezone_set('America/Argentina/Buenos_Aires');

	// Si no hay un tipo de email definido, o no existe, se cancela
	if (!isset($EmailType) || !isset($Correos[$EmailType])) {
		exit();
	}

	// Empieza un buffer para cargar el email
	ob_start();

	// Carga el archivo necesario
	include ('Emails/' . $Correos[$EmailType]['Archivo']);

	// Obtiene el contenido del email cargado
	$Contenido = ob_get_clean();

	// Importa las clases de PHPMailer
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	use PHPMailer\PHPMailer\SMTP;

	// Requiere los archivos necesarios del plugin
	require 'PHPMailer/Exception.php';
	require 'PHPMailer/PHPMailer.php';
	require 'PHPMailer/SMTP.php';

	// Instantiation and passing `true` enables exceptions
	$mail = new PHPMailer(true);

	try {
		//Server settings
		$mail->isSMTP();                                            // Send using SMTP
		$mail->Host       = 'smtp.gmail.com';              // Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		$mail->Username   = 'practicacoopmc@gmail.com';          // SMTP username
		$mail->Password   = 'practicamenu';                       // SMTP password
		$mail->SMTPSecure = 'ssl';
		$mail->Port       = 465;                                    // TCP port to connect to

		$mail->setFrom('practicacoopmc@gmail.com', $Correos[$EmailType]['Título corto']);
		$mail->addAddress($email);

		// Contenido del email
		$mail->isHTML(true);
		$mail->Subject = $Correos[$EmailType]['Título'];
		$mail->Body = $Contenido;
		$mail->CharSet = "UTF-8";
		//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		$mail->send();
	} catch (Exception $e) {
		echo json_encode(array("error" => "Error de correo. Mailer Error: {$mail->ErrorInfo}"));
		exit();
	}
?>