<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css"  href="style.css">
    <title>Alta</title>
    
</head>
<body>
<?php include('cabecera.php') ?>
    <?php include('navegacion.php') ?>

    <form action="accioncomunidad.php" method="POST">
        
        <p class="textoin">Direccion: </p><input type="text" name="Direccion">
        <p class="textoin">Propietarios: </p><input type="number" name="NumeroPropietarios">
        <p class="textoin">Num cuenta :</p><input type="text" name="CuentaCorriente">
        <p class="textoin">SaldoInicial :</p><input type="text" name="SaldoInicial">
        <p><input  type="submit" value="enviar"></p>
    </form>
    
    <?php include('foot.php') ?>
</body>
</html>