function validaFormComunidad(){
    function validaForm1() {

		
		var exprCuenta=

		var direccion = document.getElementById("Direccion");
		var numprop = document.getElementById("NumeroPropietarios");
		var cuenta = document.getElementById("CuentaCorriente");
		var saldo = document.getElementById("SaldoInicial");
	

		var numeroDNI = dni.value.substr(0, 8);
		var letra = dni.value.substr(-1);

		var resultado = true;

		if ($('#nombre').val().trim() == "") {
			nombre.setCustomValidity("Introduzca su nombre.");
			$('#nombre').css("background-color", "#ffeeee");
			resultado = false;
		}else if(!exprTildes.test($('#nombre').val().trim())){
			nombre.setCustomValidity("Introduzca un nombre válido.");
			$('#nombre').css("background-color", "#ffeeee");
			resultado = false;
		} else {
			nombre.setCustomValidity("");
			$('#nombre').css("background-color", "white");
		}

		if ($('#apellidos').val().trim() == '') {
			apellidos.setCustomValidity('Introduzca sus apellidos.');
			$('#apellidos').css("background-color", "#ffeeee");
			resultado = false;
		}else if(!exprTildes.test($('#apellidos').val().trim())){
			apellidos.setCustomValidity('Introduzca unos apellidos válidos.');
			$('#apellidos').css("background-color", "#ffeeee");
			resultado = false;
		} else {
			apellidos.setCustomValidity("");
			$('#apellidos').css("background-color", "white");
		}

		if ($('#telefono').val().trim() == '') {
			telefono.setCustomValidity('Introduzca su número de teléfono.');
			$('#telefono').css("background-color", "#ffeeee");
			resultado = false;
		} else if (!exprNumero.test($('#telefono').val().trim())) {
			telefono.setCustomValidity('Un número de teléfono solo puede contener números.');
			$('#telefono').css("background-color", "#ffeeee");
			resultado = false;
		} else if ($('#telefono').val().trim().length < 9) {
			telefono.setCustomValidity('Introduzca un número de teléfono correcto');
			$('#telefono').css("background-color", "#ffeeee");
			resultado = false;
		} else {
			telefono.setCustomValidity("");
			$('#telefono').css("background-color", "white");
		}

		if ($('#dni').val() == '') {
			dni.setCustomValidity('Introduzca su DNI');
			$('#dni').css("background-color", "#ffeeee");
			resultado = false;
		} else if (!($('#dni').val().trim().length == 9) || (!exprDNI.test($('#dni').val().trim()))) {
			dni.setCustomValidity('Introduzca un DNI válido');
			$('#dni').css("background-color", "#ffeeee");
			resultado = false;
		} else if (letra != letraDNI(numeroDNI)) {
			dni.setCustomValidity('El DNI debe contener la letra adecuada');
			$('#dni').css("background-color", "#ffeeee");
			resultado = false;
		} else {
			dni.setCustomValidity("");
			$('#dni').css("background-color", "white");
		}

		if ($('#email').val().trim() == '') {
			email.setCustomValidity('Introduzca su email.');
			$('#email').css("background-color", "#ffeeee");
			resultado = false;
		} else if (!exprEmail.test($('#email').val().trim())) {
			email.setCustomValidity('Introduzca un email correcto.');
			$('#email').css("background-color", "#ffeeee");
			resultado = false;
		} else if (!exprEmailAlum.test($("#email").val().trim())) {
			email.setCustomValidity("Introduzca un email acabado en @alum.es.");
			$("#email").css("background-color", "#ffeeee");
			resultado = false;
		} else {
			email.setCustomValidity("");
			$('#email').css("background-color", "white");
		}
		if ($('#hombre').attr('checked') == false && $('#mujer').attr('checked') == false) {
			hombre.setCustomValidity("Seleccione un sexo.");
			mujer.setCustomValidity("Seleccione un sexo.");
			$("#hombre").css("background-color", "#ffeeee");
			$("#mujer").css("background-color", "#ffeeee");
			resultado = false;
		} else {
			hombre.setCustomValidity("");
			mujer.setCustomValidity("");
			$('#hombre').css("background-color", "white");
			$('#mujer').css("background-color", "white");
		}
		if ($('#esp').attr('checked') == false && $('#eng').attr('checked') == false) {
			esp.setCustomValidity("Seleccione un sexo.");
			eng.setCustomValidity("Seleccione un sexo.");
			$("#esp").css("background-color", "#ffeeee");
			$("#eng").css("background-color", "#ffeeee");
			resultado = false;
		} else {
			esp.setCustomValidity("");
			eng.setCustomValidity("");
			$('#esp').css("background-color", "white");
			$('#eng').css("background-color", "white");
		}
		if ($('#direccion').val().trim() == '') {
			direccion.setCustomValidity('Introduzca su dirección');
			$('#direccion').css("background-color", "#ffeeee");
			resultado = false;
		} else {
			direccion.setCustomValidity("");
			$('#direccion').css("background-color", "white");
		}
		if ($("#fecha").val().trim() == "") {
			fecha.setCustomValidity("Seleccione su fecha de nacimiento.");
			$("#fecha").css("background-color", "#ffeeee");
			resultado = false;
		} else if (!exprFecha.test( formatearFecha($('#fecha').val().trim()))) {
			fecha.setCustomValidity("Formato no correcto.");
			$("#fecha").css("background-color", "#ffeeee");
			resultado = false;
		}else if( calcularEdad(formatearFecha($('#fecha').val().trim())) < 0){
			fecha.setCustomValidity('La fecha debe ser anterior a la actual.');
			$('#fecha').css("background-color", "#ffeeee");
			resultado = false;
		} else if (calcularEdad(formatearFecha($('#fecha').val().trim())) < 18 ) {
			fecha.setCustomValidity("Debes ser mayor de edad.");
			$('#fecha').css("background-color", "#ffeeee");
			resultado = false;
		} else {
			fecha.setCustomValidity("");
			$('#fecha').css("background-color", "white");
		}

		if ($("#provincia").val() != "Almería" && $("#provincia").val() != "Cádiz" && $("#provincia").val() != "Córdoba" && $("#provincia").val() != "Granada" && $("#provincia").val() != "Huelva" && $("#provincia").val() != "Jaén" && $("#provincia").val() != "Sevilla" && $("#provincia").val() != "Málaga" || $("#provincia") == "") {
			provincia.setCustomValidity('Introduzca su provincia');
			$('#provincia').css("background-color", "#ffeeee");
			resultado = false;
		} else {
			direccion.setCustomValidity("");
			$('#provincia').css("background-color", "white");
		}

		if ($('#cpostal').val().trim() == '') {
			cPostal.setCustomValidity('Introduzca su código postal');
			$('#cpostal').css("background-color", "#ffeeee");
			resultado = false;
		} else if (!($('#cpostal').val().trim().length == 5) || (!exprNumero.test($('#cpostal').val()))) {
			cPostal.setCustomValidity('Introduzca un código postal válido');
			$('#cpostal').css("background-color", "#ffeeee");
			resultado = false;
		} else {
			cPostal.setCustomValidity("");
			$('#cpostal').css("background-color", "white");
		}

		return resultado;
	}

}