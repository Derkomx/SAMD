<?php
	// Se chequea si la ejecución es mediante POST (Ajax)
	if (isset($_POST["Archivo"])) {
		//include "../includes/" . $_POST["Archivo"];
		include "includes/" . $_POST["Archivo"];
		
		exit();
	}

	$InputContent = file_get_contents('php://input');
	// Se chequea si la ejecución del inyector es mediante php://input
	if ($InputContent) {
		// Obtiene los datos ingresados mediante el php://input
		$JSONContent = json_decode(file_get_contents('php://input'), true);
		$Archivo = $JSONContent['Archivo'];

		// Incluye el archivo necesario
		include "includes/" . $JSONContent['Archivo'];

		// Termina la ejecución del archivo
		exit();
	}
?>