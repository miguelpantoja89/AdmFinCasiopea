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
    
    <title>Presupuestos</title>
    
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
                $idpres= $Fila["IDPRESUPUESTO"];
                $fecha = $Fila["FECHAAPLICACION"];
                $anyo = substr($fecha, -2);
                $anyo = $anyo + 1;
                $fecha2 = substr_replace($fecha, $anyo, -2, 2);
                $FechaI = date('d-m-Y',strtotime($fecha));
                $FechaF = date('d-m-Y',strtotime($fecha2));
                $stmn2 = conceptosPresupuesto($conexion, $idpres);
        ?>
                <tr class="breakrow">
               
                    <td><?php echo $Fila["FECHAAPROBACION"]; ?></td>
                    <td><?php echo $Fila["FECHAAPLICACION"]; ?></td>
                    <td><?php echo $Fila["MOTIVO"]; ?></td>
                </tr>
                <?php foreach ($stmn2 as $Fila2) {
                    $tipoServicio = $Fila2["SERVICIO"];
                    $presupuestado = $Fila2["CANTIDAD"];
                    $presupuestado = floatval(str_replace(",", ".", $presupuestado));
                    $facturado = doubleval(facturasServicio($conexion, $IdC, $FechaI, $FechaF, $tipoServicio));
                    $restante = doubleval($presupuestado-$facturado);
                    if($restante>=5){
                        $clase = "verde";
                    }else if($restante>=0){
                        $clase = "amarillo";
                    }else{
                        $clase = "rojo";
                    }
                ?>       
                        <tr class="datarow" style="display:none;background-color: white;">
                             <td><?php echo $Fila2["NOMBRE"]; ?></td>
                             <td><?php printf('%.2f',$presupuestado);?></td>
                             <td><?php echo $Fila2["SERVICIO"];?></td>
                             <td><?php echo $facturado;?></td>
                             <td class="<?php echo $clase?>"><?php printf('%.2f', $restante);?></td>
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
        $Comando_sql =  "SELECT IdPresupuesto, IdC,
        FechaAprobacion,
        FechaAplicacion,
        Motivo FROM PRESUPUESTOS WHERE IdC = :IdC";
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

function facturasServicio($conexion, $IdC, $FechaI,$FechaF,$tipoServicio){
    try{
        $Comando_sql =  " SELECT  COALESCE(SUM(Importe),0) AS total FROM FACTURAS WHERE :FechaI <= FechaEmision and FechaEmision <= :FechaF and IdC = :IdC and TipoServicio=:tp" ;
        $stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":FechaI", $FechaI);
        $stmn -> bindParam(":FechaF", $FechaF);
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> bindParam(":tp", $tipoServicio);
        $stmn -> execute();
        return $stmn -> fetchColumn();
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
 }
}
?>
