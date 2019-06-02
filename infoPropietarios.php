<?php

session_start();

include_once ('includes/funciones.php');
$conexion= crearConexionBD();  

  	
if(!isset($_SESSION["IdC"])){
    header("Location: inicio.php");
} else{
    $IdC = $_SESSION["IdC"];
}

$stmn = propietariosComunidad($conexion, $IdC);

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css"  href="css/style.css">
    <link rel="icon" href="img/favicon.jpg">
    
    <title>Propietarios</title>
</head>
<body>
        
    <?php include('cabecera.php') ?>
    <?php include('navegacion2.php') ?>
    <main>
     
       <section>
       
        <article class="inp">
        
            <div class="contenedor">
            
            
            <table>
            <tr>
            <th>Piso</th>
            <th>Propietarios</th>
            <th>Dni</th>
            <th>Teléfono</th>
            <th>Correo electrónico</th>
            <th>Acciones disponibles</th>
            </tr>
            <?php foreach ($stmn as $Fila) {
				
                ?>
             <tr>	
               <td><?php echo $Fila["PISOLETRA"]; ?></td>
               <td><?php echo $Fila["NOMBREAP"]; ?></td>
               <td><?php echo $Fila["DNI"]; ?></td>
               <td><?php echo $Fila["TELEFONO"]; ?></td>
               <td><?php echo $Fila["EMAIL"]; ?></td>
               <td> <form  action="controladorPropietarios.php" method="post" >
            
            <input id="Dni" name="Dni" type="hidden" value="<?php echo $Fila["DNI"];?>" />

                
                    <button id="borrar" name="borrar" type="submit" class="editar_fila" onclick="return confirm('¿Estas seguro que quieres eliminar este Propietario?');">
				    <img src="img/trash.png" class="editar_fila" alt="Borrar ">
				    </button>
                
               
        
        </form></td>
            </tr>
            
       
               <?php } ?>
               
        </table>
        <div >
                        
                        <button class="boton"><a href="altaPropietario.php">Dar de alta </a></button>
           
                    
        </div>
                </div>     
         </article>
        </section>
        

    </main>
    <!---<?php include('foot.php') ?>--->
    
</body>
</html>


