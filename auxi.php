<?php
session_start();
require_once("includes/gestionBD.php");
if(isset($_GET["Ident"])){
	// Abrimos una conexión con la BD y consultamos la lista de municipios dada una provincia
	$conexion = crearConexionBD();
	$resultado = informacionComunidad($conexion, $_GET["Ident"]);
	
	if($resultado != NULL){
		// Para cada municipio del listado devuelto
		foreach($resultado as $form){
            echo "<input type='" . "text" . "' value='" . $form["DIRECCION"] . "'/>";
            echo "<input type='" . "number" . "' value='" . $form["NUMEROPROPIETARIOS"] . "'/>";
            echo "<input type='" . "text" . "' value='" . $form["CUENTACORRIENTE"] . "'/>";
            echo "<input type='" . "text" . "' value='" . $form["SALDOINICIAL"] . "'/>";
            echo "<input type='" . "submit" . "' value='" . "enviar" . "'/>";
           

          
           
          
			
		}
	}
	// Cerramos la conexión y borramos de la sesión la variable "provincia"
	cerrarConexionBD($conexion);
	unset($_GET["Ident"]);
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