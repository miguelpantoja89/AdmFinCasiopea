<?php

include_once ("gestionBD.php");
$conexion= crearConexionBD();  

  	
if(!isset($_REQUEST["IdC"])){
    header("Location: infoContratos.php");
} else{
    $IdC = $_REQUEST["IdC"];
}
try{
$Comando_sql =  "SELECT nombre, fechainicio, fechafin FROM CONTRATOS NATURAL JOIN EMPRESAS WHERE IdC = :IdC";
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
    
    <title>Facturas</title>
</head>
<body>
        
    <?php include('cabecera.php') ?>
    <?php include('navegacion2.php') ?>
    <main>
    <?php foreach ($stmn as $Fil) { ?>	
       <section>
        <article class="inp">
            <div class="contenedor">
                   <p>Importe:   <?php echo $Fil["FechaInicio"]; ?></p>
                   <P>Fecha de Emisión:   <?php echo $Fil["FechaFin"]; ?></P>
                   <P>Empresa:  <?php echo $Fil["Nombre"]; ?></P>
                </div>     
         </article>
        </section>
        <?php } ?>

    </main>
    <!---<?php include('foot.php') ?>--->
    
</body>
</html>
