<?php
session_start();
include('includes/funciones.php');
if(isset($_SESSION["formPropietario"])){
    $form["NombreAp"] = $_POST['NombreAp'];
    $form["Dni"] = $_POST['Dni'];
    $form["PisoLetra"] = $_POST['PisoLetra'];
    $form["Telefono"] = $_POST['Telefono'];
    $form["Email"] = $_POST['Email'];

    $_SESSION['formPropietario'] = $form;
}else{
    header('Location: altaPropietario.php');
}
$conexion=crearConexionBD();

$error = validarDNI($conexion, $form);
$error = validarTelefono($conexion, $form);
$error = validarEmail($conexion, $form);

if($error!=""){
    $errores[] = $error;
}

if (count($errores)>0) {
    $_SESSION["errores"] = $errores;
}else{
    insertarPropietario($conexion, $form);
    $IdP = getIdPropietario($conexion, $form["Dni"]);
    $IdC = $_SESSION["IdC"];
    insertarPertenencia($conexion, $IdP, $IdC);
    insertarPiso($conexion, $IdP, $IdC, $form["PisoLetra"]);
    $_SESSION["mensaje"] = "Propietario añadido satisfactoriamente";
    unset($_SESSION["formPropietario"]);
}
cerrarConexionBD($conexion);
header('Location: altaPropietario.php');


?>