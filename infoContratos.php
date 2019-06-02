<?php

session_start();

include_once ('includes/funciones.php');
$conexion= crearConexionBD();  

  	
if(!isset($_SESSION["IdC"])){
    header("Location: infoContratos.php");
} else{
    $IdC = $_SESSION["IdC"];
}

if(isset($_REQUEST["borrar"])){
    $IdContrato = $_REQUEST["IdContrato"];
    borrarContrato($conexion, $IdC, $IdContrato);
}

$stmn = contratosComunidad($conexion, $IdC);

cerrarConexionBD($conexion);

 ?>
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css"  href="css/style.css">
    <link rel="icon" href="img/favicon.jpg">
    
    <title>Contratos</title>
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
            <th>Empresa</th>
            <th>Fecha de inicio</th>
            <th>Fecha de extinción</th>
            <th>Acciones disponibles</th>
            </tr>
            <?php foreach ($stmn as $Fila) {
				
                ?>
             <tr>	
               <td><?php echo $Fila["NOMBRE"]; ?></td>
               <td><?php echo $Fila["FECHAINICIO"]; ?></td>
               <td><?php echo $Fila["FECHAFIN"]; ?></td>
               <td> <form  action="infoContratos.php" method="post" >
            
            <input id="IdContrato" name="IdContrato" type="hidden" value="<?php echo $Fila["IDCONTRATO"];?>" />
                
                
                                   
                    <button id="borrar" name="borrar" type="submit" class="editar_fila">
				    <img src="img/trash.png" class="editar_fila" alt="Borrar ">
				    </button>
                
               
        
        </form></td>
            </tr>
            
       
               <?php } ?>
               
        </table>
                </div>     
         </article>
        </section>

    </main>
    <!---<?php include('foot.php') ?>--->
    
</body>
</html>
