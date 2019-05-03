<?php

session_start();
if(!isset($_SESSION["form"])){
    $form["NombreAp"] = "";
    $form["Dni"] = " ";
    $form["PisoLetra"] = " ";
    $form["Telefono"] = "";
    $form["Email"] = "";

    $_SESSION["form"] = $form;
} else{
    $form = $_SESSION["form"];
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
    <?php include('navegacion2.php');?>

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

    <form class="alta" action="accionPropietario.php" method="POST">
        
        <p class="textoin">Nombre y Apellidos: </p><input type="text" name="NombreAp" value=<?php echo $form["NombreAp"] ?>>
        <p class="textoin">DNI: </p><input  type="text" name="Dni" value=<?php echo $form["Dni"] ?>>
        <p class="textoin">Piso y Letra: </p><input  type="text" name="PisoLetra" value=<?php echo $form["PisoLetra"] ?>>
        <p class="textoin">Telefono :</p><input type="text" name="Telefono" value=<?php echo $form["Telefono"] ?>>
        <p class="textoin">Email :</p><input type="text" name="Email" value=<?php echo $form["Email"] ?>>
        <br>
        <br>
        <br>
        <p><input  type="submit" value="enviar"> <input  type="button" value="cancelar" onClick="location.href='infoPropietarios.php'"></p>
       
    </form>

    <form class="alta" action="accionPropietarios.php" method="POST" enctype="multipart/form-data">
        <label class="textoin">Importar archivo CSV</label> <input
            type="file" name="file" id="file" accept=".csv">
        <button type="submit" id="submit" name="import"
            class="btn-submit">Import</button>
        <br />
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