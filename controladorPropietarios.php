<?php	
    session_start();
    
	include_once ('includes/gestionBD.php');
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



function borrarPropietario($conexion, $IdP){
	try{
		$Comando_sql =  "DELETE FROM PROPIETARIOS WHERE IdP = :IdP";
		$stmn = $conexion->prepare($Comando_sql);
		$stmn -> bindParam(":IdP", $IdP);
		$stmn -> execute();
	} catch(PDOException $e){
		$_SESSION["excepcion"] = $e -> getMessage();
		header("Location: excepcion.php");
	}
}
function getIdPropietario($conexion, $dni){
    try{
        $stmn = $conexion -> prepare("SELECT IdP FROM Propietarios WHERE DNI=:dni");
        $stmn -> bindParam(':dni', $dni);
        $stmn -> execute();
        return $stmn -> fetchColumn();
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
    }
}


?>