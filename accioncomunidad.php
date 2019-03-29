<?php
session_start();
include('gestionBD.php');
if(isset($_SESSION["form"])){
    $form["direccion"] = $_POST['Direccion'];
    $form["numPropietarios"] = $_POST['NumeroPropietarios'];
    $form["cuenta"] = $_POST['CuentaCorriente'];
    $form["saldoInicial"] = $_POST['SaldoInicial'];

    $_SESSION['form'] = $form;
}
$conexion=crearConexionBD();

try{
    $stmn = $conexion -> prepare('INSERT INTO comunidades (Direccion, NumeroPropietarios, CuentaCorriente, SaldoInicial) VALUES(:Direccion, :NumeroPropietarios,:CuentaCorriente,:SaldoInicial)');
    $stmn -> bindParam(':Direccion', $form["direccion"]);
    $stmn -> bindParam(':NumeroPropietarios', $form["numPropietarios"]);
    $stmn -> bindParam(':CuentaCorriente', $form["cuenta"]);
    $stmn -> bindParam(':SaldoInicial', $form["saldoInicial"]);
    $stmn -> execute();
    $_SESSION["mensaje"] =  "Comunidad añadida satisfactoriamente";
} catch(PDOException $e){
    $_SESSION["excepcion"] = $e -> GetMessage();

}

header('Location:alta.php');




?>