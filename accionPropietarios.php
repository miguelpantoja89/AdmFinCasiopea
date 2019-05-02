<?php
session_start();
include_once('includes/gestionBD.php');
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
    header("Location: altaPropietarios.php");
}


function insertarPropietario($conexion, $propietario){
    try{
        $stmn = $conexion -> prepare("INSERT INTO Propietarios (NOMBREAP, DNI, TELEFONO, EMAIL) VALUES (:Nombre, :dni, :telefono, :email)");
        $stmn -> bindParam(':Nombre', $propietario[0]);
        $stmn -> bindParam(':dni', $propietario[1]);
        $stmn -> bindParam(':telefono', $propietario[2]);
        $stmn -> bindParam(':email', $propietario[3]);
        $stmn -> execute();
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
    }
}

function getIdPropietario($conexion, $dni){
    try{
        $stmn = $conexion -> prepare("SELECT IdP FROM Propietarios WHERE DNI=:dni");
        $stmn -> bindParam(':dni', $dni);
        $stmn -> execute();
        return $stmn -> fetchColumn();
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
    }
}

function insertarPertenencia($conexion, $IdP, $IdC){
    try{
        $stmn = $conexion -> prepare("INSERT INTO Pertenece (IDP, IDC) VALUES (:idp, :idc)");
        $stmn -> bindParam(':idp', $IdP);
        $stmn -> bindParam(':idc', $IdC);
        $stmn -> execute();
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
    }
}

function validarDNI($conexion, $propietario){
    $error = "";
    if(!preg_match("/^[0-9]{8}[A-Z]$/", $propietario[1])){
        $error = "El DNI de ". $propietario[0] . " no es válido";
    }else{
        try{
            $stmn = $conexion -> prepare('SELECT COUNT(*) AS TOTAL FROM Propietarios WHERE dni=:dni');
            $stmn -> bindParam(':dni', $propietario[1]);
            $stmn -> execute();
            $repetido = $stmn -> fetchColumn();
            if($repetido > 0){
                $error = "El DNI de " . $propietario[0] . " (" . $propietario[1] . ") ya existe en la base de datos";
            }
        } catch(PDOException $e){
            $_SESSION["excepcion"] = $e -> GetMessage();
            header("Location: excepcion.php");
        }
    }
    return $error;
}

function insertarPiso($conexion, $IdP, $IdC, $piso){
    try{
        $stmn = $conexion -> prepare("INSERT INTO Pisos (PISOLETRA, IDP, IDC) VALUES (:pisoletra, :idp, :idc)");
        $stmn -> bindParam(':pisoletra', $piso);
        $stmn -> bindParam(':idp', $IdP);
        $stmn -> bindParam(':idc', $IdC);
        $stmn -> execute();
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
    }
}
?>