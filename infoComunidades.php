<?php
session_start();
include_once ('includes/gestionBD.php');
$conexion= crearConexionBD();

if(!isset($_REQUEST["IdC"])){
    header("Location: inicio.php");
} else{
    $IdC = $_REQUEST["IdC"];
}
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
} catch(PDOException $e){
    $_SESSION["excepcion"] = $e -> getMessage();
}

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
        <article class="inp">
            <div class="contenedor">
                   <p>Direccion:   <?php echo $Fila["DIRECCION"]; ?></p>
                   <P>Número de propietarios:   <?php echo $Fila["NUMEROPROPIETARIOS"]; ?></P>
                   <P>Cuenta corriente:  <?php echo $Fila["CUENTACORRIENTE"]; ?></P>
                   <P>Saldo:   <?php echo  $Fila["SALDOINICIAL"]; ?></P>
                   <P>Presidente:  <?php echo getNombrePropietario($conexion, $Fila["PRESIDENTE"]); ?></P>
                </div>     
         </article>
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
    }
}


?>
