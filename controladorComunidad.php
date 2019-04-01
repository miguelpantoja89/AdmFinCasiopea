<?php	
    session_start();
    
    include_once ("gestionBD.php");
	
	if (isset($_REQUEST["IdC"])){
		$com["Direccion"] = $_GET["Direccion"];
		$com["IdC"] = $_REQUEST["IdC"];
		$com["tipo"]=$_REQUEST["tipo"];
		
		$_SESSION["com"] = $com;
			
		if (isset($_REQUEST["editar"])) Header("Location: inicio.php"); 
		else  if (isset($_REQUEST["borrar"]))  Header("Location: accion_borrar_libro.php"); 
	}
	else 
		Header("Location: inicio.php");

?>