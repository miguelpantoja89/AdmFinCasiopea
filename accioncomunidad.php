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

$error = validarCuentaBancaria($conexion, $form["cuenta"]);
if($error!=""){
    $errores[] = $error;
}

if (count($errores)>0) {
    $_SESSION["errores"] = $errores;
}else{
    insertarComunidad($conexion, $comunidad);
    unset($_SESSION["form"]);
}
cerrarConexionBD($conexion);
Header('Location: alta.php');



function insertarComunidad($conexion, $comunidad){
    try{
        $stmn = $conexion -> prepare('INSERT INTO comunidades (Direccion, NumeroPropietarios, CuentaCorriente, SaldoInicial) VALUES(:Direccion, :NumeroPropietarios,:CuentaCorriente,:SaldoInicial)');
        $stmn -> bindParam(':Direccion', $comunidad["direccion"]);
        $stmn -> bindParam(':NumeroPropietarios', $comunidad["numPropietarios"]);
        $stmn -> bindParam(':CuentaCorriente', $comunidad["cuenta"]);
        $stmn -> bindParam(':SaldoInicial', $comunidad["saldoInicial"]);
        $stmn -> execute();
        $_SESSION["mensaje"] =  "Comunidad añadida satisfactoriamente";
    } catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> GetMessage();

    }
}


function validarCuentaBancaria($conexion, $cuenta){
    $error = "";
    try{
        $stmn = $conexion -> prepare('SELECT COUNT(*) AS TOTAL FROM Comunidades WHERE CuentaCorriente=:cuenta');
        $stmn -> bindParam(':cuenta', $cuenta);
        $stmn -> execute();
        $repetido = $stmn -> fetchColumn();
        if($repetido > 0){
            $error = "La cuenta bancaria está repetida";
        }
    } catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> GetMessage();
    }
    return $error;
}

?>