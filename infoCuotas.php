<?php

session_start();

include_once ('includes/gestionBD.php');
$conexion= crearConexionBD();  

  	
if(!isset($_SESSION["IdC"])){
    header("Location: inicio.php");
} else{
    $IdC = $_SESSION["IdC"];
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
               <td> <form  action="controladorFacturas.php" method="post" >
            
            <input id="IdC" name="IdC" type="hidden" value="<?php echo $Fila["IDC"];?>" />
                
                
                    

                    <button id="consultar" name="consultar" type="submit" class="editar_fila">
                    <img src="img/info.png" class="editar_fila" alt="informaciñon">
                    </button>

                    <button id="editar" name="editar" type="submit" class="editar_fila">
				    <img src="img/pencil.png" class="editar_fila" alt="modificación">
                    </button>
                
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

<?php 
function cuotasComunidad($conexion, $IdC){
    try{
        $Comando_sql =  "SELECT Mes, IdC,
        IdCuota, PagoExigido, NombreAp, Dni FROM CUOTAS NATURAL JOIN PROPIETARIOS  WHERE IdC = :IdC ORDER BY Mes " ;
        $stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> execute();
        return $stmn;
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
 }
}

?>