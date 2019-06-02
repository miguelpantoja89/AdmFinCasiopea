<?php

session_start();

include_once ('includes/funciones.php');
$conexion= crearConexionBD();  

  	
if(!isset($_SESSION["IdC"])){
    header("Location: inicio.php");
} else{
    $IdC = $_SESSION["IdC"];
}

if(isset($_REQUEST["borrar"])){
    $IdCuota = $_REQUEST["IdCuota"];
    borrarCuota($conexion, $IdC, $IdCuota);
}

$stmn = cuotasComunidad($conexion, $IdC);

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css"  href="style.css">
    <link rel="icon" href="img/favicon.jpg">
    
    <title>Cuotas</title>
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
            <th>Mes</th>
            <th>Cantidad exigida</th>
            <th>Propietario</th>
            <th>Dni</th>
            <th>Acciones disponibles</th>
            </tr>
            <?php foreach ($stmn as $Fila) {
				
                ?>
             <tr>	
               <td><?php echo $Fila["MES"]; ?></td>
               <td><?php echo $Fila["PAGOEXIGIDO"]; ?></td>
               <td><?php echo $Fila["NOMBREAP"]; ?> </td>
               <td><?php echo $Fila["DNI"]; ?></td>
               <td> <form  action="infoCuotas.php" method="post" >
            
            <input id="IdCuota" name="IdCuota" type="hidden" value="<?php echo $Fila["IDCUOTA"];?>" />
                
                                
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
