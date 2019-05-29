function validaFormComunidad(){
    function validaForm1() {

		
		var exprCuenta;

		var direccion = document.getElementById("Direccion");
		var numprop = document.getElementById("NumeroPropietarios");
		var cuenta = document.getElementById("CuentaCorriente");
		var saldo = document.getElementById("SaldoInicial");
	

	

		if ($('#Direccion').val().trim() == "") {
			direccion.setCustomValidity("Introduzca una dirección.");
			$('#Direccion').css("background-color", "#ffeeee");
			resultado = false;
		}

		if ($('#apellidos').val().trim() == '') {
			apellidos.setCustomValidity('Introduzca sus apellidos.');
			$('#apellidos').css("background-color", "#ffeeee");
			resultado = false;
		}

		if ($('#telefono').val().trim() == '') {
			telefono.setCustomValidity('Introduzca su número de teléfono.');
			$('#telefono').css("background-color", "#ffeeee");
			resultado = false;
		} 

		if ($('#dni').val() == '') {
			dni.setCustomValidity('Introduzca su DNI');
			$('#dni').css("background-color", "#ffeeee");
			resultado = false;
		}

		
}
function colores(){
	var passField = document.getElementById("pass");
	var strength = passwordStrength(passField.value);
	
	if(!isNaN(strength)){
			var type = "weakpass";
			if(passwordValidation()!=""){
					type = "weakpass";
			}else if(strength > 0.7){
					type = "strongpass";
			}else if(strength > 0.4){
					type = "middlepass";
			}
	}else{
			type = "nanpass";
	}
	passField.className = type;
	
	return type;
}