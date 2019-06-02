<?php
session_start();
include_once ('includes/funciones.php');
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

