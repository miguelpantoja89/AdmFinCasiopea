<?php

session_start();

include_once ('includes/funciones.php');
$conexion= crearConexionBD();  

  	
if(!isset($_SESSION["IdC"])){
    header("Location: inicio.php");
} else{
    $IdC = $_SESSION["IdC"];
}

if(isset($_REQUEST["borrar"])){
    $IdFactura = $_REQUEST["IdFactura"];
    borrarFactura($conexion, $IdC, $IdFactura);
}

if(isset($_GET['fechainicio']) and isset($_GET['fechafin'])){
    $FechaI= date('d-m-Y',strtotime($_GET['fechainicio']));
    $FechaF= date('d-m-Y',strtotime($_GET['fechafin']));
    $stmn = facturasPeriodo($conexion, $IdC, $FechaI, $FechaF);
}else{
    $FechaI="01-01-2017";
    $FechaF=  date('d-m-Y');
    $stmn = facturasPeriodo($conexion, $IdC, $FechaI, $FechaF);

}
if(isset($_GET['refrescar'])){
    $FechaI="01-01-2017";
    $FechaF=  date('d-m-Y');
    $stmn = facturasPeriodo($conexion, $IdC, $FechaI, $FechaF);
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
    
    <title>Facturas</title>
</head>
<body>
        
    <?php include('cabecera.php') ?>
    <?php include('navegacion2.php') ?>
    <main>
<div class="contenedor">
<div class="caja">
<p> Selecciona un período : </p>
<form action="" method="get">
            <input type="date" name="fechainicio" >
            <input type="date" name="fechafin">
            <input type="submit" value="buscar">
            <input id="refrescar" name="refrescar" type="submit" value="todas las fechas">
             </form>
</div>
</div>      
       <section>
        <article class="inp">
            <div class="contenedor">
            <table>
            <tr>
            <th>Importe</th>
            <th>Fecha de Emisión</th>
            <th>Tipo de Servicio</th>
            <th>Acciones disponibles</th>
            </tr>
            <?php foreach ($stmn as $Fila) {
				
                ?>
             <tr>	
               <td><?php echo $Fila["IMPORTE"]; ?></td>
               <td><?php echo $Fila["FECHAEMISION"]; ?></td>
               <td><?php echo $Fila["TIPOSERVICIO"]; ?></td>
               <td> <form  action="infoFacturas.php" method="post" >
            
            <input id="IdFactura" name="IdFactura" type="hidden" value="<?php echo $Fila["IDFACTURA"];?>" />
                
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

