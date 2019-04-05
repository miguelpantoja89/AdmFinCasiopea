<?php	
    session_start();
    
	include_once ('includes/gestionBD.php');
	$conexion= crearConexionBD(); 
	
	if(!isset($_REQUEST["IdC"])){
		header("Location: inicio.php");
	} else{
		$IdC = $_REQUEST["IdC"];
		if(isset($_REQUEST["consultar"])){
			$_SESSION["IdC"] = $IdC;
			header("Location:infoComunidades.php");
		}
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