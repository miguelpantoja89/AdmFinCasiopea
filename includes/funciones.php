<?php

include('includes/gestionBD.php');

function insertarComunidad($conexion, $comunidad){
    try{
        $stmn = $conexion -> prepare('INSERT INTO comunidades (Direccion, NumeroPropietarios, CuentaCorriente, SaldoInicial) VALUES(:Direccion, :NumeroPropietarios,:CuentaCorriente,:SaldoInicial)');
        $stmn -> bindParam(':Direccion', $comunidad["direccion"]);
        $stmn -> bindParam(':NumeroPropietarios', $comunidad["numPropietarios"]);
        $stmn -> bindParam(':CuentaCorriente', $comunidad["cuenta"]);
        $stmn -> bindParam(':SaldoInicial', $comunidad["saldoInicial"]);
        $stmn -> execute();
        $_SESSION["mensaje"] =  "Comunidad añadida satisfactoriamente";
    } catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> GetMessage();
        header("Location: excepcion.php");
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

function nombrePropietariosComunidad($conexion, $IdC){
    try{
        $Comando_sql =  "SELECT IdP,NombreAp FROM PROPIETARIOS Natural JOIN PERTENECE WHERE IdC = :IdC ORDER BY NombreAp ASC";
        $stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> execute();
        return $stmn;
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
 }
}

function saldoComunidad($conexion, $IdC){
    try{
        $stmn = $conexion -> prepare('SELECT SALDO_COMUNIDAD(:IdC) FROM DUAL');
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> execute();
        return $stmn -> fetchColumn();
    }catch (PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
    }
}


// FUNCIONES DE VALIDACION COMUNIDAD
function validarComunidad($conexion, $comunidad){
    $errores = array();
    if($comunidad["direccion"]==""){
        $errores[] = "La dirección no puede estar vacía";
    }
    if($comunidad["numPropietarios"]<=0){
        $errores[] = "El número de propietarios debe ser mayor que 0";
    }
    if($comunidad["cuenta"]==""){
        $errores[] = "La cuenta bancaria no puede estar vacía";
    }else if(cuentaBancariaRepetida($conexion, $comunidad["cuenta"])>0){
        $errores[] = "La cuenta bancaria está repetida";    
    }
    if($comunidad["saldoInicial"]==""){
        $errores[] = "El saldo inicial no puede estar vacío";
    }else if($comunidad["saldoInicial"]<0){
        $errores[] = "El saldo inical no puede ser negativo";
    }
    return $errores;
}

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
    }else if(cuentaBancariaRepetida2($conexion,$comunidad["IdC"], $comunidad["cuenta"])>0){
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

function cuentaBancariaRepetida2($conexion, $IdC, $cuenta){
    try{
		$stmn = $conexion -> prepare('SELECT COUNT(*) AS TOTAL FROM Comunidades WHERE IdC<>:IdC AND CuentaCorriente=:cuenta');
		$stmn -> bindParam(':IdC', $IdC);
        $stmn -> bindParam(':cuenta', $cuenta);
        $stmn -> execute();
        $repetido = $stmn -> fetchColumn();
        return $repetido;
    } catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> GetMessage();
        header("Location: excepcion.php");
    }
}



function insertarPropietario($conexion, $propietario){
    try{
        $stmn = $conexion -> prepare("INSERT INTO Propietarios (NOMBREAP, DNI, TELEFONO, EMAIL) VALUES (:Nombre, :dni, :telefono, :email)");
        $stmn -> bindParam(':Nombre', $propietario["NombreAp"]);
        $stmn -> bindParam(':dni', $propietario["Dni"]);
        $stmn -> bindParam(':telefono', $propietario["Telefono"]);
        $stmn -> bindParam(':email', $propietario["Email"]);
        $stmn -> execute();
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
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

function getNombrePropietario($conexion, $IdP){
    try{
    $stmn = $conexion -> prepare("SELECT NombreAp FROM Propietarios WHERE IdP=:IdP");
    $stmn -> bindParam(":IdP", $IdP);
    $stmn -> execute();
    return $stmn -> fetchColumn();
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
    }
}

// VALIDACION PROPIETARIO
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


function insertarPertenencia($conexion, $IdP, $IdC){
    try{
        $stmn = $conexion -> prepare("INSERT INTO Pertenece (IDP, IDC) VALUES (:idp, :idc)");
        $stmn -> bindParam(':idp', $IdP);
        $stmn -> bindParam(':idc', $IdC);
        $stmn -> execute();
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
    }
}

function validarDNI($conexion, $propietario){
    $error = "";
    if(!preg_match("/^[0-9]{8}[A-Z]$/", $propietario["Dni"])){
        $error = "El DNI de ". $propietario["Dni"] . " no es válido";
    }else{
        try{
            $stmn = $conexion -> prepare('SELECT COUNT(*) AS TOTAL FROM Propietarios WHERE dni=:dni');
            $stmn -> bindParam(':dni', $propietario["Dni"]);
            $stmn -> execute();
            $repetido = $stmn -> fetchColumn();
            if($repetido > 0){
                $error = "El DNI de " . $propietario["NombreAp"] . " (" . $propietario["Dni"] . ") ya existe en la base de datos";
            }
        } catch(PDOException $e){
            $_SESSION["excepcion"] = $e -> GetMessage();
            header("Location: excepcion.php");
        }
    }
    return $error;
}

function insertarPiso($conexion, $IdP, $IdC, $piso){
    try{
        $stmn = $conexion -> prepare("INSERT INTO Pisos (PISOLETRA, IDP, IDC) VALUES (:pisoletra, :idp, :idc)");
        $stmn -> bindParam(':pisoletra', $piso);
        $stmn -> bindParam(':idp', $IdP);
        $stmn -> bindParam(':idc', $IdC);
        $stmn -> execute();
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
    }
}


function validarTelefono($conexion, $propietario){
    $error = "";
    if(!preg_match("/^[0-9]{9}$/", $propietario["Telefono"])){
        $error = "El Telefono de ". $propietario["Telefono"] . " no es válido";
    }else{
        try{
            $stmn = $conexion -> prepare('SELECT COUNT(*) AS TOTAL FROM Propietarios WHERE telefono=:telefono');
            $stmn -> bindParam(':telefono', $propietario["Telefono"]);
            $stmn -> execute();
            $repetido = $stmn -> fetchColumn();
            if($repetido > 0){
                $error = "El Telefono de " . $propietario["NombreAp"] . " (" . $propietario["Telefono"] . ") ya existe en la base de datos";
            }
        } catch(PDOException $e){
            $_SESSION["excepcion"] = $e -> GetMessage();
            header("Location: excepcion.php");
        }
    }
    return $error;
}

function validarEmail($conexion, $propietario){
    $error = "";
    if(!preg_match("/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/", $propietario["Email"])){
        $error = "El Email de ". $propietario["Email"] . " no es válido";
    }else{
        try{
            $stmn = $conexion -> prepare('SELECT COUNT(*) AS TOTAL FROM Propietarios WHERE email=:email');
            $stmn -> bindParam(':email', $propietario["Email"]);
            $stmn -> execute();
            $repetido = $stmn -> fetchColumn();
            if($repetido > 0){
                $error = "El Email de " . $propietario["NombreAp"] . " (" . $propietario["Email"] . ") ya existe en la base de datos";
            }
        } catch(PDOException $e){
            $_SESSION["excepcion"] = $e -> GetMessage();
            header("Location: excepcion.php");
        }
    }
    return $error;
}

function contratosComunidad($conexion, $IdC){
    try{
        $Comando_sql =  "SELECT IdContrato, nombre, fechainicio, fechafin FROM CONTRATOS NATURAL JOIN EMPRESAS WHERE IdC = :IdC";
        $stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> execute();
        return $stmn;
    } catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
    }
}

function borrarContrato($conexion, $IdC, $IdContrato){
	try{
		$Comando_sql =  "DELETE FROM Contratos WHERE IdC = :IdC AND IdContrato=:IdCon";
		$stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> bindParam(":IdCon", $IdContrato);
		$stmn -> execute();
	} catch(PDOException $e){
		$_SESSION["excepcion"] = $e -> getMessage();
		header("Location: excepcion.php");
	}
}

function cuotasComunidad($conexion, $IdC){
    try{
        $Comando_sql =  "SELECT Mes, IdC,
        IdCuota, PagoExigido, NombreAp, Dni FROM CUOTAS NATURAL JOIN PROPIETARIOS  WHERE IdC = :IdC ORDER BY Mes " ;
        $stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> execute();
        return $stmn;
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
 }
}

function borrarCuota($conexion, $IdC, $IdCuota){
	try{
		$Comando_sql =  "DELETE FROM Cuotas WHERE IdC = :IdC AND IdCuota=:IdCuota";
		$stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> bindParam(":IdCuota", $IdCuota);
		$stmn -> execute();
	} catch(PDOException $e){
		$_SESSION["excepcion"] = $e -> getMessage();
		header("Location: excepcion.php");
	}
}


function PisoProp($conexion, $IdC,  $FechaI, $FechaF){
    try{
        $Comando_sql =  "SELECT NombreAp,PisoLetra, SUM(PagoExigido) AS PAG, SUM(Cantidad) AS CAN FROM PROPIETARIOS Natural JOIN  PERTENECE natural JOIN CUOTAS NATURAL JOIN PAGOS NATURAL JOIN  PISOS WHERE :FechaI <= FechaPago  and FechaPago <= :FechaF  and :FechaI <= Mes  and Mes <= :FechaF and IdC = :IdC Group by NombreAp,PisoLetra ";
        $stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":FechaI", $FechaI);
        $stmn -> bindParam(":FechaF", $FechaF);
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> execute();
        return $stmn;
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
 }
}

?>
<?php 
function Suma($conexion, $IdC ,  $FechaI, $FechaF){
    try{
        $Comando_sql =  "SELECT  SUM(PagoExigido) AS PAG, SUM(Cantidad) AS CAN FROM  CUOTAS NATURAL JOIN PAGOS  WHERE :FechaI <= FechaPago  and FechaPago <= :FechaF  and :FechaI <= Mes  and Mes <= :FechaF and IdC = :IdC   ";
        $stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":FechaI", $FechaI);
        $stmn -> bindParam(":FechaF", $FechaF);
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> execute();
        return $stmn;
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
 }
}

?>
<?php 
function facturas($conexion, $IdC , $FechaI, $FechaF){
    try{
        
        $Comando_sql =  "SELECT TipoServicio, SUM(Importe) AS IMP FROM FACTURAS  WHERE :FechaI <= FechaEmision  and FechaEmision <= :FechaF and IdC = :IdC  GROUP BY TipoServicio";
        $stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":FechaI", $FechaI);
        $stmn -> bindParam(":FechaF", $FechaF);
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> execute();
        return $stmn;
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
 }
}

?>
<?php 
function Suma2($conexion, $IdC,  $FechaI, $FechaF){
    try{
        $Comando_sql =  "SELECT  SUM(Importe) AS IMP FROM FACTURAS  WHERE :FechaI <= FechaEmision  and FechaEmision <= :FechaF and IdC = :IdC  ";
        $stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":FechaI", $FechaI);
        $stmn -> bindParam(":FechaF", $FechaF);
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> execute();
        return $stmn;
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
    }
}

function direccionComunidad($conexion, $IdC){
    try{
        $Comando_sql =  "SELECT  Direccion FROM  Comunidades  WHERE IdC = :IdC  ";
        $stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> execute();
        $result = $stmn -> fetchColumn();
        return $result;
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
    }
}

function facturasComunidad($conexion, $IdC){
    try{
        $Comando_sql =  "SELECT IdFactura, IdC,Importe,TO_CHAR(FechaEmision, 'DD-MM-YYYY') AS FechaEmision,TipoServicio FROM FACTURAS  WHERE IdC = :IdC";
        $stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> execute();
        return $stmn;
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
 }
}

?>
<?php 
function facturasPeriodo($conexion, $IdC, $FechaI,$FechaF){
    try{
        $Comando_sql =  " SELECT  IdFactura, Importe,TO_CHAR(FechaEmision, 'DD-MM-YYYY') AS FechaEmision,TipoServicio FROM  FACTURAS WHERE :FechaI <= FechaEmision  and FechaEmision <= :FechaF and IdC = :IdC ORDER BY FechaEmision " ;
        $stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":FechaI", $FechaI);
        $stmn -> bindParam(":FechaF", $FechaF);
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> execute();
        return $stmn;
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
 }
}

function borrarFactura($conexion, $IdC, $IdFactura){
	try{
		$Comando_sql =  "DELETE FROM Facturas WHERE IdC = :IdC AND IdFactura=:IdFactura";
		$stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> bindParam(":IdFactura", $IdFactura);
		$stmn -> execute();
	} catch(PDOException $e){
		$_SESSION["excepcion"] = $e -> getMessage();
		header("Location: excepcion.php");
	}
}

function pagosComunidad($conexion, $IdC){
    try{
        $Comando_sql =  "SELECT FechaPago,IdC,IdPago,
        Cantidad, NombreAp, Dni FROM PAGOS NATURAL JOIN PROPIETARIOS  WHERE IdC = :IdC ORDER BY FechaPago " ;
        $stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> execute();
        return $stmn;
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
 }
}

function borrarPago($conexion, $IdC, $IdPago){
	try{
		$Comando_sql =  "DELETE FROM Pagos WHERE IdC = :IdC AND IdPago=:IdPago";
		$stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> bindParam(":IdPago", $IdPago);
		$stmn -> execute();
	} catch(PDOException $e){
		$_SESSION["excepcion"] = $e -> getMessage();
		header("Location: excepcion.php");
	}
}

function presupuestosComunidad($conexion, $IdC){
    try{
        $Comando_sql =  "SELECT IdPresupuesto, IdC,
        FechaAprobacion,
        FechaAplicacion,
        Motivo FROM PRESUPUESTOS WHERE IdC = :IdC";
        $stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> execute();
        return $stmn;
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
 }
}
function getIdPresupuesto($conexion, $IdC){
    try{
        $stmn = $conexion -> prepare("SELECT IdPresupuesto FROM PRESUPUESTOS WHERE IdC = :IdC");
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> execute();
        return $stmn -> fetchColumn();
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
    }
}

function conceptosPresupuesto($conexion, $IdPresupuesto){
    try{
        $Comando_sql =  "SELECT IdPresupuesto,Nombre,Cantidad,
        Servicio FROM CONCEPTOS  WHERE IdPresupuesto = :IdPresupuesto";
        $stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":IdPresupuesto", $IdPresupuesto);
        $stmn -> execute();
        return $stmn;
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
 }
}

function facturasServicio($conexion, $IdC, $FechaI,$FechaF,$tipoServicio){
    try{
        $Comando_sql =  " SELECT  COALESCE(SUM(Importe),0) AS total FROM FACTURAS WHERE :FechaI <= FechaEmision and FechaEmision <= :FechaF and IdC = :IdC and TipoServicio=:tp" ;
        $stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":FechaI", $FechaI);
        $stmn -> bindParam(":FechaF", $FechaF);
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> bindParam(":tp", $tipoServicio);
        $stmn -> execute();
        return $stmn -> fetchColumn();
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
 }
}

function propietariosComunidad($conexion, $IdC){
    try{
        $Comando_sql =  "SELECT IdP,NombreAp,Dni,Telefono,PisoLetra, Email FROM PROPIETARIOS Natural JOIN  PERTENECE natural JOIN PISOS WHERE IdC = :IdC";
        $stmn = $conexion->prepare($Comando_sql);
        $stmn -> bindParam(":IdC", $IdC);
        $stmn -> execute();
        return $stmn;
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
 }
}

?>