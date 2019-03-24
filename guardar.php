<?php
session_start();
include('gestionBD.php');
$nombre=$_POST["Direccion"];
$correo=$_POST["Propietarios"];
$conexion=crearConexionBD();

try{
    $stmn = $conexion -> prepare('INSERT INTO Propietarios VALUES(:Nombre, :Email)');
    $stmn -> bindParam(':Nombre', $nombre);
    $stmn -> bindParam(':Email', $correo);
    $stmn -> execute();
} catch(PDOException $e){
    $_SESSION["excepcion"] = $e -> GetMessage();
}

echo ("<div>");
echo $_SESSION["excepcion"];
echo ("</div>");
echo $nombre;
echo "<br>";
echo $correo;
$conexion=null;



?>