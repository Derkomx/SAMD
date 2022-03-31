<?php
ob_start(); 
include_once 'MySQL.php';
include_once 'functions.php';
session_start();
$Titulo = $_POST['Titulo'];
$uID = $_SESSION['id_usuario'];
if (isset($_POST['Titulo'])) {
    for ($i = 1; $i <= 16; $i++){
        if($i == 16){
            echo json_encode(array("error" => "Lo lamentamos, No puedes crear mas carpetas :("));
            break;
        }
        $mnn = "m".$i;
        if($stmt = $mysqli->prepare("SELECT $mnn FROM menu WHERE user = ?")){
            $stmt->bind_param('i', $uID);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($tit);
            $stmt->fetch();
            $array = array ($tit);
            if($array[0] == null OR $array[0] == '' ){
                if ($stmt2 = $mysqli->prepare("UPDATE menu SET $mnn = ? WHERE user = ? ")) {
                    $stmt2->bind_param('si',$Titulo, $uID);
                    $stmt2->execute();
                    echo json_encode(array("success" => "suuuuuuuuu "));
                    break;
                    }else{
                    }                    
            }   
        }else{
            echo json_encode(array("error" => "FALLO EL SELECT"));
            break;
        }
    }
    
}
?>