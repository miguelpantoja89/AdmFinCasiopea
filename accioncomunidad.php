<?php
session_start();
include('gestionBD.php');
$nombre=$_POST['Direccion'];
$correo=$_POST['NumeroPropietarios'];
$cuenta=$_POST['CuentaCorriente'];
$saldo=$_POST['SaldoInicial'];
$conexion=crearConexionBD();

try{
    $stmn = $conexion -> prepare('INSERT INTO comunidades VALUES(:Direccion, :NumeroPropietarios,:CuentaCorriente,:SaldoInicial)');
    $stmn -> bindParam(':Direccion', $nombre);
    $stmn -> bindParam(':NumeroPropietarios', $correo);
    $stmn -> bindParam(':CuentaCorriente', $cuenta);
    $stmn -> bindParam(':SaldoInicial', $saldo);
    $stmn -> execute();
} catch(PDOException $e){
    $_SESSION["excepcion"] = $e -> GetMessage();

}

header('Location:alta.php');




?>