<?php

session_start();
if(!isset($_SESSION["form"])){
    $form["direccion"] = "";
    $form["numPropietarios"] = 0;
    $form["cuenta"] = "";
    $form["saldoInicial"] = "";

    $_SESSION["form"] = $form;
} else{
    $form = $_SESSION["form"];
}

if (isset($_SESSION["errores"])){
    $errores = $_SESSION["errores"];
    unset($_SESSION["errores"]);
}

?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel='stylesheet' type='text/css'  href='style.css'>
    <link rel="icon" href="img/favicon.jpg">
    <title>Alta</title>
    
</head>
<body>
<?php include('cabecera.php') ?>
    <?php include('navegacion.php');?>

    <?php
    if (isset($errores) && count($errores)>0) { 
        echo "<div id=\"div_errores\" class=\"error\">";
        echo "<h4> Errores en el formulario:</h4>";
        foreach($errores as $error){
            echo $error;
        } 
        echo "</div>";
      }
    ?>

    <form class="alta"ction="accioncomunidad.php" method="POST">
        
        <p class="textoin">Direccion: </p><input type="text" name="Direccion" value=<?php echo $form["direccion"] ?>>
        <p class="textoin">Propietarios: </p><input min="1" type="number" name="NumeroPropietarios" value=<?php echo $form["numPropietarios"] ?>>
        <p class="textoin">Num cuenta :</p><input type="text" name="CuentaCorriente" value=<?php echo $form["cuenta"] ?>>
        <p class="textoin">SaldoInicial :</p><input type="text" name="SaldoInicial" value=<?php echo $form["saldoInicial"] ?>>
        <p><input  type="submit" value="enviar"> <input  type="button" value="cancelar" onClick="location.href='inicio.php'"></p>
       
    </form>
    
    <?php
    $mensaje = "";
     if(isset($_SESSION["mensaje"])){
        $mensaje = $_SESSION["mensaje"];
        unset($_SESSION["mensaje"]);
     }elseif (isset($_SESSION["excepcion"])) {
        $mensaje = $_SESSION["excepcion"];
        unset($_SESSION["excepcion"]);
     }
     echo $mensaje;
     ?>
    <?php include('foot.php') ?>
</body>
</html>