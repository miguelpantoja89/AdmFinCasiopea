<?php
session_start();
include('includes/gestionBD.php');
if(isset($_SESSION["form"])){
    $form["NombreAp"] = $_POST['NombreAp'];
    $form["Dni"] = $_POST['Dni'];
    $form["PisoLetra"] = $_POST['PisoLetra'];
    $form["Telefono"] = $_POST['Telefono'];
    $form["Email"] = $_POST['Email'];

    $_SESSION['form'] = $form;
}else{
    header('Location: alta.php');
}
$conexion=crearConexionBD();

$errores = validarDNI($conexion, $form);

if (count($errores)>0) {
    $_SESSION["errores"] = $errores;
}else{
    insertarPropietario($conexion, $form);
    $IdP = getIdPropietario($conexion, $form["Dni"]);
    $IdC = $_SESSION["IdC"];
    insertarPertenencia($conexion, $IdP, $IdC);
    insertarPiso($conexion, $IdP, $IdC, $form["PisoLetra"]);
    unset($_SESSION["form"]);
}
cerrarConexionBD($conexion);
header('Location: altaPropietario.php');





function insertarPropietario($conexion, $propietario){
    try{
        $stmn = $conexion -> prepare("INSERT INTO Propietarios (NOMBREAP, DNI, TELEFONO, EMAIL) VALUES (:Nombre, :dni, :telefono, :email)");
        $stmn -> bindParam(':Nombre', $propietario["NombreAp"]);
        $stmn -> bindParam(':dni', $propietario["Dni"]);
        $stmn -> bindParam(':telefono', $propietario["Telefono"]);
        $stmn -> bindParam(':email', $propietario["Email"]);
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
    if(!preg_match("/^[0-9]{8}[A-Z]$/", $propietario["Dni"])){
        $error = "El DNI de ". $propietario["Dni"] . " no es válido";
    }else{
        try{
            $stmn = $conexion -> prepare('SELECT COUNT(*) AS TOTAL FROM Propietarios WHERE dni=:dni');
            $stmn -> bindParam(':dni', $propietario["Dni"]);
            $stmn -> execute();
            $repetido = $stmn -> fetchColumn();
            if($repetido > 0){
                $error = "El DNI de " . $propietario["NombreAp"] . " (" . $propietario["Dni"] . ") ya existe en la base de datos";
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