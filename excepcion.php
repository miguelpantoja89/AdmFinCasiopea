<?php
session_start();
include_once ("gestionBD.php");
if (isset($_SESSION["excepcion"])) {
	$excepcion = $_SESSION["excepcion"];
	unset($_SESSION["excepcion"]);
} else {
	header("Location: inicio.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css"  href="style.css">
    <title>Excepcion</title>
</head>
<body>
        <?php include_once ('cabecera.php') ?>
        <main>
			<article>
				<div class='contenedor'>
					<section >
						<div >
							<style>
								p{
									text-align:center;
									font-size: 30px;
									font-weight: bold;
								}
								span{
									font-weight: bold;
								}
								a{
   									 text-decoration: none;
   									 color: blue;

								}
							</style>
							<span><p>¡Ups!</p></span><br />
							<span>Ocurrió un problema durante el procesado de los datos.</span><br /><br />
							<span>Información relativa al problema: <?php echo $excepcion; ?></span><br /><br />
							<span>Pulse <a  href="inicio.php">aquí</a> para volver a la página principal.
						</div>
					</section>
				</div>
			</article>
		</main>		
    
</body>
</html>