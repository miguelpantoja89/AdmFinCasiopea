<?php
session_start();
include_once ('includes/gestionBD.php');
include_once ('includes/paginacion_consulta.php');
/////////////////////////////////////////////////////////////
if (isset($_SESSION["paginacion"]))
	$paginacion = $_SESSION["paginacion"];
	
$pagina_seleccionada = isset($_GET["PAG_NUM"]) ? (int)$_GET["PAG_NUM"] : (isset($paginacion) ? (int)$paginacion["PAG_NUM"] : 1);
$pag_tam = isset($_GET["PAG_TAM"]) ? (int)$_GET["PAG_TAM"] : (isset($paginacion) ? (int)$paginacion["PAG_TAM"] : 5);

if ($pagina_seleccionada < 1) 		$pagina_seleccionada = 1;
if ($pag_tam < 1) 		$pag_tam = 5;

	
unset($_SESSION["paginacion"]);
///////////////////////////////////////////////////////////////////777
$conexion= crearConexionBD();
/////////////////////////////////////////////////////////////!!!!!!
$Comando_sql =  'SELECT IdC, DIRECCION FROM COMUNIDADES';
$Resultado=$conexion->query($Comando_sql);
//////////////////////////////////////////////////////////////////////
$total_registros = total_consulta($conexion, $Comando_sql);
$total_paginas = (int)($total_registros / $pag_tam);
if ($total_registros % $pag_tam > 0)		$total_paginas++;

if ($pagina_seleccionada > $total_paginas)		$pagina_seleccionada = $total_paginas;

	// Generamos los valores de sesión para página e intervalo para volver a ella después de una operación
$paginacion["PAG_NUM"] = $pagina_seleccionada;
$paginacion["PAG_TAM"] = $pag_tam;
$_SESSION["paginacion"] = $paginacion;

$filas = consulta_paginada($conexion, $Comando_sql, $pagina_seleccionada, $pag_tam);
?>


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
    <?php include_once ('cabecera.php') ?>
    <?php include_once ('navegacion.php') ?>
  
    <main>
    <article class="contenedor">
<div class= "caja3">
<form method="get" action="inicio.php">

			<input id="PAG_NUM" name="PAG_NUM" type="hidden" value="<?php echo $pagina_seleccionada?>"/>

			Mostrando

			<input id="PAG_TAM" name="PAG_TAM" type="number"

				min="1" max="<?php echo $total_registros; ?>"

				value="<?php echo $pag_tam?>" autofocus="autofocus" />

			entradas de <?php echo $total_registros?>

			<input type="submit" value="Cambiar">

		</form>
</div>


       <section>
        
           
             <?php foreach ($filas as $Fila) {
					
				?>	
			
       
    
        <form class="enlaces" action="controladorComunidad.php" method="post" >
            
            <input id="IdC" name="IdC" type="hidden" value="<?php echo $Fila["IDC"];?>" />
            <input id="Dir" name="Dir" type="hidden" value="<?php echo $Fila["DIRECCION"];?>" />
                
                <div class="caja"><?php echo $Fila["DIRECCION"]; ?>
                    
                    <button id="consultar" name="consultar" type="submit" class="editar_fila">
                    <img src="img/info.png" class="editar_fila" alt="informaciñon">
                    </button>

                    <button id="editar" name="editar" type="submit" class="editar_fila">
				    <img src="img/pencil.png" class="editar_fila" alt="modificación">
                    </button>
                
                    <button id="borrar" name="borrar" type="submit" class="editar_fila">
				    <img src="img/trash.png" class="editar_fila" alt="Borrar ">
				    </button>
                
                
                </div>
        
        </form>
        
      
       

    
    
    <?php } ?>
           





        <div >
                        
                        <button class="boton"><a href="alta.php">Dar de Alta</a></button>
           
                    
        </div>
        <div class="caja2" >

<?php


    for( $pagina = 1; $pagina <= $total_paginas; $pagina++ )

        if ( $pagina == $pagina_seleccionada) { 	?>

           <span class="current"> <?php echo $pagina; ?></span> 

<?php }	else { ?>
            
            <a href="inicio.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"> <?php echo $pagina; ?></a>

<?php } ?>

</div>
        <?php
        if(isset($_SESSION["excepcion"])){
         
            header("Location: excepcion.php");
           
        }?>
         </article>
        </section>
    

    </main>
    <?php include_once ('foot.php') ?>
    
</body>
</html>
