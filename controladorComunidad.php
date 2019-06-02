<?php	
    session_start();
    
	include_once ('includes/funciones.php');
	$conexion= crearConexionBD(); 
	
	if(!isset($_REQUEST["IdC"])){
		header("Location: inicio.php");
	} else{
		$IdC = $_REQUEST["IdC"];
		if(isset($_REQUEST["consultar"])){
			$_SESSION["IdC"] = $IdC;
			header("Location: infoComunidades.php");
		}
		else if(isset($_REQUEST["borrar"])){

		    
			borrarComunidad($conexion, $IdC);
			header("Location: inicio.php");
	}else if(isset($_REQUEST["editar"])){
		$comunidad["IdC"] =  $IdC;
		$comunidad["direccion"] = $_REQUEST["Direccion"];
		$comunidad["numPropietarios"] = $_REQUEST["NumeroPropietarios"];
		$comunidad["cuenta"] = $_REQUEST["CuentaCorriente"];
		$comunidad["saldoInicial"] = $_REQUEST["SaldoInicial"];
		$comunidad["presidente"] = $_REQUEST["Presidente"];
		
		$errores = validarActualizacionComunidad($conexion, $comunidad);
		if(count($errores)>0){
			echo "<div id=\"div_errores\" class=\"error\">";
        	echo "<h4> Errores en el formulario:</h4>";
        	foreach($errores as $error){
            	echo $error . "<br>";
        	} 
        	echo "</div>";
		}else{
			actualizarComunidad($conexion, $comunidad);
			echo "<div id=\"div_mensaje\" class=\"mensaje\">";
        	echo "Comunidad actualizada satisfactoriamente";
        	echo "</div>";
		}

	}

	}

?>