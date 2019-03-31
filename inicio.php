<?php
session_start();
include_once ("gestionBD.php");



$conexion= crearConexionBD();

$Comando_sql =  "SELECT IdC, DIRECCION FROM COMUNIDADES";
$Resultado=$conexion->query($Comando_sql);

?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css"  href="style.css">
    
    <title>Comunidades</title>
</head>
<body>
    <?php include_once ('cabecera.php') ?>
    <?php include_once ('navegacion.php') ?>
  
    <main>
    
       <section>
        <article class="inp">
            <div class="contenedor">
               
   
             <?php foreach ($Resultado as $Fila) {
					
				?>	
			
    <div>
    <ul >
        
        <li class="caja"><a href="infoComunidades.php?IdC=<?php echo $Fila["IDC"]; ?>"><?php echo $Fila["DIRECCION"]; ?></a> 
        
        
    </ul>
    
    <?php } ?>
</div>
            
             


      



<div >
                        
                        <button class="boton"><a href="alta.php">Dar de Alta</a></button>
           
                    
        </div>
         </article>
        </section>
    

    </main>
    <?php include_once ('foot.php') ?>
    
</body>
</html>
