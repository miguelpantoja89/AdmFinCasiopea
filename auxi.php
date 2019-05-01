<?php
session_start();
require_once("includes/gestionBD.php");
if(isset($_GET["Ident"])){
	
	$conexion = crearConexionBD();
	$resultado = informacionComunidad($conexion, $_GET["Ident"]);
	
	if($resultado != NULL){
		
		foreach($resultado as $form){
            echo "<input type='" . "text" . "' value='" . $form["DIRECCION"] . "'/>";
            echo "<input type='" . "number" . "' value='" . $form["NUMEROPROPIETARIOS"] . "'/>";
            echo "<input type='" . "text" . "' value='" . $form["CUENTACORRIENTE"] . "'/>";
            echo "<input type='" . "text" . "' value='" . $form["SALDOINICIAL"] . "'/>";
            echo "<input type='" . "submit" . "' value='" . "enviar" . "'/>";
           
           

          
           
          
			
		}
	}
	
	cerrarConexionBD($conexion);
	unset($_GET["Ident"]);
}
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
?>