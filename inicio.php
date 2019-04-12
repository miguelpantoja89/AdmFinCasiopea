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
        <article class="contenedor">
           
             <?php foreach ($Resultado as $Fila) {
					
				?>	
			
       
    
        <form class="enlaces" action="controladorComunidad.php" method="post" >
            
            <input id="IdC" name="IdC" type="hidden" value="<?php echo $Fila["IDC"];?>" />
                
                <div class="caja"><?php echo $Fila["DIRECCION"]; ?>
                    
                    <button id="consultar" name="consultar" type="submit" class="editar_fila">
                    Consultar
                    </button>

                    <button id="editar" name="editar" type="submit" class="editar_fila">
				    <img src="img/pencil.png" class="editar_fila" alt="Guardar modificación">
                    </button>
                
                    <button id="borrar" name="borrar" type="submit" class="editar_fila">
				    <img src="img/trash.png" class="editar_fila" alt="Guardar modificación">
				    </button>
                
                
                </div>
        
        </form>
        
      
       

    
    
    <?php } ?>
           





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
