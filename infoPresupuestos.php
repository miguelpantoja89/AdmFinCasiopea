<?php

session_start();

include_once ('includes/gestionBD.php');
$conexion= crearConexionBD();  

  	
if(!isset($_SESSION["IdC"])){
    header("Location: inicio.php");
} else{
    $IdC = $_SESSION["IdC"];
}

$stmn = presupuestosComunidad($conexion, $IdC);


 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css"  href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <link rel="icon" href="img/favicon.jpg">
    
    <title>Facturas</title>
    <style>
     #container{
        margin:0 auto;
        width:80%;
        overflow:auto;
    }
    table.gridtable {
                margin:0 auto;
                width:95%;
                overflow:auto;
                font-family: helvetica,arial,sans-serif;
                font-size:14px;
                color:#333333;
                border-width: 1px;
                border-color: #666666;
                border-collapse: collapse;
                text-align: center;
        }
        table.gridtable th {
                border-width: 1px;
                padding: 8px;
                border-style: solid;
                border-color: #666666;
                background-color: #F6B4A5;
        }
        table.gridtable td {
                border-width: 1px;
                padding: 8px;
                border-style: solid;
                border-color: #666666;
        }
    </style>
</head>
<body>
        
    <?php include('cabecera.php') ?>
    <?php include('navegacion2.php') ?>
    <main>


  <div class="contenedor">
  <div class="container" id="container">
        <table class="gridtable" id="tableMain">
            <thead>
                <tr class="tableheader">
                  <th>Fecha de Aprobación </th>
                  <th>Fecha de Aplicación</th>
                  <th>Motivo</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($stmn as $Fila) {
                $idpres= getIdPresupuesto($conexion, $IdC);
                $stmn2 = conceptosPresupuesto($conexion, $idpres);
        ?>
                <tr class="breakrow">
               
                    <td><?php echo $Fila["FECHAAPROBACION"]; ?></td>
                    <td><?php echo $Fila["FECHAAPLICACION"]; ?></td>
                    <td><?php echo $Fila["MOTIVO"]; ?></td>
                </tr>
                <?php foreach ($stmn2 as $Fila2) {
				
                ?>
                        <tr class="datarow" style="display:none;">
                             <td><?php echo $Fila2["NOMBRE"]; ?></td>
                             <td><?php echo $Fila2["CANTIDAD"]; ?></td>
                             <td><?php echo $Fila2["SERVICIO"]; ?></td>
                        </tr>
                      <?php } ?>
                <?php } ?>

              
                </tbody>
        </table>
    </div>
</div>







        

    </main>
    <!---<?php include('foot.php') ?>--->
    
</body>
</html>
<script>
		 $( document ).ready(function() {




//collapse and expand sections

//$('.breakrow').click(function(){
$('#tableMain').on('click', 'tr.breakrow',function(){
    $(this).nextUntil('tr.breakrow').slideToggle(200);
});
});


  </script>
<?php 
function presupuestosComunidad($conexion, $IdC){
    try{
        $Comando_sql =  "SELECT IdC,
        FechaAprobacion,
        FechaAplicacion,
        Motivo FROM PRESUPUESTOS  WHERE IdC = :IdC";
        $stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> execute();
        return $stmn;
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
 }
}
function getIdPresupuesto($conexion, $IdC){
    try{
        $stmn = $conexion -> prepare("SELECT IdPresupuesto FROM PRESUPUESTOS WHERE IdC = :IdC");
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> execute();
        return $stmn -> fetchColumn();
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
    }
}

function conceptosPresupuesto($conexion, $IdPresupuesto){
    try{
        $Comando_sql =  "SELECT IdPresupuesto,Nombre,Cantidad,
        Servicio FROM CONCEPTOS  WHERE IdPresupuesto = :IdPresupuesto";
        $stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":IdPresupuesto", $IdPresupuesto);
        $stmn -> execute();
        return $stmn;
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
 }
}
?>
