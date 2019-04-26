<?php

session_start();

include_once ('includes/gestionBD.php');
$conexion= crearConexionBD();  

  	
if(!isset($_SESSION["IdC"])){
    header("Location: inicio.php");
} else{
    $IdC = $_SESSION["IdC"];
}

$stmn = facturasComunidad($conexion, $IdC);

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
     
       <section>
        <article class="inp">
            <div class="contenedor">
            <table>
            <tr>
            <th>Importe</th>
            <th>Fecha de Emisión</th>
            <th>Tipo de Servicio</th>
            <th>Acciones disponibles</th>
            </tr>
            <?php foreach ($stmn as $Fila) {
				
                ?>
             <tr>	
               <td><?php echo $Fila["IMPORTE"]; ?></td>
               <td><?php echo $Fila["FECHAEMISION"]; ?></td>
               <td><?php echo $Fila["TIPOSERVICIO"]; ?></td>
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
function facturasComunidad($conexion, $IdC){
    try{
        $Comando_sql =  "SELECT IdC,Importe,FechaEmision,TipoServicio FROM FACTURAS  WHERE IdC = :IdC";
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