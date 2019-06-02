<?php
session_start();
include_once ("includes/gestionBD.php");
include_once ('includes/paginacion_consulta.php');
/////////////////////////////////////////////////////////////
if (isset($_SESSION["paginacion"]))
	$paginacion = $_SESSION["paginacion"];
	
$pagina_seleccionada = isset($_GET["PAG_NUM"]) ? (int)$_GET["PAG_NUM"] : (isset($paginacion) ? (int)$paginacion["PAG_NUM"] : 1);
$pag_tam = isset($_GET["PAG_TAM"]) ? (int)$_GET["PAG_TAM"] : (isset($paginacion) ? (int)$paginacion["PAG_TAM"] : 5);

if ($pagina_seleccionada < 1) 		$pagina_seleccionada = 1;
if ($pag_tam < 1) 		$pag_tam = 5;

	
unset($_SESSION["paginacion"]);
$conexion= crearConexionBD();

$Comando_sql =  "SELECT IdEmpresa,
Nombre,
Direccion,
Telf
FROM EMPRESAS";

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
    <link rel="stylesheet"   href="css/style.css">
    <link rel="icon" href="img/favicon.jpg">

    
    <title>Empresas</title>
</head>
<body>
    
    <?php include('cabecera.php') ?>
    <?php include('navegacion.php') ?>
    <main>
   
       <section>
        <article class="inp">
            <div class="contenedor">
            <div class="caja3">
            <form method="get" action="infoEmpresas.php">

                <input id="PAG_NUM" name="PAG_NUM" type="hidden" value="<?php echo $pagina_seleccionada?>"/>

                        Mostrando

                <input id="PAG_TAM" name="PAG_TAM" type="number"

                min="1" max="<?php echo $total_registros; ?>"

                 value="<?php echo $pag_tam?>" autofocus="autofocus" />

            entradas de <?php echo $total_registros?>

                <input type="submit" value="Cambiar">

            </form>
            </div>
            <table>
            <tr>
            <th>Nombre</th>
            <th>Direccion</th>
            <th>Teléfono</th>
            </tr>
            <?php foreach ($filas as $Fila) {
				
                    ?>
                 <tr>	
                   <td><?php echo $Fila["NOMBRE"]; ?></td>
                   <td><?php echo $Fila["DIRECCION"]; ?></td>
                   <td><?php echo $Fila["TELF"]; ?></td>
                </tr>
                   <?php } ?>
                   
            </table>
            <div class="caja2" >

<?php


    for( $pagina = 1; $pagina <= $total_paginas; $pagina++ )

        if ( $pagina == $pagina_seleccionada) { 	?>

           <span class="current"> <?php echo $pagina; ?></span> 

<?php }	else { ?>

            <a href="infoEmpresas.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>

<?php } ?>

</div> 
                </div>    
                
         </article>
        </section>
        

    </main>
    <!---<?php include('foot.php') ?>--->
    
</body>
</html>