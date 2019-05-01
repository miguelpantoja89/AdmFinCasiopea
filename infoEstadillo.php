<?php

session_start();

include_once ('includes/gestionBD.php');
  

  	
if(!isset($_SESSION["IdC"])){
    header("Location: inicio.php");
} else{
    $IdC = $_SESSION["IdC"];
}
if(isset($_GET['fechainicio']) and isset($_GET['fechafin'])){
    $FechaI=$_GET['fechainicio'];
    $FechaF=$_GET['fechafin'];
    $conexion= crearConexionBD();
    $stmn = facturasPeriodo($conexion, $IdC, $FechaI, $FechaF);
}

  


unset($_SESSION["form"]);







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
   
    
</body>
</html>


<?php

   

    //Incluimos la librería
    require_once ('html2pdf/html2pdf.class.php');
    ob_start(); 
    include_once 'print.php';
    $html= ob_get_clean();
     
    
   
    
 
    try
    {
    $html2pdf = new HTML2PDF('P','A4','es', true, 'UTF-8'); //Configura la hoja
    $html2pdf->pdf->SetDisplayMode('fullpage'); //Ver otros parámetros para SetDisplaMode
    $html2pdf->writeHTML($html); //Se escribe el contenido
    ob_end_clean();
    $html2pdf->Output('Estadillo.pdf'); //Nombre default del PDF
    }
    catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
    }
 

?>

