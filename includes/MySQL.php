<?php
	// Archivo: MySQL.php
	// Propósito: Maneja la conexión a MySQL

	// Incluye una sola vez el archivo de configuración
	include_once 'Configuracion.php';

	$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
	if ($mysqli->connect_error) {
    	header("Location: ../error.php?err=No se pudo conectar a la Base de Datos.");
    	exit();
	}
?>