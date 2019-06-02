<?php
session_start();
require_once("includes/funciones.php");
if(isset($_GET["Ident"])){
	$IdC = $_GET["Ident"];
	$conexion = crearConexionBD();
    $resultado = informacionComunidad($conexion, $IdC);
    $propietarios = nombrePropietariosComunidad($conexion, $IdC);
	
	if($resultado != NULL){
		
		foreach($resultado as $form){
            echo "<form id='update_form' method='post' action='controladorComunidad.php'>";
            echo "<input  id='IdC_update' name='IdC' type='hidden' value='".$IdC."'/> ";
            echo "<input  id='editar' name='editar' type='hidden' value=''/> ";
            echo "<input id='Direccion' type='" . "text" . "' name='Direccion' value='" . $form["DIRECCION"] . "'/>";
            echo "<input id='NumeroPropietarios' type='" . "number" . "' name='NumeroPropietarios' value='" . $form["NUMEROPROPIETARIOS"] . "'/>";
            echo "<input id='CuentaCorriente' type='" . "text" . "' name='CuentaCorriente' value='" . $form["CUENTACORRIENTE"] . "'/>";
            echo "<input id='SaldoInicial' type='" . "text" . "' name='SaldoInicial' value='" . $form["SALDOINICIAL"] . "'/>";
            echo "<select id='Presidente' name='presidente'>";
            foreach($propietarios as $propietario){
                if($propietario["IDP"]==$form["PRESIDENTE"]){
                    echo "<option value='".$propietario["IDP"]."' selected>".$propietario["NOMBREAP"]."</option>";
                }else{
                    echo "<option value='".$propietario["IDP"]."'>".$propietario["NOMBREAP"]."</option>";
                }
            }
            echo "</select>";
            echo "<input id='update_button' class='enviar' type='" . "button" . "' value='Enviar'/>";
            echo "</form>";
           

          
           
          
			
		}
	}
	
	cerrarConexionBD($conexion);
	unset($_GET["Ident"]);
}

?>