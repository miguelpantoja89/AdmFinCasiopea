<?php
session_start();
include_once ('includes/gestionBD.php');



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
    <link rel="icon" href="img/favicon.jpg">
    
    <title>Comunidades</title>
</head>
<body>
    <?php include_once ('cabecera.php') ?>
    <?php include_once ('navegacion.php') ?>
  
    <main>
    
       <section>
        <article >
            <div class="contenedor">
               
                <div class="espacio">
             <?php foreach ($Resultado as $Fila) {
					
				?>	
			
       
    
        <form action="controladorComunidad.php" method="post" >
        
                
                <div class="caja"><?php echo $Fila["DIRECCION"]; ?></div>
                <a href="controladorComunidad.php?IdC=<?php echo $Fila["IDC"]; ?>&tipo=editar"><img src="img/pencil.png" alt="editar" class="editar_fila"></a>
                <a href="controladorComunidad.php?IdC=<?php echo $Fila["IDC"]; ?>&tipo=borrar"><img src="img/trash.png" alt="borrar" class="editar_fila"></a>
                

        
        </form>
        
      
       

    
    
    <?php } ?>

            
             


    </div>



<div >
                        
                        <button class="boton"><a href="alta.php">Dar de Alta</a></button>
           
                    
        </div>
        <?php
        if(isset($_SESSION["excepcion"])){
         
            header("Location: excepcion.php");
           
        }?>
         </article>
        </section>
    

    </main>
    <?php include_once ('foot.php') ?>
    
</body>
</html>
