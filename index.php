<?php
ob_start(); 

include_once 'includes/MySQL.php';
include_once 'includes/functions.php';


session_start();

// Se chequea si hay una función especial
if (isset($_GET['Token']) || isset($_GET['Recovery']) || isset($_GET['cambiarEmail'])) {
    include 'Scripts.php';
    die();
}
    // Se chequea si el usuario está en una sesión
if(!isLogged()){
    // Se chequea si hay un enlace
    if (isset($_GET['Enlace'])) {
        // Se obtiene el enlace donde se encuentra el usuario
        $Enlace = $_GET['Enlace'];

        // Se chequea si quiere acceder a registrarse
        if ($Enlace == 'Registro') {
            // Se lo envía a la página de registro
            include 'vistas/Registro.php';
            die();
        }
        // Se chequea si quiere acceder a 'Olvidé mi clave'
        elseif ($Enlace == 'Recuperar') {
            // Se lo envía a la pagina para recuperación de claves
            include 'vistas/Recuperar.php';
            die();
        }

        // De otra forma, si los enlaces son incorrectos, se carga el ingreso
        else {
            include 'vistas/Ingreso.php';
            die();
        }
    }
    // Si está en el inicio, o no hay enlace, se lo envía al ingreso
    else {
        include 'vistas/Ingreso.php';
        die();
    }
}// else {
    // Se obtiene la ID del usuario
//	$ID = $_SESSION['id_usuario'];
//	$Verificado = verificado($ID, $mysqli);

//	if ($Verificado == 0) {
//		include 'paginas/CompletarPerfil.php';
//		exit();
//	}

    $Nivel = isLogged();


    include 'paginas/principal.php';

?>
