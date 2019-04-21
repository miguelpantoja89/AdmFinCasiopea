<?php

session_start();

include_once ('includes/gestionBD.php');
  

  	
if(!isset($_SESSION["IdC"])){
    header("Location: inicio.php");
} else{
    $IdC = $_SESSION["IdC"];
}
if(isset($_POST)){
    $FechaI=$_POST['fechainicio'];
    $FechaF=$_POST['fechafin'];
}

unset($_SESSION["form"]);
$conexion= crearConexionBD();



$stmn = facturasPeriodo($conexion, $IdC, $FechaI, $FechaF);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css"  href="style.css">
    <link rel="icon" href="img/favicon.jpg">
    
    <title>Estadillo</title>
</head>
<body>
        
    <?php include('cabecera.php') ?>
    <?php include('navegacion2.php') ?>
    <main>
     
    <form action="infoEstadillo.php" method="POST">
            <input type="date" name="fechainicio">
            <input type="date" name="fechafin">
            <input type="submit" value="buscar">
            </form>
            <div class="contenedor">
            
            <section>
                 <article class="inp">
            <table>
            <tr>
            <th>Empresa</th>
            <th>Importe</th>
            <th>Fecha</th>
            <th>Acciones disponibles</th>
            </tr>
            <?php foreach ($stmn as $Fila) {
				
                ?>
             <tr>	
               <td><?php echo $Fila["NOMBRE"]; ?></td>
               <td><?php echo $Fila["IMPORTE"]; ?></td>
               <td><?php echo $Fila["FECHAEMISION"]; ?> </td>
               
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
function facturasPeriodo($conexion, $IdC, $FechaI,$FechaF){
    try{
        $Comando_sql =  " SELECT Nombre, Importe, FechaEmision FROM EMPRESAS NATURAL JOIN FACTURAS WHERE :FechaI<=fechaemision and fechaemision<=:FechaF";
        $stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":FechaI", $FechaI);
        $stmn -> bindParam(":FechaF", $FechaF);
        $stmn -> execute();
        return $stmn;
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
 }
}

?>

<?php
if(isset($_POST["generar"])){

    //Incluimos la librería
    require_once ('html2pdf/html2pdf.class.php');
    ob_start(); 
    include_once 'print.php';
    $html= ob_get_clean();
     
    
   
    
 
    try
    {
    $html2pdf = new HTML2PDF('L','A4','es', true, 'UTF-8'); //Configura la hoja
    $html2pdf->pdf->SetDisplayMode('fullpage'); //Ver otros parámetros para SetDisplaMode
    $html2pdf->writeHTML($html); //Se escribe el contenido
    ob_end_clean();
    $html2pdf->Output('Estadillo.pdf'); //Nombre default del PDF
    }
    catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
    }
 
}
?>
<form action="" method="POST">
    <input type="submit" value="Generar PDF" name="generar"/>
</form>
