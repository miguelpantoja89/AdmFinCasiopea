<?php

session_start();

include_once ('includes/funciones.php');
$conexion= crearConexionBD();  

  	
if(!isset($_SESSION["IdC"])){
    header("Location: inicio.php");
} else{
    $IdC = $_SESSION["IdC"];
    
    
    
}
if(isset($_GET['fechainicio']) and isset($_GET['fechafin'])){
    $FechaI= date('d-m-Y',strtotime($_GET['fechainicio']));
    $FechaF= date('d-m-Y',strtotime($_GET['fechafin']));
    $ar = direccionComunidad($conexion, $IdC);
$stmn2 =PisoProp($conexion, $IdC ,  $FechaI, $FechaF);

$stmn3 =Suma($conexion, $IdC ,  $FechaI, $FechaF);
$fechaActual = date('d-m-Y');
$stmn4=facturas($conexion,$IdC,$FechaI,$FechaF);
$stmn5 =Suma2($conexion, $IdC, $FechaI, $FechaF);
}else{
    $FechaI="01-01-2017";
    $FechaF=  date('d-m-Y');
    $ar = direccionComunidad($conexion, $IdC);
$stmn2 =PisoProp($conexion, $IdC,  $FechaI, $FechaF);

$stmn3 =Suma($conexion, $IdC,  $FechaI, $FechaF);
$fechaActual = date('d-m-Y');
$stmn4=facturas($conexion,$IdC,$FechaI, $FechaF);
$stmn5 =Suma2($conexion, $IdC, $FechaI, $FechaF);

}
if(isset($_GET['refrescar'])){
    $FechaI="01-01-2017";
    $FechaF=  date('d-m-Y');
    $ar = direccionComunidad($conexion, $IdC);
$stmn2 =PisoProp($conexion, $IdC,  $FechaI, $FechaF);

$stmn3 =Suma($conexion, $IdC,  $FechaI, $FechaF);
$fechaActual = date('d-m-Y');
$stmn4=facturas($conexion,$IdC,$FechaI, $FechaF);
$stmn5 =Suma2($conexion, $IdC, $FechaI, $FechaF);
}




 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css"  href="css/style.css">
    <link rel="icon" href="img/favicon.jpg">
    <title>Document</title>
</head>
<body>
<?php include('cabecera.php') ?>
    <?php include('navegacion2.php') ?>
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
    <div class="contenedor">
    <table  width="*%" border=1 frame="box" rules="all" cellspacing=1 cellpadding=1>
<tr>
<td id=" logo" style="width:330px;"> <?php echo $ar ?> <br> <br>  Estadillo desde el <?php echo $FechaI ?> hasta el <?php echo $FechaF ?> 
<button style="float:right"><a href="infoEstadillo.php?FechaI=<?php echo $FechaI ?>&FechaF=<?php echo $FechaF ?>"> Generar PDF </a></button>
</td>
</tr></table> 
   
    <table>
            <tr>
            <th>Piso</th>
            <th>Propietario</th>
            <th>Cargo</th>
            <th>Cantidad</th>
            <th>Pendiente de pago</th>
            </tr>
            <?php foreach ($stmn2 as $Fila2) {
				
                ?>
             <tr>	
               <td><?php echo $Fila2["PISOLETRA"]; ?></td>
               <td><?php echo $Fila2["NOMBREAP"]; ?></td>
               <td><?php echo $Fila2["PAG"]; ?></td>
               <td><?php echo $Fila2["CAN"]; ?></td>
               <td><?php echo $Fila2["CAN"] - $Fila2["PAG"]; ?></td>
               
            </tr>
            
       
               <?php } ?>
                 
        </table>
        <table>
        <?php foreach ($stmn3 as $Fila3) {
				
                ?> 
            <tr>
            <th style="width:56.3%" >Suma de Ingresos</th>
            <td  style="width:16.1%"><?php echo $Fila3["CAN"]; ?></td>
            <td><?php echo $Fila3["CAN"] - $Fila3["PAG"]; ?></td>
            </tr>
            <?php $ing= $Fila3["CAN"];} ?>
        </table>
        <div id="separador"></div>
        <table>
            <tr>
            <th></th>
            <th>Servicios</th>
            <th>Cargos</th>
            <th>Pagos</th>
            <th>Pendiente de pago</th>
            </tr>
            <?php foreach ($stmn4 as $Fila4) {
				
                ?>
             <tr>	
               <td></td>
               <td><?php echo $Fila4["TIPOSERVICIO"]; ?></td>
               <td><?php echo $Fila4["IMP"]; ?></td>
               <td><?php echo $Fila4["IMP"]; ?></td>
               <td><?php echo $Fila4["IMP"] - $Fila4["IMP"]; ?></td>
               
            </tr>
            
       
               <?php } ?>
                 
        </table>
        <table>
        <?php foreach ($stmn5 as $Fila5) {
				
                ?> 
            <tr>
            <th style="width:46.3%" >Suma de Pagos</th>
            <td style="width: 16.1%"><?php echo $Fila5["IMP"]; ?></td>
            <td><?php echo $Fila5["IMP"] - $Fila5["IMP"]; ?></td>
            </tr>
        
            <?php  $pago= $Fila5["IMP"];} ?>
        </table>
        <table>
        
            <tr>
            <th style="width:70%" >Saldo del banco</th>
            <td><?php   echo $pago - $ing ?></td>
            </tr>
          
        </table>
        
        </div>

        

    
</body>
</html>


