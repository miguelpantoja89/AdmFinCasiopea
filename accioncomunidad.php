<?php
session_start();
include('includes/gestionBD.php');
if(isset($_SESSION["form"])){
    $form["direccion"] = $_POST['Direccion'];
    $form["numPropietarios"] = $_POST['NumeroPropietarios'];
    $form["cuenta"] = $_POST['CuentaCorriente'];
    $form["saldoInicial"] = $_POST['SaldoInicial'];

    $_SESSION['form'] = $form;
}else{
    header('Location: alta.php');
}
$conexion=crearConexionBD();

$errores = validarComunidad($conexion, $form);

if (count($errores)>0) {
    $_SESSION["errores"] = $errores;
}else{
    insertarComunidad($conexion, $form);
    unset($_SESSION["form"]);
}
cerrarConexionBD($conexion);
header('Location: alta.php');





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
        header("Location: excepcion.php");
    }
}



// FUNCIONES DE VALIDACION
function validarComunidad($conexion, $comunidad){
    $errores = array();
    if($comunidad["direccion"]==""){
        $errores[] = "La dirección no puede estar vacía";
    }
    if($comunidad["numPropietarios"]<=0){
        $errores[] = "El número de propietarios debe ser mayor que 0";
    }
    if($comunidad["cuenta"]==""){
        $errores[] = "La cuenta bancaria no puede estar vacía";
    }else if(cuentaBancariaRepetida($conexion, $comunidad["cuenta"])>0){
        $errores[] = "La cuenta bancaria está repetida";    
    }
    if($comunidad["saldoInicial"]==""){
        $errores[] = "El saldo inicial no puede estar vacío";
    }else if($comunidad["saldoInicial"]<0){
        $errores[] = "El saldo inical no puede ser negativo";
    }
    return $errores;
}

function cuentaBancariaRepetida($conexion, $cuenta){
    $error = "";
    try{
        $stmn = $conexion -> prepare('SELECT COUNT(*) AS TOTAL FROM Comunidades WHERE CuentaCorriente=:cuenta');
        $stmn -> bindParam(':cuenta', $cuenta);
        $stmn -> execute();
        $repetido = $stmn -> fetchColumn();
        return repetido;
        if($repetido > 0){
            $error = "La cuenta bancaria está repetida";
        }
    } catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> GetMessage();
        header("Location: excepcion.php");
    }
    return $error;
}

?>