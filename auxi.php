<?php
require_once("gestionBD.php");
if(isset($_GET["IdC"])){
	// Abrimos una conexión con la BD y consultamos la lista de municipios dada una provincia
	$conexion = crearConexionBD();
	$resultado = informacionComunidad($conexion, $_GET["IdC"]);
	
	if($resultado != NULL){
		// Para cada municipio del listado devuelto
		foreach($resultado as $form){
           
           echo "<p >Dirección: </p><input type="text" name="Direccion" value=<?php echo $form["direccion"] ?>>";
           echo "  <p >Número de propietarios: </p><input min="1" type="number" name="NumeroPropietarios" value=<?php echo $form["numPropietarios"] ?>>";
           echo " <p >Número de  cuenta :</p><input type="text" name="CuentaCorriente" value= .$form["cuenta"] ">" ";
           echo " <p >Saldo de Inicio :</p><input type="text" name="SaldoInicial" value= .$form["saldoInicial"] .>";
           
            echo "<p><input  type="submit" value="enviar"> <input  type="button" value="cancelar" ></p>";
			
		}
	}
	// Cerramos la conexión y borramos de la sesión la variable "provincia"
	cerrarConexionBD($conexion);
	unset($_GET["IdC"]);
}


// Función que devuelve el listado de municipios de una provincia dada
function informacionComunidad($conexion, $IdC){
    try{
        $Comando_sql =  "SELECT IdC,
        Direccion,
        NumeroPropietarios,
        CuentaCorriente,
        SaldoInicial,
        Presidente FROM COMUNIDADES WHERE IdC = :IdC";
        $stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> execute();
        return $stmn;
    } catch(PDOException $e){
            $_SESSION["excepcion"] = $e -> getMessage();
            header("Location: excepcion.php");
        }
}


// FIN DE EJERCICIO 4 
?>