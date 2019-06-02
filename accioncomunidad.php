<?php
session_start();
include('includes/funciones.php');
if(isset($_SESSION["formComunidad"])){
    $form["direccion"] = $_POST['Direccion'];
    $form["numPropietarios"] = $_POST['NumeroPropietarios'];
    $form["cuenta"] = $_POST['CuentaCorriente'];
    $form["saldoInicial"] = $_POST['SaldoInicial'];

    $_SESSION['formComunidad'] = $form;
}else{
    header('Location: alta.php');
}
$conexion=crearConexionBD();

$errores = validarComunidad($conexion, $form);

if (count($errores)>0) {
    $_SESSION["errores"] = $errores;
}else{
    insertarComunidad($conexion, $form);
    unset($_SESSION["formComunidad"]);
}
cerrarConexionBD($conexion);
header('Location: alta.php');






?>