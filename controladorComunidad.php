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

// FUNCIONES DE VALIDACION
function validarActualizacionComunidad($conexion, $comunidad){
    $errores = array();
    if($comunidad["direccion"]==""){
        $errores[] = "La dirección no puede estar vacía";
    }
    if($comunidad["numPropietarios"]<=0){
        $errores[] = "El número de propietarios debe ser mayor que 0";
    }
    if($comunidad["cuenta"]==""){
        $errores[] = "La cuenta bancaria no puede estar vacía";
    }else if(cuentaBancariaRepetida($conexion, $comunidad["cuenta"])>1){
        $errores[] = "La cuenta bancaria está repetida";    
    }
    if($comunidad["saldoInicial"]==""){
        $errores[] = "El saldo inicial no puede estar vacío";
    }else if($comunidad["saldoInicial"]<0){
        $errores[] = "El saldo inical no puede ser negativo";
    }
    return $errores;
}

function cuentaBancariaRepetida($conexion, $cuenta){
    try{
        $stmn = $conexion -> prepare('SELECT COUNT(*) AS TOTAL FROM Comunidades WHERE CuentaCorriente=:cuenta');
        $stmn -> bindParam(':cuenta', $cuenta);
        $stmn -> execute();
        $repetido = $stmn -> fetchColumn();
        return $repetido;
    } catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> GetMessage();
        header("Location: excepcion.php");
    }
}

function actualizarComunidad($conexion, $comunidad){
	try{
		$stmn = $conexion -> prepare('UPDATE Comunidades SET Direccion=:direccion, numeroPropietarios=:numeroPropietarios, cuentaCorriente=:cuentacorriente, saldoInicial=:saldoInicial, presidente=:presidente WHERE IdC=:IdC');
		$stmn -> bindParam(':direccion', $comunidad["direccion"]);
		$stmn -> bindParam(':numeroPropietarios', $comunidad["numPropietarios"]);
		$stmn -> bindParam(':cuentacorriente', $comunidad["cuenta"]);
		$stmn -> bindParam(':saldoInicial', $comunidad["saldoInicial"]);
		$stmn -> bindParam(':presidente', $comunidad["presidente"]);
		$stmn -> bindParam(':IdC', $comunidad["IdC"]);
		$stmn -> execute();
	} catch(PDOException $e){
		$_SESSION["excepcion"] = $e -> GetMessage();
        header("Location: excepcion.php");
	}
}
?>