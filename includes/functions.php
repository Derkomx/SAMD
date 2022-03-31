<?php
//////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////INICIO DE  FUNCIONES SESION//////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
include_once 'Configuracion.php';

function sec_session_start() {
    $session_name = 'sec_session_id';
    $secure = SECURE;

    $httponly = true;
   ini_set('session.use_only_cookies', true);
   if (ini_get('session.use_only_cookies') === FALSE) {
    header("Location: ../error.php?err=No se pudo inicializar una sesion segura (ini_set)");
     exit();
    }

    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);

    session_name($session_name);

    session_start();
    session_regenerate_id();
}

function login($cuil, $password, $mysqli) {
    if ($stmt = $mysqli->prepare("SELECT id_usuario, cuil, password, nivel, salt, activo, email FROM usuarios2 WHERE cuil = ? LIMIT 1")) {
        $stmt->bind_param('s', $cuil);
        $stmt->execute();
        $stmt->store_result();

        $stmt->bind_result($id_usuario, $cuil, $db_password, $nivel, $salt, $activo, $email);
        $stmt->fetch();

        $password = hash('sha512', $password . $salt);
        if ($stmt->num_rows == 1) {
            if (checkbrute($id_usuario, $mysqli) == true) {
                return false;
            } else {
                if ($db_password == $password) {
					if ($activo == 0) {
						// Si no está activa la cuenta, notifica
						echo json_encode(array("inactive" => true));
						exit();
					}
                    if(!isset($_SESSION)) 
					{ 
						session_start(); 
					} 
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];

                    $id_usuario = preg_replace("/[^0-9]+/", "", $id_usuario);
                    $_SESSION['id_usuario'] = $id_usuario;

                    $cuil = preg_replace("/[^0-9]+/", "", $cuil);

                    $_SESSION['cuil'] = $cuil;
					
					$_SESSION['nivel'] = $nivel;

					$_SESSION['email'] = $email;
					
                    $_SESSION['login_string'] = hash('sha512', $password . $user_browser);
                    $usuavio = $_SESSION['id_usuario'];

					// Ultima Visita
					$mysqli->query("INSERT INTO visitas (id_usuario, fecha) VALUES ( $usuavio, now())");

                    return true;
                } else {
                    $now = time();
                    if (!$mysqli->query("INSERT INTO intentos_logueo(id_usuario, hora) VALUES ('$id_usuario', '$now')")) {
						// Si se superaron los limites de intentos, se da aviso
						echo json_encode(array("error" => "Se superaron los intentos de ingreso, intenta más tarde."));
                        exit();
                    }

                    return false;
                }
            }
        } else {
            return false;
        }
    } else {
		// Si da error en la base de datos, se da aviso.
		echo json_encode(array("error" => "¡Ocurrió un error interno!"));
        exit();
    }
}

function checkbrute($id_usuario, $mysqli) {
    $now = time();

    $valid_attempts = $now - (2 * 60 * 60);

    if ($stmt = $mysqli->prepare("SELECT hora FROM intentos_logueo WHERE id_usuario = ? AND hora > '$valid_attempts'")) {
        $stmt->bind_param('i', $id_usuario);

        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    } else {
		echo json_encode(array("error" => "(checkbrute) ¡No se pudo conectar a la base de datos!"));
        exit();
    }
}

function login_check($mysqli) {
    if (isset($_SESSION['id_usuario'], $_SESSION['cuil'], $_SESSION['login_string'], $_SESSION['nivel'])) {
        $id_usuario = $_SESSION['id_usuario'];
        $login_string = $_SESSION['login_string'];
        $cuil = $_SESSION['cuil'];

        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        if ($stmt = $mysqli->prepare("SELECT password FROM usuarios2 WHERE id_usuario = ? LIMIT 1")) {
            $stmt->bind_param('i', $id_usuario);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);

                if ($login_check == $login_string) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            header("Location: ../error.php?err=Error de Base de datos: No se pudo realizar declaracion.");
            exit();
        }
    } else {
        return false;
    }
}


function isLogged() {
	//session_start();

    if (isset($_SESSION['id_usuario'])) {
        return $_SESSION['nivel'];
    } else {
        return false;
    }
}

//////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////FIN FUNCIONES SESION/////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////

//Obtiene el usuario loggeado, busca su menu personalizado y envia como array.
function itemsmenu($id_usuario, $mysqli) {
		if ($stmt = $mysqli->prepare("SELECT m1, m2, m3, m4, m5, m6, m7, m8, m9, m10, m11, m12, m13, m14, m15 FROM menu WHERE user = ?")) {
			$stmt->bind_param('s', $id_usuario);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($m1, $m2, $m3, $m4, $m5, $m6, $m7, $m8, $m9, $m10, $m11, $m12, $m13, $m14, $m15);
			$stmt->fetch();
			return array($m1, $m2, $m3, $m4, $m5, $m6, $m7, $m8, $m9, $m10, $m11, $m12, $m13, $m14, $m15);
		} else {
			return null;
			exit();
		}
	}
// obtiene las publicaciones echas por el usuario, su "carpeta"
function obtenerBlog($mn, $id_usuario, $mysqli) {
		$mnn = "publicacionesm".$mn;
	$resultados = array();
	if ($stmt = $mysqli->prepare("SELECT id, titulo, fecha FROM $mnn WHERE iduser = ? ORDER BY id DESC")) {
		$stmt->bind_param('i', $id_usuario);
        $stmt->execute();
        $stmt->store_result();
		$stmt->bind_result($pID, $Titulo, $Fecha);
		
		while ($stmt->fetch()) {
			$resultados[] = array($pID, $Titulo, $Fecha);
		}
		
		return ($resultados);
		
	} else {
        header("Location: ./index.php");
        exit();
    }
}
//obtiene la publicacion para cada menu
function obtenerPublicacion($mn, $PubliID, $mysqli) {
	$mnn = "publicacionesm".$mn;
    if ($stmt = $mysqli->prepare("SELECT titulo, fecha, iduser FROM $mnn WHERE id = ?")) {
        $stmt->bind_param('i', $PubliID);

        $stmt->execute();
        $stmt->store_result();

		$stmt->bind_result($Titulo, $Fecha, $Usuario);
        $stmt->fetch();
		return array($Titulo, $Fecha, $Usuario);
	} else {
        header("Location: ./index.php");
        exit();
    }
}
//obtiene el nombre de la materia (menu)
function nombremenu($mn, $id_usuario, $mysqli) {
	$mnn = "m".$mn;
    if ($stmt = $mysqli->prepare("SELECT $mnn FROM menu WHERE id = ?")) {
        $stmt->bind_param('i', $id_usuario);

        $stmt->execute();
        $stmt->store_result();

		$stmt->bind_result($Titulo);
        $stmt->fetch();
		return array($Titulo);
	} else {
        header("Location: ./index.php");
        exit();
    }
}
?>