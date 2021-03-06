<?php
session_start();
include_once('includes/gestionBD.php');

if(!isset($_SESSION["IdC"])){
    header("Location: inicio.php");
} else{
    $IdC = $_SESSION["IdC"];
}

if(isset($_SESSION["mensaje"])){
    $mensaje = $_SESSION["mensaje"];
    unset($_SESSION["mensaje"]);
}

if (isset($_SESSION["errores"])){
    $errores = $_SESSION["errores"];
    unset($_SESSION["errores"]);
}
?>

<!DOCTYPE html>
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
        
    <?php include('cabecera.php') ?>
    <?php include('navegacion2.php') ?>
    
    <?php
    if(isset($mensaje)){
        echo "<div id=\"div_mensaje\" class=\"mensaje\">";
        echo "<h3>" . $mensaje . "</h3>";
    }

    if (isset($errores) && count($errores)>0) { 
        echo "<div id=\"div_errores\" class=\"error\">";
        echo "<h4> Errores en el formulario:</h4>";
        foreach($errores as $error){
            echo $error;
            echo "<br/>";
        } 
        echo "</div>";
      }
    ?>

<form class="alta" action="accionPropietarios.php" method="POST" enctype="multipart/form-data">
        <label class="col-md-4 control-label">Importar archivo CSV</label> <input
            type="file" name="file" id="file" accept=".csv">
        <button type="submit" id="submit" name="import"
            class="btn-submit">Import</button>
        <br />
</form>

    <!---<?php include('foot.php') ?>--->
    
</body>
</html>