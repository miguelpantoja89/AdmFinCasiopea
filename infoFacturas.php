<?php

include_once ("gestionBD.php");
$conexion= crearConexionBD();  

  	
if(!isset($_REQUEST["IdC"])){
    header("Location: infoComunidades.php");
} else{
    $IdC = $_REQUEST["IdC"];
}
try{
$Comando_sql =  "SELECT IdC,Importe,FechaEmision,TipoServicio
 FROM FACTURAS  WHERE IdC = :IdC"  ;
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
    
    <title>Facturas</title>
</head>
<body>
        
    <?php include('cabecera.php') ?>
    <?php include('navegacion2.php') ?>
    <main>
    <?php foreach ($stmn as $Fila) {
					
                    ?>	
       <section>
        <article class="inp">
            <div class="contenedor">
                   <p>Importe:   <?php echo $Fila["IMPORTE"]; ?></p>
                   <P>Fecha de Emisión:   <?php echo $Fila["FECHAEMISION"]; ?></P>
                   <P>Tipo de Servicio:  <?php echo $Fila["TIPOSERVICIO"]; ?></P>
                </div>     
         </article>
        </section>
        <?php } ?>

    </main>
    <!---<?php include('foot.php') ?>--->
    
</body>
</html>
