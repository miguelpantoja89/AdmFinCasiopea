<?php
session_start();
include_once('includes/funciones.php');
$conexion = crearConexionBD();

if(!isset($_SESSION["IdC"])){
    header("Location: inicio.php");
} else{
    $IdC = $_SESSION["IdC"];
}

if (isset($_POST["import"])) {
    
    $fileName = $_FILES["file"]["tmp_name"];
    
    if ($_FILES["file"]["size"] > 0) {
        
        $file = fopen($fileName, "r");
        $counter = 0;

        while (($column = fgetcsv($file, 10000, ";")) !== FALSE) {
            $error = validarDNI($conexion, $column);
            if($error!=""){
                $errores[] = $error;
            }else{
                insertarPropietario($conexion, $column);
                $IdP = getIdPropietario($conexion, $column[1]);
                $IdC = $_SESSION["IdC"];
                insertarPertenencia($conexion, $IdP, $IdC);
                insertarPiso($conexion, $IdP, $IdC, $column[4]);
                $counter++;
            }
        }
    }
    if(count($errores)>0){
        $_SESSION["errores"] = $errores;
    }
    $_SESSION["mensaje"] = $counter . " propietarios insertados satisfactoriamente";
    header("Location: altaPropietario.php");
}

?>