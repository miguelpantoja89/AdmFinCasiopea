<?php

session_start();

include_once ('includes/gestionBD.php');
$conexion= crearConexionBD();  

  	
if(!isset($_SESSION["IdC"])){
    header("Location: inicio.php");
} else{
    $IdC = $_SESSION["IdC"];
    $Dir=$_SESSION["Dir"];
    
}


$stmn2 =PisoProp($conexion, $IdC);

$stmn3 =Suma($conexion, $IdC);


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
             margin-top:10px;
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
    </style>
    <table  width="*%" border=1 frame="box" rules="all" cellspacing=1 cellpadding=1>
<tr><td>
<img src="img/casiopea.jpg" alt="logo" ></td>
<td id=" logo" style="width:660px"><?php echo $Dir ?></td>
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
            <th style="width:540px" >Suma de Ingresos</th>
            <td><?php echo $Fila3["CAN"]; ?></td>
            <td><?php echo $Fila3["CAN"] - $Fila3["PAG"]; ?></td>
            </tr>
            <?php } ?>
        </table>
        

        

    
</body>
</html>

<?php 
function PisoProp($conexion, $IdC){
    try{
        $Comando_sql =  "SELECT NombreAp,PisoLetra, SUM(PagoExigido) AS PAG, SUM(Cantidad) AS CAN FROM PROPIETARIOS Natural JOIN  PERTENECE natural JOIN CUOTAS NATURAL JOIN PAGOS NATURAL JOIN  PISOS WHERE IdC = :IdC Group by NombreAp,PisoLetra ";
        $stmn = $conexion->prepare($Comando_sql);
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
function Suma($conexion, $IdC){
    try{
        $Comando_sql =  "SELECT  SUM(PagoExigido) AS PAG, SUM(Cantidad) AS CAN FROM  CUOTAS NATURAL JOIN PAGOS  WHERE IdC = :IdC  ";
        $stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> execute();
        return $stmn;
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
 }
}

?>
