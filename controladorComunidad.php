<?php	
    session_start();
    
	include_once ("gestionBD.php");
	$conexion= crearConexionBD(); 
	
	if(!isset($_REQUEST["IdC"])or(!isset($_REQUEST["tipo"]))){
		header("Location: inicio.php");
	} else{
		$IdC = $_REQUEST["IdC"];
		$tipo=$_REQUEST["tipo"];
		if( $tipo=="borrar"){
			try{
				$Comando_sql =  "DELETE FROM COMUNIDADES WHERE IdC = :IdC";
				 $stmn = $conexion->prepare($Comando_sql);
				 $stmn -> bindParam(":IdC", $IdC);
				 $stmn -> execute();
				 } catch(PDOException $e){
					 $_SESSION["excepcion"] = $e -> getMessage();
				 }
	}else if($tipo=="editar"){

	}
	header("Location: inicio.php");

	}



?>