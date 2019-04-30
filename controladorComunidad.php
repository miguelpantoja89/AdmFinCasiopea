<?php	
    session_start();
    
	include_once ('includes/gestionBD.php');
	$conexion= crearConexionBD(); 
	
	if(!isset($_REQUEST["IdC"])){
		header("Location: inicio.php");
	} else{
		$IdC = $_REQUEST["IdC"];
		$Dir = $_REQUEST["DIRECCION"];
		$sal= $_REQUEST["SALDOINICIAL"];
		if(isset($_REQUEST["consultar"])){
			$_SESSION["IdC"] = $IdC;
			$_SESSION["DIRECCION"]=$Dir;
			$_SESSION["SALDOINICIAL"]=$sal;
			header("Location: infoComunidades.php");
		}
		else if(isset($_REQUEST["borrar"])){

		    echo 'alert("quieres borrar")';
			borrarComunidad($conexion, $IdC);
			header("Location: inicio.php");
	}else if(isset($_REQUEST["editar"])){
		$IdC["IdC"]=$_SESSION["IdC"];
		$_SESSION["IdC"] = $IdC;
		header("Location: inicio.php");

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