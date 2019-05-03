<?php
session_start();
include_once ('includes/gestionBD.php');
$conexion= crearConexionBD();

if(!isset($_SESSION["IdC"])){
    header("Location: inicio.php");
} else{
    $IdC = $_SESSION["IdC"];
}

$stmn = informacionComunidad($conexion, $IdC);
$saldo = saldoComunidad($conexion, $IdC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css"  href="style.css">
    <link rel="icon" href="img/favicon.jpg">
    
    <title>Comunidades</title>
</head>
<body>
        
    <?php include('cabecera.php') ?>
    <?php include('navegacion2.php') ?>
    <main>
        <?php $Fila=$stmn->fetch(); ?>
    
       <section>
        
            <div class="contenedor">
            <table>
            <tr>
            <th>Dirección</th>
            <th>Número de propietarios</th>
            <th>Número de cuenta corriente</th>
            <th>Saldo de la comunidad</th>
            <th>Presidente</th>
            </tr>
            <tr>
            <td> <?php echo $Fila["DIRECCION"]; ?></td>
            <td> <?php echo $Fila["NUMEROPROPIETARIOS"]; ?></td>
            <td><?php echo $Fila["CUENTACORRIENTE"]; ?></td>
            <td><?php echo  $saldo; ?></td>
            <td><?php echo getNombrePropietario($conexion, $Fila["PRESIDENTE"]); ?></td>
            </tr>
            </table>
        </section>
        

    </main>
    <!---<?php include('foot.php') ?>--->
    
</body>
</html>

<?php 

function getNombrePropietario($conexion, $IdP){
    try{
    $stmn = $conexion -> prepare("SELECT NombreAp FROM Propietarios WHERE IdP=:IdP");
    $stmn -> bindParam(":IdP", $IdP);
    $stmn -> execute();
    return $stmn -> fetchColumn();
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
    }
}

function informacionComunidad($conexion, $IdC){
    try{
        $Comando_sql =  "SELECT IdC,
        Direccion,
        NumeroPropietarios,
        CuentaCorriente,
        SaldoInicial,
        Presidente FROM COMUNIDADES WHERE IdC = :IdC";
        $stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> execute();
        return $stmn;
    } catch(PDOException $e){
            $_SESSION["excepcion"] = $e -> getMessage();
            header("Location: excepcion.php");
        }
}

function saldoComunidad($conexion, $IdC){
    try{
        $stmn = $conexion -> prepare('CALL SALDO_COMUNIDAD(:IdC)');
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> execute();
        return $stmn -> fetchColumn();
    }catch (PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
    }
}

?>
