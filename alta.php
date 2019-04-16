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

if(isset($_SESSION["mensaje"])){
    $mensaje = $_SESSION["mensaje"];
    unset($_SESSION["mensaje"]);
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
            echo $error . "<br>";
        } 
        echo "</div>";
      }
    ?>

    <form class="alta" action="accioncomunidad.php" method="POST">
        
        <p class="textoin">Dirección: </p><input type="text" name="Direccion" value=<?php echo $form["direccion"] ?>>
        <p class="textoin">Número de propietarios: </p><input min="1" type="number" name="NumeroPropietarios" value=<?php echo $form["numPropietarios"] ?>>
        <p class="textoin">Número de  cuenta :</p><input type="text" name="CuentaCorriente" value=<?php echo $form["cuenta"] ?>>
        <p class="textoin">Saldo de Inicio :</p><input type="text" name="SaldoInicial" value=<?php echo $form["saldoInicial"] ?>>
        <br>
        <br>
        <br>
        <p><input  type="submit" value="enviar"> <input  type="button" value="cancelar" onClick="location.href='inicio.php'"></p>
       
    </form>
    
    <?php
    if (isset($mensaje)) { 
        echo "<div id=\"div_mensaje\" class=\"mensaje\">";
        echo $mensaje;
        echo "</div>";
      }
     ?>
    <?php include('foot.php') ?>
</body>
</html>