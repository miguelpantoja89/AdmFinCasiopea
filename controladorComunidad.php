<?php	
    session_start();
    
	include_once ('includes/gestionBD.php');
	$conexion= crearConexionBD(); 
	
	if(!isset($_REQUEST["IdC"])){
		header("Location: inicio.php");
	} else{
		$IdC = $_REQUEST["IdC"];
		$_SESSION["IdC"] = $IdC;
		if(isset($_REQUEST["consultar"])){
			header("Location: infoComunidades.php");
		}
		else if(isset($_REQUEST["borrar"])){
			borrarComunidad($conexion, $IdC);
			header("Location: inicio.php");
	}else if($tipo=="editar"){

	}

	}


function borrarComunidad($conexion, $IdC){
	try{
		$Comando_sql =  "DELETE FROM COMUNIDADES WHERE IdC = :IdC";
		$stmn = $conexion->prepare($Comando_sql);
		$stmn -> bindParam(":IdC", $IdC);
		$stmn -> execute();
	} catch(PDOException $e){
		$_SESSION["excepcion"] = $e -> getMessage();
		header("Location: excepcion.php");
	}
}
?>