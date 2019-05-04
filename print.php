<?php

session_start();

include_once ('includes/gestionBD.php');
$conexion= crearConexionBD();  

  	
if(!isset($_SESSION["IdC"])){
    header("Location: inicio.php");
} else{
    $IdC = $_SESSION["IdC"];
    $FechaI= $_GET['FechaI'];
    $FechaF=  $_GET['FechaF'];
    $ar = direccionComunidad($conexion, $IdC);
    $stmn2 =PisoProp($conexion, $IdC,  $FechaI, $FechaF);

    $stmn3 =Suma($conexion, $IdC,  $FechaI, $FechaF);
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
    <title>Document</title>
</head>
<body>
    <style>
        table,td,tr,th{
             border: 1px solid black;
             border-collapse: collapse;
             display:inline;
             margin-left:50px;
             margin-top:30px;
             margin-bottom:20px;
             width:50%;
            
            }
             table{
               width:80%;
               
               
               
           }
         th{
            color: white;
            background-color: #565656;
            opacity:0.6;
           }
         th,tr, td {
                padding: 15px;
                text-align: left;
         }
         img{
             width:250px;
             height: 150px;
         }
         #logo{
             font-size:30px;
             text-align:center;

         }
         #separador{
             margin-top: 1005px;
             margin-bottom:1000px;
         }
    </style>
    <table  width="*%" border=1 frame="box" rules="all" cellspacing=1 cellpadding=1>
<tr><td>
<img src="img/casiopea.jpg" alt="logo" ></td>
<td id=" logo" style="width:330px;"> <?php echo $ar ?> <br> <br>   Estadillo de: <?php echo $FechaI ?> <br> a <?php echo $FechaF ?></td>
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
            <th style="width:54%" >Suma de Ingresos</th>
            <td><?php echo $Fila3["CAN"]; ?></td>
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
            <th style="width:340px" >Suma de Pagos</th>
            <td><?php echo $Fila5["IMP"]; ?></td>
            <td><?php echo $Fila5["IMP"] - $Fila5["IMP"]; ?></td>
            </tr>
        
            <?php  $pago= $Fila5["IMP"];} ?>
        </table>
        <table>
        
            <tr>
            <th style="width:340px" >Saldo del banco</th>
            <td><?php   echo $pago - $ing ?></td>
            </tr>
          
        </table>
        
        

        

    
</body>
</html>

<?php 
function PisoProp($conexion, $IdC,  $FechaI, $FechaF){
    try{
        $Comando_sql =  "SELECT NombreAp,PisoLetra, SUM(PagoExigido) AS PAG, SUM(Cantidad) AS CAN FROM PROPIETARIOS Natural JOIN  PERTENECE natural JOIN CUOTAS NATURAL JOIN PAGOS NATURAL JOIN  PISOS WHERE :FechaI <= FechaPago  and FechaPago <= :FechaF  and :FechaI <= Mes  and Mes <= :FechaF and IdC = :IdC Group by NombreAp,PisoLetra ";
        $stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":FechaI", $FechaI);
        $stmn -> bindParam(":FechaF", $FechaF);
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> execute();
        return $stmn;
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
 }
}

?>
<?php 
function Suma($conexion, $IdC ,  $FechaI, $FechaF){
    try{
        $Comando_sql =  "SELECT  SUM(PagoExigido) AS PAG, SUM(Cantidad) AS CAN FROM  CUOTAS NATURAL JOIN PAGOS  WHERE :FechaI <= FechaPago  and FechaPago <= :FechaF  and :FechaI <= Mes  and Mes <= :FechaF and IdC = :IdC   ";
        $stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":FechaI", $FechaI);
        $stmn -> bindParam(":FechaF", $FechaF);
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> execute();
        return $stmn;
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
 }
}

?>
<?php 
function facturas($conexion, $IdC , $FechaI, $FechaF){
    try{
        
        $Comando_sql =  "SELECT TipoServicio, SUM(Importe) AS IMP FROM FACTURAS  WHERE :FechaI <= FechaEmision  and FechaEmision <= :FechaF and IdC = :IdC  GROUP BY TipoServicio";
        $stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":FechaI", $FechaI);
        $stmn -> bindParam(":FechaF", $FechaF);
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> execute();
        return $stmn;
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
 }
}

?>
<?php 
function Suma2($conexion, $IdC,  $FechaI, $FechaF){
    try{
        $Comando_sql =  "SELECT  SUM(Importe) AS IMP FROM FACTURAS  WHERE :FechaI <= FechaEmision  and FechaEmision <= :FechaF and IdC = :IdC  ";
        $stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":FechaI", $FechaI);
        $stmn -> bindParam(":FechaF", $FechaF);
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> execute();
        return $stmn;
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
    }
}

function direccionComunidad($conexion, $IdC){
    try{
        $Comando_sql =  "SELECT  Direccion FROM  Comunidades  WHERE IdC = :IdC  ";
        $stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> execute();
        $result = $stmn -> fetchColumn();
        return $result;
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
    }
}

?>
