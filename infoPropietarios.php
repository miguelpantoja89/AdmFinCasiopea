<?php

session_start();

include_once ('includes/gestionBD.php');
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
            
            <input id="IdC" name="IdC" type="hidden" value="<?php echo $Fila["IDC"];?>" />
                
                
                    
                    

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
        <div >
                        
                        <button class="boton"><a href="altaPropietarios.php">Importar desde .csv</a></button>
                        <button class="boton"><a href="altaPropietario.php">Dar de alta </a></button>
           
                    
        </div>
                </div>     
         </article>
        </section>
        

    </main>
    <!---<?php include('foot.php') ?>--->
    
</body>
</html>

<?php 
function propietariosComunidad($conexion, $IdC){
    try{
        $Comando_sql =  "SELECT NombreAp,Dni,Telefono,PisoLetra, Email FROM PROPIETARIOS Natural JOIN  PERTENECE natural JOIN PISOS WHERE IdC = :IdC";
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