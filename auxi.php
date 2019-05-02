<?php
session_start();
require_once("includes/gestionBD.php");
if(isset($_GET["Ident"])){
	$IdC = $_GET["Ident"];
	$conexion = crearConexionBD();
	$resultado = informacionComunidad($conexion, $IdC);
	
	if($resultado != NULL){
		
		foreach($resultado as $form){
            echo "<form id='update_form_".$IdC."' class='update_form' method='post' action='controladorComunidad.php'>";
            echo "<input  id='IdC' name='IdC' type='hidden' value='".$IdC."'/> ";
            echo "<input  id='editar' name='editar' type='hidden' value=''/> ";
            echo "<input type='" . "text" . "' name='Direccion' value='" . $form["DIRECCION"] . "'/>";
            echo "<input type='" . "number" . "' name='NumeroPropietarios' value='" . $form["NUMEROPROPIETARIOS"] . "'/>";
            echo "<input type='" . "text" . "' name='CuentaCorriente' value='" . $form["CUENTACORRIENTE"] . "'/>";
            echo "<input type='" . "text" . "' name='SaldoInicial' value='" . $form["SALDOINICIAL"] . "'/>";
            echo "<input id='".$IdC."' class='enviar' type='" . "submit" . "' value='Enviar'/>";
            echo "</form>";
           

          
           
          
			
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