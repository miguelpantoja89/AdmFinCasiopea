<?php
session_start();
include_once ("gestionBD.php");
$conexion= crearConexionBD();

$Comando_sql =  "SELECT IdC ,
Direccion,
NumeroPropietarios,
CuentaCorriente,
SaldoInicial,
Presidente FROM COMUNIDADES";
$Resultado=$conexion->query($Comando_sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css"  href="style.css">
    
    <title>Comunidades</title>
</head>
<body>
        
    <?php include('cabecera.php') ?>
    <?php include('navegacion2.php') ?>
    <main>
    <?php foreach ($Resultado as $Fila) {
					
                    ?>	
       <section>
        <article class="inp">
            <div class="contenedor">
                   <p>Direccion:   <?php echo $Fila["DIRECCION"]; ?></p>
                   <P>Número de propietarios:   <?php echo $Fila["NUMEROPROPIETARIOS"]; ?></P>
                   <P>Cuenta corriente:  <?php echo $Fila["CUENTACORRIENTE"]; ?></P>
                   <P>Saldo:   <?php echo  $Fila["SALDOINICIAL"]; ?></P>
                   <P>Presidente:  <?php echo $Fila["PRESIDENTE"]; ?></P>
                </div>     
         </article>
        </section>
        <?php } ?>

    </main>
    <!---<?php include('foot.php') ?>--->
    
</body>
</html>
