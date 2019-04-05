<?php
session_start();
include_once ("includes/gestionBD.php");
$conexion= crearConexionBD();

$Comando_sql =  "SELECT IdEmpresa,
Nombre,
Direccion,
Telf
FROM EMPRESAS";
$stmn = $conexion->query($Comando_sql);


?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet"   href="style.css">
    <link rel="icon" href="img/favicon.jpg">

    
    <title>Empresas</title>
</head>
<body>
    <style>
    table,td,tr,th{
    border: 1px solid black;
    border-collapse: collapse;
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;

   }
    table{
      width:100%;
      
      
      
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
    </style>    
    <?php include('cabecera.php') ?>
    <?php include('navegacion.php') ?>
    <main>
   
       <section>
        <article class="inp">
            <div class="contenedor">
            <table>
            <tr>
            <th>Nombre</th>
            <th>Direccion</th>
            <th>Teléfono</th>
            </tr>
            <?php foreach ($stmn as $Fila) {
				
                    ?>
                 <tr>	
                   <td><?php echo $Fila["NOMBRE"]; ?></td>
                   <td><?php echo $Fila["DIRECCION"]; ?></td>
                   <td><?php echo $Fila["TELF"]; ?></td>
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