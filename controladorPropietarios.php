<?php	
    session_start();
    
	include_once ('includes/funciones.php');
	$conexion= crearConexionBD(); 
	
	if(!isset($_POST["Dni"])){
		header("Location: infoPropietarios.php");
	} else{
        $Dni = $_POST["Dni"];
		if(isset($_REQUEST["borrar"])){
            $IdP= getIdPropietario($conexion,$Dni);
			borrarPropietario($conexion, $IdP);
            header("Location: infoPropietarios.php");
        }
	}


?>